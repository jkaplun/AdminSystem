-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: adminsystem
-- ------------------------------------------------------
-- Server version	5.7.10-log

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
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `clave` char(10) NOT NULL,
  `nombre_prod` varchar(50) NOT NULL,
  `version_prod` char(10) NOT NULL,
  `ruta_prod` varchar(50) DEFAULT NULL,
  `vigente_prod` char(1) DEFAULT NULL,
  `cargo_prod` char(1) DEFAULT NULL,
  `compila_prod` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (1,'database','Base de Datos','1.0','C:\\ICAAVWin\\Database','N','S','N'),(2,'icaavpro','ICAAV Pro','6.0','C:\\ICAAV6','N','S','N'),(3,'icaavwin','ICAAVWIN','1.0','C:\\ICAAVWin','S','S','S'),(7,'interwin','Interfase ICAAVWin','1.0','C:\\ICAAVWin\\Interfase','S','S','S'),(9,'iris','Iris Pro','4.0','C:\\ICAAV6','N','S','N'),(10,'layout','Layout','1.0','C:\\ICAAVWin\\Layout','S','S','N'),(11,'sopormig','Soporte Remoto','1.0','C:\\ICAAVWin\\Sopormig','N','S','N'),(12,'convenios','Convenios L.A.','1.0','C:\\ICAAVWin\\MiddleOffice','S','S','S'),(13,'bspprolan','BSP ICAAVPro',' 1.0','C:\\ICAAV6','N','S','N'),(14,'bsplink','BSP Link ICAAVWin','1.0','C:\\ICAAVWin','N','S','S'),(16,'corporativ','GVC','1.0','C:\\ICAAVWin\\GVC','S','S','S'),(17,'light','ICAAVWin Light-ASA','1.0','C:\\ICAAVWin','N','S','S'),(18,'TNW','Travel Net','1.0','','S','N','N'),(21,'interlight','Interfase Light','1.0','C:\\ICAAVWin\\Interfase','N','S','S'),(22,'iriswin','Iris Win','1.0','C:\\Iriswin','S','S','S'),(24,'directivos','Directivos','1.0','C:\\ICAAVWin\\Directivo','S','S','S'),(25,'Imple','Implementacion',' 1.0','','N','S','N'),(27,'icaavsql','ICAAVWIN-SQL','1.0','C:\\ICAAVWin','N','S','S'),(28,'lightsql','ICAAVWin Light-SQL','1.0','C:\\ICAAVWin','N','S','S'),(29,'epromo','E-Promo','1.0','','N','N','N'),(30,'email','E-mail','1.0','','N','N','N'),(31,'fe','Factura Electrónica','1.0','C:\\ICAAVWin','S','N','S'),(32,'pagina','Pagina Web','1.0','','S','N','N'),(33,'diseñomig','Diseño MIG','1.0','','N','N','N'),(34,'prometeo','Prometeo','1.0','','S','S','S'),(35,'hosting','Hosting','1.0','','S','N','N'),(36,'antivirus','Antivirus','1.0','','S','N','N'),(37,'ebackup','Ebackup','1.0','','S','S','N'),(38,'tecnico','Soporte Técnico','1.0','','S','N','N'),(39,'asadrivers','ASE Drivers','1.0','','N','N','N'),(60,'actualiza','Actualizacion','1.0','','N','S','N'),(61,'correo','Correo Electrónico','1.0','','S','N','N'),(62,'formato','Formatos','1.0','','S','S','N'),(63,'reportes','Reportes','1.0','','N','S','N'),(64,'SIFAC','SIFAC','1.0','','N','S','S'),(65,'diot','Diot','1.0','','N','S','S'),(66,'centauro','Centauro','1.0','','S','S','S'),(67,'WF','WF','1.0','','N','N','N'),(68,'Zeus','Zeus','1.0','','N','S','S'),(69,'BE','Boleto Electrónico','1.0','','N','S','S'),(70,'recnomina','Recibos de Nomina','1.0','','S','S','S'),(71,'facturala','Facturación L.A.','1.0','','S','S','N'),(74,'contaelec','Contabilidad Electrónica','1.0','','S','S','S'),(75,'V+S','Viaja + Seguro','1.0','','S','N','N');
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_poliza`
--

DROP TABLE IF EXISTS `tipo_poliza`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_poliza` (
  `tipo` char(1) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_poliza`
--

LOCK TABLES `tipo_poliza` WRITE;
/*!40000 ALTER TABLE `tipo_poliza` DISABLE KEYS */;
INSERT INTO `tipo_poliza` VALUES ('A','Actualización'),('B','Básico'),('E','Estandar'),('G','Garantia'),('I','ICAAVPro'),('M','Premium'),('P','Personalizado'),('T','Travelnet'),('V','Pago x Evento (15min x Serv)'),('X','Extensión de Garantia');
/*!40000 ALTER TABLE `tipo_poliza` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'adminsystem'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-10-09 15:05:02
