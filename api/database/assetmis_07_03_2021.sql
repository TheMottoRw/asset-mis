-- MySQL dump 10.13  Distrib 5.7.32, for Linux (x86_64)
--
-- Host: localhost    Database: assetmis
-- ------------------------------------------------------
-- Server version	5.7.32

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
-- Table structure for table `asset_movement`
--

DROP TABLE IF EXISTS `asset_movement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_movement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `asset_id` int(11) DEFAULT NULL,
  `booked_on` datetime DEFAULT NULL,
  `given_on` datetime DEFAULT NULL,
  `submitted_on` datetime DEFAULT NULL,
  `location` varchar(40) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `quantity` datetime DEFAULT NULL,
  `registered_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `std_fk` (`student_id`),
  KEY `asset_fk` (`asset_id`),
  CONSTRAINT `asset_fk` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `std_fk` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset_movement`
--

LOCK TABLES `asset_movement` WRITE;
/*!40000 ALTER TABLE `asset_movement` DISABLE KEYS */;
/*!40000 ALTER TABLE `asset_movement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assets`
--

DROP TABLE IF EXISTS `assets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `names` varchar(140) NOT NULL,
  `state` varchar(140) NOT NULL,
  `description` varchar(255) NOT NULL,
  `code` varchar(70) NOT NULL,
  `serial_number` varchar(70) NOT NULL,
  `type` varchar(70) NOT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `registered_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `dpt_fk` (`dept_id`),
  CONSTRAINT `dpt_fk` FOREIGN KEY (`dept_id`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assets`
--

LOCK TABLES `assets` WRITE;
/*!40000 ALTER TABLE `assets` DISABLE KEYS */;
INSERT INTO `assets` VALUES (1,' VGA',' ssd',' double VGA used tosddsfsfs','5YIT-2000',' 2YMATE',' COMPUTER ACCESSORY',1,'2021-01-29 19:29:57'),(5,'Power cable','In use','For Desktop','TCT-PWC-012','PWC-0121','Cable',1,'2021-03-07 11:36:25'),(6,'printer','In use','for printing','p24535673','pr66547','printer',1,'2021-03-07 11:38:07');
/*!40000 ALTER TABLE `assets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `academic_year` varchar(20) DEFAULT NULL,
  `registered_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `classdepartment` (`department`),
  CONSTRAINT `classdepartment` FOREIGN KEY (`department`) REFERENCES `department` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classes`
--

LOCK TABLES `classes` WRITE;
/*!40000 ALTER TABLE `classes` DISABLE KEYS */;
INSERT INTO `classes` VALUES (1,1,'Year II IS','2019-2020','2021-01-29 18:24:38'),(7,1,'3 ITB','2019-2020','2021-02-04 22:56:56'),(18,15,'3 A','2020-2021','2021-03-07 10:18:05'),(19,16,'1','2018-2019','2021-03-07 10:19:13'),(20,15,'2 D','2019-2020','2021-03-07 10:20:19'),(21,1,'3 x','2020-2021','2021-03-07 10:20:49');
/*!40000 ALTER TABLE `classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acronym` varchar(100) DEFAULT NULL,
  `names` varchar(255) DEFAULT NULL,
  `registered_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (1,'IT','Information Technology','2021-01-29 18:44:52'),(15,'RE','Renewable Energy','2021-02-05 00:39:30'),(16,'ETT','Electronic Telecommunication','2021-02-05 00:40:14');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(200) DEFAULT NULL,
  `lastname` varchar(200) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `role` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `registered_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `dept_fk` (`dept_id`),
  CONSTRAINT `dept_fk` FOREIGN KEY (`dept_id`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` VALUES (9,'Gad','Ishimwe','gad@gmail.com','0726183050','Admin','MTIzNDU=',1,'2021-02-04 22:01:02'),(10,'Kabatesi','Benitha','kba@gmail.com','0783555555','Admin','MTIz',16,'2021-03-07 10:39:30'),(11,'M','Olivier','mol@gmail.com','0782951455','Admin','MTIz',1,'2021-03-07 10:40:56'),(15,'Jacques','Nsulo','nsulo@jacque.rw','0789123456','Standard','MTIzNDU=',16,'2021-03-07 10:55:07');
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(250) DEFAULT NULL,
  `lastname` varchar(250) DEFAULT NULL,
  `reg_number` varchar(150) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT '',
  `password` varchar(150) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `registered_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk2` (`dept_id`),
  KEY `class_dk` (`class_id`),
  CONSTRAINT `class_dk` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk2` FOREIGN KEY (`dept_id`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES (7,'Murangirwa ','Baptiste','17RP01012','bapt@gmail.com','','MTIzNDU=',1,7,'2021-02-04 23:24:14'),(8,'Ishimwe','Gad','17RP09120','ishimwe@gmail.com','0789456123','MTIzNDU=',15,7,'2021-03-07 10:22:35'),(9,'Maniragena','Olivier','17RP010121','olly@gmail.com','0789456123','MTIzNDU=',15,20,'2021-03-07 10:35:18');
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-03-07 12:07:23