-- MySQL dump 10.13  Distrib 5.7.11, for osx10.9 (x86_64)
--
-- Host: localhost    Database: bank_sampah
-- ------------------------------------------------------
-- Server version	5.7.11

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
-- Table structure for table `cabang`
--

DROP TABLE IF EXISTS `cabang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cabang` (
  `nomor_registrasi` varchar(5) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `kecamatan` varchar(25) NOT NULL,
  `kelurahan` varchar(25) NOT NULL,
  `rw` varchar(5) NOT NULL,
  `rt` varchar(5) NOT NULL,
  PRIMARY KEY (`nomor_registrasi`),
  KEY `id` (`nomor_registrasi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cabang`
--

LOCK TABLES `cabang` WRITE;
/*!40000 ALTER TABLE `cabang` DISABLE KEYS */;
INSERT INTO `cabang` VALUES ('BS001','Kasih Ibu','Coblong','Cisitu Baru','001','012'),('BS002','Teratai','Cibeunying Kidul','Sangkuriang','002','003'),('BS003','ASD','ASD','ASD','ASD','ASD');
/*!40000 ALTER TABLE `cabang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item` (
  `nama` varchar(25) NOT NULL,
  PRIMARY KEY (`nama`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` VALUES ('Emberan'),('Kaleng'),('Plastik');
/*!40000 ALTER TABLE `item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jual`
--

DROP TABLE IF EXISTS `jual`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jual` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cabang` varchar(5) NOT NULL,
  `pengepul` varchar(25) DEFAULT NULL,
  `nama_item` varchar(25) NOT NULL,
  `berat` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  PRIMARY KEY (`id`,`id_cabang`,`nama_item`),
  KEY `id_cabang` (`id_cabang`),
  KEY `nama_item` (`nama_item`),
  CONSTRAINT `jual_ibfk_1` FOREIGN KEY (`id_cabang`) REFERENCES `cabang` (`nomor_registrasi`),
  CONSTRAINT `jual_ibfk_2` FOREIGN KEY (`nama_item`) REFERENCES `item` (`nama`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jual`
--

LOCK TABLES `jual` WRITE;
/*!40000 ALTER TABLE `jual` DISABLE KEYS */;
INSERT INTO `jual` VALUES (1,'BS001','Seseorang','Emberan',10,5500,'0000-00-00'),(2,'BS001','','Emberan',0,0,'2016-04-15');
/*!40000 ALTER TABLE `jual` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nasabah`
--

DROP TABLE IF EXISTS `nasabah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nasabah` (
  `id_cabang` varchar(5) NOT NULL,
  `nama` varchar(25) NOT NULL,
  PRIMARY KEY (`id_cabang`,`nama`),
  CONSTRAINT `nasabah_ibfk_1` FOREIGN KEY (`id_cabang`) REFERENCES `cabang` (`nomor_registrasi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nasabah`
--

LOCK TABLES `nasabah` WRITE;
/*!40000 ALTER TABLE `nasabah` DISABLE KEYS */;
INSERT INTO `nasabah` VALUES ('BS001','Husna'),('BS002','Mahar');
/*!40000 ALTER TABLE `nasabah` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setor`
--

DROP TABLE IF EXISTS `setor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cabang` varchar(5) NOT NULL,
  `nama_nasabah` varchar(25) NOT NULL,
  `nama_item` varchar(25) NOT NULL,
  `berat` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  PRIMARY KEY (`id`,`id_cabang`,`nama_nasabah`,`nama_item`),
  KEY `nama_item` (`nama_item`),
  KEY `setor_ibfk_1` (`id_cabang`,`nama_nasabah`),
  CONSTRAINT `setor_ibfk_1` FOREIGN KEY (`id_cabang`, `nama_nasabah`) REFERENCES `nasabah` (`id_cabang`, `nama`),
  CONSTRAINT `setor_ibfk_2` FOREIGN KEY (`nama_item`) REFERENCES `item` (`nama`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setor`
--

LOCK TABLES `setor` WRITE;
/*!40000 ALTER TABLE `setor` DISABLE KEYS */;
INSERT INTO `setor` VALUES (1,'BS001','Husna','Emberan',10,5000,'0000-00-00');
/*!40000 ALTER TABLE `setor` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-10 15:03:57
