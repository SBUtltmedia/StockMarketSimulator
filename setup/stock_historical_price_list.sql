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
-- Table structure for table `stock_historical_price_list`
--

DROP TABLE IF EXISTS `stock_historical_price_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock_historical_price_list` (
  `stockId` int(11) DEFAULT NULL,
  `price` float(10,2) DEFAULT NULL,
  `yearId` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_historical_price_list`
--

LOCK TABLES `stock_historical_price_list` WRITE;
/*!40000 ALTER TABLE `stock_historical_price_list` DISABLE KEYS */;
INSERT INTO `stock_historical_price_list` VALUES (1,33.88,1),(1,42.50,2),(1,48.00,3),(1,76.50,4),(1,56.25,5),(1,24.38,6),(2,84.50,1),(2,99.63,2),(2,95.75,3),(2,151.25,4),(2,139.25,5),(2,39.00,6),(3,182.50,1),(3,41.88,2),(3,40.50,3),(3,55.00,4),(3,47.13,5),(3,43.25,6),(4,64.13,1),(4,86.75,2),(4,158.75,3),(4,179.75,4),(4,45.13,5),(4,39.63,6),(5,126.13,1),(5,128.50,2),(5,149.13,3),(5,218.50,4),(5,180.00,5),(5,107.88,6),(6,43.25,1),(6,77.50,2),(6,80.00,3),(6,171.50,4),(6,50.38,5),(6,160.13,6),(7,86.00,1),(7,54.00,2),(7,39.00,3),(7,33.00,4),(7,30.00,5),(7,4.00,6),(8,57.50,1),(8,71.00,2),(8,83.75,3),(8,250.00,4),(8,175.25,5),(8,137.13,6),(9,32.69,1),(9,70.50,2),(9,125.00,3),(9,215.00,4),(9,138.75,5),(9,135.00,6),(10,27.00,1),(10,42.88,2),(10,53.00,3),(10,93.75,4),(10,50.75,5),(10,29.00,6),(11,100.00,1),(11,150.00,2),(11,164.38,3),(11,203.75,4),(11,88.56,5),(11,85.31,6),(12,99.88,1),(12,107.00,2),(12,45.75,3),(12,78.25,4),(12,43.00,5),(12,2.13,6),(13,196.50,2),(13,320.00,3),(13,221.50,4),(13,174.50,5),(13,89.00,6),(14,131.48,2),(14,136.25,3),(14,250.00,4),(14,86.75,5),(14,95.63,6),(15,64.75,3),(15,374.50,4),(15,60.00,5),(15,27.50,6),(16,112.00,3),(16,249.00,4),(16,62.63,5),(16,43.88,6),(17,118.13,3),(17,136.00,4),(17,150.00,5),(17,152.50,6);
/*!40000 ALTER TABLE `stock_historical_price_list` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-11-16 15:02:48
