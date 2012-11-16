-- MySQL dump 10.13  Distrib 5.1.61, for unknown-linux-gnu (x86_64)
--
-- Host: localhost    Database: tltsecure
-- ------------------------------------------------------
-- Server version	5.1.61-log

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
-- Table structure for table `stock_historical_change`
--

DROP TABLE IF EXISTS `stock_historical_change`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock_historical_change` (
  `stockId` int(11) DEFAULT NULL,
  `percentageChange` float(5,2) DEFAULT NULL,
  `yearId` int(11) DEFAULT NULL,
  KEY `stockId` (`stockId`),
  KEY `yearId` (`yearId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_historical_change`
--

LOCK TABLES `stock_historical_change` WRITE;
/*!40000 ALTER TABLE `stock_historical_change` DISABLE KEYS */;
INSERT INTO `stock_historical_change` VALUES (11,50.00,2),(12,7.13,2),(1,25.46,2),(2,17.90,2),(3,-77.05,2),(1,59.38,4),(12,71.04,4),(11,23.95,4),(4,35.28,2),(5,1.88,2),(6,79.19,2),(8,23.48,2),(9,115.68,2),(10,58.80,2),(7,-37.21,2),(11,9.58,3),(12,-57.24,3),(1,12.94,3),(2,-3.89,3),(3,-3.28,3),(4,83.00,3),(5,16.05,3),(6,3.23,3),(7,-27.78,3),(8,17.96,3),(9,77.30,3),(10,23.62,3),(2,57.96,4),(3,35.80,4),(4,13.23,4),(5,46.52,4),(6,114.38,4),(7,-15.38,4),(8,198.51,4),(9,72.00,4),(10,76.89,4),(1,-26.47,5),(1,-56.67,6),(2,-7.93,5),(2,-71.99,6),(3,-14.32,5),(3,-8.22,6),(4,-74.90,5),(4,-12.19,6),(5,-17.62,5),(5,-40.07,6),(6,-70.63,5),(6,217.87,6),(7,-9.09,5),(7,-86.67,6),(8,-29.90,5),(8,-21.75,6),(9,-35.47,5),(9,-2.70,6),(10,-45.87,5),(10,-42.86,6),(11,-56.53,5),(11,-3.67,6),(12,-45.05,5),(12,-95.06,6),(13,62.85,3),(13,-30.78,4),(13,-21.22,5),(13,-49.00,6),(14,3.63,3),(14,83.49,4),(14,-65.30,5),(14,10.23,6),(15,478.37,4),(15,-83.98,5),(15,-54.17,6),(16,122.32,4),(16,-74.85,5),(16,-29.94,6),(17,15.13,4),(17,10.29,5),(17,1.67,6);
/*!40000 ALTER TABLE `stock_historical_change` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-11-16 15:01:54
