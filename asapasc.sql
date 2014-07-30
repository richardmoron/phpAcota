# Host: localhost  (Version: 5.5.25)
# Date: 2013-06-28 23:18:46
# Generator: MySQL-Front 5.3  (Build 1.27)

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

DROP DATABASE IF EXISTS `asapasc`;
CREATE DATABASE `asapasc` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci */;
USE `asapasc`;

#
# Source for table "ac_consumos"
#

DROP TABLE IF EXISTS `ac_consumos`;
CREATE TABLE `ac_consumos` (
  `consumo_id` int(11) NOT NULL AUTO_INCREMENT,
  `socio_id` int(11) DEFAULT NULL,
  `nro_medidor` int(11) DEFAULT NULL,
  `fecha_lectura` timestamp NULL DEFAULT NULL,
  `fecha_emision` timestamp NULL DEFAULT NULL,
  `periodo_mes` int(11) DEFAULT NULL,
  `periodo_anio` int(11) DEFAULT NULL,
  `consumo_total_lectura` decimal(20,0) DEFAULT NULL,
  `consumo_por_pagar` decimal(20,0) DEFAULT NULL,
  `costo_consumo_por_pagar` decimal(10,2) DEFAULT NULL,
  `estado` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_hora_pago` timestamp NULL DEFAULT NULL,
  `usuario_pago` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `monto_pagado` double(5,2) DEFAULT NULL,
  `pagado_por` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ci_pagado_por` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`consumo_id`),
  KEY `consumo_socio_index` (`socio_id`),
  KEY `consumo_medidor_index` (`nro_medidor`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

#
# Data for table "ac_consumos"
#

/*!40000 ALTER TABLE `ac_consumos` DISABLE KEYS */;
INSERT INTO `ac_consumos` VALUES (1,1,123,'2013-01-28 00:00:00','2013-06-28 00:00:00',1,2013,1000,950,1950.00,'E',NULL,NULL,NULL,NULL,NULL),(3,1,123,'2013-02-28 00:00:00','2013-06-28 00:00:00',2,2013,1100,50,150.00,'E',NULL,NULL,NULL,NULL,NULL),(4,1,123,'2013-03-28 00:00:00','2013-06-28 00:00:00',3,2013,1200,50,150.00,'E',NULL,NULL,NULL,NULL,NULL),(5,1,123,'2013-04-28 00:00:00','2013-06-28 00:00:00',4,2013,1400,150,350.00,'E',NULL,NULL,NULL,NULL,NULL),(6,1,123,'2013-05-28 00:00:00','2013-06-28 00:00:00',5,2013,1500,50,150.00,'E',NULL,NULL,NULL,NULL,NULL),(7,1,123,'2013-06-28 00:00:00','2013-06-28 00:00:00',6,2013,1500,50,50.00,'E',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `ac_consumos` ENABLE KEYS */;

#
# Source for table "ac_grupos_socios"
#

DROP TABLE IF EXISTS `ac_grupos_socios`;
CREATE TABLE `ac_grupos_socios` (
  `grupo_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_grupo` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `consumo_minimo_permitido` int(11) DEFAULT NULL COMMENT 'en metros cubicos',
  `costo_consumo_minimo` double(5,2) DEFAULT NULL COMMENT 'metro cubico',
  `costo_consumo_excedido` double(5,2) DEFAULT NULL COMMENT 'metro cubico',
  PRIMARY KEY (`grupo_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

#
# Data for table "ac_grupos_socios"
#

/*!40000 ALTER TABLE `ac_grupos_socios` DISABLE KEYS */;
INSERT INTO `ac_grupos_socios` VALUES (1,'COMUN',300,30.00,1.00),(2,'COMERCIO',50,50.00,2.00),(3,'3ERA EDAD',50,30.00,0.50);
/*!40000 ALTER TABLE `ac_grupos_socios` ENABLE KEYS */;

#
# Source for table "ac_socios"
#

DROP TABLE IF EXISTS `ac_socios`;
CREATE TABLE `ac_socios` (
  `socio_id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo_id` int(11) DEFAULT NULL,
  `nro_medidor` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `marca_medidor` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombres` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `apellidos` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ci` int(11) DEFAULT NULL,
  `ci_expedido_en` char(2) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(500) COLLATE utf8_spanish_ci DEFAULT NULL,
  `comunidad_id` int(11) DEFAULT NULL,
  `zona` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `registrado_por` varchar(14) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`socio_id`),
  KEY `medidor_index` (`nro_medidor`),
  KEY `ci_index` (`ci`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

#
# Data for table "ac_socios"
#

/*!40000 ALTER TABLE `ac_socios` DISABLE KEYS */;
INSERT INTO `ac_socios` VALUES (1,2,'123','GOLD','RICHARD HENRY','MORON BORDA',5383184,'SC','B/CHACARILLA',39,'ESTE','RMORON','2013-06-28 11:25:20'),(2,1,'456','BLACK','EDWIN','SALAS',112352222,'LP','CORIPATA',38,'OESTE','RMORON','2013-06-28 19:56:20');
/*!40000 ALTER TABLE `ac_socios` ENABLE KEYS */;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
