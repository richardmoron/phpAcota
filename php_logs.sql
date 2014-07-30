# Host: localhost  (Version: 5.5.25)
# Date: 2013-01-09 16:00:55
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

DROP DATABASE IF EXISTS `php_logs`;
CREATE DATABASE `php_logs` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `php_logs`;

#
# Source for table "php_logs"
#

DROP TABLE IF EXISTS `php_logs`;
CREATE TABLE `php_logs` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_table` varchar(30) NOT NULL,
  `nom_usuario` varchar(20) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `accion` char(1) NOT NULL,
  `det_accion` text,
  `det_error` text,
  PRIMARY KEY (`log_id`),
  KEY `nom_table` (`nom_table`),
  KEY `nom_usuario` (`nom_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

#
# Data for table "php_logs"
#

/*!40000 ALTER TABLE `php_logs` DISABLE KEYS */;
INSERT INTO `php_logs` VALUES (1,'pa_areas','RMORON','2013-01-09 15:57:19','S','SELECT area_id, nombre_area  \n\t\t\t\t\t\t FROM pa_areas WHERE area_id = area_id  ORDER BY area_id LIMIT 0,20','SQL statement executed successfully \n'),(2,'pa_areas','RMORON','2013-01-09 15:57:19','S','SELECT COUNT(*) AS count FROM pa_areas WHERE area_id = area_id ','SQL statement executed successfully \n'),(3,'pa_areas','RMORON','2013-01-09 15:58:51','S','SELECT area_id, nombre_area  \n\t\t\t\t\t\t FROM pa_areas WHERE area_id = area_id  ORDER BY area_id LIMIT 0,20','SQL statement executed successfully \n'),(4,'pa_areas','RMORON','2013-01-09 15:58:51','S','SELECT COUNT(*) AS count FROM pa_areas WHERE area_id = area_id ','SQL statement executed successfully \n'),(5,'permisos','RMORON','2013-01-09 15:58:51','S','SELECT permisosUsuario(\"rmoron\",\"pa_areas.xajax.php\")  AS IBRAC;','SQL statement executed successfully \n'),(6,'pa_usuarios','RMORON','2013-01-09 15:58:51','S','SELECT usuario_id, usuario, password, nombres, apellidos, email, agencia_id, area_id, estado, tipo_usuario_id, persona_id, pregunta_secreta, respuesta_secreta   FROM pa_usuarios WHERE usuario = \"RMORON\" ;','SQL statement executed successfully \n'),(7,'permisos','RMORON','2013-01-09 15:58:51','S','SELECT permisosUsuario(\"rmoron\",\"pa_areas.xajax.php\")  AS IBRAC;','SQL statement executed successfully \n'),(8,'pa_areas','RMORON','2013-01-09 15:59:16','S','SELECT area_id, nombre_area  \n\t\t\t\t\t\t FROM pa_areas WHERE area_id = area_id  ORDER BY area_id LIMIT 0,20','SQL statement executed successfully \n'),(9,'pa_areas','RMORON','2013-01-09 15:59:16','S','SELECT COUNT(*) AS count FROM pa_areas WHERE area_id = area_id ','SQL statement executed successfully \n'),(10,'pa_usuarios','RMORON','2013-01-09 15:59:16','S','SELECT usuario_id, usuario, password, nombres, apellidos, email, agencia_id, area_id, estado, tipo_usuario_id, persona_id, pregunta_secreta, respuesta_secreta   FROM pa_usuarios WHERE usuario = \"RMORON\" ;','SQL statement executed successfully \n'),(11,'pa_usuarios','RMORON','2013-01-09 16:00:01','S','SELECT usuario_id, usuario, password, nombres, apellidos, email, agencia_id, area_id, estado, tipo_usuario_id, persona_id, pregunta_secreta, respuesta_secreta   FROM pa_usuarios WHERE usuario = \"RMORON\" ;','SQL statement executed successfully \n'),(12,'pa_menu','RMORON','2013-01-09 16:00:01','S','SELECT * FROM pa_menu WHERE menu_padre_id = 0 AND es_padre = \"S\" AND menu_id IN (\n                                                SELECT menu_id FROM pa_menu_accesos_x_area WHERE area_id = (SELECT area_id FROM pa_usuarios WHERE usuario = \"rmoron\") AND exclusivo = \"N\" \n                                                UNION ALL\n                                                SELECT menu_id FROM pa_menu_accesos_x_usuario WHERE usuario_id = (SELECT usuario_id FROM pa_usuarios WHERE usuario = \"rmoron\")\n                                                );','SQL statement executed successfully \n'),(13,'pa_menu','RMORON','2013-01-09 16:00:01','S','SELECT * FROM pa_menu WHERE menu_padre_id = 1 AND menu_padre_id IN (\n                                                SELECT menu_id FROM pa_menu_accesos_x_area WHERE area_id = (SELECT area_id FROM pa_usuarios WHERE usuario = \"rmoron\") AND exclusivo = \"N\" \n                                                UNION ALL\n                                                SELECT menu_id FROM pa_menu_accesos_x_usuario WHERE usuario_id = (SELECT usuario_id FROM pa_usuarios WHERE usuario = \"rmoron\")\n                                                );','SQL statement executed successfully \n'),(14,'pa_menu','RMORON','2013-01-09 16:00:01','S','SELECT * FROM pa_menu WHERE menu_padre_id = 9 AND menu_padre_id IN (\n                                                SELECT menu_id FROM pa_menu_accesos_x_area WHERE area_id = (SELECT area_id FROM pa_usuarios WHERE usuario = \"rmoron\") AND exclusivo = \"N\" \n                                                UNION ALL\n                                                SELECT menu_id FROM pa_menu_accesos_x_usuario WHERE usuario_id = (SELECT usuario_id FROM pa_usuarios WHERE usuario = \"rmoron\")\n                                                );','SQL statement executed successfully \n');
/*!40000 ALTER TABLE `php_logs` ENABLE KEYS */;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
