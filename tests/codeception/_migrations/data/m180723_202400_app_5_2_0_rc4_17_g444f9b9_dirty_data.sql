-- MySQL dump 10.16  Distrib 10.1.26-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: db    Database: test-phd5
-- ------------------------------------------------------
-- Server version	5.7.20-19

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `app_auth_item`
--

LOCK TABLES `app_auth_item` WRITE; TRUNCATE TABLE `app_auth_item`;
/*!40000 ALTER TABLE `app_auth_item` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `app_auth_item` VALUES ('Admin',1,'Legacy generic admin permission',NULL,NULL,1467315829,1489020665);
INSERT INTO `app_auth_item` VALUES ('app',2,'All Application Controllers (without modules) [route]',NULL,NULL,1467315829,1489020665);
INSERT INTO `app_auth_item` VALUES ('app_site',2,'Main Application Controller [route]',NULL,NULL,1463048457,1489020650);
INSERT INTO `app_auth_item` VALUES ('audit-module',2,'Audit Module',NULL,NULL,1463048457,1489020650);
INSERT INTO `app_auth_item` VALUES ('audit',2,'/audit [Route]',NULL,NULL,1463048457,1489020650);
INSERT INTO `app_auth_item` VALUES ('backend',2,'Backend Module [route]',NULL,NULL,1467315450,1489020634);
INSERT INTO `app_auth_item` VALUES ('backend_default_index',2,'Backend Dashboard Controller [route]',NULL,NULL,1485792049,1489020625);
INSERT INTO `app_auth_item` VALUES ('docs',2,'Documentation Module Guide [route]',NULL,NULL,1470099425,1489020612);
INSERT INTO `app_auth_item` VALUES ('Editor',1,'CMS Editor',NULL,NULL,1463048457,1489018947);
INSERT INTO `app_auth_item` VALUES ('filefly',2,'FileFly Manager Module [route]',NULL,NULL,1466785441,1489020535);
INSERT INTO `app_auth_item` VALUES ('filefly_api_index',2,'FileFly API Controllers [route]',NULL,NULL,1466785441,1489020557);
INSERT INTO `app_auth_item` VALUES ('filefly_default_index',2,'FileFly Manager Overview Controller [route]',NULL,NULL,1466785441,1489020574);
INSERT INTO `app_auth_item` VALUES ('FileflyAdmin',1,NULL,NULL,NULL,1466785441,1466785441);
INSERT INTO `app_auth_item` VALUES ('FileflyApi',1,NULL,NULL,NULL,1466785441,1466785441);
INSERT INTO `app_auth_item` VALUES ('FileflyDefault',1,NULL,NULL,NULL,1466785441,1466785441);
INSERT INTO `app_auth_item` VALUES ('FileflyPermissions',1,NULL,NULL,NULL,1467242026,1467242026);
INSERT INTO `app_auth_item` VALUES ('FrontendDeveloper',1,'CMS Frontend Developer',NULL,NULL,1489017224,1489018937);
INSERT INTO `app_auth_item` VALUES ('help',2,'Documentation Module Online Help [route]',NULL,NULL,1485794388,1489020594);
INSERT INTO `app_auth_item` VALUES ('Master',1,'Full Backend Access',NULL,NULL,1467314316,1489018957);
INSERT INTO `app_auth_item` VALUES ('pages',2,'Pages Module [route]',NULL,NULL,1463048455,1489020320);
INSERT INTO `app_auth_item` VALUES ('pages_copy',2,'Pages Copy Controller [route]',NULL,NULL,1487694290,1489020343);
INSERT INTO `app_auth_item` VALUES ('pages_default_page',2,'CMS Page View Action [route]',NULL,NULL,1463048457,1489020392);
INSERT INTO `app_auth_item` VALUES ('Preview',1,'Preview Access',NULL,NULL,1467331401,1489018970);
INSERT INTO `app_auth_item` VALUES ('prototype',2,'CMS Prototype Module [route]',NULL,NULL,1463351107,1489020375);
INSERT INTO `app_auth_item` VALUES ('prototype_render_twig',2,'deprecated',NULL,NULL,1463350937,1489020417);
INSERT INTO `app_auth_item` VALUES ('Default',1,'Authenticated User',NULL,NULL,1463048457,1463048457);
INSERT INTO `app_auth_item` VALUES ('Public',1,'Unauthenticated User',NULL,NULL,1463048457,1463048457);
INSERT INTO `app_auth_item` VALUES ('Guest',1,'Guest User',NULL,NULL,1463048457,1463048457);
INSERT INTO `app_auth_item` VALUES ('resque',2,'Resque Job Module [route]',NULL,NULL,1467318093,1489020432);
INSERT INTO `app_auth_item` VALUES ('redirects',2,'/redirects/* [route]',NULL,NULL,1467318093,1489020432);
INSERT INTO `app_auth_item` VALUES ('settings',2,'[route]',NULL,NULL,1467315669,1489020446);
INSERT INTO `app_auth_item` VALUES ('settings-module',2,'Settings Module',NULL,NULL,1467315605,1489020455);
INSERT INTO `app_auth_item` VALUES ('translate-module',2,'Translation Manager Module',NULL,NULL,1467318323,1489020467);
INSERT INTO `app_auth_item` VALUES ('translatemanager',2,'[route]',NULL,NULL,1467318500,1489020477);
INSERT INTO `app_auth_item` VALUES ('user',2,'[route]',NULL,NULL,1467318564,1489020489);
INSERT INTO `app_auth_item` VALUES ('user-module',2,'User Module',NULL,NULL,1467318289,1489020499);
INSERT INTO `app_auth_item` VALUES ('widgets',2,'Module (route)',NULL,NULL,1464109408,1467315725);
INSERT INTO `app_auth_item` VALUES ('widgets_copy',2,'Widgets Copy',NULL,NULL,1488904468,1488904468);
INSERT INTO `app_auth_item` VALUES ('widgets_crud_api',2,'Widgets CRUD API',NULL,NULL,1491193845,1491193845);
INSERT INTO `app_auth_item` VALUES ('widgets_crud_widget',2,'WIdget content editing',NULL,NULL,1467318867,1467318867);
INSERT INTO `app_auth_item` VALUES ('widgets_crud_widget_copy',2,'Widgets CRUD Content Copy',NULL,NULL,1491193845,1491193845);
INSERT INTO `app_auth_item` VALUES ('widgets_crud_widget_create',2,'Widgets CRUD Content Create',NULL,NULL,1491193845,1491193845);
INSERT INTO `app_auth_item` VALUES ('widgets_crud_widget_delete',2,'Widgets CRUD Content Delete',NULL,NULL,1491193845,1491193845);
INSERT INTO `app_auth_item` VALUES ('widgets_crud_widget_index',2,'Widgets CRUD Content Index',NULL,NULL,1491193845,1491193845);
INSERT INTO `app_auth_item` VALUES ('widgets_crud_widget_update',2,'Widgets CRUD Content Update',NULL,NULL,1491193845,1491193845);
INSERT INTO `app_auth_item` VALUES ('widgets_crud_widget_view',2,'Widgets CRUD Content View',NULL,NULL,1491193845,1491193845);
INSERT INTO `app_auth_item` VALUES ('widgets_default_index',2,'Widgets Manager',NULL,NULL,1491193845,1491193845);
INSERT INTO `app_auth_item` VALUES ('widgets_test',2,'Widgets TEST Playground',NULL,NULL,1491193845,1491193845);
INSERT INTO `app_auth_item` VALUES ('widgets-cell-edit',2,'Widgets frontend buttons',NULL,NULL,1532371751,1532371751);
INSERT INTO `app_auth_item` VALUES ('contact_default_index',2,'',NULL,NULL,1629714940,1629714940);
/*!40000 ALTER TABLE `app_auth_item` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping data for table `app_auth_item_child`
--

LOCK TABLES `app_auth_item_child` WRITE; TRUNCATE TABLE `app_auth_item_child`;
/*!40000 ALTER TABLE `app_auth_item_child` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `app_auth_item_child` VALUES ('Master','Admin');
INSERT INTO `app_auth_item_child` VALUES ('Master','app');
INSERT INTO `app_auth_item_child` VALUES ('Editor','app_site');
INSERT INTO `app_auth_item_child` VALUES ('Master','audit-module');
INSERT INTO `app_auth_item_child` VALUES ('Master','redirects');
INSERT INTO `app_auth_item_child` VALUES ('audit-module','audit');
INSERT INTO `app_auth_item_child` VALUES ('Editor','widgets-cell-edit');
INSERT INTO `app_auth_item_child` VALUES ('Preview','app_site');
INSERT INTO `app_auth_item_child` VALUES ('Master','backend');
INSERT INTO `app_auth_item_child` VALUES ('Editor','backend_default_index');
INSERT INTO `app_auth_item_child` VALUES ('FrontendDeveloper','backend_default_index');
INSERT INTO `app_auth_item_child` VALUES ('Editor','docs');
INSERT INTO `app_auth_item_child` VALUES ('Master','docs');
INSERT INTO `app_auth_item_child` VALUES ('FrontendDeveloper','Editor');
INSERT INTO `app_auth_item_child` VALUES ('Master','Editor');
INSERT INTO `app_auth_item_child` VALUES ('Editor','filefly');
INSERT INTO `app_auth_item_child` VALUES ('FileflyAdmin','filefly');
INSERT INTO `app_auth_item_child` VALUES ('Master','filefly');
INSERT INTO `app_auth_item_child` VALUES ('FileflyApi','filefly_api_index');
INSERT INTO `app_auth_item_child` VALUES ('FileflyDefault','filefly_default_index');
INSERT INTO `app_auth_item_child` VALUES ('FrontendDeveloper','FileflyApi');
INSERT INTO `app_auth_item_child` VALUES ('FileflyAdmin','FileflyPermissions');
INSERT INTO `app_auth_item_child` VALUES ('Editor','help');
INSERT INTO `app_auth_item_child` VALUES ('Editor','pages');
INSERT INTO `app_auth_item_child` VALUES ('FrontendDeveloper','pages');
INSERT INTO `app_auth_item_child` VALUES ('Master','pages');
INSERT INTO `app_auth_item_child` VALUES ('Preview','pages_default_page');
INSERT INTO `app_auth_item_child` VALUES ('FrontendDeveloper','prototype');
INSERT INTO `app_auth_item_child` VALUES ('Master','prototype');
INSERT INTO `app_auth_item_child` VALUES ('Editor','prototype_render_twig');
INSERT INTO `app_auth_item_child` VALUES ('Editor','Public');
INSERT INTO `app_auth_item_child` VALUES ('FrontendDeveloper','Public');
INSERT INTO `app_auth_item_child` VALUES ('Master','resque');
INSERT INTO `app_auth_item_child` VALUES ('settings-module','settings');
INSERT INTO `app_auth_item_child` VALUES ('FrontendDeveloper','settings-module');
INSERT INTO `app_auth_item_child` VALUES ('Master','settings-module');
INSERT INTO `app_auth_item_child` VALUES ('FrontendDeveloper','translate-module');
INSERT INTO `app_auth_item_child` VALUES ('Master','translate-module');
INSERT INTO `app_auth_item_child` VALUES ('translate-module','translatemanager');
INSERT INTO `app_auth_item_child` VALUES ('user-module','user');
INSERT INTO `app_auth_item_child` VALUES ('Master','user-module');
INSERT INTO `app_auth_item_child` VALUES ('FrontendDeveloper','widgets');
INSERT INTO `app_auth_item_child` VALUES ('Master','widgets');
INSERT INTO `app_auth_item_child` VALUES ('Editor','widgets_crud_widget');
INSERT INTO `app_auth_item_child` VALUES ('Public','contact_default_index');
INSERT INTO `app_auth_item_child` VALUES ('Guest','Public');
INSERT INTO `app_auth_item_child` VALUES ('Default','Public');
/*!40000 ALTER TABLE `app_auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping data for table `app_auth_rule`
--

LOCK TABLES `app_auth_rule` WRITE; TRUNCATE TABLE `app_auth_rule`;
/*!40000 ALTER TABLE `app_auth_rule` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `app_auth_rule` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping data for table `app_dmstr_page`
--

LOCK TABLES `app_dmstr_page` WRITE; TRUNCATE TABLE `app_dmstr_page`;
/*!40000 ALTER TABLE `app_dmstr_page` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `app_dmstr_page` VALUES (101,1000,6,7,1,'pages',NULL,'/pages/default','','{}',NULL,'*','*','*','*','pagelines',1,1,0,0,0,1,1,1,1,1,0,'2016-05-13 11:16:16','2017-01-30 09:45:52');
INSERT INTO `app_dmstr_page` VALUES (102,1000,17,18,2,'prototype-less',NULL,'/prototype/less','','{}',NULL,'*','*','*','*','pencil-square',1,1,0,0,0,1,1,1,1,1,0,'2016-05-15 18:51:34','2016-09-30 03:18:36');
INSERT INTO `app_dmstr_page` VALUES (103,1000,21,22,2,'prototype-html',NULL,'/prototype/html','','{}',NULL,'*','*','*','*','edit',1,1,0,0,0,1,1,1,1,1,0,'2016-05-13 11:16:19','2017-02-08 08:56:42');
INSERT INTO `app_dmstr_page` VALUES (104,1000,11,12,2,'translatemanager',NULL,'/translatemanager/language','','{}',NULL,'*','*','*','*','globe',1,1,0,0,0,1,1,1,1,1,0,'2016-05-15 18:16:16','2016-05-16 09:44:40');
INSERT INTO `app_dmstr_page` VALUES (105,1000,24,25,1,'user',NULL,'/user/admin','','{}',NULL,'*','*','*','*','user',1,1,0,0,0,1,1,1,1,1,0,'2016-05-15 18:16:16','2017-02-13 15:48:06');
INSERT INTO `app_dmstr_page` VALUES (107,1000,19,20,2,'twig',NULL,'/prototype/twig','','{}',NULL,'*','*','*','*','newspaper-o',1,1,0,0,0,1,1,1,1,1,0,'2016-05-16 00:34:43','2016-09-30 03:18:27');
INSERT INTO `app_dmstr_page` VALUES (108,1000,27,28,2,'settings',NULL,'/settings/default','','{\"sort\":\"section\"}',NULL,'*','*','*','*','cog',1,1,0,0,0,1,1,1,1,1,0,'2016-05-13 11:16:14','2017-02-08 11:16:07');
INSERT INTO `app_dmstr_page` VALUES (110,1000,35,36,2,'jobs',NULL,'/resque','','{}',NULL,'*','*','*','*','play-circle',1,1,0,0,0,1,1,1,1,1,0,'2016-05-16 09:54:07','2016-12-23 00:17:01');
INSERT INTO `app_dmstr_page` VALUES (111,1000,33,34,2,'redirects',NULL,'/redirects','','{}',NULL,'*','*','*','*','arrows-alt',1,1,0,0,0,1,1,1,1,1,0,'2016-05-16 09:52:36','2016-05-16 09:52:36');
INSERT INTO `app_dmstr_page` VALUES (112,1000,9,10,2,'widgets-content',NULL,'/widgets/crud/widget','','{}',NULL,'*','*','*','*','file-text',1,1,0,0,0,1,1,1,1,1,0,'2016-05-25 20:34:20','2017-02-01 10:05:14');
INSERT INTO `app_dmstr_page` VALUES (113,1000,15,16,2,'widget-templates',NULL,'/widgets/crud/widget-template','','{}',NULL,'*','*','*','*','file-code-o',1,1,0,0,0,1,1,1,1,1,0,'2016-05-25 20:35:04','2017-03-08 23:45:14');
INSERT INTO `app_dmstr_page` VALUES (114,1000,37,38,2,'audit',NULL,'/audit','','{}',NULL,'*','*','*','*','search-plus',1,1,0,0,0,1,1,1,1,1,0,'2016-05-16 09:51:22','2016-05-16 09:51:22');
INSERT INTO `app_dmstr_page` VALUES (115,1000,4,5,1,'moxiemanager',NULL,'/filefly','','{}',NULL,'*','*','*','*','image',1,1,0,0,0,1,1,1,1,1,0,'2016-05-25 22:29:42','2017-01-30 09:35:49');
INSERT INTO `app_dmstr_page` VALUES (147,1000,8,13,1,'cms',NULL,'','','{}',NULL,'*','*','*','*','briefcase',1,1,0,0,0,1,1,1,1,1,0,'2016-12-22 23:22:25','2017-01-30 16:07:09');
INSERT INTO `app_dmstr_page` VALUES (148,1000,26,39,1,'system',NULL,'','','{}',NULL,'*','*','*','*','cogs',1,1,0,0,0,1,1,1,1,1,0,'2016-12-22 23:34:27','2016-12-23 02:36:14');
INSERT INTO `app_dmstr_page` VALUES (149,1000,29,30,2,'configuration',NULL,'/backend/default/view-config','','{}',NULL,'*','*','*','*','suitcase',1,1,0,0,0,1,1,1,1,1,0,'2016-12-22 23:45:18','2016-12-22 23:45:18');
INSERT INTO `app_dmstr_page` VALUES (150,1000,14,23,1,'developer-tools',NULL,'','','{}',NULL,'*','*','*','*','code',1,1,0,0,0,1,1,1,1,1,0,'2017-01-30 09:34:08','2017-01-30 09:34:45');
INSERT INTO `app_dmstr_page` VALUES (151,1000,2,3,1,'dashboard',NULL,'/backend/default/index','','{}',NULL,'*','*','*','*','dashboard',1,1,0,0,0,1,1,1,1,1,0,'2017-01-30 10:00:06','2017-01-30 16:22:35');
INSERT INTO `app_dmstr_page` VALUES (1000,1000,1,44,0,'backend',NULL,'/backend','','{}',NULL,'*','*','*','*','',1,1,0,0,1,1,1,1,1,1,0,'2016-05-15 18:16:16','2016-05-13 11:09:59');
INSERT INTO `app_dmstr_page` VALUES (1001,1001,1,8,0,'root',NULL,'/pages/default/page','@vendor/dmstr/yii2-prototype-module/src/views/render/twig.php','{}',NULL,'en','*','*','*','',1,1,0,0,0,1,1,1,1,1,0,'2016-05-15 22:32:46','2017-01-30 17:01:47');
INSERT INTO `app_dmstr_page` VALUES (1003,1003,1,4,0,'root',NULL,'','','{}',0,'de','*','*','*','',1,1,0,0,0,1,1,1,1,1,0,'2016-05-15 22:54:23','2018-07-23 20:11:57');
INSERT INTO `app_dmstr_page` VALUES (1004,1003,2,3,1,'test-a',NULL,'/pages/default/page','@vendor/dmstr/yii2-prototype-module/src/views/render/twig.php','{}',0,'de','*','*','*','',1,1,0,0,0,1,1,1,1,1,0,'2016-05-15 22:54:36','2018-07-23 20:13:26');
INSERT INTO `app_dmstr_page` VALUES (1035,1001,2,3,1,'folder-1',NULL,'/pages/default/page','@vendor/dmstr/yii2-widgets2-module/src/views/test/single.twig','{}',NULL,'en','*','*','*','',1,1,0,0,0,1,1,1,1,1,0,'2016-08-01 23:18:32','2017-02-01 09:56:08');
INSERT INTO `app_dmstr_page` VALUES (1044,1044,1,2,0,'root',NULL,'','','{}',NULL,'ru','*','*','*','',1,1,0,0,0,1,1,1,1,1,0,'2016-11-08 15:09:28','2016-11-08 15:09:28');
INSERT INTO `app_dmstr_page` VALUES (1054,1000,31,32,2,'58bd0aa4a8b58',NULL,'/backend/default/show-auth','','{}',NULL,'*','*','*','*','certificate',1,1,0,0,0,1,1,1,1,1,0,'2017-03-06 07:07:16','2017-03-09 00:51:35');
INSERT INTO `app_dmstr_page` VALUES (1055,1001,4,5,1,'58e1d41112d56',NULL,'','','{}',1,'en','*','*','*','',1,1,0,0,0,1,1,1,1,1,0,'2017-04-03 04:48:17','2017-04-03 04:48:17');
INSERT INTO `app_dmstr_page` VALUES (1056,1001,6,7,1,'5b563610a2c79',NULL,'','','{}',1,'en','*',NULL,NULL,'',1,1,0,0,0,1,1,1,1,1,0,'2018-07-23 20:09:52','2018-07-23 20:09:52');
/*!40000 ALTER TABLE `app_dmstr_page` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping data for table `app_dmstr_page_translation`
--

LOCK TABLES `app_dmstr_page_translation` WRITE; TRUNCATE TABLE `app_dmstr_page_translation`;
/*!40000 ALTER TABLE `app_dmstr_page_translation` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `app_dmstr_page_translation` VALUES (1,101,'en','Page Tree','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (2,101,'de','Page Tree','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (3,101,'ru','Page Tree','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (4,102,'en','LESS Themes','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (5,102,'de','LESS Themes','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (6,102,'ru','LESS Themes','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (7,103,'en','Static HTML','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (8,103,'de','Static HTML','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (9,103,'ru','Static HTML','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (10,104,'en','Translations','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (11,104,'de','Translations','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (12,104,'ru','Translations','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (13,105,'en','Users and Roles','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (14,105,'de','Users and Roles','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (15,105,'ru','Users and Roles','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (16,107,'en','Twig Layouts','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (17,107,'de','Twig Layouts','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (18,107,'ru','Twig Layouts','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (19,108,'en','Settings','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (20,108,'de','Settings','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (21,108,'ru','Settings','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (22,110,'en','Jobs','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (23,110,'de','Jobs','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (24,110,'ru','Jobs','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (25,111,'en','Redirects','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (26,111,'de','Redirects','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (27,111,'ru','Redirects','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (28,112,'en','Widget Content','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (29,112,'de','Widget Content','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (30,112,'ru','Widget Content','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (31,113,'en','Widget Templates','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (32,113,'de','Widget Templates','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (33,113,'ru','Widget Templates','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (34,114,'en','Audit','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (35,114,'de','Audit','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (36,114,'ru','Audit','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (37,115,'en','Media Files','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (38,115,'de','Media Files','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (39,115,'ru','Media Files','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (40,147,'en','CMS','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (41,147,'de','CMS','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (42,147,'ru','CMS','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (43,148,'en','System','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (44,148,'de','System','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (45,148,'ru','System','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (46,149,'en','Configuration','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (47,149,'de','Configuration','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (48,149,'ru','Configuration','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (49,150,'en','Frontend Developer','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (50,150,'de','Frontend Developer','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (51,150,'ru','Frontend Developer','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (52,151,'en','Dashboard','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (53,151,'de','Dashboard','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (54,151,'ru','Dashboard','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (55,1000,'en','Backend','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (56,1000,'de','Backend','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (57,1000,'ru','Backend','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (58,1001,'en','Frontend','doros zuhause','doro, home, dorolein','das ist doro, doro ist eine ganz tolle webseite','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (59,1003,'de','Frontend','_ROOT_CONTAINER_','_FOLDER','This is not a real page, just a container for the navigation.','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (60,1004,'de','Beispielseite A','Titel \"A\"','beispielseite, eine, beispiel, seite','dies ist eine beispielseite','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (61,1035,'en','Example Page','Example Page','example, page','this i a example page','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (62,1044,'ru','root_ru','','','','2018-07-23 18:49:11','2018-07-23 18:49:11');
INSERT INTO `app_dmstr_page_translation` VALUES (63,1054,'en','Authorizations','','','','2018-07-23 18:49:12','2018-07-23 18:49:12');
INSERT INTO `app_dmstr_page_translation` VALUES (64,1054,'de','Authorizations','','','','2018-07-23 18:49:12','2018-07-23 18:49:12');
INSERT INTO `app_dmstr_page_translation` VALUES (65,1054,'ru','Authorizations','','','','2018-07-23 18:49:12','2018-07-23 18:49:12');
INSERT INTO `app_dmstr_page_translation` VALUES (66,1055,'en','Test-58e1d40c0273e','','','','2018-07-23 18:49:12','2018-07-23 18:49:12');
INSERT INTO `app_dmstr_page_translation` VALUES (67,1056,'en','Test-5b56360dc366d',NULL,NULL,NULL,'2018-07-23 20:09:52','2018-07-23 20:09:52');
/*!40000 ALTER TABLE `app_dmstr_page_translation` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping data for table `app_dmstr_page_translation_meta`
--

LOCK TABLES `app_dmstr_page_translation_meta` WRITE; TRUNCATE TABLE `app_dmstr_page_translation_meta`;
/*!40000 ALTER TABLE `app_dmstr_page_translation_meta` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `app_dmstr_page_translation_meta` VALUES (1,101,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (2,102,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (3,103,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (4,104,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (5,105,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (6,107,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (7,108,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (8,110,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (9,111,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (10,112,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (11,113,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (12,114,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (13,115,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (14,147,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (15,148,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (16,149,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (17,150,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (18,151,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (19,1000,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (20,1001,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (21,1003,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (22,1004,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (23,1035,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (24,1044,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (25,1054,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (26,1055,'en',0,1,NULL,NULL);
INSERT INTO `app_dmstr_page_translation_meta` VALUES (27,1056,'en',0,1,'2018-07-23 20:09:52','2018-07-23 20:09:52');
INSERT INTO `app_dmstr_page_translation_meta` VALUES (28,1003,'de',0,1,'2018-07-23 20:11:57','2018-07-23 20:11:57');
INSERT INTO `app_dmstr_page_translation_meta` VALUES (29,1004,'de',0,1,'2018-07-23 20:12:01','2018-07-23 20:13:30');
/*!40000 ALTER TABLE `app_dmstr_page_translation_meta` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping data for table `app_dmstr_publication_category`
--

LOCK TABLES `app_dmstr_publication_category` WRITE; TRUNCATE TABLE `app_dmstr_publication_category`;
/*!40000 ALTER TABLE `app_dmstr_publication_category` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `app_dmstr_publication_category` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping data for table `app_dmstr_publication_category_translation`
--

LOCK TABLES `app_dmstr_publication_category_translation` WRITE; TRUNCATE TABLE `app_dmstr_publication_category_translation`;
/*!40000 ALTER TABLE `app_dmstr_publication_category_translation` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `app_dmstr_publication_category_translation` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping data for table `app_dmstr_publication_item`
--

LOCK TABLES `app_dmstr_publication_item` WRITE; TRUNCATE TABLE `app_dmstr_publication_item`;
/*!40000 ALTER TABLE `app_dmstr_publication_item` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `app_dmstr_publication_item` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping data for table `app_dmstr_publication_item_meta`
--

LOCK TABLES `app_dmstr_publication_item_meta` WRITE; TRUNCATE TABLE `app_dmstr_publication_item_meta`;
/*!40000 ALTER TABLE `app_dmstr_publication_item_meta` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `app_dmstr_publication_item_meta` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping data for table `app_dmstr_publication_item_translation`
--

LOCK TABLES `app_dmstr_publication_item_translation` WRITE; TRUNCATE TABLE `app_dmstr_publication_item_translation`;
/*!40000 ALTER TABLE `app_dmstr_publication_item_translation` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `app_dmstr_publication_item_translation` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping data for table `app_hrzg_widget_content`
--

LOCK TABLES `app_hrzg_widget_content` WRITE; TRUNCATE TABLE `app_hrzg_widget_content`;
/*!40000 ALTER TABLE `app_hrzg_widget_content` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `app_hrzg_widget_content` VALUES (131,'58bee1146d17d',19,'*','','_footer','050','','de','*','*','*',NULL,NULL,NULL,NULL,'2017-02-21 02:10:07');
INSERT INTO `app_hrzg_widget_content` VALUES (138,'58bee114722f9',17,'pages/default/page','1004','main','','','de','*','*','*',NULL,NULL,NULL,NULL,'2017-02-07 10:34:22');
INSERT INTO `app_hrzg_widget_content` VALUES (140,'58bee11474530',9,'pages/default/page','1004','main','050','','de','*','*','*',NULL,NULL,NULL,NULL,NULL);
INSERT INTO `app_hrzg_widget_content` VALUES (141,'58bee11476a0c',4,'pages/default/page','1004','main','080','','de','*','*','*',NULL,NULL,NULL,NULL,NULL);
INSERT INTO `app_hrzg_widget_content` VALUES (143,'58bee11478996',22,'pages/default/page','1004','main','020','','de','*','*','*',NULL,NULL,NULL,NULL,'2017-02-07 10:32:42');
INSERT INTO `app_hrzg_widget_content` VALUES (154,'58bee1147ade7',2,'pages/default/page','1004','main','060','','de','*','*','*',NULL,NULL,NULL,NULL,'2017-02-07 10:32:15');
INSERT INTO `app_hrzg_widget_content` VALUES (167,'58bee1147d088',25,'pages/default/page','1004','main','030','','de','*','*','*',NULL,NULL,NULL,NULL,'2017-02-07 10:32:24');
INSERT INTO `app_hrzg_widget_content` VALUES (168,'58bee114806cc',4,'app/site/index','','top','010','','de','*','*','*',NULL,NULL,NULL,NULL,'2017-02-18 01:56:18');
INSERT INTO `app_hrzg_widget_content` VALUES (178,'58bee114828dc',3,'app/site/index','','top','000','','de','*','*','*',NULL,NULL,NULL,NULL,'2018-07-23 20:20:56');
INSERT INTO `app_hrzg_widget_content` VALUES (182,'58bee1148a2ea',19,'pages/default/page','','_footer','100','','en','*','*','*',NULL,NULL,NULL,'2017-02-07 09:40:32','2017-02-07 09:54:39');
INSERT INTO `app_hrzg_widget_content` VALUES (188,'58bee1148c61d',3,'app/site/index','','main','a-58c09834','','ru','*','*','*',NULL,NULL,NULL,'2017-02-15 12:01:07','2017-04-03 04:59:22');
INSERT INTO `app_hrzg_widget_content` VALUES (190,'58c0a2e1b4738',3,'pages/default/page','1001','top','a-58c0a2e1','','en','*','*','*',NULL,NULL,NULL,'2017-03-09 12:33:37','2017-03-09 01:28:23');
INSERT INTO `app_hrzg_widget_content` VALUES (191,'58c0a339aa01d',9,'pages/default/page','1001','main','a-58c0a339','','en','*','*','*',NULL,NULL,NULL,'2017-03-09 12:35:05','2017-03-09 12:40:41');
INSERT INTO `app_hrzg_widget_content` VALUES (192,'58e1d441526c8',4,'widgets/test/index','','container','a-58e1d441','1','en','*','*','*',NULL,NULL,NULL,'2017-04-03 04:49:05','2017-04-03 04:49:05');
INSERT INTO `app_hrzg_widget_content` VALUES (193,'5b56362929438',4,'widgets/test/index','','container','a-5b56-629','1','en','*',NULL,NULL,NULL,NULL,NULL,'2018-07-23 20:10:17','2018-07-23 20:10:17');
/*!40000 ALTER TABLE `app_hrzg_widget_content` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping data for table `app_hrzg_widget_content_translation`
--

LOCK TABLES `app_hrzg_widget_content_translation` WRITE; TRUNCATE TABLE `app_hrzg_widget_content_translation`;
/*!40000 ALTER TABLE `app_hrzg_widget_content_translation` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `app_hrzg_widget_content_translation` VALUES (1,131,'de','{\"skin\":\"inverse text-right\",\"logo\":\"\",\"blocks\":[{\"title\":\"privacy \",\"link\":\"\"},{\"title\":\"imprint\",\"link\":\"\"},{\"title\":\"contact\",\"link\":\"\"},{\"title\":\"mail\",\"link\":\"\"},{\"title\":\"adress\",\"link\":\"\"},{\"title\":\"number\",\"link\":\"\"}]}','','de','*','*','*',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation` VALUES (2,138,'de','{\"headline\":\"Herzlich Willkommen\",\"subline\":\"bei uns\",\"youtube_id\":\"tNm_VYktQCo\",\"imageSource\":\"/_phd/test.png\"}','','de','*','*','*',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation` VALUES (3,140,'de','{\"skin\":\"default text-center\",\"ckbox\":true,\"blocks\":[{\"icon\":\"camera-retro\",\"title\":\"Senectus et netus et malesuada fames ac turpis egestas.\",\"text_html\":\"<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>\",\"button_text\":\"E-Mail\",\"button_url\":\"mailto:c.beck@herzogkommunikation.de\"},{\"icon\":\"fire-extinguisher\",\"title\":\"Senectus et netus et malesuada fames ac turpis egestas.\",\"text_html\":\"<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>\",\"button_text\":\"Button\",\"button_url\":\"\"},{\"icon\":\"eraser\",\"title\":\"Senectus et netus et malesuada fames ac turpis egestas.\",\"text_html\":\"<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>\",\"button_text\":\"Button\",\"button_url\":\"\"},{\"icon\":\"volume-down\",\"title\":\"Senectus et netus et malesuada fames ac turpis egestas.\",\"text_html\":\"<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>\",\"button_text\":\"Button\",\"button_url\":\"\"}]}','','de','*','*','*',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation` VALUES (4,141,'de','{\"skin\":\"default\",\"ckbox\":true,\"title\":\"Senectus et netus et malesuada fames ac turpis\",\"subline\":\"Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante.\",\"blocks\":[{\"text_html\":\"<p><br></p><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>\",\"button_text\":\"fhtruru\",\"button_url\":\"\",\"link_target\":false}]}','','de','*','*','*',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation` VALUES (5,143,'de','{\"skin\":\"default text-center\",\"ckbox\":true,\"blocks\":[{\"image_url\":\"/_phd/example_1.jpg\",\"subline\":\"Fames ac turpis egestas\",\"headline\":\"Senectus et netus\",\"text_html\":\"<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>\",\"button_text\":\"Button\",\"button_url\":\"\",\"link_target\":false},{\"image_url\":\"/_phd/example_2.jpg\",\"subline\":\"Fames ac turpis egestas\",\"headline\":\"Senectus et netus\",\"text_html\":\"<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>\",\"button_text\":\"Button\",\"button_url\":\"\",\"link_target\":false},{\"image_url\":\"/_phd/example_3.jpg\",\"subline\":\"Fames ac turpis egestas\",\"headline\":\"Senectus et netus\",\"text_html\":\"<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>\",\"button_text\":\"Button\",\"button_url\":\"\",\"link_target\":false},{\"image_url\":\"/_phd/example_4.jpg\",\"subline\":\"Fames ac turpis egestas\",\"headline\":\"Senectus et netus\",\"text_html\":\"<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>\",\"button_text\":\"Button\",\"button_url\":\"\",\"link_target\":false}]}','','de','*','*','*',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation` VALUES (6,154,'de','{\"skin\":\"default\",\"ckbox\":false,\"slides\":[{\"content\":\"/_phd/example_2.jpg\",\"caption\":\"Quisque a lectus.\"},{\"content\":\"/_phd/example_3.jpg\",\"caption\":\"Test\"},{\"content\":\"/_phd/example_4.jpg\",\"caption\":\"lplplp\"},{\"content\":\"/_phd/example_5.jpg\",\"caption\":\"Quisque a lectus.\"}]}','','de','*','*','*',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation` VALUES (7,167,'de','{\"contained\":false,\"image_url\":\"/_phd/example_4.jpg\",\"description\":\"short description (Search Engine Optimization)\"}','','de','*','*','*',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation` VALUES (8,168,'de','{\"skin\":\"default text-center\",\"ckbox\":true,\"title\":\"Willkommen auf deiner neuen Website\",\"subline\":\"Viel Spaß damit\",\"blocks\":[{\"text_html\":\"<p>Du brauchst Hilfe? Gehe ins Backend zum Handbuch</p>\\n\",\"button_text\":\"zum Handbuch\",\"button_url\":\"http://doro.app-transporter.com.staging-1.oneba.se/de/help\",\"link_target\":false}]}','','de','*','*','*',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation` VALUES (9,178,'de','{\"headline\":\"Demo\",\"subline\":\"\",\"imageSource\":\"/_phd/example_4.jpg\",\"skin\":\"default\"}','','de','*','*','*',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation` VALUES (10,182,'en','{\"skin\":\"default\",\"logo\":\"\",\"blocks\":[{\"title\":\"new\",\"link\":\"http://www.duden.de/\",\"link_target\":true},{\"title\":\"same window\",\"link\":\"http://www.duden.de/\",\"link_target\":false}]}','','en','*','*','*',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation` VALUES (11,188,'ru','{\"headline\":\"Aliquam tincidunt mauris\",\"subline\":\"mauris eu risus\",\"imageSource\":\"/_phd/test.png\"}','','ru','*','*','*',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation` VALUES (12,190,'en','{\"headline\":\"phd5\",\"subline\":\"Application installed successfully.\",\"imageSource\":\"/_phd/test.png\"}','','en','*','*','*',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation` VALUES (13,191,'en','{\"skin\":\"default\",\"ckbox\":true,\"blocks\":[{\"icon\":\"500px\",\"title\":\"Quickstart\",\"text_html\":\"<p>First steps...<br />\\n&nbsp;</p>\\n\",\"button_text\":\"Backend\",\"button_url\":\"/backend\",\"link_target\":true},{\"icon\":\"500px\",\"title\":\"CMS Functionality\",\"text_html\":\"<p>For content editors and frontend developers</p>\\n\",\"button_text\":\"Help\",\"button_url\":\"/help\",\"link_target\":true},{\"icon\":\"500px\",\"title\":\"DevOps\",\"text_html\":\"<p>Developer guide for phd5 application.<br />\\n&nbsp;</p>\\n\",\"button_text\":\"Guide\",\"button_url\":\"/guide\",\"link_target\":true},{\"icon\":\"500px\",\"title\":\"Support\",\"text_html\":\"<p>Get help form the community and commerical support.</p>\\n\",\"button_text\":\"Support\",\"button_url\":\"\",\"link_target\":true}]}','','en','*','*','*',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation` VALUES (14,192,'en','{\"skin\":\"default\",\"ckbox\":true,\"title\":\"This is a test.\",\"subline\":\"Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante.\",\"blocks\":[]}','1','en','*','*','*',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation` VALUES (15,193,'en','{\"skin\":\"default\",\"ckbox\":true,\"title\":\"Title: test5b5635db21686\",\"subline\":\"Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante.\",\"blocks\":[{\"text_html\":\"<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>\",\"button_text\":\"Button\",\"button_url\":\"\",\"link_target\":true}]}','1','en','*',NULL,NULL,'2018-07-23 20:10:17','2018-07-23 20:10:17');
/*!40000 ALTER TABLE `app_hrzg_widget_content_translation` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping data for table `app_hrzg_widget_content_translation_meta`
--

LOCK TABLES `app_hrzg_widget_content_translation_meta` WRITE; TRUNCATE TABLE `app_hrzg_widget_content_translation_meta`;
/*!40000 ALTER TABLE `app_hrzg_widget_content_translation_meta` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `app_hrzg_widget_content_translation_meta` VALUES (1,131,'en','1',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation_meta` VALUES (2,138,'en','1',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation_meta` VALUES (3,140,'en','1',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation_meta` VALUES (4,141,'en','1',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation_meta` VALUES (5,143,'en','1',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation_meta` VALUES (6,154,'en','1',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation_meta` VALUES (7,167,'en','1',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation_meta` VALUES (8,168,'en','1',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation_meta` VALUES (9,178,'en','1',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation_meta` VALUES (10,182,'en','0',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation_meta` VALUES (11,188,'en','0',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation_meta` VALUES (12,190,'en','1',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation_meta` VALUES (13,191,'en','0',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation_meta` VALUES (14,192,'en','0',NULL,NULL);
INSERT INTO `app_hrzg_widget_content_translation_meta` VALUES (15,193,'en','0','2018-07-23 20:10:17','2018-07-23 20:10:17');
INSERT INTO `app_hrzg_widget_content_translation_meta` VALUES (16,178,'de','1','2018-07-23 20:20:56','2018-07-23 20:20:56');
/*!40000 ALTER TABLE `app_hrzg_widget_content_translation_meta` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping data for table `app_hrzg_widget_template`
--

LOCK TABLES `app_hrzg_widget_template` WRITE; TRUNCATE TABLE `app_hrzg_widget_template`;
/*!40000 ALTER TABLE `app_hrzg_widget_template` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `app_hrzg_widget_template` VALUES (2,'Slider','hrzg\\widget\\widgets\\TwigTemplate','{\n    \"title\": \"Slider Widget\",\n    \"type\": \"object\",\n    \"required\": [\n        \"skin\"\n    ],\n    \"properties\": {\n        \"skin\": {\n            \"type\": \"string\",\n            \"enum\": [\n                \"default\",\n                \"inverse\"\n            ]\n        },\n        \"ckbox\": {\n            \"title\": \"Container on\\/off\",\n            \"type\": \"boolean\",\n            \"format\": \"checkbox\"\n        },\n        \"slides\": {\n            \"type\": \"array\",\n            \"format\": \"tabs\",\n            \"title\": \"Slides\",\n            \"items\": {\n                \"type\": \"object\",\n                \"title\": \"Slide\",\n                \"properties\": {\n                    \"content\": {\n                        \"type\": \"string\",\n                        \"title\": \"Image URL\",\n                        \"format\": \"filefly\"\n                    },\n                    \"caption\": {\n                        \"type\": \"string\",\n                        \"title\": \"Beschreibung\",\n                        \"default\": \"Quisque a lectus.\"\n                    }\n                }\n            }\n        }\n    }\n}','{{ use (\'yii/bootstrap\') }}\r\n\r\n{% set arr_slides = [] %}\r\n\r\n{% for slide in slides %}\r\n{% set arr_slide = {(loop.index0):  {\"content\":(\'<img src=\"/filefly/api?action=download&path=\'~slide.content~\'\">\'), \"caption\":(slide.caption)}} %}\r\n{% set arr_slides = arr_slides|merge(arr_slide) %}\r\n{% endfor %}\r\n\r\n<div class=\"slider-image bg-{{ skin }}\" >\r\n{% if ckbox == true %}\r\n    <div class=\"container\" style=\"background-size: cover;\">\r\n    {% else %}\r\n    <div>\r\n    {% endif %} \r\n    {{ carousel_widget(\r\n    {\r\n        id: \'header\',\r\n        items: arr_slides,\r\n        controls: [\'<span class=\"ionicons ion-ios-arrow-left\" aria-hidden=\"true\"></span>\', \'<span class=\"ionicons ion-ios-arrow-right\" aria-hidden=\"true\"></span>\']\r\n        \r\n    }\r\n) }}\r\n</div>\r\n\r\n\r\n\r\n    ',NULL,NULL);
INSERT INTO `app_hrzg_widget_template` VALUES (3,'Header Image','hrzg\\widget\\widgets\\TwigTemplate','{\n    \"title\": \"Header Image Widget\",\n    \"type\": \"object\",\n    \"id\": \"jumbotron\",\n    \"required\": [\n        \"imageSource\"\n    ],\n    \"properties\": {\n        \"headline\": {\n            \"type\": \"string\",\n            \"title\": \"Headline\",\n            \"default\": \"Aliquam tincidunt mauris\"\n        },\n        \"subline\": {\n            \"type\": \"string\",\n            \"title\": \"Subline\",\n            \"default\": \"mauris eu risus\"\n        },\n        \"imageSource\": {\n            \"type\": \"string\",\n            \"format\": \"filefly\",\n            \"title\": \"Image URL\",\n            \"default\": \"\\/_phd\\/test.png\"\n        }\n    }\n}','<div class=\"header-image text-center text-on-picture\" style=\"background-image: url(/filefly/api?action=download&path={{ imageSource }});\">\r\n    <div class=\"container\">\r\n        <h1> {{ headline }} </h1>\r\n        <h2> {{ subline }} </h2>\r\n    </div>\r\n</div>',NULL,NULL);
INSERT INTO `app_hrzg_widget_template` VALUES (4,'Content','hrzg\\widget\\widgets\\TwigTemplate','{\n    \"title\": \"Content with Button Widget\",\n    \"type\": \"object\",\n    \"id\": \"jumbotron\",\n    \"required\": [\n        \"skin\"\n    ],\n    \"properties\": {\n        \"skin\": {\n            \"type\": \"string\",\n            \"title\": \"Widget Style\",\n            \"enum\": [\n                \"default\",\n                \"inverse\",\n                \"default text-center\",\n                \"inverse text-center\"\n            ]\n        },\n        \"ckbox\": {\n            \"title\": \"Container on\\/off\",\n            \"type\": \"boolean\",\n            \"format\": \"checkbox\",\n            \"default\": true\n        },\n        \"title\": {\n            \"type\": \"string\",\n            \"title\": \"Headline\",\n            \"default\": \"Senectus et netus et malesuada fames ac turpis\"\n        },\n        \"subline\": {\n            \"type\": \"string\",\n            \"title\": \"Subline\",\n            \"default\": \"Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante.\"\n        },\n        \"blocks\": {\n            \"type\": \"array\",\n            \"format\": \"tabs\",\n            \"title\": \"Text\",\n            \"items\": {\n                \"type\": \"object\",\n                \"title\": \"Paragraph\",\n                \"properties\": {\n                    \"text_html\": {\n                        \"type\": \"string\",\n                        \"title\": \"Text\",\n                        \"default\": \"<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.<\\/p>\",\n                        \"format\": \"html\",\n                        \"options\": {\n                            \"wysiwyg\": true\n                        }\n                    },\n                    \"button_text\": {\n                        \"type\": \"string\",\n                        \"title\": \"Button Text\",\n                        \"default\": \"Button\"\n                    },\n                    \"button_url\": {\n                        \"type\": \"string\",\n                        \"title\": \"Link \\/ Mailto \\/ Anchor\",\n                        \"description\": \"Link: http:\\/\\/www.example.com \\/ Mailto: mailto:mail@info.com \\/ Anchor: #widget-NameID\"\n                    },\n                    \"link_target\": {\n                        \"type\": \"boolean\",\n                        \"format\": \"checkbox\",\n                        \"title\": \"Open in new window\",\n                        \"default\": true\n                    }\n                }\n            }\n        }\n    }\n}','<div class=\"widget-content call-to-action bg-{{ skin }}\">\r\n    {% if ckbox == true %}\r\n    <div class=\"container\">\r\n    {% else %}\r\n        <div class=\"no-container\">\r\n        {% endif %} \r\n            <h2>{{ title }}\r\n            <br>\r\n            <small>{{subline}}</small>\r\n            </h2>\r\n            {% for block in  blocks %}\r\n                {{ block.text_html|raw }}\r\n                {% if (block.button_text) != \"\" %}\r\n                <p>\r\n                    {% if block.link_target == true %}\r\n                        <a href=\"{{block.button_url}}\" target=\"_blank\" class=\"btn btn-primary\">{{block.button_text}}</a>\r\n                    {% else %}\r\n                        <a href=\"{{block.button_url}}\" target=\"_self\" class=\"btn btn-primary\">{{block.button_text}}</a>\r\n                    {% endif %} \r\n                </p>\r\n                {% endif %}\r\n            {% endfor %}\r\n        </div>\r\n</div>\r\n',NULL,NULL);
INSERT INTO `app_hrzg_widget_template` VALUES (9,'Content Icon blocks (1-6)','hrzg\\widget\\widgets\\TwigTemplate','{\n    \"title\": \"Content Icon blocks Widget\",\n    \"type\": \"object\",\n    \"required\": [\n        \"skin\"\n    ],\n    \"properties\": {\n        \"skin\": {\n            \"type\": \"string\",\n            \"title\": \"Style skin\",\n            \"enum\": [\n                \"default\",\n                \"inverse\",\n                \"default text-center\",\n                \"inverse text-center\"\n            ]\n        },\n        \"ckbox\": {\n            \"title\": \"Container on\\/off\",\n            \"type\": \"boolean\",\n            \"format\": \"checkbox\",\n            \"default\": true\n        },\n        \"blocks\": {\n            \"type\": \"array\",\n            \"format\": \"tabs\",\n            \"title\": \"Iconblock\",\n            \"items\": {\n                \"type\": \"object\",\n                \"title\": \"Iconblock\",\n                \"properties\": {\n                    \"icon\": {\n                        \"type\": \"string\",\n                        \"title\": \"Icon\",\n                        \"enum\": [\n                            \"500px\",\n                            \"adjust\",\n                            \"adn\",\n                            \"align-center\",\n                            \"align-justify\",\n                            \"align-left\",\n                            \"align-right\",\n                            \"amazon\",\n                            \"ambulance\",\n                            \"anchor\",\n                            \"android\",\n                            \"angellist\",\n                            \"angle-double-down\",\n                            \"angle-double-left\",\n                            \"angle-double-right\",\n                            \"angle-double-up\",\n                            \"angle-down\",\n                            \"angle-left\",\n                            \"angle-right\",\n                            \"angle-up\",\n                            \"apple\",\n                            \"archive\",\n                            \"area-chart\",\n                            \"arrow-circle-down\",\n                            \"arrow-circle-left\",\n                            \"arrow-circle-o-down\",\n                            \"arrow-circle-o-left\",\n                            \"arrow-circle-o-right\",\n                            \"arrow-circle-o-up\",\n                            \"arrow-circle-right\",\n                            \"arrow-circle-up\",\n                            \"arrow-down\",\n                            \"arrow-left\",\n                            \"arrow-right\",\n                            \"arrow-up\",\n                            \"arrows\",\n                            \"arrows-alt\",\n                            \"arrows-h\",\n                            \"arrows-v\",\n                            \"asterisk\",\n                            \"at\",\n                            \"automobile\",\n                            \"backward\",\n                            \"balance-scale\",\n                            \"ban\",\n                            \"bank\",\n                            \"bar-chart\",\n                            \"bar-chart-o\",\n                            \"barcode\",\n                            \"bars\",\n                            \"battery-0\",\n                            \"battery-1\",\n                            \"battery-2\",\n                            \"battery-3\",\n                            \"battery-4\",\n                            \"battery-empty\",\n                            \"battery-full\",\n                            \"battery-half\",\n                            \"battery-quarter\",\n                            \"battery-three-quarters\",\n                            \"bed\",\n                            \"beer\",\n                            \"behance\",\n                            \"behance-square\",\n                            \"bell\",\n                            \"bell-o\",\n                            \"bell-slash\",\n                            \"bell-slash-o\",\n                            \"bicycle\",\n                            \"binoculars\",\n                            \"birthday-cake\",\n                            \"bitbucket\",\n                            \"bitbucket-square\",\n                            \"bitcoin\",\n                            \"black-tie\",\n                            \"bluetooth\",\n                            \"bluetooth-b\",\n                            \"bold\",\n                            \"bolt\",\n                            \"bomb\",\n                            \"book\",\n                            \"bookmark\",\n                            \"bookmark-o\",\n                            \"briefcase\",\n                            \"btc\",\n                            \"bug\",\n                            \"building\",\n                            \"building-o\",\n                            \"bullhorn\",\n                            \"bullseye\",\n                            \"bus\",\n                            \"buysellads\",\n                            \"cab\",\n                            \"calculator\",\n                            \"calendar\",\n                            \"calendar-check-o\",\n                            \"calendar-minus-o\",\n                            \"calendar-o\",\n                            \"calendar-plus-o\",\n                            \"calendar-times-o\",\n                            \"camera\",\n                            \"camera-retro\",\n                            \"car\",\n                            \"caret-down\",\n                            \"caret-left\",\n                            \"caret-right\",\n                            \"caret-square-o-down\",\n                            \"caret-square-o-left\",\n                            \"caret-square-o-right\",\n                            \"caret-square-o-up\",\n                            \"caret-up\",\n                            \"cart-arrow-down\",\n                            \"cart-plus\",\n                            \"cc\",\n                            \"cc-amex\",\n                            \"cc-diners-club\",\n                            \"cc-discover\",\n                            \"cc-jcb\",\n                            \"cc-mastercard\",\n                            \"cc-paypal\",\n                            \"cc-stripe\",\n                            \"cc-visa\",\n                            \"certificate\",\n                            \"chain\",\n                            \"chain-broken\",\n                            \"check\",\n                            \"check-circle\",\n                            \"check-circle-o\",\n                            \"check-square\",\n                            \"check-square-o\",\n                            \"chevron-circle-down\",\n                            \"chevron-circle-left\",\n                            \"chevron-circle-right\",\n                            \"chevron-circle-up\",\n                            \"chevron-down\",\n                            \"chevron-left\",\n                            \"chevron-right\",\n                            \"chevron-up\",\n                            \"child\",\n                            \"chrome\",\n                            \"circle\",\n                            \"circle-o\",\n                            \"circle-o-notch\",\n                            \"circle-thin\",\n                            \"clipboard\",\n                            \"clock-o\",\n                            \"clone\",\n                            \"close\",\n                            \"cloud\",\n                            \"cloud-download\",\n                            \"cloud-upload\",\n                            \"cny\",\n                            \"code\",\n                            \"code-fork\",\n                            \"codepen\",\n                            \"codiepie\",\n                            \"coffee\",\n                            \"cog\",\n                            \"cogs\",\n                            \"columns\",\n                            \"comment\",\n                            \"comment-o\",\n                            \"commenting\",\n                            \"commenting-o\",\n                            \"comments\",\n                            \"comments-o\",\n                            \"compass\",\n                            \"compress\",\n                            \"connectdevelop\",\n                            \"contao\",\n                            \"copy\",\n                            \"copyright\",\n                            \"creative-commons\",\n                            \"credit-card\",\n                            \"credit-card-alt\",\n                            \"crop\",\n                            \"crosshairs\",\n                            \"css3\",\n                            \"cube\",\n                            \"cubes\",\n                            \"cut\",\n                            \"cutlery\",\n                            \"dashboard\",\n                            \"dashcube\",\n                            \"database\",\n                            \"dedent\",\n                            \"delicious\",\n                            \"desktop\",\n                            \"deviantart\",\n                            \"diamond\",\n                            \"digg\",\n                            \"dollar\",\n                            \"dot-circle-o\",\n                            \"download\",\n                            \"dribbble\",\n                            \"dropbox\",\n                            \"drupal\",\n                            \"edge\",\n                            \"edit\",\n                            \"eject\",\n                            \"ellipsis-h\",\n                            \"ellipsis-v\",\n                            \"empire\",\n                            \"envelope\",\n                            \"envelope-o\",\n                            \"envelope-square\",\n                            \"eraser\",\n                            \"eur\",\n                            \"euro\",\n                            \"exchange\",\n                            \"exclamation\",\n                            \"exclamation-circle\",\n                            \"exclamation-triangle\",\n                            \"expand\",\n                            \"expeditedssl\",\n                            \"external-link\",\n                            \"external-link-square\",\n                            \"eye\",\n                            \"eye-slash\",\n                            \"eyedropper\",\n                            \"facebook\",\n                            \"facebook-f\",\n                            \"facebook-official\",\n                            \"facebook-square\",\n                            \"fast-backward\",\n                            \"fast-forward\",\n                            \"fax\",\n                            \"feed\",\n                            \"female\",\n                            \"fighter-jet\",\n                            \"file\",\n                            \"file-archive-o\",\n                            \"file-audio-o\",\n                            \"file-code-o\",\n                            \"file-excel-o\",\n                            \"file-image-o\",\n                            \"file-movie-o\",\n                            \"file-o\",\n                            \"file-pdf-o\",\n                            \"file-photo-o\",\n                            \"file-picture-o\",\n                            \"file-powerpoint-o\",\n                            \"file-sound-o\",\n                            \"file-text\",\n                            \"file-text-o\",\n                            \"file-video-o\",\n                            \"file-word-o\",\n                            \"file-zip-o\",\n                            \"files-o\",\n                            \"film\",\n                            \"filter\",\n                            \"fire\",\n                            \"fire-extinguisher\",\n                            \"firefox\",\n                            \"flag\",\n                            \"flag-checkered\",\n                            \"flag-o\",\n                            \"flash\",\n                            \"flask\",\n                            \"flickr\",\n                            \"floppy-o\",\n                            \"folder\",\n                            \"folder-o\",\n                            \"folder-open\",\n                            \"folder-open-o\",\n                            \"font\",\n                            \"fonticons\",\n                            \"fort-awesome\",\n                            \"forumbee\",\n                            \"forward\",\n                            \"foursquare\",\n                            \"frown-o\",\n                            \"futbol-o\",\n                            \"gamepad\",\n                            \"gavel\",\n                            \"gbp\",\n                            \"ge\",\n                            \"gear\",\n                            \"gears\",\n                            \"genderless\",\n                            \"get-pocket\",\n                            \"gg\",\n                            \"gg-circle\",\n                            \"gift\",\n                            \"git\",\n                            \"git-square\",\n                            \"github\",\n                            \"github-alt\",\n                            \"github-square\",\n                            \"gittip\",\n                            \"glass\",\n                            \"globe\",\n                            \"google\",\n                            \"google-plus\",\n                            \"google-plus-square\",\n                            \"google-wallet\",\n                            \"graduation-cap\",\n                            \"gratipay\",\n                            \"group\",\n                            \"h-square\",\n                            \"hacker-news\",\n                            \"hand-grab-o\",\n                            \"hand-lizard-o\",\n                            \"hand-o-down\",\n                            \"hand-o-left\",\n                            \"hand-o-right\",\n                            \"hand-o-up\",\n                            \"hand-paper-o\",\n                            \"hand-peace-o\",\n                            \"hand-pointer-o\",\n                            \"hand-rock-o\",\n                            \"hand-scissors-o\",\n                            \"hand-spock-o\",\n                            \"hand-stop-o\",\n                            \"hashtag\",\n                            \"hdd-o\",\n                            \"header\",\n                            \"headphones\",\n                            \"heart\",\n                            \"heart-o\",\n                            \"heartbeat\",\n                            \"history\",\n                            \"home\",\n                            \"hospital-o\",\n                            \"hotel\",\n                            \"hourglass\",\n                            \"hourglass-1\",\n                            \"hourglass-2\",\n                            \"hourglass-3\",\n                            \"hourglass-end\",\n                            \"hourglass-half\",\n                            \"hourglass-o\",\n                            \"hourglass-start\",\n                            \"houzz\",\n                            \"html5\",\n                            \"i-cursor\",\n                            \"ils\",\n                            \"image\",\n                            \"inbox\",\n                            \"indent\",\n                            \"industry\",\n                            \"info\",\n                            \"info-circle\",\n                            \"inr\",\n                            \"instagram\",\n                            \"institution\",\n                            \"internet-explorer\",\n                            \"intersex\",\n                            \"ioxhost\",\n                            \"italic\",\n                            \"joomla\",\n                            \"jpy\",\n                            \"jsfiddle\",\n                            \"key\",\n                            \"keyboard-o\",\n                            \"krw\",\n                            \"language\",\n                            \"laptop\",\n                            \"lastfm\",\n                            \"lastfm-square\",\n                            \"leaf\",\n                            \"leanpub\",\n                            \"legal\",\n                            \"lemon-o\",\n                            \"level-down\",\n                            \"level-up\",\n                            \"life-bouy\",\n                            \"life-buoy\",\n                            \"life-ring\",\n                            \"life-saver\",\n                            \"lightbulb-o\",\n                            \"line-chart\",\n                            \"link\",\n                            \"linkedin\",\n                            \"linkedin-square\",\n                            \"linux\",\n                            \"list\",\n                            \"list-alt\",\n                            \"list-ol\",\n                            \"list-ul\",\n                            \"location-arrow\",\n                            \"lock\",\n                            \"long-arrow-down\",\n                            \"long-arrow-left\",\n                            \"long-arrow-right\",\n                            \"long-arrow-up\",\n                            \"magic\",\n                            \"magnet\",\n                            \"mail-forward\",\n                            \"mail-reply\",\n                            \"mail-reply-all\",\n                            \"male\",\n                            \"map\",\n                            \"map-marker\",\n                            \"map-o\",\n                            \"map-pin\",\n                            \"map-signs\",\n                            \"mars\",\n                            \"mars-double\",\n                            \"mars-stroke\",\n                            \"mars-stroke-h\",\n                            \"mars-stroke-v\",\n                            \"maxcdn\",\n                            \"meanpath\",\n                            \"medium\",\n                            \"medkit\",\n                            \"meh-o\",\n                            \"mercury\",\n                            \"microphone\",\n                            \"microphone-slash\",\n                            \"minus\",\n                            \"minus-circle\",\n                            \"minus-square\",\n                            \"minus-square-o\",\n                            \"mixcloud\",\n                            \"mobile\",\n                            \"mobile-phone\",\n                            \"modx\",\n                            \"money\",\n                            \"moon-o\",\n                            \"mortar-board\",\n                            \"motorcycle\",\n                            \"mouse-pointer\",\n                            \"music\",\n                            \"navicon\",\n                            \"neuter\",\n                            \"newspaper-o\",\n                            \"object-group\",\n                            \"object-ungroup\",\n                            \"odnoklassniki\",\n                            \"odnoklassniki-square\",\n                            \"opencart\",\n                            \"openid\",\n                            \"opera\",\n                            \"optin-monster\",\n                            \"outdent\",\n                            \"pagelines\",\n                            \"paint-brush\",\n                            \"paper-plane\",\n                            \"paper-plane-o\",\n                            \"paperclip\",\n                            \"paragraph\",\n                            \"paste\",\n                            \"pause\",\n                            \"pause-circle\",\n                            \"pause-circle-o\",\n                            \"paw\",\n                            \"paypal\",\n                            \"pencil\",\n                            \"pencil-square\",\n                            \"pencil-square-o\",\n                            \"percent\",\n                            \"phone\",\n                            \"phone-square\",\n                            \"photo\",\n                            \"picture-o\",\n                            \"pie-chart\",\n                            \"pied-piper\",\n                            \"pied-piper-alt\",\n                            \"pinterest\",\n                            \"pinterest-p\",\n                            \"pinterest-square\",\n                            \"plane\",\n                            \"play\",\n                            \"play-circle\",\n                            \"play-circle-o\",\n                            \"plug\",\n                            \"plus\",\n                            \"plus-circle\",\n                            \"plus-square\",\n                            \"plus-square-o\",\n                            \"power-off\",\n                            \"print\",\n                            \"product-hunt\",\n                            \"puzzle-piece\",\n                            \"qq\",\n                            \"qrcode\",\n                            \"question\",\n                            \"question-circle\",\n                            \"quote-left\",\n                            \"quote-right\",\n                            \"ra\",\n                            \"random\",\n                            \"rebel\",\n                            \"recycle\",\n                            \"reddit\",\n                            \"reddit-alien\",\n                            \"reddit-square\",\n                            \"refresh\",\n                            \"registered\",\n                            \"remove\",\n                            \"renren\",\n                            \"reorder\",\n                            \"repeat\",\n                            \"reply\",\n                            \"reply-all\",\n                            \"retweet\",\n                            \"rmb\",\n                            \"road\",\n                            \"rocket\",\n                            \"rotate-left\",\n                            \"rotate-right\",\n                            \"rouble\",\n                            \"rss\",\n                            \"rss-square\",\n                            \"rub\",\n                            \"ruble\",\n                            \"rupee\",\n                            \"safari\",\n                            \"save\",\n                            \"scissors\",\n                            \"scribd\",\n                            \"search\",\n                            \"search-minus\",\n                            \"search-plus\",\n                            \"sellsy\",\n                            \"send\",\n                            \"send-o\",\n                            \"server\",\n                            \"share\",\n                            \"share-alt\",\n                            \"share-alt-square\",\n                            \"share-square\",\n                            \"share-square-o\",\n                            \"shekel\",\n                            \"sheqel\",\n                            \"shield\",\n                            \"ship\",\n                            \"shirtsinbulk\",\n                            \"shopping-bag\",\n                            \"shopping-basket\",\n                            \"shopping-cart\",\n                            \"sign-in\",\n                            \"sign-out\",\n                            \"signal\",\n                            \"simplybuilt\",\n                            \"sitemap\",\n                            \"skyatlas\",\n                            \"skype\",\n                            \"slack\",\n                            \"sliders\",\n                            \"slideshare\",\n                            \"smile-o\",\n                            \"soccer-ball-o\",\n                            \"sort\",\n                            \"sort-alpha-asc\",\n                            \"sort-alpha-desc\",\n                            \"sort-amount-asc\",\n                            \"sort-amount-desc\",\n                            \"sort-asc\",\n                            \"sort-desc\",\n                            \"sort-down\",\n                            \"sort-numeric-asc\",\n                            \"sort-numeric-desc\",\n                            \"sort-up\",\n                            \"soundcloud\",\n                            \"space-shuttle\",\n                            \"spinner\",\n                            \"spoon\",\n                            \"spotify\",\n                            \"square\",\n                            \"square-o\",\n                            \"stack-exchange\",\n                            \"stack-overflow\",\n                            \"star\",\n                            \"star-half\",\n                            \"star-half-empty\",\n                            \"star-half-full\",\n                            \"star-half-o\",\n                            \"star-o\",\n                            \"steam\",\n                            \"steam-square\",\n                            \"step-backward\",\n                            \"step-forward\",\n                            \"stethoscope\",\n                            \"sticky-note\",\n                            \"sticky-note-o\",\n                            \"stop\",\n                            \"stop-circle\",\n                            \"stop-circle-o\",\n                            \"street-view\",\n                            \"strikethrough\",\n                            \"stumbleupon\",\n                            \"stumbleupon-circle\",\n                            \"subscript\",\n                            \"subway\",\n                            \"suitcase\",\n                            \"sun-o\",\n                            \"superscript\",\n                            \"support\",\n                            \"table\",\n                            \"tablet\",\n                            \"tachometer\",\n                            \"tag\",\n                            \"tags\",\n                            \"tasks\",\n                            \"taxi\",\n                            \"television\",\n                            \"tencent-weibo\",\n                            \"terminal\",\n                            \"text-height\",\n                            \"text-width\",\n                            \"th\",\n                            \"th-large\",\n                            \"th-list\",\n                            \"thumb-tack\",\n                            \"thumbs-down\",\n                            \"thumbs-o-down\",\n                            \"thumbs-o-up\",\n                            \"thumbs-up\",\n                            \"ticket\",\n                            \"times\",\n                            \"times-circle\",\n                            \"times-circle-o\",\n                            \"tint\",\n                            \"toggle-down\",\n                            \"toggle-left\",\n                            \"toggle-off\",\n                            \"toggle-on\",\n                            \"toggle-right\",\n                            \"toggle-up\",\n                            \"trademark\",\n                            \"train\",\n                            \"transgender\",\n                            \"transgender-alt\",\n                            \"trash\",\n                            \"trash-o\",\n                            \"tree\",\n                            \"trello\",\n                            \"tripadvisor\",\n                            \"trophy\",\n                            \"truck\",\n                            \"try\",\n                            \"tty\",\n                            \"tumblr\",\n                            \"tumblr-square\",\n                            \"turkish-lira\",\n                            \"tv\",\n                            \"twitch\",\n                            \"twitter\",\n                            \"twitter-square\",\n                            \"umbrella\",\n                            \"underline\",\n                            \"undo\",\n                            \"university\",\n                            \"unlink\",\n                            \"unlock\",\n                            \"unlock-alt\",\n                            \"unsorted\",\n                            \"upload\",\n                            \"usb\",\n                            \"usd\",\n                            \"user\",\n                            \"user-md\",\n                            \"user-plus\",\n                            \"user-secret\",\n                            \"user-times\",\n                            \"users\",\n                            \"venus\",\n                            \"venus-double\",\n                            \"venus-mars\",\n                            \"viacoin\",\n                            \"video-camera\",\n                            \"vimeo\",\n                            \"vimeo-square\",\n                            \"vine\",\n                            \"vk\",\n                            \"volume-down\",\n                            \"volume-off\",\n                            \"volume-up\",\n                            \"warning\",\n                            \"wechat\",\n                            \"weibo\",\n                            \"weixin\",\n                            \"whatsapp\",\n                            \"wheelchair\",\n                            \"wifi\",\n                            \"wikipedia-w\",\n                            \"windows\",\n                            \"won\",\n                            \"wordpress\",\n                            \"wrench\",\n                            \"xing\",\n                            \"xing-square\",\n                            \"y-combinator\",\n                            \"y-combinator-square\",\n                            \"yahoo\",\n                            \"yc\",\n                            \"yc-square\",\n                            \"yelp\",\n                            \"yen\",\n                            \"youtube\",\n                            \"youtube-play\",\n                            \"youtube-square\"\n                        ],\n                        \"format\": \"select\"\n                    },\n                    \"title\": {\n                        \"type\": \"string\",\n                        \"title\": \"Headline\",\n                        \"default\": \"Senectus et netus et malesuada fames ac turpis egestas.\"\n                    },\n                    \"text_html\": {\n                        \"type\": \"string\",\n                        \"title\": \"Text\",\n                        \"default\": \"<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.<\\/p>\",\n                        \"format\": \"html\",\n                        \"options\": {\n                            \"wysiwyg\": true\n                        }\n                    },\n                    \"button_text\": {\n                        \"type\": \"string\",\n                        \"title\": \"Button Text\",\n                        \"default\": \"Button\"\n                    },\n                    \"button_url\": {\n                        \"type\": \"string\",\n                        \"title\": \"Link \\/ Mailto \\/ Anchor\",\n                        \"description\": \"Link: www.url.com \\/ Mailto: mailto:mail@info.com \\/ Anchor: #widget-NameID\"\n                    },\n                    \"link_target\": {\n                        \"type\": \"boolean\",\n                        \"format\": \"checkbox\",\n                        \"title\": \"Open in new window\",\n                        \"default\": true\n                    }\n                }\n            }\n        }\n    }\n}','<div class=\"widget-content blocks bg-{{ skin }}\">\r\n    {% if ckbox == true %}\r\n    <div class=\"container\">\r\n    {% else %}\r\n    <div class=\"no-container\">\r\n    {% endif %}\r\n        <div class=\"row\">\r\n            {% for block in  blocks %}\r\n                {% if blocks|length == 4 %}\r\n                <div class=\"col-lg-3 col-sm-6 col-md-6\">\r\n                {% elseif blocks|length == 6 %}\r\n                <div class=\"col-lg-2 col-sm-4 col-md-2\">\r\n                {% else %} \r\n                <div class=\"col-sm-{{ 12 / blocks|length }}\">\r\n                {% endif %}\r\n                    <div class=\"icon\">\r\n                        <i class=\"fa fa-{{ block.icon }}\"></i>\r\n                    </div>\r\n                    <h3>{{ block.title }}</h3>\r\n                    {{ block.text_html|raw }}\r\n                    {% if (block.button_text) != \"\" %}\r\n                    <p>\r\n                        {% if block.link_target == true %}\r\n                        <a href=\"{{block.button_url}}\" target=\"_blank\" class=\"btn btn-primary\">{{block.button_text}}</a>\r\n                        {% else %}\r\n                        <a href=\"{{block.button_url}}\" target=\"_self\" class=\"btn btn-primary\">{{block.button_text}}</a>\r\n                    {% endif %} \r\n                    </p>\r\n                    {% endif %}\r\n                </div>\r\n                    {% if (blocks|length == 4) and ((loop.index % 2) == 0)  %}\r\n                    <div class=\"clearfix visible-sm-block visible-md-block\"></div>\r\n                    {% endif %}\r\n            {% endfor %}\r\n        </div>\r\n    </div>\r\n</div>\r\n',NULL,NULL);
INSERT INTO `app_hrzg_widget_template` VALUES (17,'Header Video','hrzg\\widget\\widgets\\TwigTemplate','{\n    \"title\": \"Header Video Widget\",\n    \"type\": \"object\",\n    \"properties\": {\n        \"headline\": {\n            \"type\": \"string\",\n            \"title\": \"Headline\",\n            \"default\": \"Herzlich Willkommen\"\n        },\n        \"subline\": {\n            \"type\": \"string\",\n            \"title\": \"Subline\",\n            \"default\": \"bei uns\"\n        },\n        \"youtube_id\": {\n            \"type\": \"string\",\n            \"title\": \"YouTube ID\",\n            \"default\": \"tNm_VYktQCo\"\n        },\n        \"imageSource\": {\n            \"type\": \"string\",\n            \"format\": \"filefly\",\n            \"title\": \"Image URL\",\n            \"default\": \"\\/_phd\\/test.png\"\n        }\n    }\n}','<div class=\"hidden-sm hidden-xs\"style=\"position: relative\">\r\n    <div class=\"embed-responsive embed-responsive-16by9\">\r\n        <div id=\"background\">\r\n           <iframe id=\'player\' width=\"100%\" height=\"100%\" src=\"https://www.youtube.com/embed/{{ youtube_id }}?rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=1&amp;loop=1&amp;playlist={{ youtube_id }}&amp;enablejsapi=1&version=3\" frameborder=\"0\"></iframe>\r\n        </div>\r\n    </div>\r\n    <div class=\"video-front text-on-picture\">\r\n        <h1>{{ headline }}</h1>\r\n        <h2>{{ subline }}</h2>\r\n    </div>\r\n    <div class=\"video-overlay\"></div>\r\n</div>\r\n<div class=\"hidden-lg hidden-md widget-content text-on-picture text-center\" style=\"background-image: url(/filefly/api?action=download&path={{ imageSource }});\">\r\n    <h1>{{ headline }}</h1>\r\n    <h2>{{ subline }}</h2>\r\n</div>',NULL,NULL);
INSERT INTO `app_hrzg_widget_template` VALUES (19,'Footer','hrzg\\widget\\widgets\\TwigTemplate','{\n    \"title\": \"Footer Widget\",\n    \"type\": \"object\",\n    \"id\": \"footer\",\n    \"required\": [\n        \"skin\"\n    ],\n    \"properties\": {\n        \"skin\": {\n            \"type\": \"string\",\n            \"title\": \"Widget Style\",\n            \"enum\": [\n                \"default\",\n                \"inverse\",\n                \"default text-center\",\n                \"inverse text-center\",\n                \"default text-right\",\n                \"inverse text-right\"\n            ]\n        },\n        \"logo\": {\n            \"type\": \"string\",\n            \"title\": \"Logo URL\",\n            \"description\": \"Logo will appear on the left side\"\n        },\n        \"blocks\": {\n            \"type\": \"array\",\n            \"format\": \"tabs\",\n            \"title\": \"Link\",\n            \"items\": {\n                \"type\": \"object\",\n                \"title\": \"Link\",\n                \"properties\": {\n                    \"title\": {\n                        \"type\": \"string\",\n                        \"title\": \"Title\"\n                    },\n                    \"link\": {\n                        \"type\": \"string\",\n                        \"title\": \"Link URL\"\n                    },\n                    \"link_target\": {\n                        \"type\": \"boolean\",\n                        \"format\": \"checkbox\",\n                        \"title\": \"Open in new window\",\n                        \"default\": true\n                    }\n                }\n            }\n        }\n    }\n}','<div class=\"widget-content footer bg-{{ skin }}\">\r\n    <div class=\"container\">\r\n        <ul class=\"list-inline\">\r\n        {% if (logo) != \"\" %}\r\n        <span class=\"{{ skin }}-right\"><img class= \"footer-logo\" src=\"{{ logo }}\"></img></span>\r\n        {% endif %}\r\n        {% for block in  blocks %}\r\n        <li> \r\n        {% if block.link_target == true %}\r\n            <a href=\"{{block.link}}\" target=\"_blank\">{{block.title}}</a>\r\n        {% else %}\r\n            <a href=\"{{block.link}}\" target=\"_self\">{{block.title}}</a>\r\n        {% endif %} \r\n        </li>\r\n        {% endfor %}\r\n        <li>\r\n            <a href=\"#\" data-toggle=\"modal\" data-target=\"#footer-modal\"><img class=\"footer-logo-herzog\" src=\"/_phd/dmstr-logo.svg\" alt=\"icon dmstr\" data-pin-nopin=\"true\"></a>\r\n        </li>\r\n        </ul>\r\n    </div>\r\n</div>\r\n\r\n<!-- Small modal -->\r\n<div id=\"footer-modal\" class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"mySmallModalLabel\">\r\n  <div class=\"modal-dialog modal-sm\" role=\"document\">\r\n    <div class=\"modal-content\">\r\n      <div class=\"modal-body\">\r\n        Realized by <b><a href=\"http://herzogkommunikation.de\">herzog kommunikation GmbH</a>, Stuttgart</b>\r\n      </div>\r\n    </div>\r\n  </div>\r\n</div>',NULL,NULL);
INSERT INTO `app_hrzg_widget_template` VALUES (22,'Content blocks (1-6)','hrzg\\widget\\widgets\\TwigTemplate','{\n    \"title\": \"Content blocks Widget\",\n    \"type\": \"object\",\n    \"required\": [\n        \"skin\"\n    ],\n    \"properties\": {\n        \"skin\": {\n            \"type\": \"string\",\n            \"title\": \"Widget Style\",\n            \"enum\": [\n                \"default\",\n                \"inverse\",\n                \"default text-center\",\n                \"inverse text-center\"\n            ]\n        },\n        \"ckbox\": {\n            \"title\": \"Container on\\/off\",\n            \"type\": \"boolean\",\n            \"format\": \"checkbox\",\n            \"default\": true\n        },\n        \"blocks\": {\n            \"type\": \"array\",\n            \"title\": \"Contentblock\",\n            \"format\": \"tabs\",\n            \"items\": {\n                \"type\": \"object\",\n                \"title\": \"Contentblock\",\n                \"properties\": {\n                    \"image_url\": {\n                        \"type\": \"string\",\n                        \"title\": \"Image URL\",\n                        \"format\": \"filefly\",\n                        \"default\": \"\\/_phd\\/test.png\"\n                    },\n                    \"subline\": {\n                        \"type\": \"string\",\n                        \"title\": \"Subline\",\n                        \"default\": \"Fames ac turpis egestas\"\n                    },\n                    \"headline\": {\n                        \"type\": \"string\",\n                        \"title\": \"Headline\",\n                        \"default\": \"Senectus et netus\"\n                    },\n                    \"text_html\": {\n                        \"type\": \"string\",\n                        \"title\": \"Text\",\n                        \"default\": \"<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.<\\/p>\",\n                        \"format\": \"html\",\n                        \"options\": {\n                            \"wysiwyg\": true\n                        }\n                    },\n                    \"button_text\": {\n                        \"type\": \"string\",\n                        \"title\": \"Button Text\",\n                        \"default\": \"Button\"\n                    },\n                    \"button_url\": {\n                        \"type\": \"string\",\n                        \"title\": \"Link \\/ Mailto \\/ Anchor\",\n                        \"description\": \"Link: www.url.com \\/ Mailto: mailto:mail@info.com \\/ Anchor: #widget-NameID\"\n                    },\n                    \"link_target\": {\n                        \"type\": \"boolean\",\n                        \"format\": \"checkbox\",\n                        \"title\": \"Open in new window\",\n                        \"default\": true\n                    }\n                }\n            }\n        }\n    }\n}','<div class=\"widget-content blocks bg-{{ skin }}\">\r\n    {% if ckbox == true %}\r\n    <div class=\"container\">\r\n    {% else %}\r\n    <div class=\"no-container\">\r\n    {% endif %}\r\n        <div class=\"row\">\r\n        {% for block in  blocks %}\r\n        {% if blocks|length == 4 %}\r\n        <div class=\"col-lg-3 col-sm-6 col-md-6\">\r\n        {% elseif blocks|length == 6 %}\r\n        <div class=\"col-lg-2 col-sm-4 col-md-2\">\r\n        {% else %} \r\n        <div class=\"col-sm-{{ 12 / blocks|length }}\">\r\n        {% endif %}\r\n            <div class=\"img-responsive\">\r\n                 <img src=\"/filefly/api?action=download&path={{ block.image_url }}\" class=\"img-responsive\"/>\r\n            </div>\r\n            <div>\r\n                <h4>{{ block.subline}}</h4>\r\n                <h3>{{ block.headline}}</h3>\r\n            </div>\r\n            {{ block.text_html|raw }}\r\n                    {% if (block.button_text) != \"\" %}\r\n                    <p>\r\n                    {% if block.link_target == true %}\r\n                        <a href=\"{{block.button_url}}\" target=\"_blank\" class=\"btn btn-primary\">{{block.button_text}}</a>\r\n                    {% else %}\r\n                        <a href=\"{{block.button_url}}\" target=\"_self\" class=\"btn btn-primary\">{{block.button_text}}</a>\r\n                    {% endif %} \r\n                    </p>\r\n                    {% endif %}\r\n        </div>\r\n        {% if (blocks|length == 4) and ((loop.index % 2) == 0)  %}\r\n        <div class=\"clearfix visible-sm-block visible-md-block\"></div>\r\n        {% endif %}\r\n        {% endfor %}\r\n        </div>\r\n    </div>\r\n</div>\r\n',NULL,NULL);
INSERT INTO `app_hrzg_widget_template` VALUES (24,'Content & Image','hrzg\\widget\\widgets\\TwigTemplate','{\n    \"title\": \"Content & Image Widget\",\n    \"type\": \"object\",\n    \"required\": [\n        \"skin\"\n    ],\n    \"properties\": {\n        \"skin\": {\n            \"type\": \"string\",\n            \"title\": \"Widget style\",\n            \"enum\": [\n                \"default\",\n                \"inverse\",\n                \"default text-center\",\n                \"inverse text-center\"\n            ]\n        },\n        \"position\": {\n            \"title\": \"Text position\",\n            \"type\": \"string\",\n            \"enum\": [\n                \"text-left\",\n                \"text-right\"\n            ]\n        },\n        \"ckbox\": {\n            \"title\": \"Container on\\/off\",\n            \"type\": \"boolean\",\n            \"format\": \"checkbox\",\n            \"default\": true\n        },\n        \"text_html\": {\n            \"type\": \"string\",\n            \"title\": \"Text\",\n            \"default\": \"<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.<\\/p>\",\n            \"format\": \"html\",\n            \"options\": {\n                \"wysiwyg\": true\n            }\n        },\n        \"image_url\": {\n            \"type\": \"string\",\n            \"title\": \"Image URL\",\n            \"format\": \"filefly\",\n            \"default\": \"\\/_phd\\/test.png\"\n        },\n        \"image_seo\": {\n            \"type\": \"string\",\n            \"title\": \"Image SEO\",\n            \"default\": \"Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante.\"\n        }\n    }\n}','<div class=\"widget-content content bg-{{ skin }}\">\r\n    {% if ckbox == true %}\r\n    <div class=\"container\">\r\n    {% else %}\r\n    <div class=\"no-container\">\r\n    {% endif %}\r\n    \r\n        {% if position == \"text-left\" %}\r\n        <div class=\"row\">\r\n            <div class=\"col-md-6\">\r\n                {{ text_html|raw }}\r\n            </div>   \r\n            <div class=\"col-md-6\">\r\n                <img class=\"img-responsive\"\r\n                            src=\"/filefly/api?action=download&path={{ image_url }}\"\r\n                            alt=\"{{ image_seo }}\">\r\n            </div>\r\n         </div>\r\n        {% endif %}\r\n        \r\n        {% if position == \"text-right\" %}\r\n        <div class=\"row\">\r\n            <div class=\"col-md-6\">\r\n                <img class=\"img-responsive\"\r\n                            src=\"/filefly/api?action=download&path={{ image_url }}\"\r\n                            alt=\"{{ image_seo }}\">\r\n            </div>\r\n            <div class=\"col-md-6\">\r\n                {{ text_html|raw }}\r\n            </div>   \r\n        </div>\r\n        {% endif %}\r\n        \r\n    </div>\r\n</div>\r\n\r\n',NULL,NULL);
INSERT INTO `app_hrzg_widget_template` VALUES (25,'Separator','hrzg\\widget\\widgets\\TwigTemplate','{\n    \"title\": \"Separator\",\n    \"type\": \"object\",\n    \"properties\": {\n        \"contained\": {\n            \"title\": \"Container ON\",\n            \"description\": \"Check if container is needed, without container = parallax\",\n            \"type\": \"boolean\",\n            \"format\": \"checkbox\"\n        },\n        \"image_url\": {\n            \"type\": \"string\",\n            \"title\": \"Image URL\",\n            \"format\": \"filefly\",\n            \"default\": \"\\/_phd\\/test.png\"\n        },\n        \"description\": {\n            \"type\": \"string\",\n            \"title\": \"Image description (SEO)\",\n            \"default\": \"short description (Search Engine Optimization)\"\n        }\n    }\n}','<section class=\"separator-image\">\r\n    \r\n     {% if contained != \"true\" %}\r\n    \r\n        <figure>\r\n            <div id=\"parallax\" style=\"background-image:url(/filefly/api?action=download&path={{ image_url }})\"></div> \r\n        </figure>\r\n                \r\n    {% else %}\r\n    \r\n    \r\n        <div class=\"container\">\r\n            <div class=\"row\">\r\n                <figure class=\" col-xs-12 col-md-12\">\r\n    \r\n                        <img class=\"img-responsive\"\r\n                            src=\"/filefly/api?action=download&path={{ image_url }}\"\r\n                            alt=\"{{ description }}\">\r\n                </figure>\r\n            </div>\r\n        </div>\r\n\r\n    {% endif %}\r\n    \r\n</section>',NULL,NULL);
/*!40000 ALTER TABLE `app_hrzg_widget_template` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping data for table `app_html`
--

LOCK TABLES `app_html` WRITE; TRUNCATE TABLE `app_html`;
/*!40000 ALTER TABLE `app_html` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `app_html` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping data for table `app_language`
--

LOCK TABLES `app_language` WRITE; TRUNCATE TABLE `app_language`;
/*!40000 ALTER TABLE `app_language` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `app_language` VALUES ('af-ZA','af','za','Afrikaans','Afrikaans',0);
INSERT INTO `app_language` VALUES ('ar-AR','ar','ar','‚ÄèÿßŸÑÿπÿ±ÿ®Ÿäÿ©‚Äè','Arabic',0);
INSERT INTO `app_language` VALUES ('az-AZ','az','az','Az…ôrbaycan dili','Azerbaijani',0);
INSERT INTO `app_language` VALUES ('be-BY','be','by','–ë–µ–ª–∞—Ä—É—Å–∫–∞—è','Belarusian',0);
INSERT INTO `app_language` VALUES ('bg-BG','bg','bg','–ë—ä–ª–≥–∞—Ä—Å–∫–∏','Bulgarian',0);
INSERT INTO `app_language` VALUES ('bn-IN','bn','in','‡¶¨‡¶æ‡¶Ç‡¶≤‡¶æ','Bengali',0);
INSERT INTO `app_language` VALUES ('bs-BA','bs','ba','Bosanski','Bosnian',0);
INSERT INTO `app_language` VALUES ('ca-ES','ca','es','Catal√†','Catalan',0);
INSERT INTO `app_language` VALUES ('cs-CZ','cs','cz','ƒåe≈°tina','Czech',0);
INSERT INTO `app_language` VALUES ('cy-GB','cy','gb','Cymraeg','Welsh',0);
INSERT INTO `app_language` VALUES ('da-DK','da','dk','Dansk','Danish',0);
INSERT INTO `app_language` VALUES ('de-DE','de','de','Deutsch','German',0);
INSERT INTO `app_language` VALUES ('el-GR','el','gr','ŒïŒªŒªŒ∑ŒΩŒπŒ∫Œ¨','Greek',0);
INSERT INTO `app_language` VALUES ('en-GB','en','gb','English (UK)','English (UK)',1);
INSERT INTO `app_language` VALUES ('en-PI','en','pi','English (Pirate)','English (Pirate)',0);
INSERT INTO `app_language` VALUES ('en-UD','en','ud','English (Upside Down)','English (Upside Down)',0);
INSERT INTO `app_language` VALUES ('en-US','en','us','English (US)','English (US)',1);
INSERT INTO `app_language` VALUES ('eo-EO','eo','eo','Esperanto','Esperanto',0);
INSERT INTO `app_language` VALUES ('es-ES','es','es','Espa√±ol (Espa√±a)','Spanish (Spain)',0);
INSERT INTO `app_language` VALUES ('es-LA','es','la','Espa√±ol','Spanish',0);
INSERT INTO `app_language` VALUES ('et-EE','et','ee','Eesti','Estonian',0);
INSERT INTO `app_language` VALUES ('eu-ES','eu','es','Euskara','Basque',0);
INSERT INTO `app_language` VALUES ('fa-IR','fa','ir','‚ÄèŸÅÿßÿ±ÿ≥€å‚Äè','Persian',0);
INSERT INTO `app_language` VALUES ('fb-LT','fb','lt','Leet Speak','Leet Speak',0);
INSERT INTO `app_language` VALUES ('fi-FI','fi','fi','Suomi','Finnish',0);
INSERT INTO `app_language` VALUES ('fo-FO','fo','fo','F√∏royskt','Faroese',0);
INSERT INTO `app_language` VALUES ('fr-CA','fr','ca','Fran√ßais (Canada)','French (Canada)',0);
INSERT INTO `app_language` VALUES ('fr-FR','fr','fr','Fran√ßais (France)','French (France)',0);
INSERT INTO `app_language` VALUES ('fy-NL','fy','nl','Frysk','Frisian',0);
INSERT INTO `app_language` VALUES ('ga-IE','ga','ie','Gaeilge','Irish',0);
INSERT INTO `app_language` VALUES ('gl-ES','gl','es','Galego','Galician',0);
INSERT INTO `app_language` VALUES ('he-IL','he','il','‚Äè◊¢◊ë◊®◊ô◊™‚Äè','Hebrew',0);
INSERT INTO `app_language` VALUES ('hi-IN','hi','in','‡§π‡§ø‡§®‡•ç‡§¶‡•Ä','Hindi',0);
INSERT INTO `app_language` VALUES ('hr-HR','hr','hr','Hrvatski','Croatian',0);
INSERT INTO `app_language` VALUES ('hu-HU','hu','hu','Magyar','Hungarian',0);
INSERT INTO `app_language` VALUES ('hy-AM','hy','am','’Ä’°’µ’•÷Ä’•’∂','Armenian',0);
INSERT INTO `app_language` VALUES ('id-ID','id','id','Bahasa Indonesia','Indonesian',0);
INSERT INTO `app_language` VALUES ('is-IS','is','is','√çslenska','Icelandic',0);
INSERT INTO `app_language` VALUES ('it-IT','it','it','Italiano','Italian',0);
INSERT INTO `app_language` VALUES ('ja-JP','ja','jp','Êó•Êú¨Ë™û','Japanese',0);
INSERT INTO `app_language` VALUES ('ka-GE','ka','ge','·É•·Éê·É†·Éó·É£·Éö·Éò','Georgian',0);
INSERT INTO `app_language` VALUES ('km-KH','km','kh','·ûó·û∂·ûü·û∂·ûÅ·üí·ûò·üÇ·ûö','Khmer',0);
INSERT INTO `app_language` VALUES ('ko-KR','ko','kr','ÌïúÍµ≠Ïñ¥','Korean',0);
INSERT INTO `app_language` VALUES ('ku-TR','ku','tr','Kurd√Æ','Kurdish',0);
INSERT INTO `app_language` VALUES ('la-VA','la','va','lingua latina','Latin',0);
INSERT INTO `app_language` VALUES ('lt-LT','lt','lt','Lietuvi≈≥','Lithuanian',0);
INSERT INTO `app_language` VALUES ('lv-LV','lv','lv','Latvie≈°u','Latvian',0);
INSERT INTO `app_language` VALUES ('mk-MK','mk','mk','–ú–∞–∫–µ–¥–æ–Ω—Å–∫–∏','Macedonian',0);
INSERT INTO `app_language` VALUES ('ml-IN','ml','in','‡¥Æ‡¥≤‡¥Ø‡¥æ‡¥≥‡¥Ç','Malayalam',0);
INSERT INTO `app_language` VALUES ('ms-MY','ms','my','Bahasa Melayu','Malay',0);
INSERT INTO `app_language` VALUES ('nb-NO','nb','no','Norsk (bokm√•l)','Norwegian (bokmal)',0);
INSERT INTO `app_language` VALUES ('ne-NP','ne','np','‡§®‡•á‡§™‡§æ‡§≤‡•Ä','Nepali',0);
INSERT INTO `app_language` VALUES ('nl-NL','nl','nl','Nederlands','Dutch',0);
INSERT INTO `app_language` VALUES ('nn-NO','nn','no','Norsk (nynorsk)','Norwegian (nynorsk)',0);
INSERT INTO `app_language` VALUES ('pa-IN','pa','in','‡®™‡©∞‡®ú‡®æ‡®¨‡©Ä','Punjabi',0);
INSERT INTO `app_language` VALUES ('pl-PL','pl','pl','Polski','Polish',0);
INSERT INTO `app_language` VALUES ('ps-AF','ps','af','‚ÄèŸæ⁄öÿ™Ÿà‚Äè','Pashto',0);
INSERT INTO `app_language` VALUES ('pt-BR','pt','br','Portugu√™s (Brasil)','Portuguese (Brazil)',0);
INSERT INTO `app_language` VALUES ('pt-PT','pt','pt','Portugu√™s (Portugal)','Portuguese (Portugal)',0);
INSERT INTO `app_language` VALUES ('ro-RO','ro','ro','Rom√¢nƒÉ','Romanian',0);
INSERT INTO `app_language` VALUES ('ru-RU','ru','ru','–†—É—Å—Å–∫–∏–π','Russian',0);
INSERT INTO `app_language` VALUES ('sk-SK','sk','sk','Slovenƒçina','Slovak',0);
INSERT INTO `app_language` VALUES ('sl-SI','sl','si','Sloven≈°ƒçina','Slovenian',0);
INSERT INTO `app_language` VALUES ('sq-AL','sq','al','Shqip','Albanian',0);
INSERT INTO `app_language` VALUES ('sr-RS','sr','rs','–°—Ä–ø—Å–∫–∏','Serbian',0);
INSERT INTO `app_language` VALUES ('sv-SE','sv','se','Svenska','Swedish',0);
INSERT INTO `app_language` VALUES ('sw-KE','sw','ke','Kiswahili','Swahili',0);
INSERT INTO `app_language` VALUES ('ta-IN','ta','in','‡Æ§‡ÆÆ‡Æø‡Æ¥‡Øç','Tamil',0);
INSERT INTO `app_language` VALUES ('te-IN','te','in','‡∞§‡±Ü‡∞≤‡±Å‡∞ó‡±Å','Telugu',0);
INSERT INTO `app_language` VALUES ('th-TH','th','th','‡∏†‡∏≤‡∏©‡∏≤‡πÑ‡∏ó‡∏¢','Thai',0);
INSERT INTO `app_language` VALUES ('tl-PH','tl','ph','Filipino','Filipino',0);
INSERT INTO `app_language` VALUES ('tr-TR','tr','tr','T√ºrk√ße','Turkish',0);
INSERT INTO `app_language` VALUES ('uk-UA','uk','ua','–£–∫—Ä–∞—ó–Ω—Å—å–∫–∞','Ukrainian',0);
INSERT INTO `app_language` VALUES ('vi-VN','vi','vn','Ti·∫øng Vi·ªát','Vietnamese',0);
INSERT INTO `app_language` VALUES ('xx-XX','xx','xx','Fejleszt≈ë','Developer',0);
INSERT INTO `app_language` VALUES ('zh-CN','zh','cn','‰∏≠Êñá(ÁÆÄ‰Ωì)','Simplified Chinese (China)',0);
INSERT INTO `app_language` VALUES ('zh-HK','zh','hk','‰∏≠Êñá(È¶ôÊ∏Ø)','Traditional Chinese (Hong Kong)',0);
INSERT INTO `app_language` VALUES ('zh-TW','zh','tw','‰∏≠Êñá(Âè∞ÁÅ£)','Traditional Chinese (Taiwan)',0);
/*!40000 ALTER TABLE `app_language` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping data for table `app_language_source`
--

LOCK TABLES `app_language_source` WRITE; TRUNCATE TABLE `app_language_source`;
/*!40000 ALTER TABLE `app_language_source` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `app_language_source` VALUES (1,'app','Close');
/*!40000 ALTER TABLE `app_language_source` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping data for table `app_language_translate`
--

LOCK TABLES `app_language_translate` WRITE; TRUNCATE TABLE `app_language_translate`;
/*!40000 ALTER TABLE `app_language_translate` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `app_language_translate` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping data for table `app_less`
--

LOCK TABLES `app_less` WRITE; TRUNCATE TABLE `app_less`;
/*!40000 ALTER TABLE `app_less` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `app_less` VALUES (14,'doro-main','// Main LESS file\r\n\r\n// Theme\r\n// see http://bootswatch.com\r\n//\r\n// available themes: \r\n// cerulean,cosmo,cyborg,darkly,flatly,journal,lumen,paper,readable,\r\n// sandstone,simplex,slate,spacelab,superhero,united,yeti\r\n@theme: \'cosmo\';\r\n\r\n// Framework and base theme\r\n@import \"/app/vendor/bower/bootstrap/less/bootstrap.less\";\r\n@import \"/app/vendor/thomaspark/bootswatch/@{theme}/variables.less\";\r\n@import \"/app/vendor/thomaspark/bootswatch/@{theme}/bootswatch.less\";\r\n@import \"//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css\";\r\n\r\n// Workaround for missing font files, when using prototype LESS\r\n@icon-font-path: \'//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/fonts/\';\r\n\r\n// Theme customizations\r\n@navbar-border-radius: 0px;\r\n@navbar-margin-bottom: 0px;\r\n@import \"open-color\";\r\n//@body-bg: #ddd;\r\n@brand-primary: @oc-orange-4;\r\n\r\n// Style for widget templates\r\n@import \"doro-widgets\";\r\n\r\n.alert{\r\n    margin-bottom: 0px;\r\n}\r\n\r\n/*h1 {\r\n    font-size: 50px;\r\n    @media (max-width: @screen-xs-max) {\r\n        font-size: 30px;\r\n        }\r\n}*/\r\n');
INSERT INTO `app_less` VALUES (18,'doro-widgets','.widget-content {\r\n    padding: 3em 0;\r\n        &.bg-inverse {\r\n            background: @well-bg;\r\n        }\r\n        &.content {\r\n            line-height: 1.5em;\r\n        }\r\n        &.blocks {\r\n            .icon {\r\n                font-size: 6em;\r\n            }\r\n            [class^=\"col-\"] {\r\n            margin-bottom: 3em;\r\n            }\r\n        }\r\n        .no-container {\r\n            padding: 0 2em;\r\n        }\r\n}\r\n\r\n.header-image {\r\n            padding: 300px 0;\r\n            @media (max-width: @screen-xs-max) {\r\n                padding: 90px 0;\r\n                }\r\n}\r\n    \r\n.text-on-picture {\r\n        background-size: cover;\r\n        color: white;\r\n        text-shadow: 0 0 1px rgba(0,0,0,0.05),0 1px 2px rgba(0,0,0,0.3),\r\n}\r\n        \r\n.footer {\r\n    .footer-logo {\r\n        max-height: 30px;\r\n        margin-right: 50px;\r\n        }\r\n    .footer-logo-herzog {\r\n        height: 1.6em;    \r\n    }\r\n    .text-right-right {\r\n    float: left;    \r\n    }\r\n}\r\n\r\n.video-front{\r\n    text-align: center;\r\n    z-index: 2;\r\n    position: absolute;\r\n    top:40%;\r\n    width: 100%;\r\n}\r\n\r\n.video-overlay{\r\n    position: absolute;\r\n    top: 0;\r\n    height: 100%;\r\n    width: 100%;\r\n    z-index: 1;\r\n}\r\n\r\n.embed-responsive{\r\n    height: 100%;\r\n}\r\n\r\n.slider-image {\r\n    .carousel-control{\r\n       span{\r\n           position: absolute;\r\n           top: 50%;\r\n           transform: translateY(-50%);\r\n       } \r\n    }\r\n    .item {\r\n        max-height: 500px;\r\n        img{\r\n            width: 100%\r\n        }\r\n    }\r\n    .carousel-caption{\r\n        padding-bottom: 50px;\r\n    }\r\n    .carousel-indicators {\r\n        li {\r\n            background-color: rgba(255,255,255,0.3);\r\n            border: 0px;\r\n            height: 15px;\r\n            width: 15px;\r\n            margin: 0px;\r\n        }    \r\n        .active {\r\n            background-color: rgba(255,255,255,1);\r\n            height: 15px;\r\n            width: 15px;\r\n            }\r\n    }\r\n}\r\n\r\n.separator-image {\r\n  max-height: 80vh;\r\n  overflow: hidden;\r\n  img {\r\n    margin: 0 auto;\r\n  }\r\n  div#parallax {\r\n    height: 60vh;\r\n    background-size: cover;\r\n    background-repeat: no-repeat;\r\n    background-position: center center;\r\n    position: relative;\r\n    background-attachment: fixed;\r\n    }\r\n  }\r\n\r\n\r\n@media (max-width: 400px) {\r\n    .separator-image {\r\n        background-attachment: local;\r\n        height: 400px;\r\n    }   \r\n    .list-inline {\r\n            margin-bottom: 10px;\r\n    }\r\n}');
INSERT INTO `app_less` VALUES (19,'open-color','// see https://github.com/yeun/open-color\r\n//\r\n//  ???? ???? ???? ???? ????\r\n//  v 1.4.0\r\n//\r\n//  ???????????????????????????????????\r\n\r\n\r\n//  General\r\n//  ???????????????????????????????????\r\n\r\n@oc-white:         #ffffff;\r\n@oc-black:         #000000;\r\n\r\n\r\n//  Gray\r\n//  ???????????????????????????????????\r\n\r\n@oc-gray-list: #f8f9fa, #f1f3f5, #e9ecef, #dee2e6, #ced4da, #adb5bd, #868e96, #495057, #343a40, #212529;\r\n\r\n@oc-gray-0: extract(@oc-gray-list, 1);\r\n@oc-gray-1: extract(@oc-gray-list, 2);\r\n@oc-gray-2: extract(@oc-gray-list, 3);\r\n@oc-gray-3: extract(@oc-gray-list, 4);\r\n@oc-gray-4: extract(@oc-gray-list, 5);\r\n@oc-gray-5: extract(@oc-gray-list, 6);\r\n@oc-gray-6: extract(@oc-gray-list, 7);\r\n@oc-gray-7: extract(@oc-gray-list, 8);\r\n@oc-gray-8: extract(@oc-gray-list, 9);\r\n@oc-gray-9: extract(@oc-gray-list, 10);\r\n\r\n\r\n//  Red\r\n//  ???????????????????????????????????\r\n\r\n@oc-red-list: #fff5f5, #ffe3e3, #ffc9c9, #ffa8a8, #ff8787, #ff6b6b, #fa5252, #f03e3e, #e03131, #c92a2a;\r\n\r\n@oc-red-0: extract(@oc-red-list, 1);\r\n@oc-red-1: extract(@oc-red-list, 2);\r\n@oc-red-2: extract(@oc-red-list, 3);\r\n@oc-red-3: extract(@oc-red-list, 4);\r\n@oc-red-4: extract(@oc-red-list, 5);\r\n@oc-red-5: extract(@oc-red-list, 6);\r\n@oc-red-6: extract(@oc-red-list, 7);\r\n@oc-red-7: extract(@oc-red-list, 8);\r\n@oc-red-8: extract(@oc-red-list, 9);\r\n@oc-red-9: extract(@oc-red-list, 10);\r\n\r\n\r\n//  Pink\r\n//  ???????????????????????????????????\r\n\r\n@oc-pink-list: #fff0f6, #ffdeeb, #fcc2d7, #faa2c1, #f783ac, #f06595, #e64980, #d6336c, #c2255c, #a61e4d;\r\n\r\n@oc-pink-0: extract(@oc-pink-list, 1);\r\n@oc-pink-1: extract(@oc-pink-list, 2);\r\n@oc-pink-2: extract(@oc-pink-list, 3);\r\n@oc-pink-3: extract(@oc-pink-list, 4);\r\n@oc-pink-4: extract(@oc-pink-list, 5);\r\n@oc-pink-5: extract(@oc-pink-list, 6);\r\n@oc-pink-6: extract(@oc-pink-list, 7);\r\n@oc-pink-7: extract(@oc-pink-list, 8);\r\n@oc-pink-8: extract(@oc-pink-list, 9);\r\n@oc-pink-9: extract(@oc-pink-list, 10);\r\n\r\n\r\n//  Grape\r\n//  ???????????????????????????????????\r\n\r\n@oc-grape-list: #f8f0fc, #f3d9fa, #eebefa, #e599f7, #da77f2, #cc5de8, #be4bdb, #ae3ec9, #9c36b5, #862e9c;\r\n\r\n@oc-grape-0: extract(@oc-grape-list, 1);\r\n@oc-grape-1: extract(@oc-grape-list, 2);\r\n@oc-grape-2: extract(@oc-grape-list, 3);\r\n@oc-grape-3: extract(@oc-grape-list, 4);\r\n@oc-grape-4: extract(@oc-grape-list, 5);\r\n@oc-grape-5: extract(@oc-grape-list, 6);\r\n@oc-grape-6: extract(@oc-grape-list, 7);\r\n@oc-grape-7: extract(@oc-grape-list, 8);\r\n@oc-grape-8: extract(@oc-grape-list, 9);\r\n@oc-grape-9: extract(@oc-grape-list, 10);\r\n\r\n\r\n//  Violet\r\n//  ???????????????????????????????????\r\n\r\n@oc-violet-list: #f3f0ff, #e5dbff, #d0bfff, #b197fc, #9775fa, #845ef7, #7950f2, #7048e8, #6741d9, #5f3dc4;\r\n\r\n@oc-violet-0: extract(@oc-violet-list, 1);\r\n@oc-violet-1: extract(@oc-violet-list, 2);\r\n@oc-violet-2: extract(@oc-violet-list, 3);\r\n@oc-violet-3: extract(@oc-violet-list, 4);\r\n@oc-violet-4: extract(@oc-violet-list, 5);\r\n@oc-violet-5: extract(@oc-violet-list, 6);\r\n@oc-violet-6: extract(@oc-violet-list, 7);\r\n@oc-violet-7: extract(@oc-violet-list, 8);\r\n@oc-violet-8: extract(@oc-violet-list, 9);\r\n@oc-violet-9: extract(@oc-violet-list, 10);\r\n\r\n\r\n//  Indigo\r\n//  ???????????????????????????????????\r\n\r\n@oc-indigo-list: #edf2ff, #dbe4ff, #bac8ff, #91a7ff, #748ffc, #5c7cfa, #4c6ef5, #4263eb, #3b5bdb, #364fc7;\r\n\r\n@oc-indigo-0: extract(@oc-indigo-list, 1);\r\n@oc-indigo-1: extract(@oc-indigo-list, 2);\r\n@oc-indigo-2: extract(@oc-indigo-list, 3);\r\n@oc-indigo-3: extract(@oc-indigo-list, 4);\r\n@oc-indigo-4: extract(@oc-indigo-list, 5);\r\n@oc-indigo-5: extract(@oc-indigo-list, 6);\r\n@oc-indigo-6: extract(@oc-indigo-list, 7);\r\n@oc-indigo-7: extract(@oc-indigo-list, 8);\r\n@oc-indigo-8: extract(@oc-indigo-list, 9);\r\n@oc-indigo-9: extract(@oc-indigo-list, 10);\r\n\r\n\r\n//  Blue\r\n//  ???????????????????????????????????\r\n\r\n@oc-blue-list: #e8f7ff, #ccedff, #a3daff, #72c3fc, #4dadf7, #329af0, #228ae6, #1c7cd6, #1b6ec2, #1862ab;\r\n\r\n@oc-blue-0: extract(@oc-blue-list, 1);\r\n@oc-blue-1: extract(@oc-blue-list, 2);\r\n@oc-blue-2: extract(@oc-blue-list, 3);\r\n@oc-blue-3: extract(@oc-blue-list, 4);\r\n@oc-blue-4: extract(@oc-blue-list, 5);\r\n@oc-blue-5: extract(@oc-blue-list, 6);\r\n@oc-blue-6: extract(@oc-blue-list, 7);\r\n@oc-blue-7: extract(@oc-blue-list, 8);\r\n@oc-blue-8: extract(@oc-blue-list, 9);\r\n@oc-blue-9: extract(@oc-blue-list, 10);\r\n\r\n\r\n//  Cyan\r\n//  ???????????????????????????????????\r\n\r\n@oc-cyan-list: #e3fafc, #c5f6fa, #99e9f2, #66d9e8, #3bc9db, #22b8cf, #15aabf, #1098ad, #0c8599, #0b7285;\r\n\r\n@oc-cyan-0: extract(@oc-cyan-list, 1);\r\n@oc-cyan-1: extract(@oc-cyan-list, 2);\r\n@oc-cyan-2: extract(@oc-cyan-list, 3);\r\n@oc-cyan-3: extract(@oc-cyan-list, 4);\r\n@oc-cyan-4: extract(@oc-cyan-list, 5);\r\n@oc-cyan-5: extract(@oc-cyan-list, 6);\r\n@oc-cyan-6: extract(@oc-cyan-list, 7);\r\n@oc-cyan-7: extract(@oc-cyan-list, 8);\r\n@oc-cyan-8: extract(@oc-cyan-list, 9);\r\n@oc-cyan-9: extract(@oc-cyan-list, 10);\r\n\r\n\r\n//  Teal\r\n//  ???????????????????????????????????\r\n\r\n@oc-teal-list: #e6fcf5, #c3fae8, #96f2d7, #63e6be, #38d9a9, #20c997, #12b886, #0ca678, #099268, #087f5b;\r\n\r\n@oc-teal-0: extract(@oc-teal-list, 1);\r\n@oc-teal-1: extract(@oc-teal-list, 2);\r\n@oc-teal-2: extract(@oc-teal-list, 3);\r\n@oc-teal-3: extract(@oc-teal-list, 4);\r\n@oc-teal-4: extract(@oc-teal-list, 5);\r\n@oc-teal-5: extract(@oc-teal-list, 6);\r\n@oc-teal-6: extract(@oc-teal-list, 7);\r\n@oc-teal-7: extract(@oc-teal-list, 8);\r\n@oc-teal-8: extract(@oc-teal-list, 9);\r\n@oc-teal-9: extract(@oc-teal-list, 10);\r\n\r\n\r\n//  Green\r\n//  ???????????????????????????????????\r\n\r\n@oc-green-list: #ebfbee, #d3f9d8, #b2f2bb, #8ce99a, #69db7c, #51cf66, #40c057, #37b24d, #2f9e44, #2b8a3e;\r\n\r\n@oc-green-0: extract(@oc-green-list, 1);\r\n@oc-green-1: extract(@oc-green-list, 2);\r\n@oc-green-2: extract(@oc-green-list, 3);\r\n@oc-green-3: extract(@oc-green-list, 4);\r\n@oc-green-4: extract(@oc-green-list, 5);\r\n@oc-green-5: extract(@oc-green-list, 6);\r\n@oc-green-6: extract(@oc-green-list, 7);\r\n@oc-green-7: extract(@oc-green-list, 8);\r\n@oc-green-8: extract(@oc-green-list, 9);\r\n@oc-green-9: extract(@oc-green-list, 10);\r\n\r\n\r\n//  Lime\r\n//  ???????????????????????????????????\r\n\r\n@oc-lime-list: #f4fce3, #e9fac8, #d8f5a2, #c0eb75, #a9e34b, #94d82d, #82c91e, #74b816, #66a80f, #5c940d;\r\n\r\n@oc-lime-0: extract(@oc-lime-list, 1);\r\n@oc-lime-1: extract(@oc-lime-list, 2);\r\n@oc-lime-2: extract(@oc-lime-list, 3);\r\n@oc-lime-3: extract(@oc-lime-list, 4);\r\n@oc-lime-4: extract(@oc-lime-list, 5);\r\n@oc-lime-5: extract(@oc-lime-list, 6);\r\n@oc-lime-6: extract(@oc-lime-list, 7);\r\n@oc-lime-7: extract(@oc-lime-list, 8);\r\n@oc-lime-8: extract(@oc-lime-list, 9);\r\n@oc-lime-9: extract(@oc-lime-list, 10);\r\n\r\n\r\n//  Yellow\r\n//  ???????????????????????????????????\r\n\r\n@oc-yellow-list: #fff9db, #fff3bf, #ffec99, #ffe066, #ffd43b, #fcc419, #fab005, #f59f00, #f08c00, #e67700;\r\n\r\n@oc-yellow-0: extract(@oc-yellow-list, 1);\r\n@oc-yellow-1: extract(@oc-yellow-list, 2);\r\n@oc-yellow-2: extract(@oc-yellow-list, 3);\r\n@oc-yellow-3: extract(@oc-yellow-list, 4);\r\n@oc-yellow-4: extract(@oc-yellow-list, 5);\r\n@oc-yellow-5: extract(@oc-yellow-list, 6);\r\n@oc-yellow-6: extract(@oc-yellow-list, 7);\r\n@oc-yellow-7: extract(@oc-yellow-list, 8);\r\n@oc-yellow-8: extract(@oc-yellow-list, 9);\r\n@oc-yellow-9: extract(@oc-yellow-list, 10);\r\n\r\n\r\n//  Orange\r\n//  ???????????????????????????????????\r\n\r\n@oc-orange-list: #fff4e6, #ffe8cc, #ffd8a8, #ffc078, #ffa94d, #ff922b, #fd7e14, #f76707, #e8590c, #d9480f;\r\n\r\n@oc-orange-0: extract(@oc-orange-list, 1);\r\n@oc-orange-1: extract(@oc-orange-list, 2);\r\n@oc-orange-2: extract(@oc-orange-list, 3);\r\n@oc-orange-3: extract(@oc-orange-list, 4);\r\n@oc-orange-4: extract(@oc-orange-list, 5);\r\n@oc-orange-5: extract(@oc-orange-list, 6);\r\n@oc-orange-6: extract(@oc-orange-list, 7);\r\n@oc-orange-7: extract(@oc-orange-list, 8);\r\n@oc-orange-8: extract(@oc-orange-list, 9);\r\n@oc-orange-9: extract(@oc-orange-list, 10);');
/*!40000 ALTER TABLE `app_less` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping data for table `app_settings`
--

LOCK TABLES `app_settings` WRITE; TRUNCATE TABLE `app_settings`;
/*!40000 ALTER TABLE `app_settings` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `app_settings` VALUES (1,'string','pages','availableGlobalRoutes','/backend/default/index\r\n/backend/default/view-config\r\n/backend/default/show-auth\r\n/settings/default\r\n/help\r\n/guide\r\n/pages/default\r\n/moxiemanager/default\r\n/crud\r\n/filefly\r\n/filefly/test\r\n/prototype\r\n/prototype/html\r\n/prototype/less\r\n/prototype/twig\r\n/widgets\r\n/widgets/crud/widget\r\n/widgets/crud/widget-template\r\n/translatemanager/language\r\n/user/admin\r\n/rbac/role\r\n/rbac/permission\r\n/redirects\r\n/resque\r\n/audit\r\n/user/settings\r\n/user/profile',1,'2016-05-13 22:27:14','2017-03-06 07:06:41');
INSERT INTO `app_settings` VALUES (2,'string','pages','availableRoutes','/pages/default/page',1,'2016-05-15 22:09:50','2016-07-20 11:34:02');
INSERT INTO `app_settings` VALUES (3,'string','app.assets','registerPrototypeAssetKey','doro',1,'2016-05-25 14:50:40','2017-01-11 10:46:43');
INSERT INTO `app_settings` VALUES (4,'object','widgets','availablePhpClasses','{\"hrzg\\\\widget\\\\widgets\\\\TwigTemplate\": \"Twig layout\"}',1,'2016-05-25 23:14:09','2017-03-08 14:37:28');
INSERT INTO `app_settings` VALUES (5,'string','help','markdownUrl','https://git.hrzg.de/c.beck/handbuch/raw/master/help',1,'2016-06-29 23:21:21','2017-01-30 17:04:12');
INSERT INTO `app_settings` VALUES (6,'string','help','forkUrl','https://git.hrzg.de/c.beck/handbuch/edit/master/help',1,'2016-06-29 23:22:26','2017-01-30 17:27:22');
INSERT INTO `app_settings` VALUES (7,'string','help','defaultIndexFile','index.md',1,'2016-06-29 23:22:58','2016-08-03 16:45:46');
INSERT INTO `app_settings` VALUES (8,'string','pages','availableViews','@vendor/dmstr/yii2-widgets2-module/src/views/test/single.twig\r\n@vendor/dmstr/yii2-widgets2-module/src/views/test/header-container.twig\r\n@vendor/dmstr/yii2-widgets2-module/src/views/test/index.twig\r\n@vendor/dmstr/yii2-prototype-module/src/views/render/twig.php\r\n',1,'2016-07-20 02:38:22','2017-01-31 20:02:08');
INSERT INTO `app_settings` VALUES (9,'string','guide','markdownUrl','https://git.hrzg.de/dmstr/docs-phd5/raw/master/guide',1,'2016-08-03 16:06:19','2016-08-03 19:22:40');
INSERT INTO `app_settings` VALUES (10,'string','guide','defaultIndexFile','index.md',1,'2016-08-03 16:44:26','2016-08-03 16:45:30');
INSERT INTO `app_settings` VALUES (11,'string','guide','forkUrl','https://git.hrzg.de/dmstr/docs-phd5/edit/master/guide',1,'2016-08-03 19:23:00','2016-08-03 19:23:22');
INSERT INTO `app_settings` VALUES (13,'string','backend.adminlte','skin','blue',1,'2016-12-23 03:14:03','2017-03-09 00:16:41');
INSERT INTO `app_settings` VALUES (14,'string','app.seo.keywords','/de/site/index','keyword, number 1, test 1, test 2',1,'2016-12-26 13:20:05','2017-03-07 14:24:22');
INSERT INTO `app_settings` VALUES (15,'boolean','app.layout','enableTwigNavbar','1',0,'2017-02-21 06:48:15','2017-03-08 14:37:35');
INSERT INTO `app_settings` VALUES (18,'string','app.seo.descriptions','/de/site/index','hallo dies ist ein test',1,'2017-03-07 14:25:21','2017-03-07 14:46:21');
INSERT INTO `app_settings` VALUES (27,'boolean','backend.toolbar','useIframe','1',0,'2017-10-27 19:16:34','2017-10-27 19:17:27');
INSERT INTO `app_settings` VALUES (28,'string','app.assets','settingsAssetList','app\\assets\\AppAsset',1,'2018-07-23 18:50:28',NULL);
/*!40000 ALTER TABLE `app_settings` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping data for table `app_twig`
--

LOCK TABLES `app_twig` WRITE; TRUNCATE TABLE `app_twig`;
/*!40000 ALTER TABLE `app_twig` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `app_twig` VALUES (4,'de/pages/default/page/1004','{{ use (\'hrzg/widget/widgets\') }}\r\n{{ cell_widget({id: \'main\'}) }}');
INSERT INTO `app_twig` VALUES (5,'de/pages/default/page/1011','{{ use (\'hrzg/widget/widgets\') }}\r\n{{ cell_widget({id: \'main\'}) }}\r\n');
INSERT INTO `app_twig` VALUES (7,'de/site/index','{{ use (\'hrzg/widget/widgets\') }}\r\n{{ cell_widget({id: \'top\'}) }}\r\n{{ cell_widget({id: \'main\'}) }}');
INSERT INTO `app_twig` VALUES (8,'de/pages/default/page/1006','{{ use (\'hrzg/widget/widgets\') }}\r\n{{ widget_container_widget({id: \'top\'}) }}\r\n{{ widget_container_widget({id: \'main\'}) }}\r\n{{ widget_container_widget({id: \'footer\'}) }}');
INSERT INTO `app_twig` VALUES (11,'de/pages/default/page/1021','{{ use (\'hrzg/widget/widgets\') }}\r\n{{ widget_container_widget({id: \'header\'}) }}\r\n<div class=\"container\">\r\n    {{ widget_container_widget({id: \'container\'}) }}\r\n</div>');
INSERT INTO `app_twig` VALUES (12,'en/site/index','{{ use (\'hrzg/widget/widgets\') }}\r\n{{ cell_widget({id: \'main\'}) }}');
INSERT INTO `app_twig` VALUES (14,'en/prototype/default/test','{{ use (\'hrzg/filemanager/widgets\') }}\r\n\r\n{{ file_manager_widget_widget({\r\n    \'handlerUrl\': \'/en/filefly/api\'\r\n}) }}');
INSERT INTO `app_twig` VALUES (15,'en/pages/default/page/1019','{{ use (\'hrzg/widget/widgets\') }}\r\n\r\n{{ cell_widget({id: \'header\'}) }}\r\n\r\n<div class=\"container\">\r\n    \r\n    <div class=\"row\">\r\n        <div class=\"col-sm-6\">{{ cell_widget({id: \'left\'}) }}</div>\r\n        <div class=\"col-sm-6\">{{ cell_widget({id: \'right\'}) }}</div>\r\n    </div>\r\n\r\n</div>\r\n');
INSERT INTO `app_twig` VALUES (16,'ru/site/index','{{ use (\'hrzg/widget/widgets\') }}\r\n{{ cell_widget({id: \'main\'}) }}');
INSERT INTO `app_twig` VALUES (17,'en/pages/default/page/1002','{{ use (\'hrzg/widget/widgets\') }}\r\n{{ cell_widget({id: \'main\'}) }}\r\n');
INSERT INTO `app_twig` VALUES (19,'de/pages/default/page/1043','{{ use (\'hrzg/widget/widgets\') }}\r\n{{ cell_widget({id: \'main\'}) }}');
INSERT INTO `app_twig` VALUES (20,'en/prototype/less/index#main-top','<div class=\"box\">\r\n    <div class=\"box-body\">\r\n        <p>\r\n            <a href=\"/settings\" target=\"_blank\" class=\"btn btn-info\">\r\n                Settings\r\n            </a>\r\n        </p>\r\n    </div>\r\n</div>');
INSERT INTO `app_twig` VALUES (21,'en/prototype/twig/update#main-top','<p>\r\n    <a href=\"https://github.com/yiisoft/yii2-twig/tree/master/docs/guide\" target=\"_blank\" class=\"btn btn-info\">\r\n        Twig Syntax\r\n    </a>\r\n</p>');
INSERT INTO `app_twig` VALUES (22,'backend.extra.content','{{ use (\'yii/bootstrap\') }}\r\n{{ modal_begin(\r\n    {\r\n        \'id\': \'modal-filemanager\',\r\n        \'size\': \'modal-lg\'\r\n    }\r\n) }}\r\n\r\n{{ use (\'hrzg/filemanager/widgets\') }}\r\n{{ file_manager_widget_widget(\r\n    {\r\n        \"handlerUrl\": \"/#{app.language}/filefly/api\"\r\n    }\r\n) }}\r\n\r\n{{ modal_end() }}\r\n');
INSERT INTO `app_twig` VALUES (23,'backend.extra.menuItems','<a type=\"button\" data-toggle=\"modal\" data-target=\"#modal-filemanager\">\r\n  <i class=\"fa fa-folder-open\"></i>\r\n</a>');
INSERT INTO `app_twig` VALUES (24,'en/backend/default/index#main-bottom','<a class=\"btn btn-lg btn-warning\" href=\"/settings/default?SettingSearch%5Bid%5D=&SettingSearch%5Bsection%5D=help\">Help Settings</a>');
INSERT INTO `app_twig` VALUES (25,'en/pages/default/page/1001','{{ use (\'hrzg/widget/widgets\') }}\r\n{{ cell_widget({id: \'top\'}) }}\r\n{{ cell_widget({id: \'main\'}) }}');
INSERT INTO `app_twig` VALUES (26,'_navbar','{{ use(\'dmstr/modules/pages/models\') }}\r\n{{ use(\'yii/helpers\') }}\r\n{{ use(\'rmrevin/yii/fontawesome\') }}\r\n\r\n{% set frontendItems = Tree.getMenuItems(\'root\', true) %}\r\n{% set backendItems = Tree.getMenuItems(\'backend\', true) %}\r\n\r\n{{ use(\'yii/bootstrap\') }}\r\n\r\n{{ nav_bar_begin({\r\n    \'brandLabel\': FA.i(\'cog\'),\r\n}) }}\r\n\r\n    {{ nav_widget({\r\n        \'options\': {\r\n            \'class\': \'navbar-nav navbar-right\',\r\n        },\r\n        \'items\': [\r\n            {\r\n            \'label\': \'Backend\',\r\n            \'items\': backendItems,\r\n            \'visible\': app.user.can(\'backend_default_index\')\r\n            }\r\n        ]\r\n    }) }}\r\n\r\n    {{ nav_widget({\r\n        \'options\': {\r\n            \'class\': \'navbar-nav navbar-right\',\r\n        },\r\n        \'items\': frontendItems\r\n    }) }}\r\n    \r\n    {{ nav_widget({\r\n        \'options\': {\r\n            \'class\': \'navbar-nav navbar-right\',\r\n        },\r\n        \'items\': [\r\n            {\r\n            \'label\': \'Logout\',\r\n            \'url\': [\'/user/security/logout\'],\r\n            \'linkOptions\': {\'data-method\':\'post\'},\r\n            \'visible\': (app.user.isGuest == false)\r\n            }\r\n        ]\r\n    }) }}\r\n\r\n{{ nav_bar_end() }}\r\n');
/*!40000 ALTER TABLE `app_twig` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping data for table `dmstr_redirect`
--

LOCK TABLES `dmstr_redirect` WRITE; TRUNCATE TABLE `dmstr_redirect`;
/*!40000 ALTER TABLE `dmstr_redirect` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `dmstr_redirect` VALUES (1,'path','','','/en','/en/doros-zuhause-1001',301,'2016-08-02 15:22:49','2017-01-30 16:49:19');
INSERT INTO `dmstr_redirect` VALUES (2,'domain','http://example.com','http://www.example.com','','',301,'2016-08-02 18:27:40','2016-12-15 18:18:31');
INSERT INTO `dmstr_redirect` VALUES (3,'path','','','/__test-redirect','/user/profile',301,'2017-04-03 04:48:39','2017-04-03 04:48:39');
INSERT INTO `dmstr_redirect` VALUES (4,'path','','','/__test-redirect','/user/profile',301,'2018-07-23 20:10:01','2018-07-23 20:10:01');
/*!40000 ALTER TABLE `dmstr_redirect` ENABLE KEYS */;
UNLOCK TABLES;
commit;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-07-23 20:24:00
