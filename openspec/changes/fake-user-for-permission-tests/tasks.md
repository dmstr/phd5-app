## 1. Test-Stubs erstellen

- [x] 1.1 `tests/TestIdentity.php` erstellen: implementiert `yii\web\IdentityInterface` mit konfigurierbarer `$id`
- [x] 1.2 `tests/TestAuthManager.php` erstellen: In-Memory `assign(userId, role)` + `getRolesByUser(userId)` mit Rückgabe-Format kompatibel zu Yii2-RBAC
- [x] 1.3 `tests/TestUserFactory.php` erstellen: statische `make(string $userId, array $groups): yii\web\User`-Methode, setzt `Yii::$app->authManager` und `Yii::$app->user`

## 2. Bootstrap erweitern

- [x] 2.1 `tests/bootstrap.php`: `user`-Komponente (`yii\web\User` mit `identityClass = TestIdentity`) zur Test-App hinzufügen

## 3. CheckPermissionsTest implementieren

- [x] 3.1 `testDirectoryAllowsMatchingGroup`: `TestUserFactory::make('u1', ['GruppeA'])` verwenden, `$dir->checkPermissions(READ, $user)` assertTrue
- [x] 3.2 `testDirectoryDeniesUnmatchedGroupWithDefaultGrantZero`: User in `GruppeX`, `default_grant=0` auf Root, assertFalse
- [x] 3.3 `testFileWithoutOwnPermissionsUsesParentHashmap`: Datei ohne eigene Permissions, Parent-Hashmap greift, assertTrue
- [x] 3.4 `testFileWithOwnPermissionsIgnoresParentHashmap`: Datei mit eigenen Permissions, Parent-Hashmap ignoriert, assertFalse für User der nur in Parent-Gruppe ist
- [x] 3.5 `testMultipleGroupMasksAreCombinedWithOr`: User in GruppeA + GruppeC, kombinierte Maske prüfen

## 4. BIT_OR SQLite-Kompatibilität prüfen

- [x] 4.1 Prüfen ob `BIT_OR()` in SQLite verfügbar ist (seit SQLite 3.44.0); falls nicht: `checkPermissions` für SQLite anpassen oder Test überspringen
