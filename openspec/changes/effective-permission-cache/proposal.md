## Why

`checkPermissions()` und `readableBy()` traversieren aktuell zur Laufzeit den Verzeichnisbaum, um geerbte Permissions zu ermitteln. Bei tiefen Hierarchien und vielen gleichzeitigen Zugriffen führt das zu wiederholten, teuren SQL-Subqueries. Eine vorberechnete Effective-Permission-Tabelle pro Verzeichnis und Gruppe eliminiert diese Laufzeittraversierung vollständig.

## What Changes

- Neue Tabelle `storage_item_effective_permission`: speichert pro Verzeichnis und Gruppe die vorberechnete effektive Bitmask
- Neues Feld `default_grant` am Root-`StorageItem`: Fallback-Bitmask wenn kein Ancestor für eine Gruppe einen expliziten Eintrag hat
- `StorageItem` bekommt `recomputeEffectivePermissions()`: berechnet alle Hashmap-Einträge für ein Verzeichnis neu (per-Gruppe Traversierung aufwärts); kaskadiert synchron auf alle Nachfahren
- `checkPermissions()` ersetzt Traversal durch einfachen Hashmap-Lookup; für Dateien ohne eigene explizite Permissions wird der Hashmap-Eintrag des Parent-Verzeichnisses genutzt
- `readableBy()` ersetzt `EXISTS`-Subquery mit Ancestor-Traversal durch `IN`-Lookup auf `storage_item_effective_permission`
- Hashmap wird ausgelöst bei: Verzeichnis anlegen, `storage_item_permission` eines Verzeichnisses ändern (via `afterSave` / Service-Methode)
- **Semantische Änderung**: Traversierung erfolgt per Gruppe unabhängig — GruppeA findet ihren nächsten Ancestor mit GruppeA-Eintrag, GruppeB findet ihren nächsten Ancestor mit GruppeB-Eintrag; Ergebnisse werden per OR kombiniert. Bisher stoppte die Traversierung sobald ein Ancestor *irgendwelche* Rows hatte.

## Capabilities

### New Capabilities

- `effective-permission-cache`: Vorberechnete effektive Permissions pro Verzeichnis und Gruppe mit synchroner Invalidierung bei Permission-Änderungen

### Modified Capabilities

- `multi-group-permissions`: `checkPermissions()` und `readableBy()` ändern ihre Laufzeit-Semantik — Traversal wird durch Hashmap-Lookup ersetzt; Traversierungs-Logik per Gruppe wird in `recomputeEffectivePermissions()` verlagert

## Impact

- **yii2-flysystem-rest-api** (`vendor/eluhr/`): `StorageItem` model, `StorageItemQuery`, neue Migration, neues Model `StorageItemEffectivePermission`
- **Database**: neue Tabelle `storage_item_effective_permission`; neues Feld `default_grant` auf `storage_item` (nur Root-Items relevant)
- **Performance**: `checkPermissions()` und `readableBy()` werden zu O(1)-Lookups; Schreibpfad (Permission-Änderung) wird teurer durch Kaskaden-Recompute
- **Keine API-Änderungen**: Endpoints und Response-Formate bleiben identisch
