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
-- Table structure for table `stock_stocks`
--

DROP TABLE IF EXISTS `stock_stocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock_stocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `tickerSymbol` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_stocks`
--

LOCK TABLES `stock_stocks` WRITE;
/*!40000 ALTER TABLE `stock_stocks` DISABLE KEYS */;
INSERT INTO `stock_stocks` VALUES (1,'Pennsylvania RR',33.875,NULL),(2,'U.S. Steel',84.5,NULL),(3,'Standard Oil of NJ',182.5,NULL),(4,'Sears Roebuck',64.125,NULL),(5,'Union Pacific',126.125,NULL),(6,'Coca-cola',43.25,NULL),(7,'Virginia Iron Coke and Coal',86,NULL),(8,'Allied Chemical',57.5,NULL),(9,'Woolworth',32.6875,NULL),(10,'International Cement',27,NULL),(11,'General Motors',100,NULL),(12,'Studebaker Co.',99.875,NULL);
/*!40000 ALTER TABLE `stock_stocks` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-10-17 15:25:52
