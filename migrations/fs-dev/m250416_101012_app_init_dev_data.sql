# ************************************************************
# Sequel Pro SQL dump
# Version 5446
#
# https://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 192.168.56.10 (MySQL 5.7.44-48)
# Database: phd5-newfs
# Generation Time: 2025-04-16 08:52:57 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table app_auth_assignment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_auth_assignment`;

CREATE TABLE `app_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `app_idx-auth_assignment-user_id` (`user_id`),
  CONSTRAINT `app_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `app_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `app_auth_assignment` WRITE;
/*!40000 ALTER TABLE `app_auth_assignment` DISABLE KEYS */;

INSERT INTO `app_auth_assignment` (`item_name`, `user_id`, `created_at`)
VALUES
	('Editor','2',1744793332);

/*!40000 ALTER TABLE `app_auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table app_dmstr_page
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_dmstr_page`;

CREATE TABLE `app_dmstr_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `root` int(11) NOT NULL DEFAULT '0',
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `lvl` smallint(6) NOT NULL,
  `domain_id` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `view` varchar(255) DEFAULT NULL,
  `request_params` text,
  `access_owner` int(11) DEFAULT NULL,
  `access_domain` varchar(8) DEFAULT NULL,
  `access_read` varchar(255) DEFAULT NULL,
  `access_update` varchar(255) DEFAULT NULL,
  `access_delete` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `icon_type` smallint(6) DEFAULT '1',
  `active` smallint(6) DEFAULT '1',
  `selected` smallint(6) DEFAULT '0',
  `readonly` smallint(6) DEFAULT '0',
  `collapsed` smallint(6) DEFAULT '0',
  `movable_u` smallint(6) DEFAULT '1',
  `movable_d` smallint(6) DEFAULT '1',
  `movable_l` smallint(6) DEFAULT '1',
  `movable_r` smallint(6) DEFAULT '1',
  `removable` smallint(6) DEFAULT '1',
  `removable_all` smallint(6) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_id_UNIQUE` (`domain_id`,`access_domain`),
  KEY `tbl_tree_NK1` (`root`),
  KEY `tbl_tree_NK2` (`lft`),
  KEY `tbl_tree_NK3` (`rgt`),
  KEY `tbl_tree_NK4` (`lvl`),
  KEY `tbl_tree_NK5` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `app_dmstr_page` WRITE;
/*!40000 ALTER TABLE `app_dmstr_page` DISABLE KEYS */;

INSERT INTO `app_dmstr_page` (`id`, `root`, `lft`, `rgt`, `lvl`, `domain_id`, `slug`, `route`, `view`, `request_params`, `access_owner`, `access_domain`, `access_read`, `access_update`, `access_delete`, `icon`, `icon_type`, `active`, `selected`, `readonly`, `collapsed`, `movable_u`, `movable_d`, `movable_l`, `movable_r`, `removable`, `removable_all`, `created_at`, `updated_at`)
VALUES
	(1,1,1,8,0,'backend',NULL,'','','{}',1,'en','BackendEditor','Master','Master','',1,1,0,0,0,1,1,1,1,1,0,'2025-04-16 08:37:36','2025-04-16 08:43:46'),
	(2,1,2,3,1,'67ff6c9222d37',NULL,'/filemanager/backend','','{}',1,'en','FilemanagerEditor','Master','Master','file-image-o',1,1,0,0,0,1,1,1,1,1,0,'2025-04-16 08:38:42','2025-04-16 08:44:19'),
	(3,1,4,5,1,'67ff6e56c873e',NULL,'/user','','{}',1,'en','UserMaster','Master','Master','user',1,1,0,0,0,1,1,1,1,1,0,'2025-04-16 08:46:14','2025-04-16 08:46:14'),
	(4,1,6,7,1,'67ff6e9785e11',NULL,'/pages/default','','{}',1,'en','PagesEditor','Master','Master','tree',1,1,0,0,0,1,1,1,1,1,0,'2025-04-16 08:47:19','2025-04-16 08:47:19');

/*!40000 ALTER TABLE `app_dmstr_page` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table app_dmstr_page_translation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_dmstr_page_translation`;

CREATE TABLE `app_dmstr_page_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `language` char(7) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `page_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `default_meta_keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `default_meta_description` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_page_translation_page` (`page_id`),
  CONSTRAINT `FK_page_translation_page` FOREIGN KEY (`page_id`) REFERENCES `app_dmstr_page` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `app_dmstr_page_translation` WRITE;
/*!40000 ALTER TABLE `app_dmstr_page_translation` DISABLE KEYS */;

INSERT INTO `app_dmstr_page_translation` (`id`, `page_id`, `language`, `name`, `page_title`, `default_meta_keywords`, `default_meta_description`, `created_at`, `updated_at`)
VALUES
	(1,1,'en','backend','backend',NULL,NULL,'2025-04-16 08:37:36','2025-04-16 08:37:36'),
	(2,2,'en','filemanager','filemanager',NULL,NULL,'2025-04-16 08:38:42','2025-04-16 08:38:42'),
	(3,3,'en','user','user & permissions',NULL,NULL,'2025-04-16 08:46:14','2025-04-16 08:46:14'),
	(4,4,'en','pages','pages',NULL,NULL,'2025-04-16 08:47:19','2025-04-16 08:47:19');

