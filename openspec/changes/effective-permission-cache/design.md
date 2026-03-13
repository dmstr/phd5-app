## Context

`yii2-flysystem-rest-api` speichert explizite Gruppen-Permissions in `storage_item_permission` (N Rows pro Verzeichnis). `checkPermissions()` und `readableBy()` traversieren aktuell zur Laufzeit den Verzeichnisbaum: für jedes Item wird geprüft ob es eigene Rows hat; wenn nicht, wird zum Parent gegangen. Das ist eine `EXISTS`-Subquery mit rekursiven Ancestor-Joins. Bei tiefen Bäumen (>10 Ebenen) und read-heavy Workloads entstehen so pro Zugriffscheck viele DB-Roundtrips.

Zusätzlich ist die bisherige Traversier-Semantik "per Item" (sobald ein Ancestor *irgendwelche* Permission-Rows hat, stoppt die Suche für alle Gruppen). Die neue Semantik ist "per Gruppe": jede Gruppe traversiert unabhängig bis sie einen expliziten Eintrag für sich findet. Das ist feingranularer und korrekt für Mixed-Permission-Bäume.

## Goals / Non-Goals

**Goals:**
- `checkPermissions()` und `readableBy()` als O(1)-DB-Lookup ohne Traversal
- Korrekte per-Gruppe-Semantik: jede Gruppe findet eigenständig ihren nächsten expliziten Ancestor
- Synchrone Invalidierung: nach jeder Permission-Änderung ist die Hashmap sofort konsistent
- Fallback auf `default_grant` am Root wenn keine Gruppe einen Ancestor-Eintrag hat
- Dateien ohne eigene Permissions nutzen den Hashmap-Eintrag ihres Parent-Verzeichnisses

**Non-Goals:**
- Caching in Redis/Memory (DB-Tabelle ist die einzige Quelle)
- Hashmap-Einträge für Dateien (nur Verzeichnisse)
- Unterstützung für zirkuläre Strukturen (Storage-Items sind ein DAG/Baum)

## Decisions

### 1. Separate Tabelle `storage_item_effective_permission`
Spalten: `storage_item_id` (FK → `storage_item.id`), `group_name` (VARCHAR 255), `effective_grant_mask` (BIGINT UNSIGNED). Primärschlüssel composite `(storage_item_id, group_name)`.

*Rationale:* Gleiche Struktur wie `storage_item_permission` → SQL-Joins bleiben einfach. Kein JSON-Blob, der schwer zu querien wäre.

*Alternative:* JSON-Spalte auf `storage_item` — abgelehnt, da kein effizienter Index möglich.

### 2. Per-Gruppe-Traversierung beim Recompute
`recomputeEffectivePermissions(StorageItem $dir)` sammelt alle Gruppen die irgendwo im Ancestor-Pfad von `$dir` bis Root in `storage_item_permission` vorkommen. Für jede Gruppe wird der nächste Ancestor mit einem expliziten Eintrag für genau diese Gruppe gesucht (`storage_item_permission` nach `group_name = ?` filtern). Ergebnis: ein `effective_grant_mask`-Eintrag pro Gruppe.

Gruppen die **nirgends** im Ancestor-Pfad auftauchen, bekommen **keinen** Hashmap-Eintrag — für diese greift `default_grant` des Root-Items zur Laufzeit.

*Rationale:* Die Hashmap bleibt schlank (nur relevante Gruppen). Lookup benötigt nur ein einfaches `WHERE storage_item_id = ? AND group_name IN (?)`.

### 3. `default_grant` am Root-Item
Neues Feld `default_grant BIGINT UNSIGNED NOT NULL DEFAULT 0` auf `storage_item`. Nur für Root-Items semantisch relevant (Items ohne Parent). `checkPermissions()` liest dieses Feld wenn kein Hashmap-Eintrag für die Gruppe gefunden wurde.

*Rationale:* Default liegt am Datensatz selbst, nicht in der Applikationskonfiguration — damit ist er per Storage konfigurierbar.

### 4. Kaskaden-Invalidierung: synchron oder per Queue (konfigurierbar)
Wenn `storage_item_permission` für ein Verzeichnis geändert wird, löst `updatePermissionsFromJson()` einen Recompute für das Verzeichnis und alle Nachfahren aus. Das Verhalten ist über einen konfigurierbaren Schwellwert steuerbar:

