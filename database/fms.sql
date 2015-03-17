-- MySQL dump 10.15  Distrib 10.0.15-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: fms
-- ------------------------------------------------------
-- Server version	10.0.15-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `buildings`
--

DROP TABLE IF EXISTS `buildings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buildings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `abbv` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buildings`
--

LOCK TABLES `buildings` WRITE;
/*!40000 ALTER TABLE `buildings` DISABLE KEYS */;
INSERT INTO `buildings` VALUES (1,'AN Bourns Science Building','ABB','2015-03-11 21:43:50','2015-03-11 21:43:50');
/*!40000 ALTER TABLE `buildings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dismissed_notifications`
--

DROP TABLE IF EXISTS `dismissed_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dismissed_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `notification_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `dismissed_notifications_user_id_foreign` (`user_id`),
  KEY `dismissed_notifications_notification_id_foreign` (`notification_id`),
  CONSTRAINT `dismissed_notifications_notification_id_foreign` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `dismissed_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dismissed_notifications`
--

LOCK TABLES `dismissed_notifications` WRITE;
/*!40000 ALTER TABLE `dismissed_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `dismissed_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fume_hoods`
--

DROP TABLE IF EXISTS `fume_hoods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fume_hoods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `room_id` int(10) unsigned NOT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `install_date` date NOT NULL,
  `maintenance_date` date NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `fume_hoods_name_unique` (`name`),
  KEY `fume_hoods_room_id_foreign` (`room_id`),
  CONSTRAINT `fume_hoods_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fume_hoods`
--

LOCK TABLES `fume_hoods` WRITE;
/*!40000 ALTER TABLE `fume_hoods` DISABLE KEYS */;
INSERT INTO `fume_hoods` VALUES (1,'0001',1,'Test Model','2015-03-11','2015-03-11','Test Hood 1','2015-03-11 21:43:50','2015-03-11 21:43:50'),(2,'0002',1,'Test Model','2015-03-11','2015-03-11','Test Hood 2','2015-03-11 21:43:50','2015-03-11 21:43:50'),(3,'0003',2,'Test Model','2015-03-11','2015-03-11','Test Hood 3','2015-03-11 21:43:50','2015-03-11 21:43:50');
/*!40000 ALTER TABLE `fume_hoods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `measurements`
--

DROP TABLE IF EXISTS `measurements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `measurements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fume_hood_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sash_up` tinyint(1) NOT NULL,
  `velocity` float(8,2) NOT NULL,
  `measurement_time` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `alarm` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `measurements_fume_hood_name_foreign` (`fume_hood_name`),
  CONSTRAINT `measurements_fume_hood_name_foreign` FOREIGN KEY (`fume_hood_name`) REFERENCES `fume_hoods` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `measurements`
--

LOCK TABLES `measurements` WRITE;
/*!40000 ALTER TABLE `measurements` DISABLE KEYS */;
INSERT INTO `measurements` VALUES (1,'0001',0,20.00,'2015-03-11 17:43:50','2015-03-11 21:43:50','2015-03-11 21:43:50',0),(2,'0001',0,21.00,'2015-03-11 22:43:58','2015-03-11 21:43:51','2015-03-11 21:43:51',0),(3,'0001',0,22.00,'2015-03-22 17:43:58','2015-03-11 21:43:53','2015-03-11 21:43:53',0),(4,'0001',1,21.00,'2015-03-22 22:43:58','2015-03-11 21:43:54','2015-03-11 21:43:54',0),(5,'0001',1,21.00,'2015-03-24 17:43:58','2015-03-11 21:43:55','2015-03-11 21:43:55',1),(6,'0001',0,22.00,'2015-03-24 22:43:58','2015-03-11 21:43:56','2015-03-11 21:43:56',0),(7,'0001',0,23.00,'2015-03-26 17:43:58','2015-03-11 21:43:57','2015-03-11 21:43:57',1),(8,'0001',0,22.00,'2015-03-26 22:43:58','2015-03-11 21:43:58','2015-03-11 21:43:58',0),(9,'0001',1,0.00,'2015-03-11 22:43:58','0000-00-00 00:00:00','0000-00-00 00:00:00',0),(10,'0001',0,0.00,'2015-03-26 22:43:58','0000-00-00 00:00:00','0000-00-00 00:00:00',0),(11,'0001',0,0.00,'2015-03-26 22:43:58','0000-00-00 00:00:00','0000-00-00 00:00:00',0),(12,'0001',0,0.00,'2015-03-11 22:43:58','0000-00-00 00:00:00','0000-00-00 00:00:00',0),(13,'0001',1,0.00,'2015-03-11 22:43:58','0000-00-00 00:00:00','0000-00-00 00:00:00',0);
/*!40000 ALTER TABLE `measurements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2015_01_16_171134_create_users_table',1),('2015_01_16_173523_create_user_types_table',1),('2015_01_23_113509_create_buildings_table',1),('2015_01_23_113532_create_rooms_table',1),('2015_01_23_113617_create_fumehoods_table',1),('2015_01_23_113642_create_notification_settings_table',1),('2015_01_23_205006_create_notifications_table',1),('2015_01_23_210713_create_measurements_table',1),('2015_01_23_210938_create_dismissed_table',1),('2015_01_23_212845_create_settings_table',1),('2015_01_30_104328_create_password_reminders_table',1),('2015_02_24_124436_add_alarm_column',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification_settings`
--

DROP TABLE IF EXISTS `notification_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `critical` tinyint(1) NOT NULL,
  `alert` tinyint(1) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `room_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `notification_settings_user_id_foreign` (`user_id`),
  KEY `notification_settings_room_id_foreign` (`room_id`),
  CONSTRAINT `notification_settings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `notification_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification_settings`
--

LOCK TABLES `notification_settings` WRITE;
/*!40000 ALTER TABLE `notification_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fume_hood_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `class` enum('alert','critical') COLLATE utf8_unicode_ci NOT NULL,
  `measurement_time` datetime NOT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('new','acknowledged','resolved') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'new',
  `updated_by` int(10) unsigned DEFAULT NULL,
  `updated_time` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `notifications_fume_hood_name_foreign` (`fume_hood_name`),
  KEY `notifications_updated_by_foreign` (`updated_by`),
  CONSTRAINT `notifications_fume_hood_name_foreign` FOREIGN KEY (`fume_hood_name`) REFERENCES `fume_hoods` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `notifications_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,'0001','alert','2015-03-11 17:43:50','Velocity Low','new',NULL,'0000-00-00 00:00:00','2015-03-11 21:43:50','2015-03-11 21:43:50'),(2,'0001','critical','2015-03-11 17:43:50','Velocity Low','new',NULL,'0000-00-00 00:00:00','2015-03-11 21:43:50','2015-03-11 21:43:50'),(3,'0002','alert','2015-03-11 17:43:50','Velocity High','new',NULL,'0000-00-00 00:00:00','2015-03-11 21:43:50','2015-03-11 21:43:50'),(4,'0002','alert','2015-03-11 17:43:50','Sash Up Overnight','new',NULL,'0000-00-00 00:00:00','2015-03-11 21:43:50','2015-03-11 21:43:50'),(5,'0001','alert','2015-03-11 17:43:50','Sash Up Overnight','new',NULL,'0000-00-00 00:00:00','2015-03-11 21:43:50','2015-03-11 21:43:50');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reminders`
--

DROP TABLE IF EXISTS `password_reminders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reminders` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_reminders_email_index` (`email`),
  KEY `password_reminders_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reminders`
--

LOCK TABLES `password_reminders` WRITE;
/*!40000 ALTER TABLE `password_reminders` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reminders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rooms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `building_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `rooms_building_id_foreign` (`building_id`),
  CONSTRAINT `rooms_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (1,'101','lab_abb101@mcmaster.ca',1,'2015-03-11 21:43:50','2015-03-11 21:43:50'),(2,'102','ex55555',1,'2015-03-11 21:43:50','2015-03-11 21:43:50');
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_settings`
--

DROP TABLE IF EXISTS `system_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `critical_max_velocity` float(8,2) NOT NULL DEFAULT '110.00',
  `critical_min_velocity` float(8,2) NOT NULL DEFAULT '10.00',
  `alert_max_velocity` float(8,2) NOT NULL DEFAULT '100.00',
  `alert_min_velocity` float(8,2) NOT NULL DEFAULT '20.00',
  `critical_resend_hours` float(8,2) NOT NULL DEFAULT '24.00',
  `alert_resend_hours` float(8,2) NOT NULL DEFAULT '6.00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_settings`
--

LOCK TABLES `system_settings` WRITE;
/*!40000 ALTER TABLE `system_settings` DISABLE KEYS */;
INSERT INTO `system_settings` VALUES (1,110.00,10.00,100.00,20.00,24.00,6.00,'2015-03-11 21:43:49','2015-03-11 21:43:49');
/*!40000 ALTER TABLE `system_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_types`
--

DROP TABLE IF EXISTS `user_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_types_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_types`
--

LOCK TABLES `user_types` WRITE;
/*!40000 ALTER TABLE `user_types` DISABLE KEYS */;
INSERT INTO `user_types` VALUES (1,'user','2015-03-11 21:43:50','2015-03-11 21:43:50'),(2,'admin','2015-03-11 21:43:50','2015-03-11 21:43:50');
/*!40000 ALTER TABLE `user_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_type_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_user_type_id_foreign` (`user_type_id`),
  CONSTRAINT `users_user_type_id_foreign` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'administrator@fms.mcmaster.ca','$2y$10$F9rekPyBeFoR2sg3EjE44ucMPAo6iOJhMabwwdyOtZzUxXtrtuy7e',NULL,'2015-03-11 21:43:50','2015-03-11 21:43:50',2);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-16 21:03:16
