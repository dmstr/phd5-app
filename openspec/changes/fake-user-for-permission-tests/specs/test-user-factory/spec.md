## ADDED Requirements

### Requirement: TestIdentity stellt eine minimale Yii2-Identity bereit
`TestIdentity` implementiert `yii\web\IdentityInterface`. Sie besitzt eine konfigurierbare `$id` und hat keine DB-Abhängigkeit.

#### Scenario: Identity liefert konfigurierte ID
- **WHEN** `TestIdentity` mit `id = 'user42'` erstellt wird
- **THEN** gibt `getId()` den String `'user42'` zurück

### Requirement: TestAuthManager weist Usern Rollen zu
`TestAuthManager` speichert Rollen-Zuweisungen in-memory. `getRolesByUser($userId)` MUSS ein Array zurückgeben, dessen Keys die Rollennamen sind (kompatibel zum Yii2-RBAC-Interface).

#### Scenario: Zugewiesene Rollen werden zurückgegeben
- **WHEN** `assign('user1', 'GruppeA')` aufgerufen wird
- **THEN** gibt `getRolesByUser('user1')` ein Array zurück, das den Key `'GruppeA'` enthält

#### Scenario: Kein Eintrag für unbekannten User
- **WHEN** `getRolesByUser('unknown')` aufgerufen wird ohne vorherige Zuweisung
- **THEN** wird ein leeres Array zurückgegeben

### Requirement: TestUserFactory erzeugt eingeloggten User mit Gruppen
`TestUserFactory::make(string $userId, array $groups)` konfiguriert `Yii::$app->authManager` und `Yii::$app->user` so, dass `checkPermissions()` den User als eingeloggt mit den angegebenen Gruppen sieht.

#### Scenario: User in einer Gruppe
- **WHEN** `TestUserFactory::make('u1', ['GruppeA'])` aufgerufen wird
- **THEN** ist `Yii::$app->user->isGuest` false
- **THEN** gibt `Yii::$app->authManager->getRolesByUser('u1')` `['GruppeA' => ...]` zurück
- **THEN** gibt `Yii::$app->user->getId()` `'u1'` zurück

#### Scenario: User in mehreren Gruppen
- **WHEN** `TestUserFactory::make('u2', ['GruppeA', 'GruppeB'])` aufgerufen wird
- **THEN** enthält `getRolesByUser('u2')` sowohl `'GruppeA'` als auch `'GruppeB'`
