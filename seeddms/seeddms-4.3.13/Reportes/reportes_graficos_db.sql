-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 01-06-2015 a las 04:50:51
-- Versión del servidor: 5.6.12-log
-- Versión de PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `reportes_graficos_db`
--
CREATE DATABASE IF NOT EXISTS `reportes_graficos_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `reportes_graficos_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deudas`
--

CREATE TABLE IF NOT EXISTS `deudas` (
  `cod_deuda` int(11) NOT NULL AUTO_INCREMENT,
  `nom_deudor` varchar(20) NOT NULL,
  `ape_deudor` varchar(20) NOT NULL,
  `monto_deudor` int(11) NOT NULL,
  PRIMARY KEY (`cod_deuda`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `deudas`
--

INSERT INTO `deudas` (`cod_deuda`, `nom_deudor`, `ape_deudor`, `monto_deudor`) VALUES
(1, 'juan cristian', 'montaño', 300),
(2, 'andrea', 'Perez bustamante', 400),
(3, 'juan', 'morales', 200),
(4, 'Nesyi ', 'Daniela', 100),
(5, 'Limbert', 'Soliz', 500),
(6, 'Crisalida', 'Herrera', 560),
(7, 'Luiz Eduardo', 'Pizarro', 1000),
(8, 'Betty', 'Toribio', 670),
(9, 'jose', 'ramirez Hurtado', 590),
(10, 'Cristina', 'zapatero', 760),
(11, 'Oscar', 'cholico', 130),
(12, 'Iveth Marcela', 'Galeano', 1400);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
