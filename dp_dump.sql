-- MySQL dump 10.13  Distrib 8.0.37, for Win64 (x86_64)
--
-- Host: localhost    Database: laravel
-- ------------------------------------------------------
-- Server version	8.0.37

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
-- Table structure for table `activites`
--

DROP TABLE IF EXISTS `activites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activites` (
  `ActiviteID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Type` enum('Cours','TP','TD') COLLATE utf8mb4_unicode_ci NOT NULL,
  `ModuleID` bigint unsigned NOT NULL,
  `ProfesseurID` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ActiviteID`),
  UNIQUE KEY `activite_moduleid_professeurid_type_unique` (`ModuleID`,`ProfesseurID`,`Type`),
  KEY `activite_professeurid_foreign` (`ProfesseurID`),
  CONSTRAINT `activite_moduleid_foreign` FOREIGN KEY (`ModuleID`) REFERENCES `modules` (`ModuleID`),
  CONSTRAINT `activite_professeurid_foreign` FOREIGN KEY (`ProfesseurID`) REFERENCES `professeurs` (`ProfesseurID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activites`
--

LOCK TABLES `activites` WRITE;
/*!40000 ALTER TABLE `activites` DISABLE KEYS */;
INSERT INTO `activites` VALUES (1,'TD',1,1,'2025-03-17 11:02:20',NULL);
/*!40000 ALTER TABLE `activites` ENABLE KEYS */;
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
-- Table structure for table `departement`
--

DROP TABLE IF EXISTS `departement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departement` (
  `DepartementID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ChefPedagogiqueID` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`DepartementID`),
  KEY `departement_chefpedagogiqueid_foreign` (`ChefPedagogiqueID`),
  CONSTRAINT `departement_chefpedagogiqueid_foreign` FOREIGN KEY (`ChefPedagogiqueID`) REFERENCES `professeurs` (`ProfesseurID`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departement`
--

LOCK TABLES `departement` WRITE;
/*!40000 ALTER TABLE `departement` DISABLE KEYS */;
INSERT INTO `departement` VALUES (1,'Informatique',1),(2,'Math',NULL),(3,'Phisic',NULL),(4,'chimie',4);
/*!40000 ALTER TABLE `departement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emploi_du_temps`
--

DROP TABLE IF EXISTS `emploi_du_temps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `emploi_du_temps` (
  `EmploiDuTempsID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Jour` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TimeSlot` int NOT NULL,
  `SectionID` bigint unsigned DEFAULT NULL,
  `ParcoursID` bigint unsigned DEFAULT NULL,
  `NiveauID` bigint unsigned DEFAULT NULL,
  `SpecialiteID` bigint unsigned DEFAULT NULL,
  `ActiviteID` bigint unsigned DEFAULT NULL,
  `ProfesseurID` bigint unsigned DEFAULT NULL,
  `GroupID` bigint unsigned DEFAULT NULL,
  `ModuleID` bigint unsigned DEFAULT NULL,
  `LocalID` bigint unsigned DEFAULT NULL,
  `departement_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `SemestreID` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`EmploiDuTempsID`),
  KEY `emploi_du_temps_professeurid_foreign` (`ProfesseurID`),
  KEY `emploi_du_temps_groupid_foreign` (`GroupID`),
  KEY `emploi_du_temps_moduleid_foreign` (`ModuleID`),
  KEY `emploi_du_temps_localid_foreign` (`LocalID`),
  KEY `emploi_du_temps_sectionid_foreign` (`SectionID`),
  KEY `emploi_du_temps_parcoursid_foreign` (`ParcoursID`),
  KEY `emploi_du_temps_niveauid_foreign` (`NiveauID`),
  KEY `emploi_du_temps_specialiteid_foreign` (`SpecialiteID`),
  KEY `emploi_du_temps_activiteid_foreign` (`ActiviteID`),
  KEY `emploi_du_temps_semestreid_foreign` (`SemestreID`),
  CONSTRAINT `emploi_du_temps_activiteid_foreign` FOREIGN KEY (`ActiviteID`) REFERENCES `activites` (`ActiviteID`),
  CONSTRAINT `emploi_du_temps_groupid_foreign` FOREIGN KEY (`GroupID`) REFERENCES `groups` (`GroupID`),
  CONSTRAINT `emploi_du_temps_localid_foreign` FOREIGN KEY (`LocalID`) REFERENCES `locals` (`LocalID`),
  CONSTRAINT `emploi_du_temps_moduleid_foreign` FOREIGN KEY (`ModuleID`) REFERENCES `modules` (`ModuleID`),
  CONSTRAINT `emploi_du_temps_niveauid_foreign` FOREIGN KEY (`NiveauID`) REFERENCES `niveaux` (`NiveauID`),
  CONSTRAINT `emploi_du_temps_parcoursid_foreign` FOREIGN KEY (`ParcoursID`) REFERENCES `parcours` (`ParcoursID`),
  CONSTRAINT `emploi_du_temps_professeurid_foreign` FOREIGN KEY (`ProfesseurID`) REFERENCES `professeurs` (`ProfesseurID`),
  CONSTRAINT `emploi_du_temps_sectionid_foreign` FOREIGN KEY (`SectionID`) REFERENCES `sections` (`SectionID`),
  CONSTRAINT `emploi_du_temps_semestreid_foreign` FOREIGN KEY (`SemestreID`) REFERENCES `semesters` (`SemestreID`),
  CONSTRAINT `emploi_du_temps_specialiteid_foreign` FOREIGN KEY (`SpecialiteID`) REFERENCES `specialites` (`SpecialiteID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emploi_du_temps`
--

LOCK TABLES `emploi_du_temps` WRITE;
/*!40000 ALTER TABLE `emploi_du_temps` DISABLE KEYS */;
INSERT INTO `emploi_du_temps` VALUES (5,'Samedi',0,1,1,1,1,1,2,1,1,2,1,'2025-04-15 15:17:03','2025-04-15 15:17:03',NULL);
/*!40000 ALTER TABLE `emploi_du_temps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emploisoutenance`
--

DROP TABLE IF EXISTS `emploisoutenance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `emploisoutenance` (
  `EmploiSoutenanceID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ProfesseurID` bigint unsigned NOT NULL,
  `SousEncadrantID` bigint unsigned DEFAULT NULL,
  `ThemeID` bigint unsigned NOT NULL,
  `EtudiantID` bigint unsigned NOT NULL,
  `SpecialiteID` bigint unsigned NOT NULL,
  `GroupID` bigint unsigned NOT NULL,
  `HeureDebut` time NOT NULL,
  `HeureFin` time NOT NULL,
  `LocalID` bigint unsigned NOT NULL,
  `Jour` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`EmploiSoutenanceID`),
  KEY `emploisoutenance_professeurid_foreign` (`ProfesseurID`),
  KEY `emploisoutenance_themeid_foreign` (`ThemeID`),
  KEY `emploisoutenance_etudiantid_foreign` (`EtudiantID`),
  KEY `emploisoutenance_specialiteid_foreign` (`SpecialiteID`),
  KEY `emploisoutenance_groupid_foreign` (`GroupID`),
  KEY `emploisoutenance_localid_foreign` (`LocalID`),
  KEY `emploisoutenance_sousencadrantid_foreign` (`SousEncadrantID`),
  CONSTRAINT `emploisoutenance_etudiantid_foreign` FOREIGN KEY (`EtudiantID`) REFERENCES `etudiants` (`EtudiantID`) ON DELETE CASCADE,
  CONSTRAINT `emploisoutenance_groupid_foreign` FOREIGN KEY (`GroupID`) REFERENCES `groups` (`GroupID`) ON DELETE CASCADE,
  CONSTRAINT `emploisoutenance_localid_foreign` FOREIGN KEY (`LocalID`) REFERENCES `locals` (`LocalID`) ON DELETE CASCADE,
  CONSTRAINT `emploisoutenance_professeurid_foreign` FOREIGN KEY (`ProfesseurID`) REFERENCES `professeurs` (`ProfesseurID`) ON DELETE CASCADE,
  CONSTRAINT `emploisoutenance_sousencadrantid_foreign` FOREIGN KEY (`SousEncadrantID`) REFERENCES `professeurs` (`ProfesseurID`) ON DELETE SET NULL,
  CONSTRAINT `emploisoutenance_specialiteid_foreign` FOREIGN KEY (`SpecialiteID`) REFERENCES `specialites` (`SpecialiteID`) ON DELETE CASCADE,
  CONSTRAINT `emploisoutenance_themeid_foreign` FOREIGN KEY (`ThemeID`) REFERENCES `themes` (`ThemeID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emploisoutenance`
--

LOCK TABLES `emploisoutenance` WRITE;
/*!40000 ALTER TABLE `emploisoutenance` DISABLE KEYS */;
INSERT INTO `emploisoutenance` VALUES (11,6,3,5,1,1,1,'10:00:00','10:30:00',2,'Samedi','2025-04-15 10:13:34','2025-04-15 10:13:34'),(12,6,3,5,3,1,2,'10:00:00','10:30:00',2,'Samedi','2025-04-15 10:13:34','2025-04-15 10:13:34');
/*!40000 ALTER TABLE `emploisoutenance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etudiants`
--

DROP TABLE IF EXISTS `etudiants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `etudiants` (
  `EtudiantID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `GroupID` bigint unsigned DEFAULT NULL,
  `SpecialiteID` bigint unsigned DEFAULT NULL,
  `NiveauID` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`EtudiantID`),
  KEY `etudiant_groupid_foreign` (`GroupID`),
  KEY `etudiant_specialiteid_foreign` (`SpecialiteID`),
  KEY `etudiant_niveauid_foreign` (`NiveauID`),
  CONSTRAINT `etudiant_groupid_foreign` FOREIGN KEY (`GroupID`) REFERENCES `groups` (`GroupID`),
  CONSTRAINT `etudiant_niveauid_foreign` FOREIGN KEY (`NiveauID`) REFERENCES `niveaux` (`NiveauID`),
  CONSTRAINT `etudiant_specialiteid_foreign` FOREIGN KEY (`SpecialiteID`) REFERENCES `specialites` (`SpecialiteID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etudiants`
--

LOCK TABLES `etudiants` WRITE;
/*!40000 ALTER TABLE `etudiants` DISABLE KEYS */;
INSERT INTO `etudiants` VALUES (1,'benatiia rahma',1,1,1,'2025-03-24 12:56:50',NULL),(2,'mounir',1,1,1,'2025-03-24 12:58:40',NULL),(3,'seif khemira',2,1,1,'2025-04-11 09:16:30',NULL);
/*!40000 ALTER TABLE `etudiants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gestion_theme_etudiant`
--

DROP TABLE IF EXISTS `gestion_theme_etudiant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gestion_theme_etudiant` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `GestionThemeID` bigint unsigned NOT NULL,
  `EtudiantID` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gestion_theme_etudiant_gestionthemeid_foreign` (`GestionThemeID`),
  KEY `gestion_theme_etudiant_etudiantid_foreign` (`EtudiantID`),
  CONSTRAINT `gestion_theme_etudiant_etudiantid_foreign` FOREIGN KEY (`EtudiantID`) REFERENCES `etudiants` (`EtudiantID`) ON DELETE CASCADE,
  CONSTRAINT `gestion_theme_etudiant_gestionthemeid_foreign` FOREIGN KEY (`GestionThemeID`) REFERENCES `gestiondesthemes` (`GestionThemeID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gestion_theme_etudiant`
--

LOCK TABLES `gestion_theme_etudiant` WRITE;
/*!40000 ALTER TABLE `gestion_theme_etudiant` DISABLE KEYS */;
INSERT INTO `gestion_theme_etudiant` VALUES (23,19,1,NULL,NULL),(24,19,3,NULL,NULL);
/*!40000 ALTER TABLE `gestion_theme_etudiant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gestion_theme_professeur`
--

DROP TABLE IF EXISTS `gestion_theme_professeur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gestion_theme_professeur` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `GestionThemeID` bigint unsigned NOT NULL,
  `ProfesseurID` bigint unsigned NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'encadrant',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gestion_theme_professeur_gestionthemeid_foreign` (`GestionThemeID`),
  KEY `gestion_theme_professeur_professeurid_foreign` (`ProfesseurID`),
  CONSTRAINT `gestion_theme_professeur_gestionthemeid_foreign` FOREIGN KEY (`GestionThemeID`) REFERENCES `gestiondesthemes` (`GestionThemeID`) ON DELETE CASCADE,
  CONSTRAINT `gestion_theme_professeur_professeurid_foreign` FOREIGN KEY (`ProfesseurID`) REFERENCES `professeurs` (`ProfesseurID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gestion_theme_professeur`
--

LOCK TABLES `gestion_theme_professeur` WRITE;
/*!40000 ALTER TABLE `gestion_theme_professeur` DISABLE KEYS */;
INSERT INTO `gestion_theme_professeur` VALUES (25,19,6,'encadrant',NULL,NULL),(26,19,3,'sous_encadrant',NULL,NULL);
/*!40000 ALTER TABLE `gestion_theme_professeur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gestiondesthemes`
--

DROP TABLE IF EXISTS `gestiondesthemes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gestiondesthemes` (
  `GestionThemeID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `SpecialiteID` bigint unsigned NOT NULL,
  `GroupID` bigint unsigned NOT NULL,
  `ThemeID` bigint unsigned NOT NULL,
  `DepartementID` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`GestionThemeID`),
  KEY `gestiondesthemes_specialiteid_foreign` (`SpecialiteID`),
  KEY `gestiondesthemes_groupid_foreign` (`GroupID`),
  KEY `gestiondesthemes_themeid_foreign` (`ThemeID`) /*!80000 INVISIBLE */,
  KEY `gestiondesthemes_departmentid_foreign` (`DepartementID`),
  CONSTRAINT `gestiondesthemes_departmentid_foreign` FOREIGN KEY (`DepartementID`) REFERENCES `departement` (`DepartementID`) ON DELETE CASCADE,
  CONSTRAINT `gestiondesthemes_groupid_foreign` FOREIGN KEY (`GroupID`) REFERENCES `groups` (`GroupID`) ON DELETE CASCADE,
  CONSTRAINT `gestiondesthemes_specialiteid_foreign` FOREIGN KEY (`SpecialiteID`) REFERENCES `specialites` (`SpecialiteID`) ON DELETE CASCADE,
  CONSTRAINT `gestiondesthemes_themeid_foreign` FOREIGN KEY (`ThemeID`) REFERENCES `themes` (`ThemeID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gestiondesthemes`
--

LOCK TABLES `gestiondesthemes` WRITE;
/*!40000 ALTER TABLE `gestiondesthemes` DISABLE KEYS */;
INSERT INTO `gestiondesthemes` VALUES (19,1,1,5,1,'2025-04-15 07:48:15','2025-04-15 07:48:15');
/*!40000 ALTER TABLE `gestiondesthemes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `groups` (
  `GroupID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `SectionID` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`GroupID`),
  KEY `groups_sectionid_foreign` (`SectionID`),
  CONSTRAINT `groups_sectionid_foreign` FOREIGN KEY (`SectionID`) REFERENCES `sections` (`SectionID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'G1','2025-03-17 11:00:10',NULL,1),(2,'G2','2025-04-07 20:47:00',NULL,1),(3,'G3','2025-04-09 11:37:39',NULL,1),(4,'G1','2025-04-09 11:37:50',NULL,2),(5,'G2','2025-04-09 11:40:00',NULL,2),(6,'G3','2025-04-09 11:40:30',NULL,2);
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locals`
--

DROP TABLE IF EXISTS `locals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `locals` (
  `LocalID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Capacite` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`LocalID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locals`
--

LOCK TABLES `locals` WRITE;
/*!40000 ALTER TABLE `locals` DISABLE KEYS */;
INSERT INTO `locals` VALUES (1,'labou 05',NULL,'2025-03-17 11:04:20',NULL),(2,'salle1',35,'2025-04-03 10:15:54','2025-04-03 10:15:54'),(3,'labou13',25,'2025-04-07 07:07:20','2025-04-07 07:07:20'),(4,'salle2',35,'2025-04-07 15:57:43','2025-04-07 15:57:43');
/*!40000 ALTER TABLE `locals` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_03_13_090730_create_professeur_table',1),(5,'2025_03_13_090744_create_departement_table',1),(6,'2025_03_13_090745_create_section_table',1),(7,'2025_03_13_090750_create_parcours_table',1),(8,'2025_03_13_090751_create_niveau_table',1),(9,'2025_03_13_090752_create_specialite_table',1),(10,'2025_03_13_090753_create_group_table',1),(11,'2025_03_13_090754_create_etudiant_table',1),(12,'2025_03_13_090756_create_local_table',1),(13,'2025_03_13_090758_create_module_table',1),(14,'2025_03_13_090800_create_activite_table',1),(16,'2025_03_13_090803_create_professeur_module_table',1),(17,'2025_03_13_090804_create_professeur_specialite_table',1),(18,'2025_03_13_090805_create_professeur_parcours_table',1),(19,'2025_03_13_090821_create_professeur_niveau_table',1),(20,'2025_03_13_124755_add_foreign_keys_to_departement_and_professeur_tables',2),(21,'2025_03_17_093155_add_departement_id_to_users_table',3),(22,'2025_03_17_103456_add_chefpedagogiqueid_foreign_to_departement_table',4),(26,'2025_03_24_122241_create_themes_table',6),(32,'2025_03_26_121408_create_emploisoutenance_table',10),(33,'2025_04_03_115226_add_capacite_to_locals_table',11),(34,'2025_04_05_105245_add_jour_to_emploisoutenance_table',12),(35,'2025_04_07_211416_add_department_id_to_gestiondesthemes_table',13),(36,'2025_04_09_085038_update_parcours_table',14),(37,'2025_04_09_085604_update_niveaux_table',15),(38,'2025_04_09_093318_create_semesters_table',16),(39,'2025_04_09_093758_create_niveau_semester_table',17),(40,'2025_04_09_095219_update_specialites_table',18),(41,'2025_04_09_101951_update_sections_table',19),(42,'2025_04_09_103119_update_groups_table',20),(43,'2025_04_09_104101_update_module_table_add_sectionid',21),(44,'2025_04_09_110930_update_semesters_table_add_niveauid',22),(45,'2025_04_09_112113_remove_niveauid_from_semesters_table',23),(46,'2025_04_09_120529_create_semester_module_table',24),(47,'2025_04_10_084347_add_semestre_id_to_emploi_du_temps_table',25),(48,'2025_04_11_071554_add_section_to_gestiondesthemes_table',26),(49,'2025_04_11_080949_add_role_to_gestion_theme_professeur_table',27),(50,'2025_04_14_092727_add_departement_id_to_themes_table',28),(51,'2025_04_14_104601_drop_sectionid_and_foreign_key_from_gestiondesthemes_table',29),(52,'2025_04_15_102826_add_sous_encadrant_id_to_emploisoutenance_table',30),(53,'2025_04_15_163322_add_departmentid_to_emploi_du_temps_table',31);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modules` (
  `ModuleID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `SectionID` bigint unsigned NOT NULL,
  PRIMARY KEY (`ModuleID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules`
--

LOCK TABLES `modules` WRITE;
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
INSERT INTO `modules` VALUES (1,'SR','2025-03-17 11:01:10',NULL,1),(2,'ASR','2025-04-09 11:37:30',NULL,1);
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `niveau_semester`
--

DROP TABLE IF EXISTS `niveau_semester`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `niveau_semester` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `NiveauID` bigint unsigned NOT NULL,
  `SemestreID` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `niveau_semester_niveauid_semestreid_unique` (`NiveauID`,`SemestreID`),
  KEY `niveau_semester_semestreid_foreign` (`SemestreID`),
  CONSTRAINT `niveau_semester_niveauid_foreign` FOREIGN KEY (`NiveauID`) REFERENCES `niveaux` (`NiveauID`) ON DELETE CASCADE,
  CONSTRAINT `niveau_semester_semestreid_foreign` FOREIGN KEY (`SemestreID`) REFERENCES `semesters` (`SemestreID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `niveau_semester`
--

LOCK TABLES `niveau_semester` WRITE;
/*!40000 ALTER TABLE `niveau_semester` DISABLE KEYS */;
INSERT INTO `niveau_semester` VALUES (1,1,1,'2025-04-09 11:25:20','2025-04-09 11:25:20'),(2,1,2,'2025-04-09 11:25:25','2025-04-09 11:25:25'),(3,2,3,'2025-04-09 11:26:25','2025-04-09 11:26:25'),(4,2,4,'2025-04-09 11:26:50','2025-04-09 11:26:50'),(5,3,1,'2025-04-09 11:26:55','2025-04-09 11:26:55'),(6,3,2,'2025-04-09 11:27:00','2025-04-09 11:27:00'),(7,4,3,'2025-04-09 11:27:10','2025-04-09 11:27:10'),(8,4,4,'2025-04-09 11:28:10','2025-04-09 11:28:10');
/*!40000 ALTER TABLE `niveau_semester` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `niveaux`
--

DROP TABLE IF EXISTS `niveaux`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `niveaux` (
  `NiveauID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ParcoursID` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`NiveauID`),
  KEY `niveau_parcoursid_foreign` (`ParcoursID`),
  CONSTRAINT `niveau_parcoursid_foreign` FOREIGN KEY (`ParcoursID`) REFERENCES `parcours` (`ParcoursID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `niveaux`
--

LOCK TABLES `niveaux` WRITE;
/*!40000 ALTER TABLE `niveaux` DISABLE KEYS */;
INSERT INTO `niveaux` VALUES (1,'M1',1,'2025-03-17 10:58:10',NULL),(2,'M2',1,'2025-04-09 10:55:10',NULL),(3,'L1',2,'2025-04-09 10:55:40',NULL),(4,'L2',2,'2025-04-09 10:56:10',NULL),(5,'L3',2,'2025-04-09 10:56:50',NULL),(6,'ING1',3,'2025-04-09 10:58:10',NULL),(7,'ING2',3,'2025-04-09 10:58:40',NULL),(8,'ING3',3,'2025-04-09 10:58:50',NULL),(9,'ING4',3,'2025-04-09 10:59:10',NULL),(10,'ING4',3,'2025-04-09 10:59:50',NULL);
/*!40000 ALTER TABLE `niveaux` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parcours`
--

DROP TABLE IF EXISTS `parcours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `parcours` (
  `ParcoursID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ParcoursID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parcours`
--

LOCK TABLES `parcours` WRITE;
/*!40000 ALTER TABLE `parcours` DISABLE KEYS */;
INSERT INTO `parcours` VALUES (1,'master','2025-03-17 10:57:30',NULL),(2,'licence','2025-04-09 10:54:40',NULL),(3,'Ingenieur','2025-04-09 10:57:10',NULL);
/*!40000 ALTER TABLE `parcours` ENABLE KEYS */;
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
-- Table structure for table `professeur_module`
--

DROP TABLE IF EXISTS `professeur_module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `professeur_module` (
  `ProfesseurID` bigint unsigned NOT NULL,
  `ModuleID` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ProfesseurID`,`ModuleID`),
  KEY `professeur_module_moduleid_foreign` (`ModuleID`),
  CONSTRAINT `professeur_module_moduleid_foreign` FOREIGN KEY (`ModuleID`) REFERENCES `modules` (`ModuleID`),
  CONSTRAINT `professeur_module_professeurid_foreign` FOREIGN KEY (`ProfesseurID`) REFERENCES `professeurs` (`ProfesseurID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `professeur_module`
--

LOCK TABLES `professeur_module` WRITE;
/*!40000 ALTER TABLE `professeur_module` DISABLE KEYS */;
/*!40000 ALTER TABLE `professeur_module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `professeur_niveau`
--

DROP TABLE IF EXISTS `professeur_niveau`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `professeur_niveau` (
  `ProfesseurID` bigint unsigned NOT NULL,
  `NiveauID` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ProfesseurID`,`NiveauID`),
  KEY `professeur_niveau_niveauid_foreign` (`NiveauID`),
  CONSTRAINT `professeur_niveau_niveauid_foreign` FOREIGN KEY (`NiveauID`) REFERENCES `niveaux` (`NiveauID`),
  CONSTRAINT `professeur_niveau_professeurid_foreign` FOREIGN KEY (`ProfesseurID`) REFERENCES `professeurs` (`ProfesseurID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `professeur_niveau`
--

LOCK TABLES `professeur_niveau` WRITE;
/*!40000 ALTER TABLE `professeur_niveau` DISABLE KEYS */;
/*!40000 ALTER TABLE `professeur_niveau` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `professeur_parcours`
--

DROP TABLE IF EXISTS `professeur_parcours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `professeur_parcours` (
  `ProfesseurID` bigint unsigned NOT NULL,
  `ParcoursID` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ProfesseurID`,`ParcoursID`),
  KEY `professeur_parcours_parcoursid_foreign` (`ParcoursID`),
  CONSTRAINT `professeur_parcours_parcoursid_foreign` FOREIGN KEY (`ParcoursID`) REFERENCES `parcours` (`ParcoursID`),
  CONSTRAINT `professeur_parcours_professeurid_foreign` FOREIGN KEY (`ProfesseurID`) REFERENCES `professeurs` (`ProfesseurID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `professeur_parcours`
--

LOCK TABLES `professeur_parcours` WRITE;
/*!40000 ALTER TABLE `professeur_parcours` DISABLE KEYS */;
/*!40000 ALTER TABLE `professeur_parcours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `professeur_specialite`
--

DROP TABLE IF EXISTS `professeur_specialite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `professeur_specialite` (
  `ProfesseurID` bigint unsigned NOT NULL,
  `SpecialiteID` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ProfesseurID`,`SpecialiteID`),
  KEY `professeur_specialite_specialiteid_foreign` (`SpecialiteID`),
  CONSTRAINT `professeur_specialite_professeurid_foreign` FOREIGN KEY (`ProfesseurID`) REFERENCES `professeurs` (`ProfesseurID`),
  CONSTRAINT `professeur_specialite_specialiteid_foreign` FOREIGN KEY (`SpecialiteID`) REFERENCES `specialites` (`SpecialiteID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `professeur_specialite`
--

LOCK TABLES `professeur_specialite` WRITE;
/*!40000 ALTER TABLE `professeur_specialite` DISABLE KEYS */;
/*!40000 ALTER TABLE `professeur_specialite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `professeurs`
--

DROP TABLE IF EXISTS `professeurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `professeurs` (
  `ProfesseurID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DepartementID` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `grade` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bureau` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ProfesseurID`),
  KEY `professeur_departementid_foreign` (`DepartementID`),
  CONSTRAINT `professeur_departementid_foreign` FOREIGN KEY (`DepartementID`) REFERENCES `departement` (`DepartementID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `professeurs`
--

LOCK TABLES `professeurs` WRITE;
/*!40000 ALTER TABLE `professeurs` DISABLE KEYS */;
INSERT INTO `professeurs` VALUES (1,'laouadi',1,'2025-03-17 08:57:12',NULL,'Maitre de conferences classe B','mohamed.laouadi@univ-setif.dz','19'),(2,'mansouri',1,'2025-03-17 08:14:35','2025-03-17 08:14:35','Maitre de conferences classe A','mansouri_houssem@univ-setif.dz','1'),(3,'aissaoua',1,'2025-03-17 08:58:58','2025-03-17 08:58:58','Maitre de conferences classe B','habib.aissaoua@univ-setif.dz','10'),(4,'haroun',4,'2025-03-22 12:09:50',NULL,'Maitre de conferences classe A','mohamed.haroun@univ-setif.dz','5'),(6,'KAMEL Nadjet',1,'2025-04-07 07:02:21','2025-04-07 07:02:21','Professeur','nkamel@univ-setif.dz','2'),(7,'ZOUAOUI Zibouda',1,'2025-04-07 07:04:49','2025-04-07 07:04:49','Professeur','zaliouat@univ-setif.dz','20'),(8,'BERRIMI Fella',1,'2025-04-07 16:07:16','2025-04-07 16:07:16','Maitre de conferences classe B','fella.berimi@univ-setif.dz','08');
/*!40000 ALTER TABLE `professeurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sections`
--

DROP TABLE IF EXISTS `sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sections` (
  `SectionID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SpecialiteID` bigint unsigned DEFAULT NULL,
  `NiveauID` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`SectionID`),
  KEY `sections_specialiteid_foreign` (`SpecialiteID`),
  KEY `sections_niveauid_foreign` (`NiveauID`),
  CONSTRAINT `sections_niveauid_foreign` FOREIGN KEY (`NiveauID`) REFERENCES `niveaux` (`NiveauID`) ON DELETE CASCADE,
  CONSTRAINT `sections_specialiteid_foreign` FOREIGN KEY (`SpecialiteID`) REFERENCES `specialites` (`SpecialiteID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sections`
--

LOCK TABLES `sections` WRITE;
/*!40000 ALTER TABLE `sections` DISABLE KEYS */;
INSERT INTO `sections` VALUES (1,'A',1,1,'2025-04-09 11:29:15','2025-04-09 11:29:15'),(2,'A',2,2,'2025-04-09 11:36:15','2025-04-09 11:36:15'),(3,'A',3,1,'2025-04-09 11:37:15','2025-04-09 11:37:15'),(4,'A',4,1,'2025-04-09 11:37:30','2025-04-09 11:37:30');
/*!40000 ALTER TABLE `sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `semester_module`
--

DROP TABLE IF EXISTS `semester_module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `semester_module` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `SemestreID` bigint unsigned NOT NULL,
  `ModuleID` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `semester_module_semestreid_foreign` (`SemestreID`),
  KEY `semester_module_moduleid_foreign` (`ModuleID`),
  CONSTRAINT `semester_module_moduleid_foreign` FOREIGN KEY (`ModuleID`) REFERENCES `modules` (`ModuleID`) ON DELETE CASCADE,
  CONSTRAINT `semester_module_semestreid_foreign` FOREIGN KEY (`SemestreID`) REFERENCES `semesters` (`SemestreID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `semester_module`
--

LOCK TABLES `semester_module` WRITE;
/*!40000 ALTER TABLE `semester_module` DISABLE KEYS */;
INSERT INTO `semester_module` VALUES (1,1,1,'2025-04-09 12:11:10','2025-04-09 12:11:10'),(2,1,2,'2025-04-09 12:12:10','2025-04-09 12:12:10');
/*!40000 ALTER TABLE `semester_module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `semesters`
--

DROP TABLE IF EXISTS `semesters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `semesters` (
  `SemestreID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`SemestreID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `semesters`
--

LOCK TABLES `semesters` WRITE;
/*!40000 ALTER TABLE `semesters` DISABLE KEYS */;
INSERT INTO `semesters` VALUES (1,'S1','2025-04-09 11:11:10','2025-04-09 11:11:20'),(2,'S2','2025-04-09 11:12:12','2025-04-09 11:12:14'),(3,'S3','2025-04-09 11:12:50','2025-04-09 11:12:50'),(4,'S4','2025-04-09 11:13:10','2025-04-09 11:13:10'),(5,'S5','2025-04-09 11:13:10','2025-04-09 11:13:10'),(6,'S6','2025-04-09 11:14:20','2025-04-09 11:14:20'),(7,'S7','2025-04-09 11:23:20','2025-04-09 11:23:20'),(8,'S8','2025-04-09 11:23:40','2025-04-09 11:23:40'),(9,'S9','2025-04-09 11:23:50','2025-04-09 11:23:50'),(10,'S10','2025-04-09 11:23:55','2025-04-09 11:23:55');
/*!40000 ALTER TABLE `semesters` ENABLE KEYS */;
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
INSERT INTO `sessions` VALUES ('0pPoJSn15yoC9v5HBV8MOJj67ArOAmHSvO1S2YYf',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYmpHNGJQaUYwaHF4anc1aUp6Y095RURyd1pIMXBqcWphemRzWkRTdSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9lbXBsb2lfZHVfdGVtcHMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=',1744742860);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specialites`
--

DROP TABLE IF EXISTS `specialites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `specialites` (
  `SpecialiteID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `NiveauID` bigint unsigned DEFAULT NULL,
  `DepartmentID` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`SpecialiteID`),
  KEY `specialites_niveauid_foreign` (`NiveauID`),
  CONSTRAINT `specialites_niveauid_foreign` FOREIGN KEY (`NiveauID`) REFERENCES `niveaux` (`NiveauID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specialites`
--

LOCK TABLES `specialites` WRITE;
/*!40000 ALTER TABLE `specialites` DISABLE KEYS */;
INSERT INTO `specialites` VALUES (1,'RSD','2025-03-17 10:59:20',NULL,1,1),(2,'RSD','2025-04-09 11:29:15',NULL,2,1),(3,'WEB','2025-04-09 11:32:15',NULL,1,1),(4,'WEB','2025-04-09 11:32:16',NULL,2,1),(5,'licence academique','2025-04-09 11:32:20',NULL,3,1);
/*!40000 ALTER TABLE `specialites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `themes`
--

DROP TABLE IF EXISTS `themes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `themes` (
  `ThemeID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ProfesseurID` bigint unsigned NOT NULL,
  `DepartementID` bigint unsigned NOT NULL,
  PRIMARY KEY (`ThemeID`),
  KEY `themes_professeurid_foreign` (`ProfesseurID`),
  CONSTRAINT `themes_professeurid_foreign` FOREIGN KEY (`ProfesseurID`) REFERENCES `professeurs` (`ProfesseurID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `themes`
--

LOCK TABLES `themes` WRITE;
/*!40000 ALTER TABLE `themes` DISABLE KEYS */;
INSERT INTO `themes` VALUES (5,'AI-Driven Fake News Detection: Applying Transformers /Large Language Models to Social Media',6,1),(6,'ia pour chimie',4,4);
/*!40000 ALTER TABLE `themes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usertype` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departement_id` bigint unsigned DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_departement_id_foreign` (`departement_id`),
  CONSTRAINT `users_departement_id_foreign` FOREIGN KEY (`departement_id`) REFERENCES `departement` (`DepartementID`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'laouadi','admin','mohamed.laouadi@univ-setif.dz',1,NULL,'$2y$12$NEiF0rlj0mLpGPmDE5pe2eTHdIWStx9m5oQTC3j/12fV7mj4wmmA2','WA1LnNAlgi0NFuOmpLWiUyb8MjFgPp3FxqGurdl8XOSpWjLyxO9MfX8uDUfL','2025-03-13 11:54:49','2025-03-13 11:54:49'),(2,'haroun','admin','mohamed.haroun@univ-setif.dz',4,NULL,'$2y$12$uT/6AawLxmlQZtwcELDHKu.fXcADekwREGcuDGSebmrs8CZBAl6yS',NULL,'2025-04-15 14:02:18','2025-04-15 14:02:18');
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

-- Dump completed on 2025-04-15 21:34:50
