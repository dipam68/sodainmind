-- MySQL dump 10.13  Distrib 8.0.21, for Win64 (x86_64)
--
-- Host: localhost    Database: simtest_db
-- ------------------------------------------------------
-- Server version	8.0.21

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plans` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(45) DEFAULT NULL,
  `description` text,
  `price` int DEFAULT NULL,
  `icon` varchar(45) DEFAULT NULL,
  `color` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plans`
--

LOCK TABLES `plans` WRITE;
/*!40000 ALTER TABLE `plans` DISABLE KEYS */;
INSERT INTO `plans` VALUES (20,'Silver Tier','For beginner purpose. Wanna learn but don\'t want to take much risk.',10,NULL,NULL,'2020-12-14 19:27:50','2020-12-14 19:27:50'),(21,'Gold Tier','For brave people who wanna earn more and take some risk!',20,NULL,NULL,'2020-12-14 19:28:35','2020-12-14 19:28:35'),(22,'Platinum Tier','For people who wanna be the champions regardless anything!',30,NULL,NULL,'2020-12-14 19:29:17','2020-12-14 19:29:17');
/*!40000 ALTER TABLE `plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `trial_day` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (12,7,'2020-12-14 21:13:20','2020-12-14 21:25:45');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscriptions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `id_plan` int DEFAULT NULL,
  `is_trial` int DEFAULT NULL,
  `trial_end` datetime DEFAULT NULL,
  `is_paid` int DEFAULT NULL,
  `status` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriptions`
--

LOCK TABLES `subscriptions` WRITE;
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
INSERT INTO `subscriptions` VALUES (1,1,1,1,NULL,NULL,1,NULL,NULL),(2,29,20,1,'2020-12-21 23:12:14',0,1,'2020-12-14 23:14:14','2020-12-14 23:14:14'),(3,36,20,0,'2020-12-22 03:12:02',1,1,'2020-12-15 03:14:02','2020-12-15 03:14:02'),(4,37,20,1,'2020-12-27 06:12:54',0,1,'2020-12-20 06:29:54','2020-12-20 06:29:54'),(5,37,20,1,'2020-12-27 06:12:55',0,1,'2020-12-20 06:30:55','2020-12-20 06:30:55'),(6,37,20,1,'2020-12-27 06:12:26',0,1,'2020-12-20 06:32:26','2020-12-20 06:32:26'),(7,37,20,1,'2020-12-27 06:12:03',0,1,'2020-12-20 06:33:03','2020-12-20 06:33:03'),(8,38,20,1,'2020-12-27 12:12:16',0,1,'2020-12-20 12:10:16','2020-12-20 12:10:16'),(9,45,22,0,NULL,1,1,'2020-12-21 01:59:48','2020-12-21 01:59:48'),(10,46,22,0,NULL,1,1,'2020-12-21 02:04:57','2020-12-21 02:04:57'),(11,46,22,0,NULL,1,1,'2020-12-21 02:05:21','2020-12-21 02:05:21'),(12,48,22,0,NULL,1,1,'2020-12-21 02:09:56','2020-12-21 02:09:56'),(13,48,22,0,NULL,1,1,'2020-12-21 02:10:44','2020-12-21 02:10:44'),(14,50,21,0,NULL,1,1,'2020-12-21 02:11:33','2020-12-21 02:11:33'),(15,54,20,0,NULL,1,1,'2020-12-21 03:49:15','2020-12-21 02:30:47');
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `role` int DEFAULT NULL,
  `is_login` int DEFAULT '0',
  `email` varchar(55) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (6,'f','4a0a19218e082a343a1b17e5333409af9d98f0f5',1,0,'f@f.com','2020-12-13 10:23:00','2020-12-13 10:23:19',1),(29,'fs','3f4bb586f04a0c1d93eadab9363a8a3183b4860c',2,0,'fitra90@gmail.com','2020-12-14 23:12:37','2020-12-14 23:13:23',1),(30,'david','aa743a0aaec8f7d7a1f01442503957f4d7a2d634',2,0,'david@mail.com','2020-12-15 03:02:42','2020-12-15 03:02:42',0),(31,'da','cdd4f874095045f4ae6670038cbbd05fac9d4802',2,0,'da@da.com','2020-12-15 03:03:43','2020-12-15 03:03:43',0),(32,'david','386d89d8ae604d2332c5c6cc5dc5a43c97d2d789',2,0,'dav@email2.com','2020-12-15 03:07:10','2020-12-15 03:07:10',0),(33,'sdf','9a6747fc6259aa374ab4e1bb03074b6ec672cf99',2,0,'sdf@sdf.sdf','2020-12-15 03:08:46','2020-12-15 03:08:46',0),(34,'dav3','d516a13616d2e64984e82ddd64b9237d33dcff90',2,0,'dada@dsfdsds.com','2020-12-15 03:09:12','2020-12-15 03:09:12',0),(35,'john','a51dda7c7ff50b61eaea0444371f4a6a9301e501',2,0,'john@doe.com','2020-12-15 03:11:50','2020-12-15 03:11:50',0),(36,'kim','a6312121e15caec74845b7ba5af23330d52d4ac0',2,0,'kim@email.com','2020-12-15 03:13:17','2020-12-15 03:14:02',1),(37,'darman','5f7ed78f4c71105cc20bbad234a0e84f877a0309',2,0,'darman@email.com','2020-12-20 06:29:29','2020-12-20 06:29:54',1),(38,'darmin','2c1a62201cd8bbc7f5df9af08173fbb6e928e900',2,0,'darmin@darmin.com','2020-12-20 12:09:48','2020-12-20 12:10:16',1),(39,'tese','da39a3ee5e6b4b0d3255bfef95601890afd80709',2,0,'tese@sdf.dsf','2020-12-20 20:01:49','2020-12-20 20:04:04',1),(40,'admin2','da39a3ee5e6b4b0d3255bfef95601890afd80709',2,0,'fitra90@gmsail.com','2020-12-20 20:08:34','2020-12-20 20:08:34',0),(41,'joni','91010ab2791f95fcd50d52d8b32f5c756438c411',2,0,'joni@email.com','2020-12-21 01:02:13','2020-12-21 01:02:50',1),(42,'rt','fd01c0d7916f6c1fd4e3a3d8b10cbdeed574632c',2,0,'rt@erer.er','2020-12-21 01:42:30','2020-12-21 01:42:30',0),(43,'rms','8081031fe20c252106f58a6c5b2ce840596f0a83',2,0,'rms@dsf.sdf','2020-12-21 01:45:24','2020-12-21 01:45:24',0),(44,'xx','dd7b7b74ea160e049dd128478e074ce47254bde8',2,0,'xx@jdl.dsf','2020-12-21 01:53:52','2020-12-21 01:53:52',0),(45,'s','a0f1490a20d0211c997b44bc357e1972deab8ae3',2,0,'s@s.sss','2020-12-21 01:59:48','2020-12-21 01:59:48',0),(46,'sc','04096ad9c89678a1014d9c435db136c296cd2168',2,0,'sc@sc.scd','2020-12-21 02:04:57','2020-12-21 02:04:57',0),(47,'sc','04096ad9c89678a1014d9c435db136c296cd2168',2,0,'sc@sc.scd','2020-12-21 02:05:21','2020-12-21 02:05:21',0),(48,'sd','4452d71687b6bc2c9389c3349fdc17fbd73b833b',2,0,'sd@sdf.sdf','2020-12-21 02:09:56','2020-12-21 02:09:56',0),(49,'sd','4452d71687b6bc2c9389c3349fdc17fbd73b833b',2,0,'sd@sdf.sdf','2020-12-21 02:10:44','2020-12-21 02:10:44',0),(50,'real','c9c64e071d2853bc7906c017a231ad1cc46ab630',2,0,'real@user.com','2020-12-21 02:11:33','2020-12-21 02:11:58',1),(51,'jaja','cc61a0f386a2877e3e27587fa086d2945b97c811',2,0,'aj@aj.co','2020-12-21 02:12:35','2020-12-21 02:12:56',1),(52,'sasa','7bf1ab1b8f7331ab5dc410e01f959d958bfd210e',2,0,'sasa@bamformd.com','2020-12-21 02:24:43','2020-12-21 02:24:43',0),(53,'sss','bf9661defa3daecacfde5bde0214c4a439351d4d',2,0,'sss@sss.sss','2020-12-21 02:29:53','2020-12-21 02:29:53',0),(54,'es','09cd68a2a77b22a312dded612dd0d9988685189f',2,0,'es@es.com','2020-12-21 02:30:47','2020-12-21 02:31:04',1);
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

-- Dump completed on 2020-12-21 12:08:53
