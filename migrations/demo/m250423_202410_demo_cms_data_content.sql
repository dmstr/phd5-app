DELETE FROM `app_dmstr_page_translation`;
DELETE FROM `app_dmstr_page_translation_meta`;
DELETE FROM `app_dmstr_page`;

INSERT INTO `app_dmstr_page` (`id`, `root`, `lft`, `rgt`, `lvl`, `domain_id`, `slug`, `route`, `view`, `request_params`, `access_owner`, `access_domain`, `access_read`, `access_update`, `access_delete`, `icon`, `icon_type`, `active`, `selected`, `readonly`, `collapsed`, `movable_u`, `movable_d`, `movable_l`, `movable_r`, `removable`, `removable_all`, `created_at`, `updated_at`)
VALUES
    ('2', '2', '1', '30', '0', 'backend', NULL, '', '', '{}', '2', 'de', '*', 'Editor', 'Editor', '', '1', '1', '0', '0', '1', '1', '1', '1', '1', '1', '0', '2022-05-24 12:52:35', '2022-09-14 11:14:51'),
    ('3', '2', '2', '3', '1', '628cb964a352b', NULL, '/pages/default/index', '', '{}', '2', 'de', '*', 'Editor', 'Editor', 'sitemap', '1', '1', '0', '0', '0', '1', '1', '1', '1', '1', '0', '2022-05-24 12:54:28', '2022-05-24 13:34:46'),
    ('4', '2', '4', '5', '1', '628cbd2d87d9f', NULL, '/filefly/default/filemanager', '', '{}', '2', 'de', '*', 'Editor', 'Editor', 'image', '1', '1', '0', '0', '0', '1', '1', '1', '1', '1', '0', '2022-05-24 13:10:38', '2022-05-24 13:11:34'),
    ('5', '2', '28', '29', '1', '628cbd3aaf2d7', NULL, '/settings/default/index', '', '{}', '2', 'de', '*', 'Editor', 'Editor', 'cogs', '1', '1', '0', '0', '0', '1', '1', '1', '1', '1', '0', '2022-05-24 13:10:51', '2022-05-24 13:11:05'),
    ('6', '2', '6', '7', '1', '628cbd7fcc4fd', NULL, '/user/admin/index', '', '{}', '2', 'de', '*', 'Master', 'Master', 'users', '1', '1', '0', '0', '0', '1', '1', '1', '1', '1', '0', '2022-05-24 13:12:00', '2022-05-24 13:12:38'),
    ('7', '2', '20', '21', '1', '628cbe0ac1be4', NULL, '/translatemanager/language/list', '', '{}', '2', 'de', '*', 'Editor', 'Editor', 'flag-o', '1', '1', '0', '0', '0', '1', '1', '1', '1', '1', '0', '2022-05-24 13:14:19', '2022-05-24 13:14:19'),
    ('8', '2', '8', '13', '1', '628cc1a384584', NULL, '', '', '{}', '2', '*', 'Editor', 'Editor', 'Editor', 'cubes', '1', '1', '0', '0', '0', '1', '1', '1', '1', '1', '0', '2022-05-24 13:29:40', '2024-11-19 11:19:48'),
    ('9', '2', '9', '10', '2', '628cc1bd40b3e', NULL, '/widgets/crud/widget/index', '', '{}', '2', 'de', '*', 'Editor', 'Editor', 'list-alt', '1', '1', '0', '0', '0', '1', '1', '1', '1', '1', '0', '2022-05-24 13:30:05', '2022-05-24 13:30:05'),
    ('10', '2', '11', '12', '2', '628cc1e2c6eb1', NULL, '/widgets/crud/widget-template/index', '', '{}', '2', 'de', '*', 'Editor', 'Editor', 'map-o', '1', '1', '0', '0', '0', '1', '1', '1', '1', '1', '0', '2022-05-24 13:30:43', '2022-05-24 13:30:56'),
    ('11', '2', '22', '23', '1', '628cc2085d2b8', NULL, '/audit/default/index', '', '{}', '2', 'de', '*', 'Master', 'Master', 'pie-chart', '1', '1', '0', '0', '0', '1', '1', '1', '1', '1', '0', '2022-05-24 13:31:20', '2022-05-24 13:31:54'),
    ('12', '2', '14', '19', '1', '628cc29212e3a', NULL, '', '', '{}', '2', '*', 'Editor', 'Editor', 'Editor', 'pencil-square-o', '1', '1', '0', '0', '0', '1', '1', '1', '1', '1', '0', '2022-05-24 13:33:38', '2024-11-19 11:20:00'),
    ('13', '2', '15', '16', '2', '628cc2a9a99e9', NULL, '/prototype/less/index', '', '{}', '2', 'de', '*', 'Editor', 'Editor', 'pencil', '1', '1', '0', '0', '0', '1', '1', '1', '1', '1', '0', '2022-05-24 13:34:02', '2022-05-24 13:34:02'),
    ('14', '2', '17', '18', '2', '628cc2c21174f', NULL, '/prototype/twig/index', '', '{}', '2', 'de', '*', 'Editor', 'Editor', 'leaf', '1', '1', '0', '0', '0', '1', '1', '1', '1', '1', '0', '2022-05-24 13:34:26', '2022-05-24 13:34:26'),
    ('15', '15', '1', '2', '0', 'root', NULL, '', '', '{}', '7', 'de', '*', 'Editor', 'Editor', '', '1', '1', '0', '0', '0', '1', '1', '1', '1', '1', '0', '2022-07-14 10:11:56', '2022-07-14 10:11:56'),
    ('22', '26', '2', '3', '1', '63205492bbdeb', NULL, '/pages/default/page', '@vendor/dmstr/yii2-widgets2-module/src/views/test/triple.twig', '{}', '5', 'de', '*', 'Editor', 'Editor', '', '1', '1', '0', '0', '0', '1', '1', '1', '1', '1', '0', '2022-09-13 11:59:47', '2022-09-13 11:59:47'),
    ('23', '26', '4', '5', '1', '632054a5e482e', NULL, '/pages/default/page', '@vendor/dmstr/yii2-widgets2-module/src/views/test/triple.twig', '{}', '5', 'de', '*', 'Editor', 'Editor', '', '1', '1', '0', '0', '0', '1', '1', '1', '1', '1', '0', '2022-09-13 12:00:06', '2022-09-13 12:00:06'),
    ('26', '26', '1', '6', '0', 'footer', NULL, '', '', '{}', '2', 'de', '*', 'Editor', 'Editor', '', '1', '1', '0', '0', '0', '1', '1', '1', '1', '1', '0', '2022-09-22 14:03:20', '2022-09-22 14:03:20'),
    ('28', '2', '24', '25', '1', '6406fef430cd1', NULL, '/redirects', '', '{}', '5', 'de', '*', 'Editor', 'Editor', 'arrows-h', '1', '1', '0', '0', '0', '1', '1', '1', '1', '1', '0', '2023-03-07 10:08:04', '2023-03-07 10:08:04'),
    ('29', '2', '26', '27', '1', '6422b12fcbcf0', NULL, '/contact/crud/contact-template', '', '{}', '5', 'de', '*', 'Editor', 'Editor', 'handshake-o', '1', '1', '0', '0', '0', '1', '1', '1', '1', '1', '0', '2023-03-28 11:19:44', '2023-03-28 11:19:44');