/*!40000 ALTER TABLE `app_dmstr_page_translation` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table app_dmstr_page_translation_meta
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_dmstr_page_translation_meta`;

CREATE TABLE `app_dmstr_page_translation_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `language` char(7) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` smallint(6) DEFAULT '0',
  `visible` smallint(6) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_page_page_translation_meta_id` (`page_id`),
  CONSTRAINT `fk_page_page_translation_meta_id` FOREIGN KEY (`page_id`) REFERENCES `app_dmstr_page` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `app_dmstr_page_translation_meta` WRITE;
/*!40000 ALTER TABLE `app_dmstr_page_translation_meta` DISABLE KEYS */;

INSERT INTO `app_dmstr_page_translation_meta` (`id`, `page_id`, `language`, `disabled`, `visible`, `created_at`, `updated_at`)
VALUES
	(1,1,'en',0,1,'2025-04-16 08:37:36','2025-04-16 08:43:46'),
	(2,2,'en',0,1,'2025-04-16 08:38:42','2025-04-16 08:44:19'),
	(3,3,'en',0,1,'2025-04-16 08:46:14','2025-04-16 08:46:14'),
	(4,4,'en',0,1,'2025-04-16 08:47:19','2025-04-16 08:47:19');

/*!40000 ALTER TABLE `app_dmstr_page_translation_meta` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table app_settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_settings`;

CREATE TABLE `app_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `section` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text,
  `active` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_unique_key_section` (`section`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `app_settings` WRITE;
/*!40000 ALTER TABLE `app_settings` DISABLE KEYS */;

INSERT INTO `app_settings` (`id`, `type`, `section`, `key`, `value`, `active`, `created`, `modified`)
VALUES
	(1,'object','widgets','availablePhpClasses','{\"hrzg\\\\widget\\\\widgets\\\\TwigTemplate\": \"Twig layout\"}',1,'2025-04-16 08:34:54',NULL),
	(2,'string','backend.adminlte','skin','black-light',1,'2025-04-16 08:34:54',NULL),
	(3,'string','app.assets','registerPrototypeAssetKey','default',0,'2025-04-16 08:34:54','2025-04-16 08:34:54'),
	(4,'string','pages','availableRoutes','/pages/default/page\n/filemanager/backend\n/user',1,'2025-04-16 08:34:54',NULL),
	(5,'string','pages','availableGlobalRoutes','/pages/default',1,'2025-04-16 08:34:54',NULL),
	(6,'string','pages','availableViews','@vendor/dmstr/yii2-pages-module/example-views/column1.php',1,'2025-04-16 08:34:54',NULL),
	(7,'string','frontend','backendWidget','modal',1,'2025-04-16 08:34:55',NULL),
	(8,'string','app.assets','settingsAssetList','app\\assets\\AppAsset',1,'2025-04-16 08:35:00',NULL),
	(9,'string','frontend','growl.location','br',1,'2025-04-16 08:35:01',NULL),
	(10,'string','backend','growl.location','br',1,'2025-04-16 08:35:15',NULL);

/*!40000 ALTER TABLE `app_settings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table app_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_user`;

CREATE TABLE `app_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `unconfirmed_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `registration_ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `flags` int(11) NOT NULL DEFAULT '0',
  `confirmed_at` int(11) DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `last_login_at` int(11) DEFAULT NULL,
  `last_login_ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_tf_key` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_tf_enabled` tinyint(1) DEFAULT '0',
  `auth_tf_type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_tf_mobile_phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_changed_at` int(11) DEFAULT NULL,
  `gdpr_consent` tinyint(1) DEFAULT '0',
  `gdpr_consent_date` int(11) DEFAULT NULL,
  `gdpr_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_user_username` (`username`),
  UNIQUE KEY `idx_user_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `app_user` WRITE;
/*!40000 ALTER TABLE `app_user` DISABLE KEYS */;

INSERT INTO `app_user` (`id`, `username`, `email`, `password_hash`, `auth_key`, `unconfirmed_email`, `registration_ip`, `flags`, `confirmed_at`, `blocked_at`, `updated_at`, `created_at`, `last_login_at`, `last_login_ip`, `auth_tf_key`, `auth_tf_enabled`, `auth_tf_type`, `auth_tf_mobile_phone`, `password_changed_at`, `gdpr_consent`, `gdpr_consent_date`, `gdpr_deleted`)
VALUES
	(1,'admin','admin@local.develop','$2y$10$s3NwRaXxuvfoOf3p2kuFk.h9uGmM/4sdC1X0/l1FBVVjBaaLR4tLy','t7oyFzGiNX-35f-2-Wad0bxAl_YovsqA',NULL,NULL,0,1744792495,NULL,1744792495,1744792495,1744792506,'192.168.56.1','',0,NULL,NULL,1744792495,0,1744792495,0),
	(2,'editor','dev-editor@h17n.de','$2y$10$eNAfnxV/otaxvnftJvIvzOF6Ar6A7o0bHVt2eWz8KkDMJic1khlxe','-04x-tXJDZOU_CcFGXRB8hOKdx2hzYDM',NULL,'192.168.56.1',0,1744793314,NULL,1744793314,1744793314,1744793365,'192.168.56.1','',0,NULL,NULL,1744793314,0,1744793314,0);

/*!40000 ALTER TABLE `app_user` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
