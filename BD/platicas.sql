-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 08, 2013 at 09:38 PM
-- Server version: 5.6.10
-- PHP Version: 5.4.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `platicas`
--

-- --------------------------------------------------------

--
-- Table structure for table `ciudad`
--

CREATE TABLE IF NOT EXISTS `ciudad` (
  `ciudad_nombre` char(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `pais_id` char(3) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `estado_nombre` char(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  KEY `ciudad_nombre` (`ciudad_nombre`),
  KEY `estado_nombre` (`estado_nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `civil`
--

CREATE TABLE IF NOT EXISTS `civil` (
  `civil` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  KEY `civil` (`civil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `colonia`
--

CREATE TABLE IF NOT EXISTS `colonia` (
  `colonia` varchar(48) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cp` int(5) NOT NULL,
  UNIQUE KEY `colonia` (`colonia`),
  KEY `cp` (`cp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `disponible`
--

CREATE TABLE IF NOT EXISTS `disponible` (
  `disponible_id` date NOT NULL,
  `platica_id` int(11) NOT NULL,
  `disponible_contador` int(2) NOT NULL DEFAULT '0',
  `disponible_activo` enum('abierto','cerrado') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'abierto',
  PRIMARY KEY (`disponible_id`),
  KEY `platica_id` (`platica_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `el`
--

CREATE TABLE IF NOT EXISTS `el` (
  `el_id` int(11) NOT NULL AUTO_INCREMENT,
  `el_paterno` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `el_materno` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `el_nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `el_fecha` date NOT NULL,
  `el_pais_nombre` char(52) COLLATE utf8_spanish_ci NOT NULL,
  `el_estado_nombre` char(45) COLLATE utf8_spanish_ci NOT NULL,
  `el_ciudad_nombre` char(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `el_curp` varchar(18) COLLATE utf8_spanish_ci NOT NULL,
  `el_calle` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `el_numero` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `el_interior` varchar(8) COLLATE utf8_spanish_ci DEFAULT NULL,
  `el_colonia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `el_ciudad_nombre_dir` char(45) COLLATE utf8_spanish_ci NOT NULL,
  `el_cp` int(5) NOT NULL,
  `el_telefono` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `el_movil` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `el_email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `el_ocupacion` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `el_escolaridad` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `el_civil` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_alta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`el_id`),
  UNIQUE KEY `el_curp` (`el_curp`),
  KEY `el_pais_nombre` (`el_pais_nombre`),
  KEY `el_ciudad_nombre_dir` (`el_ciudad_nombre_dir`),
  KEY `el_ocupacion` (`el_ocupacion`),
  KEY `el_escolaridad` (`el_escolaridad`),
  KEY `el_civil` (`el_civil`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=167 ;

-- --------------------------------------------------------

--
-- Table structure for table `ella`
--

CREATE TABLE IF NOT EXISTS `ella` (
  `ella_id` int(11) NOT NULL AUTO_INCREMENT,
  `ella_paterno` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `ella_materno` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `ella_nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `ella_fecha` date NOT NULL,
  `ella_pais_nombre` char(52) COLLATE utf8_spanish_ci NOT NULL,
  `ella_estado_nombre` char(45) COLLATE utf8_spanish_ci NOT NULL,
  `ella_ciudad_nombre` char(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ella_curp` varchar(18) COLLATE utf8_spanish_ci NOT NULL,
  `ella_calle` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ella_numero` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `ella_interior` varchar(8) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ella_colonia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ella_ciudad_nombre_dir` char(45) COLLATE utf8_spanish_ci NOT NULL,
  `ella_cp` int(5) NOT NULL,
  `ella_telefono` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ella_movil` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ella_email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ella_ocupacion` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `ella_escolaridad` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ella_civil` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_alta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ella_id`),
  UNIQUE KEY `ella_curp` (`ella_curp`),
  KEY `ella_pais_nombre` (`ella_pais_nombre`),
  KEY `ella_ciudad_nombre_dir` (`ella_ciudad_nombre_dir`),
  KEY `ella_ocupacion` (`ella_ocupacion`),
  KEY `ella_civil` (`ella_civil`),
  KEY `ella_escolaridad` (`ella_escolaridad`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=112 ;

-- --------------------------------------------------------

--
-- Table structure for table `escolaridad`
--

CREATE TABLE IF NOT EXISTS `escolaridad` (
  `escolaridad` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Sin Primaria',
  PRIMARY KEY (`escolaridad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `folio`
--

CREATE TABLE IF NOT EXISTS `folio` (
  `folio_id` int(11) NOT NULL AUTO_INCREMENT,
  `disponible_id` date DEFAULT NULL,
  `el_id` int(11) NOT NULL,
  `ella_id` int(11) NOT NULL,
  `recibo` int(7) NOT NULL,
  `hijos` int(2) NOT NULL,
  `delegacion` varchar(25) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'La Mesa',
  `usuario_id` int(11) NOT NULL,
  `termino` enum('si','no') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'no',
  `folio_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`folio_id`),
  KEY `disponible_id` (`disponible_id`),
  KEY `ella_id` (`ella_id`),
  KEY `el_id` (`el_id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=76 ;

-- --------------------------------------------------------

--
-- Table structure for table `ocupacion`
--

CREATE TABLE IF NOT EXISTS `ocupacion` (
  `ocupacion` varchar(25) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Empleado',
  PRIMARY KEY (`ocupacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pais`
--

CREATE TABLE IF NOT EXISTS `pais` (
  `pais_id` char(3) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `pais_nombre` char(52) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`pais_id`),
  KEY `pais_nombre` (`pais_nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `platica`
--

CREATE TABLE IF NOT EXISTS `platica` (
  `platica_id` int(11) NOT NULL AUTO_INCREMENT,
  `platica_lugar` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `platica_calle` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `platica_numero` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `platica_colonia` varchar(48) COLLATE utf8_spanish_ci NOT NULL,
  `platica_capacidad` int(2) NOT NULL,
  `ciudad_nombre` char(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Tijuana',
  PRIMARY KEY (`platica_id`),
  KEY `ciudad_nombre` (`ciudad_nombre`),
  KEY `platica_colonia` (`platica_colonia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_nombre` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `usuario_clave` varchar(80) COLLATE utf8_spanish_ci NOT NULL COMMENT 'crypt()',
  `usuario_nivel` enum('Administrador','usuario') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'usuario',
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `usuario` (`usuario_nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=46 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `disponible`
--
ALTER TABLE `disponible`
  ADD CONSTRAINT `disponible_platica_id` FOREIGN KEY (`platica_id`) REFERENCES `platica` (`platica_id`);

--
-- Constraints for table `el`
--
ALTER TABLE `el`
  ADD CONSTRAINT `el_ciudad` FOREIGN KEY (`el_ciudad_nombre_dir`) REFERENCES `ciudad` (`ciudad_nombre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `el_civil` FOREIGN KEY (`el_civil`) REFERENCES `civil` (`civil`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `el_escolaridad` FOREIGN KEY (`el_escolaridad`) REFERENCES `escolaridad` (`escolaridad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `el_ocupacion` FOREIGN KEY (`el_ocupacion`) REFERENCES `ocupacion` (`ocupacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `el_pais` FOREIGN KEY (`el_pais_nombre`) REFERENCES `pais` (`pais_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ella`
--
ALTER TABLE `ella`
  ADD CONSTRAINT `ella_ciudad` FOREIGN KEY (`ella_ciudad_nombre_dir`) REFERENCES `ciudad` (`ciudad_nombre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ella_civil` FOREIGN KEY (`ella_civil`) REFERENCES `civil` (`civil`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ella_escolaridad` FOREIGN KEY (`ella_escolaridad`) REFERENCES `escolaridad` (`escolaridad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ella_ocupacion` FOREIGN KEY (`ella_ocupacion`) REFERENCES `ocupacion` (`ocupacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ella_pais` FOREIGN KEY (`ella_pais_nombre`) REFERENCES `pais` (`pais_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `folio`
--
ALTER TABLE `folio`
  ADD CONSTRAINT `folio_disponible_id` FOREIGN KEY (`disponible_id`) REFERENCES `disponible` (`disponible_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `folio_ella_id` FOREIGN KEY (`ella_id`) REFERENCES `ella` (`ella_id`),
  ADD CONSTRAINT `folio_el_id` FOREIGN KEY (`el_id`) REFERENCES `el` (`el_id`),
  ADD CONSTRAINT `folio_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`);

--
-- Constraints for table `platica`
--
ALTER TABLE `platica`
  ADD CONSTRAINT `platica_ciudad` FOREIGN KEY (`ciudad_nombre`) REFERENCES `ciudad` (`ciudad_nombre`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