INSERT INTO `app_dmstr_page_translation` (`id`, `page_id`, `language`, `name`, `page_title`, `default_meta_keywords`, `default_meta_description`, `created_at`, `updated_at`)
VALUES
    ('1', '2', 'de', 'Backend', NULL, NULL, NULL, '2022-05-24 12:52:35', '2022-05-24 12:52:35'),
    ('2', '3', 'de', 'Pages', NULL, NULL, NULL, '2022-05-24 12:54:29', '2022-05-24 12:54:29'),
    ('3', '4', 'de', 'Medienmanager', NULL, NULL, NULL, '2022-05-24 13:10:38', '2022-05-24 13:10:38'),
    ('4', '5', 'de', 'Einstellungen', NULL, NULL, NULL, '2022-05-24 13:10:51', '2022-05-24 13:10:51'),
    ('5', '6', 'de', 'Benutzer', NULL, NULL, NULL, '2022-05-24 13:12:00', '2022-05-24 13:12:00'),
    ('6', '7', 'de', 'Übersetzungen', NULL, NULL, NULL, '2022-05-24 13:14:19', '2022-05-24 13:14:19'),
    ('7', '8', 'de', 'Widgets', NULL, NULL, NULL, '2022-05-24 13:29:40', '2022-05-24 13:33:20'),
    ('8', '9', 'de', 'Widget Inhalte', NULL, NULL, NULL, '2022-05-24 13:30:05', '2022-05-24 13:30:05'),
    ('9', '10', 'de', 'Widget Vorlagen', NULL, NULL, NULL, '2022-05-24 13:30:43', '2022-05-24 13:30:43'),
    ('10', '11', 'de', 'Audit', NULL, NULL, NULL, '2022-05-24 13:31:20', '2022-05-24 13:31:20'),
    ('11', '12', 'de', 'Prototype', NULL, NULL, NULL, '2022-05-24 13:33:38', '2022-05-24 13:33:38'),
    ('12', '13', 'de', 'LESS', NULL, NULL, NULL, '2022-05-24 13:34:02', '2022-05-24 13:34:02'),
    ('13', '14', 'de', 'TWIG', NULL, NULL, NULL, '2022-05-24 13:34:26', '2022-05-24 13:34:26'),
    ('14', '15', 'de', 'Frontend', '_ROOT_CONTAINER_ ', '_FOLDER', 'This is not a real page, just a container for the navigation.', '2022-07-14 10:11:56', '2022-07-14 10:11:56'),
    ('21', '22', 'de', 'Datenschutz', 'Datenschutz', 'Datenschutz', 'Datenschutz', '2022-09-13 11:59:47', '2022-09-13 11:59:47'),
    ('22', '23', 'de', 'Impressum', 'Impressum', 'Impressum', 'Impressum', '2022-09-13 12:00:06', '2022-09-13 12:00:06'),
    ('25', '26', 'de', 'Fußzeile', NULL, NULL, NULL, '2022-09-22 14:03:20', '2022-09-22 14:03:20'),
    ('27', '28', 'de', 'Redirects', NULL, NULL, NULL, '2023-03-07 10:08:04', '2023-03-07 10:08:04'),
    ('28', '29', 'de', 'Kontaktformular', NULL, NULL, NULL, '2023-03-28 11:19:44', '2023-03-28 11:19:44');

