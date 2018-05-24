# Changelog

### 5.2.0

- removed CLI alias `db/x-dump-data`
- removed composer `dev` packages during image build

### 5.1.0

- disabled user registration by default (`APP_USER_ENABLE_REGISTRATION`)
- `APP_MIGRATION_LOOKUP` accepts a comma separated list of path-aliases
- refactored ENV variables (moved `src/app.env` to `src/config/env-defaults`)

### 5.1.0-rc6

- changed global Twig class `Url` to `FileUrl`, added standard Yii helper `Url`
- changed global layout `TwigWidget` from `_top` to `_beginBody`, added `_endBody`

### 5.1.0-rc5

- added version constraint for `jquery` to use `2.*` (avoids [issue](https://github.com/jquery/jquery/issues/3194) with `onload` handler)
- removed extensions `knplabs/github-api`, `phpoffice/phpexcel`, `romdim/yii2-bootstrap-material`

### 5.1.0-rc4

- replaced `dmstr/yii2-cms-dev-metapackage` with `dev-dependencies` in `compsoer.json` 

### 5.1.0-rc3

- updated base images

### 5.0.0-beta38

- added `APP_USER_ENABLE_REGISTRATION`