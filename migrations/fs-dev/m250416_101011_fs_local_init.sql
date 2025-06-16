# ************************************************************
# Sequel Pro SQL dump
# Version 5446
#
# https://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 192.168.56.10 (MySQL 5.7.44-48)
# Database: phd5-newfs
# Generation Time: 2025-04-16 07:59:11 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table app_storage_item
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_storage_item`;

CREATE TABLE `app_storage_item` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `storage_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_synced_at` datetime NOT NULL,
  `permission_owner` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `permission_owner_grant` int(11) unsigned DEFAULT NULL,
  `permission_group_grant` int(11) unsigned DEFAULT NULL,
  `permission_group_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `permission_other_grant` int(11) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `storageIdIdx` (`storage_id`),
  KEY `storageId2PathIdx` (`storage_id`,`path`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `app_storage_item` WRITE;
/*!40000 ALTER TABLE `app_storage_item` DISABLE KEYS */;

INSERT INTO `app_storage_item` (`id`, `storage_id`, `path`, `name`, `type`, `last_synced_at`, `permission_owner`, `permission_owner_grant`, `permission_group_grant`, `permission_group_name`, `permission_other_grant`, `created_at`, `updated_at`)
VALUES
	('3946c8dd-2e16-53d1-9fba-2fe9324f7113','fsLocal','/protected','hello-world.png','file','2025-04-16 07:35:10',NULL,NULL,NULL,NULL,NULL,'2025-04-16 07:35:10','2025-04-16 07:35:10'),
	('6b2731e7-30ca-5d8d-8d8e-32e063722bf6','fsLocal','/public','dummy.jpeg','file','2025-04-16 07:24:53',NULL,NULL,NULL,NULL,NULL,'2025-04-16 07:24:53','2025-04-16 07:24:53'),
	('7128e2f4-2ae5-59f1-80cb-769c28e08603','fsLocal','/','public','dir','2025-04-16 07:36:34',NULL,NULL,NULL,NULL,1,'2025-04-16 07:00:37','2025-04-16 07:36:34'),
	('786fa2a7-26fc-505d-9418-4a5ec4cb5df6','fsLocal','/public','public-text.txt','file','2025-04-16 07:24:53',NULL,NULL,NULL,NULL,NULL,'2025-04-16 07:24:53','2025-04-16 07:24:53'),
	('7b492b24-de50-5ed2-88c5-5c77934bfdb0','fsLocal','/public','docker.png','file','2025-04-16 07:24:53',NULL,NULL,NULL,NULL,NULL,'2025-04-16 07:24:53','2025-04-16 07:24:53'),
	('b2bd3d61-b7d1-5840-a5df-ee5b61be7487','fsLocal','/','.','root','2025-04-16 07:00:19','1',15,15,'FilemanagerEditor',0,'2025-04-16 07:00:19','2025-04-16 07:00:19'),
	('f5b26fa7-9f23-5afe-9ed7-9a073c52e848','fsLocal','/protected','privat-text.txt','file','2025-04-16 07:27:16',NULL,NULL,NULL,NULL,NULL,'2025-04-16 07:27:16','2025-04-16 07:27:16'),
	('f947cdd3-ec43-520a-a597-6ad3105d960a','fsLocal','/','protected','dir','2025-04-16 07:35:53',NULL,NULL,NULL,NULL,0,'2025-04-16 07:00:54','2025-04-16 07:35:53');

/*!40000 ALTER TABLE `app_storage_item` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