INSERT INTO `app_dmstr_page_translation_meta` (`id`, `page_id`, `language`, `disabled`, `visible`, `created_at`, `updated_at`)
VALUES
    ('1', '2', 'de', '0', '1', '2022-05-24 12:52:35', '2022-09-14 11:14:51'),
    ('2', '3', 'de', '0', '1', '2022-05-24 12:54:29', '2022-05-24 13:34:46'),
    ('3', '4', 'de', '0', '1', '2022-05-24 13:10:38', '2022-05-24 13:11:34'),
    ('4', '5', 'de', '0', '1', '2022-05-24 13:10:51', '2022-05-24 13:11:05'),
    ('5', '6', 'de', '0', '1', '2022-05-24 13:12:00', '2022-05-24 13:12:38'),
    ('6', '7', 'de', '0', '1', '2022-05-24 13:14:19', '2022-05-24 13:14:19'),
    ('7', '8', 'de', '0', '1', '2022-05-24 13:29:40', '2024-11-19 11:19:48'),
    ('8', '9', 'de', '0', '1', '2022-05-24 13:30:05', '2022-05-24 13:30:05'),
    ('9', '10', 'de', '0', '1', '2022-05-24 13:30:43', '2024-05-15 14:32:26'),
    ('10', '11', 'de', '0', '1', '2022-05-24 13:31:20', '2022-05-24 13:31:54'),
    ('11', '12', 'de', '0', '1', '2022-05-24 13:33:38', '2024-11-19 11:20:00'),
    ('12', '13', 'de', '0', '1', '2022-05-24 13:34:02', '2022-05-24 13:34:02'),
    ('13', '14', 'de', '0', '1', '2022-05-24 13:34:26', '2022-05-24 13:34:26'),
    ('14', '15', 'de', '0', '1', '2022-07-14 10:11:56', '2022-07-14 10:11:56'),
    ('21', '22', 'de', '0', '1', '2022-09-13 11:59:47', '2024-06-06 10:36:48'),
    ('22', '23', 'de', '0', '1', '2022-09-13 12:00:06', '2022-09-22 14:04:09'),
    ('25', '26', 'de', '0', '1', '2022-09-22 14:03:20', '2022-09-22 14:03:20'),
    ('27', '28', 'de', '0', '1', '2023-03-07 10:08:04', '2023-03-07 10:08:04'),
    ('28', '29', 'de', '0', '1', '2023-03-28 11:19:44', '2023-03-28 11:19:44');

