## Why

`CheckPermissionsTest` muss `StorageItem::checkPermissions()` aufrufen, das intern `Yii::$app->authManager->getRolesByUser()` und ein `yii\web\User`-Objekt mit einer Identity braucht. Im SQLite-Test-Bootstrap existieren weder `authManager` noch `user`-Komponente, weshalb alle Permission-Tests auf `$authManager === null` fallen und nicht das Gruppenverhalten testen.

## What Changes

- `TestUserFactory` helper-Klasse in `tests/` des Vendor-Packages: erzeugt eine `yii\web\User`-Instanz mit konfigurierbarer User-ID und Gruppen-Zuweisung
- `TestAuthManager` stub-Klasse in `tests/`: minimale In-Memory-Implementierung von `getRolesByUser()`, kein DB-Zugriff
- `TestIdentity` stub-Klasse in `tests/`: implementiert `yii\web\IdentityInterface` mit fester ID
- `bootstrap.php` erweitern: `user`- und `authManager`-Komponente zur Test-App hinzufügen

## Capabilities

### New Capabilities
- `test-user-factory`: Hilfsmittel zum Erstellen von gefakten Yii2-Usern mit konfigurierten RBAC-Rollen für PHPUnit-Tests im Vendor-Package

### Modified Capabilities

## Impact

- Nur `tests/` im Vendor-Package `eluhr/yii2-flysystem-rest-api` betroffen
- Keine Änderungen an Produktionscode
- Keine neuen Composer-Abhängigkeiten
