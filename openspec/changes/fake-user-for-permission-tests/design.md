## Context

`StorageItem::checkPermissions()` benötigt zwei Yii2-Komponenten:
1. `Yii::$app->user` — ein `yii\web\User` mit einer eingeloggten Identity (`isGuest=false`, `getId()`)
2. `Yii::$app->authManager` — ein Manager mit `getRolesByUser($userId)`, der die RBAC-Gruppen des Users zurückgibt

Die Test-App in `bootstrap.php` ist eine `yii\console\Application` mit SQLite in-memory. Die App des Projekts nutzt `Da\User\Component\AuthDbManagerComponent` (DB-basiert), was in Unit-Tests nicht verfügbar ist.

## Goals / Non-Goals

**Goals:**
- Einen User mit beliebiger ID und beliebigen Gruppen (z. B. `GruppeA`) in Tests injizierbar machen
- Keinen DB-Zugriff für User/RBAC nötig
- Einfach verwendbar: `TestUserFactory::make('user1', ['GruppeA'])`

**Non-Goals:**
- Kein vollständiges RBAC (Permissions, Rules, Hierarchien)
- Keine Integration mit dem echten `Da\User`-Modell
- Kein Testen der RBAC-Struktur selbst

## Decisions

**D1: In-Memory Stub statt echtem AuthManager**
`TestAuthManager` ist ein einfaches PHP-Objekt mit einem `array $assignments`-Store. `getRolesByUser($userId)` gibt ein Array zurück, dessen Keys die Rollennamen sind (wie Yii2 es erwartet: `['GruppeA' => Role-Objekt]`). Alternative wäre `yii\rbac\PhpManager` mit Temp-Dateien — zu viel Overhead für diesen Zweck.

**D2: `TestIdentity` als eigene Klasse, kein Mocking-Framework**
Implementiert `yii\web\IdentityInterface` mit fest codierter ID. Kein PHPUnit-Mock nötig, kein zusätzliches Framework (Mockery etc.). Die Klasse ist so minimal wie möglich.

**D3: `yii\web\User` direkt instantiieren, nicht mocken**
`yii\web\User` wird mit `setIdentity($identity)` direkt befüllt. Kein Subclassing nötig. Funktioniert auch außerhalb eines Web-Requests.

**D4: `authManager` als Application-Komponente registrieren**
`Yii::$app->set('authManager', new TestAuthManager())` in `TestUserFactory::make()`. So sieht `checkPermissions()` den Manager über `Yii::$app->authManager`. Die Registrierung überschreibt bei jedem Test-Aufruf den vorherigen Stand — kein globaler State zwischen Tests, da `setUp()` die Daten ohnehin löscht.

## Risks / Trade-offs

- **[Risk] `yii\web\User` in Console-App**: `yii\console\Application` hat normalerweise keine `user`-Komponente. → Mitigation: `Yii::$app->set('user', $userComponent)` im Factory-Aufruf setzt sie dynamisch.
- **[Risk] `BIT_OR()` in SQLite**: `checkPermissions` nutzt `BIT_OR(effective_grant_mask)` als SQL-Aggregat. SQLite unterstützt das nicht nativ. → Mitigation: muss separat geprüft/gelöst werden (außerhalb dieses Changes).
