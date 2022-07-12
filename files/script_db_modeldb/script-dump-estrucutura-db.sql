CREATE DATABASE  IF NOT EXISTS `adminbase_db` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `adminbase_db`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: monteoli_saf_db
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.10-MariaDB

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
-- Table structure for table `auditoria_logs`
--

DROP TABLE IF EXISTS `auditoria_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auditoria_logs` (
  `auditoria_id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_hora` timestamp NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) DEFAULT NULL,
  `consulta` longtext DEFAULT NULL,
  `controlador` varchar(255) DEFAULT NULL,
  `datos_log` longtext DEFAULT NULL,
  PRIMARY KEY (`auditoria_id`),
  KEY `fk_usuario_id_x3_idx` (`usuario_id`),
  CONSTRAINT `fk_usuario_id_x3` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auditoria_logs`
--

LOCK TABLES `auditoria_logs` WRITE;
/*!40000 ALTER TABLE `auditoria_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `auditoria_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `caja_cab`
--

DROP TABLE IF EXISTS `caja_cab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `caja_cab` (
  `caja_cab_id` int(11) NOT NULL,
  `caja_cab_nrocaja` decimal(10,0) NOT NULL,
  `usuarios_id` int(11) NOT NULL,
  `caja_cab_tipo` varchar(10) NOT NULL,
  `caja_cab_fecha` timestamp NULL DEFAULT current_timestamp(),
  `caja_cab_hora` time NOT NULL,
  `caja_cab_total` decimal(10,0) DEFAULT NULL,
  `caja_cab_total_tarjeta_c` decimal(10,0) DEFAULT NULL,
  `caja_cab_total_tarjeta_d` decimal(10,0) DEFAULT NULL,
  `caja_cab_total_efectivo` decimal(10,0) DEFAULT NULL,
  `caja_cab_total_cheque` decimal(10,0) DEFAULT NULL,
  `caja_cab_total_fallo_caja` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`caja_cab_id`),
  KEY `fk_caja_cab_usuarios1_idx` (`usuarios_id`),
  CONSTRAINT `fk_caja_cab_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `caja_cab`
--

LOCK TABLES `caja_cab` WRITE;
/*!40000 ALTER TABLE `caja_cab` DISABLE KEYS */;
/*!40000 ALTER TABLE `caja_cab` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `caja_det`
--

DROP TABLE IF EXISTS `caja_det`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `caja_det` (
  `caja_det_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `caja_cab_id` int(11) NOT NULL,
  `moneda_id` int(11) NOT NULL,
  `caja_det_cantidad` decimal(10,0) DEFAULT NULL,
  `caja_det_subtotal` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`caja_det_id`),
  UNIQUE KEY `caja_det_id_UNIQUE` (`caja_det_id`),
  KEY `fk_Caja_det_caja_cab1_idx` (`caja_cab_id`),
  KEY `fk_Caja_det_moneda1_idx` (`moneda_id`),
  CONSTRAINT `fk_Caja_det_caja_cab1` FOREIGN KEY (`caja_cab_id`) REFERENCES `caja_cab` (`caja_cab_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Caja_det_moneda1` FOREIGN KEY (`moneda_id`) REFERENCES `moneda` (`moneda_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `caja_det`
--

LOCK TABLES `caja_det` WRITE;
/*!40000 ALTER TABLE `caja_det` DISABLE KEYS */;
/*!40000 ALTER TABLE `caja_det` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_sessions`
--

LOCK TABLES `ci_sessions` WRITE;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `cliente_id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_nombre` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cliente_apellido` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cliente_id_padre` int(11) DEFAULT NULL,
  `cliente_ci` int(11) DEFAULT NULL,
  `cliente_cel` int(10) DEFAULT NULL,
  `cliente_tipo_id` int(11) NOT NULL,
  `cliente_fecha_nacimiento` date DEFAULT '1100-01-01',
  `cliente_sexo` enum('M','F') COLLATE utf8_spanish_ci DEFAULT NULL,
  `cliente_direccion` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cliente_dateinsert` datetime NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `cliente_estado` enum('activo','inactivo','borrado') COLLATE utf8_spanish_ci NOT NULL,
  `cliente_archivo` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`cliente_id`),
  KEY `cliente_tipo_id_idx` (`cliente_tipo_id`),
  KEY `cliente_id_padre_idx` (`cliente_id_padre`),
  KEY `usuario_id_idx` (`usuario_id`),
  CONSTRAINT `cliente_id_padre` FOREIGN KEY (`cliente_id_padre`) REFERENCES `clientes` (`cliente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `cliente_tipo_id` FOREIGN KEY (`cliente_tipo_id`) REFERENCES `clientes_tipo` (`cliente_tipo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes_tipo`
--

DROP TABLE IF EXISTS `clientes_tipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes_tipo` (
  `cliente_tipo_id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_tipo_nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cliente_tipo_descripcion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`cliente_tipo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes_tipo`
--

LOCK TABLES `clientes_tipo` WRITE;
/*!40000 ALTER TABLE `clientes_tipo` DISABLE KEYS */;
/*!40000 ALTER TABLE `clientes_tipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo`
--

DROP TABLE IF EXISTS `grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo` (
  `grupo_id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo_nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `grupo_dateupdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `grupo_dateinsert` datetime NOT NULL,
  PRIMARY KEY (`grupo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo`
--

LOCK TABLES `grupo` WRITE;
/*!40000 ALTER TABLE `grupo` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_acciones`
--

DROP TABLE IF EXISTS `grupo_acciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo_acciones` (
  `grupo_acciones_id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo_acciones_nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `grupo_acciones_descripcion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`grupo_acciones_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_acciones`
--

LOCK TABLES `grupo_acciones` WRITE;
/*!40000 ALTER TABLE `grupo_acciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupo_acciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_permisos`
--

DROP TABLE IF EXISTS `grupo_permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo_permisos` (
  `grupo_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `grupo_acciones_id` int(11) NOT NULL,
  PRIMARY KEY (`grupo_id`,`menu_id`,`grupo_acciones_id`),
  KEY `fk_perfil_id_idx` (`grupo_id`),
  KEY `fk_perfil_acciones_id_idx` (`grupo_acciones_id`),
  KEY `fk_menu_id2_idx` (`menu_id`),
  CONSTRAINT `fk_menu_id3` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_perfil_acciones_id1` FOREIGN KEY (`grupo_acciones_id`) REFERENCES `grupo_acciones` (`grupo_acciones_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_perfil_id3` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`grupo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_permisos`
--

LOCK TABLES `grupo_permisos` WRITE;
/*!40000 ALTER TABLE `grupo_permisos` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupo_permisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_usuarios`
--

DROP TABLE IF EXISTS `grupo_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo_usuarios` (
  `usuario_id` int(11) NOT NULL,
  `grupo_id` int(11) NOT NULL,
  PRIMARY KEY (`usuario_id`,`grupo_id`),
  KEY `fk_usuario_id_idx` (`usuario_id`),
  KEY `fk_perfil_id_idx` (`grupo_id`),
  CONSTRAINT `fk_perfil_id1` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`grupo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_id1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_usuarios`
--

LOCK TABLES `grupo_usuarios` WRITE;
/*!40000 ALTER TABLE `grupo_usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupo_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_nivel` int(11) DEFAULT NULL,
  `menu_nombre` varchar(45) DEFAULT NULL,
  `menu_id_padre` int(11) DEFAULT NULL,
  `menu_icono` varchar(45) DEFAULT NULL,
  `menu_controlador` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `moneda`
--

DROP TABLE IF EXISTS `moneda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moneda` (
  `moneda_id` int(11) NOT NULL,
  `moneda_descripcion` varchar(45) NOT NULL,
  `moneda_valor` decimal(10,0) NOT NULL COMMENT 'Ejemplo\\nId	Descripcion	Valor\\n1	100.000 mil	 100000 \\n2	50.000 mil	 50000 \\n3	20.000 mil	 20000 \\n4	10.000 mil	 10000 \\n5	5.000 mil	 5000 \\n6	2.000 mil	 2000 \\n7	1.000 mil	 1000 \\n8	500 mil	 500 \\n9	100 mil	 100 \\n10	50 mil	 50 ',
  PRIMARY KEY (`moneda_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `moneda`
--

LOCK TABLES `moneda` WRITE;
/*!40000 ALTER TABLE `moneda` DISABLE KEYS */;
/*!40000 ALTER TABLE `moneda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pago_cliente`
--

DROP TABLE IF EXISTS `pago_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pago_cliente` (
  `pago_cliente_id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) DEFAULT NULL,
  `pago_cliente_fecha` datetime NOT NULL,
  `pago_cliente_fecha_hasta` datetime NOT NULL,
  `pago_cliente_cuotas` int(11) NOT NULL,
  `pago_cliente_monto_plan` decimal(10,0) DEFAULT NULL,
  `pago_cliente_monto_iva` decimal(10,0) DEFAULT NULL,
  `pago_cliente_monto_total` decimal(10,0) DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `pago_cliente_estado` enum('Pendiente','Anulado','Pagado') COLLATE utf8_spanish_ci NOT NULL,
  `pago_cliente_dateinsert` timestamp NULL DEFAULT current_timestamp(),
  `pago_forma_id` int(11) DEFAULT NULL,
  `pago_forma_efectivo_monto` decimal(10,0) DEFAULT NULL,
  `pago_forma_tarjeta_monto` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`pago_cliente_id`),
  KEY `cliente_id_idx` (`cliente_id`),
  KEY `usuario_id_pago_cliente` (`usuario_id`),
  KEY `pago_forma_id_idx` (`pago_forma_id`),
  CONSTRAINT `cliente_id` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`cliente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `pago_forma_id` FOREIGN KEY (`pago_forma_id`) REFERENCES `pago_forma` (`pago_forma_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `usuario_id_pago_cliente` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pago_cliente`
--

LOCK TABLES `pago_cliente` WRITE;
/*!40000 ALTER TABLE `pago_cliente` DISABLE KEYS */;
/*!40000 ALTER TABLE `pago_cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pago_cliente_detalle`
--

DROP TABLE IF EXISTS `pago_cliente_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pago_cliente_detalle` (
  `pago_cliente_detalle_id` int(11) NOT NULL AUTO_INCREMENT,
  `pago_cliente_id` int(11) DEFAULT NULL,
  `planes_clientes_id` int(11) DEFAULT NULL,
  `pago_cliente_detalle_monto_plan` decimal(10,0) DEFAULT NULL,
  `pago_cliente_detalle_monto_adicional` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`pago_cliente_detalle_id`),
  KEY `pago_cliente_id_idx` (`pago_cliente_id`),
  KEY `planes_clientes_id_idx` (`planes_clientes_id`),
  CONSTRAINT `pago_cliente_id` FOREIGN KEY (`pago_cliente_id`) REFERENCES `pago_cliente` (`pago_cliente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `planes_clientes_id` FOREIGN KEY (`planes_clientes_id`) REFERENCES `planes_clientes` (`planes_clientes_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pago_cliente_detalle`
--

LOCK TABLES `pago_cliente_detalle` WRITE;
/*!40000 ALTER TABLE `pago_cliente_detalle` DISABLE KEYS */;
/*!40000 ALTER TABLE `pago_cliente_detalle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pago_forma`
--

DROP TABLE IF EXISTS `pago_forma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pago_forma` (
  `pago_forma_id` int(11) NOT NULL AUTO_INCREMENT,
  `pago_forma_descripcion` varchar(45) DEFAULT NULL,
  `pago_forma_tipo` varchar(45) DEFAULT NULL,
  `pago_forma_alias` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`pago_forma_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pago_forma`
--

LOCK TABLES `pago_forma` WRITE;
/*!40000 ALTER TABLE `pago_forma` DISABLE KEYS */;
/*!40000 ALTER TABLE `pago_forma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `planes`
--

DROP TABLE IF EXISTS `planes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `planes` (
  `plan_id` int(11) NOT NULL AUTO_INCREMENT,
  `plan_rango_edad_id` int(11) NOT NULL,
  `plan_categoria_id` int(11) NOT NULL,
  `planes_costo` int(11) NOT NULL,
  PRIMARY KEY (`plan_id`),
  KEY `categoria_id_idx` (`plan_categoria_id`),
  KEY `rango_edad_id_idx` (`plan_rango_edad_id`),
  CONSTRAINT `plan_categoria_id` FOREIGN KEY (`plan_categoria_id`) REFERENCES `planes_categoria` (`plan_categoria_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `plan_rango_edad_id` FOREIGN KEY (`plan_rango_edad_id`) REFERENCES `planes_rango_edad` (`plan_rango_edad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planes`
--

LOCK TABLES `planes` WRITE;
/*!40000 ALTER TABLE `planes` DISABLE KEYS */;
/*!40000 ALTER TABLE `planes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `planes_categoria`
--

DROP TABLE IF EXISTS `planes_categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `planes_categoria` (
  `plan_categoria_id` int(11) NOT NULL AUTO_INCREMENT,
  `plan_categoria_nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`plan_categoria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planes_categoria`
--

LOCK TABLES `planes_categoria` WRITE;
/*!40000 ALTER TABLE `planes_categoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `planes_categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `planes_clientes`
--

DROP TABLE IF EXISTS `planes_clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `planes_clientes` (
  `planes_clientes_id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `planes_clientes_estado` enum('activo','inactivo') COLLATE utf8_spanish_ci DEFAULT NULL,
  `planes_clientes_fecha_ingreso` date DEFAULT NULL,
  `planes_clientes_dateinsert` datetime DEFAULT NULL,
  `planes_clientes_modificar_monto` enum('si','no') COLLATE utf8_spanish_ci DEFAULT NULL,
  `planes_clientes_monto` int(11) DEFAULT NULL,
  PRIMARY KEY (`planes_clientes_id`),
  KEY `clientes_id_idx` (`cliente_id`),
  KEY `plan_id_idx` (`plan_id`),
  CONSTRAINT `clientes_id` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`cliente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `plan_id` FOREIGN KEY (`plan_id`) REFERENCES `planes` (`plan_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planes_clientes`
--

LOCK TABLES `planes_clientes` WRITE;
/*!40000 ALTER TABLE `planes_clientes` DISABLE KEYS */;
/*!40000 ALTER TABLE `planes_clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `planes_rango_edad`
--

DROP TABLE IF EXISTS `planes_rango_edad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `planes_rango_edad` (
  `plan_rango_edad_id` int(11) NOT NULL AUTO_INCREMENT,
  `plan_rango_edad_nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `planes_rango_limite_inferior` int(11) NOT NULL,
  `planes_rango_limite_superior` int(11) NOT NULL,
  `plan_vigencia_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`plan_rango_edad_id`),
  KEY `vigencia_id_idx` (`plan_vigencia_id`),
  CONSTRAINT `plan_vigencia_id` FOREIGN KEY (`plan_vigencia_id`) REFERENCES `planes_vigencia` (`plan_vigencia_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planes_rango_edad`
--

LOCK TABLES `planes_rango_edad` WRITE;
/*!40000 ALTER TABLE `planes_rango_edad` DISABLE KEYS */;
/*!40000 ALTER TABLE `planes_rango_edad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `planes_vigencia`
--

DROP TABLE IF EXISTS `planes_vigencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `planes_vigencia` (
  `plan_vigencia_id` int(11) NOT NULL AUTO_INCREMENT,
  `plan_vigencia_nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `plan_vigencia_dias` int(11) DEFAULT NULL,
  PRIMARY KEY (`plan_vigencia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planes_vigencia`
--

LOCK TABLES `planes_vigencia` WRITE;
/*!40000 ALTER TABLE `planes_vigencia` DISABLE KEYS */;
/*!40000 ALTER TABLE `planes_vigencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sucursal`
--

DROP TABLE IF EXISTS `sucursal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sucursal` (
  `sucursal_id` int(11) NOT NULL AUTO_INCREMENT,
  `sucursal_descripcion` varchar(45) DEFAULT NULL,
  `sucursal_direccion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`sucursal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sucursal`
--

LOCK TABLES `sucursal` WRITE;
/*!40000 ALTER TABLE `sucursal` DISABLE KEYS */;
/*!40000 ALTER TABLE `sucursal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_nombre` varchar(45) DEFAULT NULL,
  `usuario_apellido` varchar(45) DEFAULT NULL,
  `usuario_user` varchar(45) NOT NULL,
  `usuario_pass` varchar(45) NOT NULL,
  `usuario_estado` enum('activo','inactivo','borrado') DEFAULT NULL,
  `usuario_dateupdate` timestamp NULL DEFAULT NULL,
  `usuario_dateinsert` datetime NOT NULL,
  `usuario_foto` varchar(150) DEFAULT NULL,
  `sucursal_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `usuario_user_UNIQUE` (`usuario_user`),
  KEY `sucursal_id_idx` (`sucursal_id`),
  CONSTRAINT `sucursal_id` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursal` (`sucursal_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'monteoli_saf_db'
--

--
-- Dumping routines for database 'monteoli_saf_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-23 17:54:37
