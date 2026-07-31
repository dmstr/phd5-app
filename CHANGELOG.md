# Changelog

### 5.12.1

- fixed Docker image: preserve the request port in `HTTP_HOST` for PHP by overriding
  `/etc/nginx/conf.d/default.conf` with an additional `fastcgi_param HTTP_HOST $http_host;`
  (Debian's nginx security update sends port-less `$host`, which broke absolute
  redirect URLs like `http://localhost:11280/` → `http://localhost/en`), see #6
  - **Note**: projects with their own prod stage built directly `FROM yiisoftware/yii2-php:*`
    (instead of the phd5 image) are not covered by this fix and need the same
    `default.conf` override themselves
- updated `dompurify` to `3.4.12`

### 5.12.0

- **BREAKING CHANGE**: new asset management via `cramer` (asset migration tool)
  - replaced `asset-packagist` based `bower-asset/*` and `npm-asset/*` dependencies
    with native Bower and Yarn (NPM) package management
  - bower packages are now installed via `bower install` into `src/vendor/bower`
  - npm packages are now installed via `yarn install` into `src/node_modules`
  - added local Composer replacement package `app/local-replaced-assets`
    (`src/assets-replaced/`) to satisfy former asset package requirements
  - added `package.json`, `yarn.lock`, `.yarnrc`, `bower.json` and `.bowerrc` in `src/`
  - added `image-files/usr/local/bin/create-npm-asset-symlinks` to keep existing
    `AssetBundle` paths working (e.g. `json-editor--json-editor` →
    `@json-editor/json-editor`) via NPM postinstall hook
  - added `dmstr/cramer` asset migration tool (`src/extensions/dmstr/cramer/`)
    providing `yii asset-migration/analyze` and `yii asset-migration/generate`
  - see [`cramer/README.md`](https://git.hrzg.de/dmstr/phd5-app/-/blob/release/5.12.x/src/extensions/dmstr/cramer/README.md)
    for details and migration guide
- Docker image: install Node.js 20.18.1 from official binaries (replaces
  NodeSource sources, avoids GPG/SHA1 issues) and install `yarn` globally
- Dockerfile: install Yarn and Bower assets during image build
- updated `dmstr/yii2-backend-module` to `^2.3.0`
- added `dmstr/yii2-mermaid-asset` `^2.0.0`
- removed `bower-asset/*` entries from `conflict` section in `composer.phd5.json`

### 5.11.0

- updated base image to `yiisoftware/yii2-php:8.4-fpm-nginx`
- changed queue driver from `redis` to `db`
- removed `ignatenkovnikita/yii2-queuemanager`
- added dependency to 

### 5.10.0

- updated base image to `yiisoftware/yii2-php:8.2-fpm-nginx`

### 5.9.0

- updated base image to `yiisoftware/yii2-php:8.1-fpm-nginx`
- added debug-by-env variables `APP_DEBUG_KEY`, `APP_DEBUG_TOKEN`
- added Redis queue id sync event
- enabled debug module for CLI requests

### 5.8.0

- switched base image to `yiisoftware/yii2-php:8.0-fpm-nginx`
- moved `c3.php` to test root folder

### 5.7.0

- base-image upgraded to `PHP 8.0`
- upgraded `codeception/codeception ~4.2.1`

### 5.6.0

- updated base-image `dmstr/php-yii2:7.4-fpm-8.0`
- composer 2
- added healthchecks
- use asset-packagist (preferred); disabled fxp/composer-asset-plugin

### 5.5.0-beta1

- added `Cell`s (`_beforeContent`, `_afterContent`) to `layouts/main.php`
- removed `Pjax` container in `layouts/main.php`

### 5.5.0-alpha1

- `yii db` has changed API
- base-image upgraded to `PHP 7.4`

### 5.4.1

- added `fsFtp` filesystem component

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
