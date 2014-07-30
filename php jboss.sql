# MySQL-Front 5.0  (Build 1.0)

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;


# Host: localhost    Database: php
# ------------------------------------------------------
# Server version 5.1.43-community

DROP DATABASE IF EXISTS `php`;
CREATE DATABASE `php` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `php`;

#
# Table structure for table pa_areas
#

CREATE TABLE `pa_areas` (
  `area_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_area` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`area_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
INSERT INTO `pa_areas` VALUES (1,'SISTEMAS');
INSERT INTO `pa_areas` VALUES (2,'GERENCIA');
INSERT INTO `pa_areas` VALUES (3,'AUDITORIA');
INSERT INTO `pa_areas` VALUES (4,'RECURSOS HUMANOS');
INSERT INTO `pa_areas` VALUES (5,'CONTABILIDAD');
INSERT INTO `pa_areas` VALUES (6,'ADQUISICIONES');
/*!40000 ALTER TABLE `pa_areas` ENABLE KEYS */;
UNLOCK TABLES;

#
# Table structure for table pa_menu
#

CREATE TABLE `pa_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` mediumtext,
  `link` varchar(255) DEFAULT NULL,
  `menu_padre_id` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  `es_padre` char(1) DEFAULT NULL,
  `exclusivo` char(1) DEFAULT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `posicion` int(11) DEFAULT '0',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
INSERT INTO `pa_menu` VALUES (1,'CONFIGURACIÓN','CONFIGURACIÓN DEL SISTEMA','',0,0,'S','N','',0);
INSERT INTO `pa_menu` VALUES (9,'PARAMETROS','PARAMETROS DEL SISTEMA','',0,0,'S','N','',0);
INSERT INTO `pa_menu` VALUES (10,'MENUS','GESTIÓN DE MENÊS','http://127.0.0.1/php/modules/parametros/www/php/pa_menu.php',9,0,'N','N','',0);
INSERT INTO `pa_menu` VALUES (11,'ACCESOS POR AREA','ACCESOS DE MENU POR AREA','http://127.0.0.1/php/modules/parametros/www/php/pa_menu_accesos_x_area.php',9,0,'N','N','',0);
INSERT INTO `pa_menu` VALUES (12,'ACCESOS POR USUARIO','ACCESOS DE MENU POR USUARIO','http://127.0.0.1/php/modules/parametros/www/php/pa_menu_accesos_x_usuario.php',9,0,'N','N','',0);
INSERT INTO `pa_menu` VALUES (13,'PERMISOS POR ÁREA','PERMISOS POR ÁREA','http://127.0.0.1/php/modules/parametros/www/php/pa_permisos_x_area.php',9,0,'N','N','',0);
INSERT INTO `pa_menu` VALUES (14,'PERMISOS POR USUARIO','PERMISOS POR USUARIO','http://127.0.0.1/php/modules/parametros/www/php/pa_permisos_x_usuario.php',9,0,'N','N','',0);
INSERT INTO `pa_menu` VALUES (15,'USUARIOS','GESTIÓN DE USUARIOS','http://127.0.0.1/php/modules/parametros/www/php/pa_usuarios.php',9,0,'N','N','',0);
INSERT INTO `pa_menu` VALUES (16,'PARAMETROS','TABLA PARAMETROS','http://127.0.0.1/php/modules/parametros/www/php/pa_parametros.php',9,0,'N','N','',0);
INSERT INTO `pa_menu` VALUES (17,'AREAS','AREAS DEL SISTEMA','http://127.0.0.1/php/modules/parametros/www/php/pa_areas.php',9,0,'N','N','',0);
INSERT INTO `pa_menu` VALUES (18,'VARIABLES GLOBALES','VARIABLES GLOBALES','http://127.0.0.1/php/modules/parametros/www/php/pa_configure.php',1,0,'N','N','',0);
INSERT INTO `pa_menu` VALUES (19,'SALIR','OPCIÓN DE SALIDA DEL SISTEMA','http://127.0.0.1/php/logout.php',1,0,'N','N','',100);
/*!40000 ALTER TABLE `pa_menu` ENABLE KEYS */;
UNLOCK TABLES;

#
# Table structure for table pa_menu_accesos_x_area
#

CREATE TABLE `pa_menu_accesos_x_area` (
  `menu_acceso_area_id` int(11) NOT NULL AUTO_INCREMENT,
  `area_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `observaciones` text,
  PRIMARY KEY (`menu_acceso_area_id`),
  KEY `FK7BC4D63296D20E7C` (`menu_id`),
  KEY `FK7BC4D6323A4612B1` (`area_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
INSERT INTO `pa_menu_accesos_x_area` VALUES (2,1,1,'');
INSERT INTO `pa_menu_accesos_x_area` VALUES (3,1,9,'test');
/*!40000 ALTER TABLE `pa_menu_accesos_x_area` ENABLE KEYS */;
UNLOCK TABLES;

#
# Table structure for table pa_menu_accesos_x_usuario
#

CREATE TABLE `pa_menu_accesos_x_usuario` (
  `menu_acceso_x_usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `observaciones` text,
  PRIMARY KEY (`menu_acceso_x_usuario_id`),
  KEY `FK43AECF6996D20E7C` (`menu_id`),
  KEY `FK43AECF6916CC26F3` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
INSERT INTO `pa_menu_accesos_x_usuario` VALUES (1,1,1,'1');
/*!40000 ALTER TABLE `pa_menu_accesos_x_usuario` ENABLE KEYS */;
UNLOCK TABLES;

#
# Table structure for table pa_parametros
#

CREATE TABLE `pa_parametros` (
  `parametro_id` int(11) NOT NULL AUTO_INCREMENT,
  `entidad` varchar(50) DEFAULT NULL,
  `codigo` varchar(20) DEFAULT NULL,
  `valor` varchar(25) DEFAULT NULL,
  `descripcion` varchar(252) DEFAULT NULL,
  PRIMARY KEY (`parametro_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
INSERT INTO `pa_parametros` VALUES (5,'ESTADO_CIVIL','S','SOLTERO','ESTADO CIVIL DE SOLTERO');
INSERT INTO `pa_parametros` VALUES (6,'ESTADO_CIVIL','C','CASADO','ESTADO CIVIL DE CASADO');
/*!40000 ALTER TABLE `pa_parametros` ENABLE KEYS */;
UNLOCK TABLES;

#
# Table structure for table pa_permisos_x_area
#

CREATE TABLE `pa_permisos_x_area` (
  `permisos_x_area_id` int(11) NOT NULL AUTO_INCREMENT,
  `area_id` int(11) DEFAULT NULL,
  `archivo` varchar(50) DEFAULT NULL,
  `insertar` char(1) DEFAULT NULL,
  `borrar` char(1) DEFAULT NULL,
  `reporte` char(1) DEFAULT NULL,
  `actualizar` char(1) DEFAULT NULL,
  `consultar` char(1) DEFAULT NULL,
  `observaciones` text,
  PRIMARY KEY (`permisos_x_area_id`),
  KEY `FK650935873A4612B1` (`area_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
INSERT INTO `pa_permisos_x_area` VALUES (7,1,'pa_menu.xajax.php','S','S','S','S','S','CONFIGURACIÓN POR DEFECTO');
INSERT INTO `pa_permisos_x_area` VALUES (8,1,'pa_menu_accesos_x_area.xajax.php','S','S','S','S','S','CONFIGURACIÓN POR DEFECTO');
INSERT INTO `pa_permisos_x_area` VALUES (9,1,'pa_menu_accesos_x_usuario.xajax.php','S','S','S','S','S','CONFIGURACIÓN POR DEFECTO');
INSERT INTO `pa_permisos_x_area` VALUES (10,1,'pa_permisos_x_area.xajax.php','S','S','S','S','S','CONFIGURACIÓN POR DEFECTO');
INSERT INTO `pa_permisos_x_area` VALUES (11,1,'pa_permisos_x_usuario.xajax.php','S','S','S','S','S','CONFIGURACIÓN POR DEFECTO');
INSERT INTO `pa_permisos_x_area` VALUES (13,1,'pa_usuarios.xajax.php','S','S','S','S','S','CONFIGURACIÓN POR DEFECTO');
INSERT INTO `pa_permisos_x_area` VALUES (14,1,'pa_areas.xajax.php','S','S','S','N','S','CONFIGURACIÓN POR DEFECTO');
INSERT INTO `pa_permisos_x_area` VALUES (15,1,'pa_parametros.xajax.php','S','S','S','S','S','CONFIGURACIÓN POR DEFECTO');
INSERT INTO `pa_permisos_x_area` VALUES (16,1,'php_logs.xajax.php','S','S','S','S','S','');
/*!40000 ALTER TABLE `pa_permisos_x_area` ENABLE KEYS */;
UNLOCK TABLES;

#
# Table structure for table pa_permisos_x_usuario
#

CREATE TABLE `pa_permisos_x_usuario` (
  `permisos_x_usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `archivo` varchar(50) DEFAULT NULL,
  `insertar` char(1) DEFAULT NULL,
  `borrar` char(1) DEFAULT NULL,
  `reporte` char(1) DEFAULT NULL,
  `actualizar` char(1) DEFAULT NULL,
  `consultar` char(1) DEFAULT NULL,
  `observaciones` text,
  PRIMARY KEY (`permisos_x_usuario_id`),
  KEY `FKCF40B3F416CC26F3` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
INSERT INTO `pa_permisos_x_usuario` VALUES (1,1,'index.php','S','S','N','S','S','');
INSERT INTO `pa_permisos_x_usuario` VALUES (2,1,'menu.php','S','S','S','S','S','');
/*!40000 ALTER TABLE `pa_permisos_x_usuario` ENABLE KEYS */;
UNLOCK TABLES;

#
# Table structure for table pa_usuarios
#

CREATE TABLE `pa_usuarios` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(15) NOT NULL DEFAULT '',
  `password` mediumtext NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `agencia_id` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  `estado` char(1) NOT NULL DEFAULT 'A',
  `tipo_usuario_id` int(11) DEFAULT NULL,
  `persona_id` int(11) DEFAULT NULL,
  `pregunta_secreta` mediumtext,
  `respuesta_secreta` mediumtext,
  PRIMARY KEY (`usuario_id`),
  KEY `FKC3D0B5933A4612B1` (`area_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
INSERT INTO `pa_usuarios` VALUES (1,'RMORON','180431af41c2768cec9aab1724215a87','RICHARD ','MORON ','RMORON@BB.COM.BR',1,1,'A',1,1,'','');
INSERT INTO `pa_usuarios` VALUES (2,'MORTIZ','7C269C5B83963C1D7ADB6792B5276BAB','MAICOL','ORTIZ','MORTIZ@IMCRUZ.COM',1,1,'A',1,1,'','');
/*!40000 ALTER TABLE `pa_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for function permisosUsuario
#

CREATE FUNCTION `permisosUsuario`(
	-- Add the parameters for the function here
	p_usuario varchar(25),
	p_archivo varchar(255)
) RETURNS varchar(10) CHARSET latin1
BEGIN
DECLARE v_insertar char(1);
DECLARE v_borrar char(1);
DECLARE v_reporte char(1);
DECLARE v_actualizar char(1);
DECLARE v_consultar char(1);

DECLARE insertar_tmp char(1);
DECLARE borrar_tmp char(1);
DECLARE reporte_tmp char(1);
DECLARE actualizar_tmp char(1);
DECLARE consultar_tmp char(1);

DECLARE ibrac VARCHAR(10);
-- PERMISOS POR AREA
SET v_insertar = (SELECT insertar FROM pa_permisos_x_area WHERE area_id = 
				(SELECT area_id FROM pa_usuarios WHERE UPPER(usuario) = UPPER(p_usuario)) AND archivo = p_archivo );
-- SET v_insertar = 'S';
 		
SET v_borrar = (SELECT borrar FROM pa_permisos_x_area WHERE area_id = 
				(SELECT area_id FROM pa_usuarios WHERE UPPER(usuario) = UPPER(p_usuario)) AND archivo = p_archivo );
				
SET v_reporte = (SELECT reporte FROM pa_permisos_x_area WHERE area_id = 
				(SELECT area_id FROM pa_usuarios WHERE UPPER(usuario) = UPPER(p_usuario)) AND archivo = p_archivo );
				
SET v_actualizar = (SELECT actualizar FROM pa_permisos_x_area WHERE area_id = 
				(SELECT area_id FROM pa_usuarios WHERE UPPER(usuario) = UPPER(p_usuario)) AND archivo = p_archivo );
				
SET v_consultar = (SELECT consultar FROM pa_permisos_x_area WHERE area_id = 
				(SELECT area_id FROM pa_usuarios WHERE UPPER(usuario) = UPPER(p_usuario)) AND archivo = p_archivo );																

-- PERMISOS POR USUARIO
SET insertar_tmp = (SELECT insertar FROM pa_permisos_x_usuario WHERE UPPER(usuario_id) = 
                   (SELECT usuario_id FROM pa_usuarios WHERE UPPER(usuario) = UPPER(p_usuario)) AND archivo = p_archivo );
 IF (insertar_tmp IS NOT NULL) THEN
	SET v_insertar = insertar_tmp;
 END IF;

SET borrar_tmp = (SELECT borrar FROM pa_permisos_x_usuario WHERE UPPER(usuario_id) = 
                   (SELECT usuario_id FROM pa_usuarios WHERE UPPER(usuario) = UPPER(p_usuario)) AND archivo = p_archivo );
IF (borrar_tmp IS NOT NULL) THEN
	SET v_borrar = borrar_tmp;
END IF;

SET reporte_tmp = (SELECT reporte FROM pa_permisos_x_usuario WHERE UPPER(usuario_id) = 
                   (SELECT usuario_id FROM pa_usuarios WHERE UPPER(usuario) = UPPER(p_usuario)) AND archivo = p_archivo );
IF (reporte_tmp IS NOT NULL) THEN
	SET v_reporte = reporte_tmp;
END IF;
	
SET actualizar_tmp = (SELECT actualizar FROM pa_permisos_x_usuario WHERE UPPER(usuario_id) = 
                   (SELECT usuario_id FROM pa_usuarios WHERE UPPER(usuario) = UPPER(p_usuario)) AND archivo = p_archivo );
IF (actualizar_tmp IS NOT NULL) THEN
	SET v_actualizar = actualizar_tmp;
END IF;
	
SET consultar_tmp = (SELECT consultar FROM pa_permisos_x_usuario WHERE UPPER(usuario_id) = 
                   (SELECT usuario_id FROM pa_usuarios WHERE UPPER(usuario) = UPPER(p_usuario)) AND archivo = p_archivo );
IF (consultar_tmp IS NOT NULL) THEN
	SET v_consultar = consultar_tmp;		
END IF;
				
-- INSERTAR			
IF (v_insertar = 'S') THEN
 	SET v_insertar = 'I';
ELSE
    SET v_insertar = '';	
 END IF;

-- BORRAR
IF (v_borrar = 'S') THEN
	SET v_borrar = 'B';
ELSE
	SET v_borrar = '';
END IF;

-- REPORTE
IF (v_reporte = 'S') THEN
	SET v_reporte = 'R';
ELSE
	SET v_reporte = '';
END IF;

-- ACTUALIZAR	
IF (v_actualizar = 'S') THEN
	SET v_actualizar = 'A';
ELSE
	SET v_actualizar = '';
END IF;

-- CONSULTAR		 
IF (v_consultar = 'S') THEN
	SET v_consultar = 'C';
ELSE
	SET v_consultar = '';
END IF;

  RETURN CONCAT(v_insertar,v_borrar,v_reporte,v_actualizar,v_consultar);
 
END;


#
#  Foreign keys for table pa_menu_accesos_x_usuario
#

ALTER TABLE `pa_menu_accesos_x_usuario`
ADD CONSTRAINT `FK43AECF6916CC26F3` FOREIGN KEY (`usuario_id`) REFERENCES `pa_usuarios` (`usuario_id`),
  ADD CONSTRAINT `FK43AECF6996D20E7C` FOREIGN KEY (`menu_id`) REFERENCES `pa_menu` (`menu_id`);

#
#  Foreign keys for table pa_permisos_x_area
#

ALTER TABLE `pa_permisos_x_area`
ADD CONSTRAINT `FK650935873A4612B1` FOREIGN KEY (`area_id`) REFERENCES `pa_areas` (`area_id`);

#
#  Foreign keys for table pa_permisos_x_usuario
#

ALTER TABLE `pa_permisos_x_usuario`
ADD CONSTRAINT `FKCF40B3F416CC26F3` FOREIGN KEY (`usuario_id`) REFERENCES `pa_usuarios` (`usuario_id`);

#
#  Foreign keys for table pa_usuarios
#

ALTER TABLE `pa_usuarios`
ADD CONSTRAINT `FKC3D0B5933A4612B1` FOREIGN KEY (`area_id`) REFERENCES `pa_areas` (`area_id`);


/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
