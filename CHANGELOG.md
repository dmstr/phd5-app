# Changelog

### 5.4.0

- added `APP_PAGES_TITLE_PREFIX`
- removed `cinghie/yii2-cookie-consent`
- removed `dmstr/yii2-contact-module`
- changed default vendor-asset paths to `bower-asset` & `npm-asset`
- changed scheduler to use `--entrySolo` for `audit/cleanup`

### 5.3.0

- removed Alpine support
- switched to `2amigos/yii2-usuario`
- updated `dmstr/yii2-widgets2-module` and `dmstr/yii2-pages-module`
- use same window/tab for *Backend*, if `APP_PARAMS_BACKEND_IFRAME_NAME` is not set
- added `omnilight/yii2-scheduling`
- removed seo keywords and descriptions in Settings module

### 5.2.0

- updated `dmstr/yii2-resque-module`
  - uses `yiisoft/yii2-queue`
- removed CLI alias `db/x-dump-data`
- removed composer `dev` packages during image build
- removed forked repositories
  - `yii rbac` command moved to `dmstr/yii2-helpers`

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