TRUNCATE TABLE `app_less`;
INSERT INTO `app_less` (`key`, `value`, `created_at`, `updated_at`)
VALUES
    ('default-main', '@import \"bootstrap\";\r\n@import \"variables\";\r\n@import \"common\";\r\n', '2022-05-24 11:53:55', '2025-04-23 20:29:25'),
    ('variables', '// Bootstrap 3 Variables: https://getbootstrap.com/docs/3.4/customize/#less-variables\r\n\r\n@brand-primary: #ff7f4a;\r\n', '2022-05-24 11:54:33', '2025-04-23 20:29:15'),
    ('bootstrap', '@basePath: \"/app/vendor/bower-asset/bootstrap/less\";\r\n\r\n// Core variables and mixins\r\n@import \"@{basePath}/variables.less\";\r\n@import \"@{basePath}/mixins.less\";\r\n\r\n// Reset and dependencies\r\n@import \"@{basePath}/normalize.less\";\r\n@import \"@{basePath}/print.less\";\r\n\r\n// Core CSS\r\n@import \"@{basePath}/scaffolding.less\";\r\n@import \"@{basePath}/type.less\";\r\n@import \"@{basePath}/code.less\";\r\n@import \"@{basePath}/grid.less\";\r\n@import \"@{basePath}/tables.less\";\r\n@import \"@{basePath}/forms.less\";\r\n@import \"@{basePath}/buttons.less\";\r\n\r\n// Components\r\n@import \"@{basePath}/component-animations.less\";\r\n@import \"@{basePath}/dropdowns.less\";\r\n@import \"@{basePath}/button-groups.less\";\r\n@import \"@{basePath}/input-groups.less\";\r\n@import \"@{basePath}/navs.less\";\r\n@import \"@{basePath}/navbar.less\";\r\n@import \"@{basePath}/breadcrumbs.less\";\r\n@import \"@{basePath}/pagination.less\";\r\n@import \"@{basePath}/pager.less\";\r\n@import \"@{basePath}/labels.less\";\r\n@import \"@{basePath}/badges.less\";\r\n@import \"@{basePath}/jumbotron.less\";\r\n@import \"@{basePath}/thumbnails.less\";\r\n@import \"@{basePath}/alerts.less\";\r\n@import \"@{basePath}/progress-bars.less\";\r\n@import \"@{basePath}/media.less\";\r\n@import \"@{basePath}/list-group.less\";\r\n@import \"@{basePath}/panels.less\";\r\n@import \"@{basePath}/responsive-embed.less\";\r\n@import \"@{basePath}/wells.less\";\r\n@import \"@{basePath}/close.less\";\r\n\r\n// Components w/ JavaScript\r\n@import \"@{basePath}/modals.less\";\r\n@import \"@{basePath}/tooltip.less\";\r\n@import \"@{basePath}/popovers.less\";\r\n@import \"@{basePath}/carousel.less\";\r\n\r\n// Utility classes\r\n@import \"@{basePath}/utilities.less\";\r\n@import \"@{basePath}/responsive-utilities.less\";\r\n', '2022-05-24 12:08:02', '2023-03-31 12:49:36'),
    ('common', '.wrap {\r\n  padding-top: @navbar-height;\r\n}\r\n\r\n.footer-navigation {\r\n  text-align: center;\r\n  background-color: @brand-primary;\r\n  @media (min-width: @screen-md-min) {\r\n    text-align: right;\r\n  }\r\n  \r\n  ul {\r\n    li {\r\n      text-align: center;\r\n      @media (min-width: @screen-md-min) {\r\n        text-align: left;\r\n        display: inline-block;\r\n        \r\n      }\r\n      &.active {\r\n        a {\r\n          background-color: darken(@brand-primary, 5%);\r\n        }\r\n      }\r\n      a {\r\n        color: #ffffff;\r\n        padding: @grid-gutter-width * 0.5;\r\n        @media (max-width: @screen-sm-max) {\r\n           padding: @grid-gutter-width * 0.25 @grid-gutter-width * 0.5;\r\n         }\r\n        &:hover,&:focus {\r\n          background-color: darken(@brand-primary, 5%);\r\n        }\r\n        img {\r\n          height: 16px;\r\n          filter: brightness(100);\r\n        }\r\n      }\r\n    }\r\n  }\r\n}\r\n\r\n.cookie-consent-popup {\r\n  background-color: #ffffff;\r\n  padding: @grid-gutter-width;\r\n\r\n  .cookie-consent-top-wrapper {\r\n    .cookie-consent-accept-all {\r\n      .btn;\r\n      .btn-primary;\r\n    }\r\n    \r\n    .cookie-consent-controls-toggle {\r\n      .btn;\r\n      .btn-default;\r\n    }\r\n    \r\n    .cookie-consent-details-toggle {\r\n      .btn;\r\n      .btn-default;\r\n      display: none;\r\n    }\r\n  }\r\n\r\n  .cookie-consent-controls {\r\n    max-height: 0;\r\n    overflow: hidden;\r\n\r\n    &.open {\r\n      margin-top: @grid-gutter-width * 0.5;\r\n      max-height: 600px;\r\n    }\r\n    \r\n    .cookie-consent-control {\r\n      display: block;\r\n      margin-bottom: @grid-gutter-width * 0.5;\r\n    }\r\n    \r\n    .cookie-consent-save {\r\n      .btn;\r\n      .btn-default;\r\n    }\r\n  }\r\n}', '2024-10-09 12:30:10', '2025-04-23 21:00:36');