- **Unter Schwellwert** (`recomputeQueueThreshold`, default z.B. 500 Nachfahren): synchroner Recompute innerhalb derselben Operation
- **Über Schwellwert**: der Recompute wird als Job in den Queuemanager (`hrzg/yii2-resque`) eingestellt; die Hashmap ist bis zur Job-Ausführung veraltet — dies wird geloggt

Der Schwellwert wird als Modul-Property von `yii2-flysystem-rest-api` konfiguriert (`Module::$recomputeQueueThreshold`). Wert `0` erzwingt immer Queue, Wert `-1` erzwingt immer synchron. Queue-Dispatch erfolgt via `yiisoft/yii2-queue` (bereits im phd5-app vendor installiert) — das Queue-Komponent-ID ist über `Module::$queueComponent` konfigurierbar (default: `'queue'`). Der Job implementiert `yii\queue\JobInterface`.

*Rationale:* Kleine Bäume profitieren von sofortiger Konsistenz ohne Queue-Overhead. Große Installationen mit tausenden Nachfahren dürfen die Schreiboperation nicht blockieren. `yiisoft/yii2-queue` ist bereits vorhanden, kein neues Paket nötig.

*Alternative:* Immer synchron — abgelehnt für große Bäume (Timeout-Risiko). Immer Queue — abgelehnt, da Inkonsistenz-Fenster für kleine Bäume unnötig ist.

### 5. Dateien: kein Hashmap-Eintrag, Parent-Lookup
Dateien (`type = 'file'`) bekommen keine Einträge in `storage_item_effective_permission`. `checkPermissions()` prüft bei einer Datei zuerst eigene `storage_item_permission`-Rows; hat sie keine, wird der Hashmap-Eintrag des Parent-Verzeichnisses verwendet.

*Rationale:* Dateien sind Blätter — sie ändern den Vererbungspfad nicht. Ihnen einen eigenen Hashmap-Eintrag zu geben würde die Tabelle massiv aufblähen.

### 6. `readableBy()` via Hashmap-Join
Statt `EXISTS`-Subquery mit Ancestor-Traversal: `JOIN storage_item_effective_permission ON storage_item_id = id WHERE group_name IN (:groups) AND effective_grant_mask & :readFlag > 0`. Für Dateien: JOIN auf Parent-ID des Items.

*Rationale:* Einfache Equi-Joins sind vom Query-Planner optimal optimierbar; kein rekursiver CTE nötig.

## Risks / Trade-offs

- **Schreibpfad-Latenz bei großen Bäumen** → Kaskaden-Recompute kann bei Bäumen mit Tausenden von Nachfahren mehrere Sekunden dauern. Mitigation: konfigurierbarer `recomputeQueueThreshold` — über Schwellwert wird in Queue ausgelagert; Inkonsistenz-Fenster wird geloggt.
- **Hashmap-Drift bei direkten DB-Writes** → Wenn `storage_item_permission` direkt in der DB modifiziert wird (ohne App-Layer), bleibt die Hashmap veraltet. Mitigation: Dokumentieren; ggf. Konsistenz-Check-Kommando bereitstellen.
- **Speicherbedarf** → Pro Verzeichnis × Anzahl relevanter Gruppen. Bei flachen Bäumen mit vielen Gruppen kann die Tabelle groß werden. Mitigation: Index auf `(storage_item_id, group_name)` reicht; keine zusätzliche Partitionierung nötig.
- **Recompute bei `migrate-from-filefly`** → Nach dem Filefly-Import müssen alle Hashmap-Einträge initial berechnet werden. Mitigation: Neues Console-Kommando `yii storage/recompute-effective-permissions`.

## Migration Plan

1. Migration: Tabelle `storage_item_effective_permission` anlegen + Feld `default_grant` auf `storage_item`
2. Console-Kommando `yii storage/recompute-effective-permissions` ausführen → initial Hashmap für alle Verzeichnisse befüllen
3. Code deployen: `checkPermissions()`, `readableBy()`, `recomputeEffectivePermissions()`, Trigger in `updatePermissionsFromJson()`

**Rollback:** Migration rückgängig via `safeDown`; Code-Revert; kein Datenverlust (Tabelle ist rein derived data).

## Open Questions

- Welcher konkrete Default-Wert für `recomputeQueueThreshold` ist sinnvoll für typische Installationen?
