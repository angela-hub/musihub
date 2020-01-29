-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `music`
--
CREATE DATABASE IF NOT EXISTS `music` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `music`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instrumentos`
--

DROP TABLE IF EXISTS `instrumentos`;
CREATE TABLE IF NOT EXISTS `instrumentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `referencia` text COLLATE utf8_spanish_ci NOT NULL,
  `distribuidor` text COLLATE utf8_spanish_ci NOT NULL,
  `tipo` text COLLATE utf8_spanish_ci NOT NULL,
  `precio` text COLLATE utf8_spanish_ci NOT NULL,
  `descuento` text COLLATE utf8_spanish_ci NOT NULL,
  `stockinicial` text COLLATE utf8_spanish_ci NOT NULL,
  `imagen` text COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `instrumentos`
--

INSERT INTO `instrumentos` (`id`, `nombre`, `referencia`, `distribuidor`, `tipo`, `precio`, `descuento`, `stockinicial`, `imagen`) VALUES(8, 'Tambor', '1', 'Gonalca', 'percusion', '279', 'No', '3', '79b87381e5cfd61ac34f4c0265afc873.jpeg');
INSERT INTO `instrumentos` (`id`, `nombre`, `referencia`, `distribuidor`, `tipo`, `precio`, `descuento`, `stockinicial`, `imagen`) VALUES(10, 'Guitarra', '9', 'Fender', 'cuerda', '125', 'No', '7', 'a7334fb2116f86a3246b41628e1a6805.jpeg');
INSERT INTO `instrumentos` (`id`, `nombre`, `referencia`, `distribuidor`, `tipo`, `precio`, `descuento`, `stockinicial`, `imagen`) VALUES(11, 'Flauta', '6', 'Moeck', 'viento', '239', 'No', '8', '720e27f5cf220ededa35fed65e404590.jpeg');
INSERT INTO `instrumentos` (`id`, `nombre`, `referencia`, `distribuidor`, `tipo`, `precio`, `descuento`, `stockinicial`, `imagen`) VALUES(13, 'Piano', '5', 'Thomann', 'percusion', '439', 'No', '9', 'f33b6efc8528ec01e269c95c828202e2.jpeg');
INSERT INTO `instrumentos` (`id`, `nombre`, `referencia`, `distribuidor`, `tipo`, `precio`, `descuento`, `stockinicial`, `imagen`) VALUES(14, 'Bombos', '9', 'Millenium', 'percusion', '29', 'No', '2', 'f2a919ee7d5dabfdbf63be6a2e7dfc4d.jpeg');
INSERT INTO `instrumentos` (`id`, `nombre`, `referencia`, `distribuidor`, `tipo`, `precio`, `descuento`, `stockinicial`, `imagen`) VALUES(15, 'Tuba', '8', 'Jupiter', 'viento', '2777', 'No', '1', '9c669fcbca2382b23fc71cf4bf93a7e5.jpeg');
INSERT INTO `instrumentos` (`id`, `nombre`, `referencia`, `distribuidor`, `tipo`, `precio`, `descuento`, `stockinicial`, `imagen`) VALUES(16, 'Clarinete', '1', 'Yamaha', 'viento', '3998', 'No', '6', 'd6c4e62210d78fdb28461e5c8aa9f172.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineasventas`
--

DROP TABLE IF EXISTS `lineasventas`;
CREATE TABLE IF NOT EXISTS `lineasventas` (
  `idVenta` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `idProducto` int(11) NOT NULL,
  `distribuidor` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `precio` float NOT NULL,
  `cantidad` int(11) NOT NULL,
  PRIMARY KEY (`idVenta`,`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` text COLLATE utf8_spanish_ci NOT NULL,
  `email` text COLLATE utf8_spanish_ci NOT NULL,
  `password` text COLLATE utf8_spanish_ci NOT NULL,
  `administrador` text COLLATE utf8_spanish_ci NOT NULL,
  `telefono` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha_alta` text COLLATE utf8_spanish_ci NOT NULL,
  `foto` text COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `email`, `password`, `administrador`, `telefono`, `fecha_alta`, `foto`) VALUES(25, 'Angela', 'Hidalgo', 'angela@gmail.com', 'b41cb62ec6767f2e41f9df7a2d161515', 'si', '654654657', '25-01-2020', '61d6bd2799dc64c1d1a467d8f67fe360.jpeg');
INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `email`, `password`, `administrador`, `telefono`, `fecha_alta`, `foto`) VALUES(27, 'Luis', 'ruiz', 'luis@gmail.com', 'b41cb62ec6767f2e41f9df7a2d161515', 'no', '633251469', '25-01-2020', 'c909741265d2d272ba365f9eddd9d47d.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

DROP TABLE IF EXISTS `ventas`;
CREATE TABLE IF NOT EXISTS `ventas` (
  `idVenta` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `total` float NOT NULL,
  `subtotal` float NOT NULL,
  `iva` float NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `direccion` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nombreTarjeta` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `numTarjeta` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idVenta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
COMMIT;

-- --------------------------------------------------------

--
-- Indices 
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `instrumentos`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `instrumentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
ALTER TABLE `lineasventas`
  ADD PRIMARY KEY (`idVenta`,`idProducto`);
  
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`idVenta`);