TRUNCATE TABLE `app_settings`;
INSERT INTO `app_settings` (`id`, `type`, `section`, `key`, `value`, `active`, `created`, `modified`)
VALUES
    ('1', 'object', 'widgets', 'availablePhpClasses', '{\"hrzg\\\\widget\\\\widgets\\\\TwigTemplate\": \"Twig layout\"}', '1', '2022-05-24 11:33:28', NULL),
    ('2', 'string', 'backend.adminlte', 'skin', 'yellow', '1', '2022-05-24 11:33:28', '2025-04-23 20:38:35'),
    ('3', 'string', 'app.assets', 'registerPrototypeAssetKey', 'default', '1', '2022-05-24 11:33:28', '2022-05-24 11:57:11'),
    ('4', 'string', 'pages', 'availableRoutes', '/pages/default/page\r\n/user/admin/index\r\n/pages/default/index\r\n/settings/default/index\r\n/audit/default/index\r\n/widgets/crud/widget/index\r\n/widgets/crud/widget-template/index\r\n/prototype/less/index\r\n/prototype/twig/index\r\n/translatemanager/language/list\r\n/filefly/default/filemanager\r\n/pages/default/ref-page\r\n/site/index\r\n/redirects\r\n/contact/crud/contact-template\r\n/site/index', '1', '2022-05-24 11:33:28', '2025-04-23 20:40:00'),
    ('6', 'string', 'pages', 'availableViews', '@vendor/dmstr/yii2-widgets2-module/src/views/test/triple.twig;standard\r\n@vendor/dmstr/yii2-prototype-module/src/views/render/twig.php;code', '1', '2022-05-24 11:33:28', '2022-05-24 11:49:36'),
    ('7', 'string', 'frontend', 'backendWidget', 'modal', '1', '2022-05-24 11:33:37', NULL),
    ('8', 'string', 'app.assets', 'settingsAssetList', 'dmstr\\modules\\prototype\\assets\\DbAsset\r\nrmrevin\\yii\\fontawesome\\AssetBundle', '1', '2022-05-24 11:36:06', '2022-07-25 10:32:48'),
    ('11', 'string', 'backend', 'growl.location', 'br', '1', '2022-05-24 11:47:28', NULL),
    ('12', 'string', 'app.frontend', 'imgBaseUrl', 'http://localhost:12345', '1', '2022-05-24 11:51:09', '2024-10-09 14:20:48'),
    ('13', 'string', 'app.frontend', 'imgHostPrefix', 'img/stream', '1', '2022-05-24 11:51:33', '2024-10-09 14:20:35'),
    ('14', 'string', 'app.frontend', 'imgHostSuffix', ',p0', '1', '2022-05-24 11:51:45', '2022-09-22 13:44:42'),
    ('15', 'string', 'frontend', 'growl.location', 'br', '1', '2022-05-24 11:53:36', NULL),
    ('16', 'object', 'widgets', 'ckeditor.config', '{\r\n  \"height\": \"200px\",\r\n  \"toolbar\": [\r\n    [\r\n      \"JustifyLeft\",\r\n      \"JustifyCenter\",\r\n      \"JustifyRight\",\r\n      \"JustifyBlock\",\r\n      \"Format\",\r\n      \"Link\",\r\n      \"Unlink\",\r\n      \"NumberedList\",\r\n      \"BulletedList\",\r\n      \"Bold\",\r\n      \"Italic\",\r\n      \"RemoveFormat\",\r\n      \"Undo\",\r\n      \"Redo\",\r\n      \"Paste\",\r\n      \"PasteText\",\r\n      \"PasteFromWord\",\r\n      \"Cut\",\r\n      \"Copy\",\r\n      \"Outdent\",\r\n      \"Indent\"\r\n    ]\r\n  ],\r\n  \"extraPlugins\": \"divarea,justify\",\r\n  \"format_tags\": \"p;h3;h4\"\r\n}', '1', '2022-05-24 11:55:24', '2022-07-15 15:17:09'),
    ('17', 'string', 'filefly', 'mime-whitelist', 'image/png,image/jpeg,image/svg+xml,application/pdf,image/svg', '1', '2022-05-24 13:05:44', '2023-03-09 13:41:00'),
    ('18', 'boolean', 'app.layout', 'enableTwigNavbar', '1', '1', '2022-05-24 13:18:57', '2022-07-19 14:03:02'),
    ('19', 'integer', 'captcha', 'testLimit', '100', '1', '2022-07-08 15:06:56', NULL),
    ('20', 'integer', 'captcha', 'width', '140', '1', '2022-07-08 15:06:56', NULL),
    ('21', 'integer', 'captcha', 'height', '75', '1', '2022-07-08 15:06:56', NULL),
    ('22', 'integer', 'captcha', 'offset', '-1', '1', '2022-07-08 15:06:56', NULL),
    ('23', 'string', 'captcha', 'backColor', '0x333333', '1', '2022-07-08 15:06:56', NULL),
    ('24', 'string', 'captcha', 'foreColor', '0xFFFFFF', '1', '2022-07-08 15:06:56', NULL),
    ('25', 'string', 'backend.adminlte', 'navBarIcon', 'asterisk', '1', '2024-10-09 12:31:45', '2025-04-23 20:35:36');


