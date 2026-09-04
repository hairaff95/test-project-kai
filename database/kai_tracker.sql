-- MySQL dump 10.13  Distrib 9.4.0, for macos15.4 (arm64)
--
-- Host: localhost    Database: kai_tracker
-- ------------------------------------------------------
-- Server version	9.4.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `kai_tracker`
--

/*!40000 DROP DATABASE IF EXISTS `kai_tracker`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `kai_tracker` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `kai_tracker`;

--
-- Table structure for table `assets`
--

DROP TABLE IF EXISTS `assets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assets` (
  `asset_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asset_block_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `size_area` decimal(10,2) DEFAULT NULL,
  `peruntukan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_asset` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stasiun` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wilayah_asset` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `images` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`asset_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assets`
--

LOCK TABLES `assets` WRITE;
/*!40000 ALTER TABLE `assets` DISABLE KEYS */;
INSERT INTO `assets` VALUES ('04.01.00764','LAHAN BARU BLOK B PEKALONGAN','Pekalongan Barat, Kota Pekalongan','Aset Lahan Komersial KAI Daop 4 Pekalongan',50.00,'Tanah','Tanah','Pekalongan','Daop 4 Semarang',-6.88620000,109.67380000,'[]','2026-09-03 07:28:12');
/*!40000 ALTER TABLE `assets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contract_financials`
--

DROP TABLE IF EXISTS `contract_financials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contract_financials` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `contract_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_hari` int NOT NULL DEFAULT '0',
  `nilai_per_hari` decimal(15,2) NOT NULL DEFAULT '0.00',
  `awal` date DEFAULT NULL,
  `akhir` date DEFAULT NULL,
  `hari_2026` int NOT NULL DEFAULT '0',
  `nilai_2026` decimal(15,2) NOT NULL DEFAULT '0.00',
  `nilai_backlog` decimal(15,2) NOT NULL DEFAULT '0.00',
  `nilai_backlog2` decimal(15,2) NOT NULL DEFAULT '0.00',
  `gl_account` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_rka` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_rka` int NOT NULL DEFAULT '2026',
  `jenis_pendapatan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persentase` decimal(5,2) NOT NULL DEFAULT '0.00',
  `pencapaian` decimal(5,2) NOT NULL DEFAULT '0.00',
  `ket` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `contract_financials_contract_number_foreign` (`contract_number`),
  CONSTRAINT `contract_financials_contract_number_foreign` FOREIGN KEY (`contract_number`) REFERENCES `contracts` (`contract_number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contract_financials`
--

LOCK TABLES `contract_financials` WRITE;
/*!40000 ALTER TABLE `contract_financials` DISABLE KEYS */;
INSERT INTO `contract_financials` VALUES (1,'0005/51116/D.4/941/PK/TN/XII/2016',730,3102.00,'2026-01-01','2026-12-31',365,1132197.00,9063780.00,9402819.00,'3421190010','RKA',2026,'Pendapatan Non Angkutan',0.90,0.90,'AKTIF'),(2,'0004/51116/D.4/941/PK/TN/XI/2016',882,2140.00,'2026-01-01','2026-12-31',365,781151.00,5733437.00,6019359.00,'3421190010','RKA',2026,'Pendapatan Non Angkutan',0.90,0.90,'AKTIF');
/*!40000 ALTER TABLE `contract_financials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contracts`
--

DROP TABLE IF EXISTS `contracts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contracts` (
  `contract_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tenant_id` int unsigned NOT NULL,
  `asset_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contract_date` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kontrak` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area_kontrak` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_datetime` date DEFAULT NULL,
  `end_datetime` date DEFAULT NULL,
  `start_datetime_baru` date DEFAULT NULL,
  `end_datetime_baru` date DEFAULT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `spv` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asset_block_name` text COLLATE utf8mb4_unicode_ci,
  `size_area` decimal(10,2) DEFAULT NULL,
  `peruntukan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`contract_number`),
  KEY `contracts_tenant_id_foreign` (`tenant_id`),
  KEY `contracts_asset_number_foreign` (`asset_number`),
  CONSTRAINT `contracts_asset_number_foreign` FOREIGN KEY (`asset_number`) REFERENCES `assets` (`asset_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `contracts_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contracts`
--

LOCK TABLES `contracts` WRITE;
/*!40000 ALTER TABLE `contracts` DISABLE KEYS */;
INSERT INTO `contracts` VALUES ('0004/51116/D.4/941/PK/TN/XI/2016',2,'04.01.00764','42678','Kontrak Sewa','Daop 4 Semarang','2016-04-01','2018-08-31','2018-09-01','2026-12-31',1887604.00,'Sales Executive Area 1 Pekalongan','SEKITAR KM. 2+533 S.D KM. 3+533 KEL. PRINGREJO KEC. PEKALONGAN BARAT KOTA PEKALONGAN LINTAS NON OPERASI PEKALONGAN - WONOSOBO (4/51116/PK/TN/941)',43.50,'RUMAH TINGGAL','RKA','2026-09-03 07:28:12'),('0005/51116/D.4/941/PK/TN/XII/2016',1,'04.01.00764','42710','Kontrak Sewa','Non Row','2016-01-01','2017-12-31','2018-01-01','2026-12-31',2264394.00,'Sales Executive Area 1 Pekalongan','SEKITAR 2+1/200 LINTAS NON OPERASI - WONOPRINGGO KEL. TEGALREJO RT/RW.01/02 KEC. PEKALONGAN BARAT KOTA PEKALONGAN (5/51116/PK/TN/941)',42.00,'Tanah','Pendapatan Sewa Tanah Non Row','2026-09-03 07:28:12');
/*!40000 ALTER TABLE `contracts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'2026_08_14_155645_create_assets_table',1),(3,'2026_08_27_112440_create_main_tables',1),(4,'2026_08_31_000001_create_password_reset_requests_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `monthly_schedules`
--

DROP TABLE IF EXISTS `monthly_schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `monthly_schedules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `contract_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` int NOT NULL DEFAULT '2026',
  `invoice` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `januari` decimal(15,2) NOT NULL DEFAULT '0.00',
  `febuari` decimal(15,2) NOT NULL DEFAULT '0.00',
  `maret` decimal(15,2) NOT NULL DEFAULT '0.00',
  `april` decimal(15,2) NOT NULL DEFAULT '0.00',
  `mei` decimal(15,2) NOT NULL DEFAULT '0.00',
  `juni` decimal(15,2) NOT NULL DEFAULT '0.00',
  `juli` decimal(15,2) NOT NULL DEFAULT '0.00',
  `agustus` decimal(15,2) NOT NULL DEFAULT '0.00',
  `september` decimal(15,2) NOT NULL DEFAULT '0.00',
  `oktober` decimal(15,2) NOT NULL DEFAULT '0.00',
  `november` decimal(15,2) NOT NULL DEFAULT '0.00',
  `desember` decimal(15,2) NOT NULL DEFAULT '0.00',
  `jan_des` decimal(15,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `monthly_schedules_contract_number_foreign` (`contract_number`),
  CONSTRAINT `monthly_schedules_contract_number_foreign` FOREIGN KEY (`contract_number`) REFERENCES `contracts` (`contract_number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `monthly_schedules`
--

LOCK TABLES `monthly_schedules` WRITE;
/*!40000 ALTER TABLE `monthly_schedules` DISABLE KEYS */;
INSERT INTO `monthly_schedules` VALUES (1,'0005/51116/D.4/941/PK/TN/XII/2016',2026,'SUDAH TERBIT',105775.00,95539.00,105775.00,102363.00,105775.00,102363.00,105775.00,105775.00,102363.00,105775.00,102363.00,105775.00,1245417.00),(2,'0004/51116/D.4/941/PK/TN/XI/2016',2026,'SUDAH TERBIT',72979.00,65916.00,72979.00,70625.00,72979.00,70625.00,72979.00,72979.00,70625.00,72979.00,70625.00,72979.00,859266.00);
/*!40000 ALTER TABLE `monthly_schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_requests`
--

DROP TABLE IF EXISTS `password_reset_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `otp_code` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected','completed','auto_reset') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `request_expires_at` timestamp NULL DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `password_reset_requests_user_id_foreign` (`user_id`),
  CONSTRAINT `password_reset_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_requests`
--

LOCK TABLES `password_reset_requests` WRITE;
/*!40000 ALTER TABLE `password_reset_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('lUtiAtLbyv8E9tD9FB1Y17WNxoyFScPWqPS4JZUG',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:154.0) Gecko/20100101 Firefox/154.0','eyJfdG9rZW4iOiJzUEVPcTN5TXpDeEE3Nm9iUmRBbXVRWWR3aVV3T2JvbUloQkZOMnRnIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hcGlcL25vdGlmaWNhdGlvbnNcL25ldy1hc3NldHMiLCJyb3V0ZSI6Im5vdGlmaWNhdGlvbnMubmV3LWFzc2V0cyJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788445788);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tenants`
--

DROP TABLE IF EXISTS `tenants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tenants` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_customer` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_perusahaan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tenants`
--

LOCK TABLES `tenants` WRITE;
/*!40000 ALTER TABLE `tenants` DISABLE KEYS */;
INSERT INTO `tenants` VALUES (1,'MARDIYAH','Swasta','Perorangan','(kosong)','2026-09-03 07:28:12'),(2,'ARIF KHUZAINI','Swasta','Perorangan','(kosong)','2026-09-03 07:28:12');
/*!40000 ALTER TABLE `tenants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','admin','superadmin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'superadmin','Super Admin KAI Daop 4','superadmin@kai-daop4.id',NULL,'$2y$12$IwKcMQpzzIIWMW7sG0Cm0u4abULXUuJ4rP5qm/tUn48f47kJhwP8e','superadmin',1,NULL,'2026-09-03 07:28:12','2026-09-03 07:28:12'),(2,'admin.daop4','Admin KAI Daop 4','admin@kai-daop4.id',NULL,'$2y$12$RMQyggdUYpmVuv4E0BrchuzFa2VscZaJkOcHWsa.wCj98.9SHA8/m','admin',1,NULL,'2026-09-03 07:28:12','2026-09-03 07:28:12');
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

-- Dump completed on 2026-09-03 21:30:33