TRUNCATE TABLE `app_twig`;
INSERT INTO `app_twig` (`id`, `key`, `value`, `created_at`, `updated_at`)
VALUES
    ('1', 'de/site/index', '{{ use(\'hrzg/widget/widgets/Cell\') }}\r\n\r\n{{ Cell_widget({id: \'main\'}) }}\r\n', '2022-05-24 11:43:01', '2024-10-09 12:53:45'),
    ('2', '_endBody', '{{ use(\'dmstr/cookieconsent/widgets/CookieConsent\') }}\r\n{{ CookieConsent_widget({\r\n    \"name\": \"cookie_consent_status\",\r\n    \"path\": \"/\",\r\n    \"domain\": \"\",\r\n    \"expiryDays\": 365,\r\n    \"message\": t(\"cookie-consent\", \"Diese Website benutzt Cookies. Wenn Sie die Website weiter nutzen, stimmen Sie der Verwendung von Cookies zu.\"),\r\n    \"save\": t(\"cookie-consent\", \"Speichern\"),\r\n    \"acceptAll\": t(\"cookie-consent\", \"Alle akzeptieren\"),\r\n    \"controlsOpen\": t(\"cookie-consent\", \"Ändern\"),\r\n    \"detailsOpen\": t(\"cookie-consent\", \"Cookie Details\"),\r\n    \"learnMore\": t(\"cookie-consent\", \"Datenschutzerklärung\"),\r\n    \"visibleControls\": false,\r\n    \"visibleDetails\": false,\r\n    \"link\": \"/datenschutz\",\r\n    \"consent\": {\r\n        \"necessary\": {\r\n            \"label\": t(\"cookie-consent\", \"Funktional\"),\r\n            \"checked\": true,\r\n            \"disabled\": true\r\n        }\r\n    }\r\n}) }}', '2022-05-24 11:58:46', '2025-04-23 20:44:48'),
    ('3', 'backend.extra.content', '{% if app.user.can(\'Editor\') and app.controller.module.id != \'filefly\' %}\r\n{{ use (\'yii/bootstrap\') }}\r\n{{ modal_begin(\r\n    {\r\n        \'id\': \'modal-filemanager\',\r\n        \'size\': \'modal-lg\'\r\n    }\r\n) }}\r\n\r\n<iframe id=\"filefly-iframe\" \r\n    width=\"100%\" \r\n    height=\"100%\" \r\n    style=\"height: 70vh\" \r\n    frameborder=\"0\"\r\n    src=\"\"></iframe>\r\n\r\n{{ modal_end() }}\r\n{% endif %}', '2022-05-24 13:16:09', '2022-05-24 13:16:09'),
    ('4', 'backend.extra.menuItems', '{% if app.user.can(\'Editor\') and app.controller.module.id != \'filefly\' %}\r\n<li>\r\n    <a type=\"button\" data-toggle=\"modal\" data-target=\"#modal-filemanager\" id=\"filefly-iframe-toggle\">\r\n        <i class=\"fa fa-folder-open\"></i>\r\n    </a>\r\n</li>\r\n\r\n<script>\r\n    window.addEventListener(\'load\', function () {\r\n        var fileflyIframeToggle = document.querySelector(\'#filefly-iframe-toggle\');\r\n        var iframe = document.querySelector(\'#filefly-iframe\');\r\n        \r\n         fileflyIframeToggle.addEventListener(\'click\', function () {\r\n            iframe.src = \"/{{ app.language|lower }}/filefly/default/filemanager-full-screen\";\r\n        });\r\n    });\r\n</script>\r\n{% endif %}\r\n\r\n\r\n', '2022-05-24 13:16:39', '2024-06-06 09:50:09'),
    ('5', 'de/translatemanager/language/list#main-top', '<div class=\"form-group\">\r\n    <div class=\"btn-group\">\r\n        {{ Html.a(t(\'twig-widget\',\'Scan application for translatables\'),[\'/translatemanager/language/scan\'],{class: \'btn btn-primary\'}) | raw }}\r\n    </div>\r\n</div>', '2022-05-24 13:17:36', '2022-05-24 13:17:36'),
    ('6', '_navbar', '{{ use(\'yii/bootstrap\') }}\r\n\r\n{{ nav_bar_begin({\r\n    \'options\': {\r\n        \'class\': \'navbar navbar-default navbar-fixed-top\'\r\n    }\r\n}) }}\r\n    {{ nav_widget({\r\n        \'options\': {\r\n            \'class\': \'navbar-nav navbar-right\'\r\n        },\r\n        \'encodeLabels\': false,\r\n        \'items\': Tree.getMenuItems(\'root\')|merge([\r\n\r\n            {\r\n                \'label\': app.user.identity.username,\r\n                \'visible\': not app.user.isGuest,\r\n                \'items\': [\r\n                    {\r\n                        \'label\': t(\'twig-widget\',\'Profil\'),\r\n                        \'url\': [\'/user/settings/profile\']\r\n                    },\r\n                    {\r\n                        \'label\': t(\'twig-widget\',\'Abmelden\'),\r\n                        \'url\': [\'/user/security/logout\'],\r\n                        \'linkOptions\': {\'data-method\': \'post\'}\r\n                    }\r\n                ]\r\n            }\r\n        ])\r\n    }) }}\r\n{{ nav_bar_end() }}', '2022-05-24 13:20:24', '2024-10-09 14:20:08'),
    ('10', '_afterContent', '{{ use(\'yii/bootstrap\') }}\r\n\r\n<footer class=\"footer-navigation\">\r\n    {{ nav_widget({\r\n        \'encodeLabels\': false,\r\n        \'options\': {\r\n            \'role\': \'navigation\'\r\n        },\r\n        \'class\': \'\',\r\n        \'items\': Tree.getMenuItems(\'footer\')|merge([{\r\n            \'label\': \'<img class=\"hrzg-logo\" alt=\"Logo herzog kommunikation GmbH\" src=\"/_phd/dmstr-logo.svg\">\',\r\n            \'url\': \'#\',\r\n            \'linkOptions\': {\r\n                \'role\': \'button\',\r\n                \'data\': {\r\n                    \'toggle\': \'modal\',\r\n                    \'target\': \'#footer-modal\'\r\n                }\r\n            }\r\n        }])\r\n    }) }}\r\n</footer>\r\n\r\n<div id=\"footer-modal\" class=\"modal fade\" tabindex=\"-1\" role=\"dialog\">\r\n  <div class=\"modal-dialog modal-sm\" role=\"document\">\r\n    <div class=\"modal-content\">\r\n      <div class=\"modal-body\">\r\n          <div>\r\n            Realized by <b><a href=\"https://herzogkommunikation.de\" target=\"_blank\">herzog kommunikation GmbH</a></b>, Stuttgart  \r\n          </div>\r\n          <div>\r\n            <b><a class=\"modal-login\" href=\"{{ Url.to([\'/backend/default/index\']) }}\">{{ app.user.isGuest ? t(\'twig-widget\', \'Anmelden\') : t(\'twig-widget\', \'Backend\') }}</a></b>\r\n          </div>\r\n      </div>\r\n    </div>\r\n  </div>\r\n</div>', '2022-09-22 13:54:12', '2024-10-09 12:54:37');

INSERT INTO `dmstr_redirect` (`type`, `from_domain`, `to_domain`, `from_path`, `to_path`, `status_code`, `created_at`, `updated_at`)
VALUES
    ('path', '', '', '/datenschutz', '/de/p/datenschutz-22.html', '301', '2025-04-23 20:42:29', '2025-04-23 20:42:29'),
    ( 'path', '', '', '/impressum', '/de/p/impressum-23.html', '301', '2025-04-23 20:42:53', '2025-04-23 20:42:53');
