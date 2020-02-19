-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-02-2020 a las 19:37:46
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

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
CREATE TABLE `instrumentos` (
  `id` int(11) NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `referencia` text COLLATE utf8_spanish_ci NOT NULL,
  `distribuidor` text COLLATE utf8_spanish_ci NOT NULL,
  `tipo` text COLLATE utf8_spanish_ci NOT NULL,
  `precio` text COLLATE utf8_spanish_ci NOT NULL,
  `descuento` text COLLATE utf8_spanish_ci NOT NULL,
  `stockinicial` text COLLATE utf8_spanish_ci NOT NULL,
  `imagen` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `instrumentos`
--

INSERT INTO `instrumentos` (`id`, `nombre`, `referencia`, `distribuidor`, `tipo`, `precio`, `descuento`, `stockinicial`, `imagen`) VALUES
(8, 'Tambor', '1', 'Gonalca', 'percusion', '279', 'No', '8', '79b87381e5cfd61ac34f4c0265afc873.jpeg'),
(10, 'Guitarra', '9', 'Fender', 'cuerda', '125', 'No', '3', 'a7334fb2116f86a3246b41628e1a6805.jpeg'),
(11, 'Flauta', '6', 'Moeck', 'viento', '239', 'No', '13', '720e27f5cf220ededa35fed65e404590.jpeg'),
(13, 'Piano', '5', 'Thomann', 'percusion', '439', 'No', '7', 'f33b6efc8528ec01e269c95c828202e2.jpeg'),
(14, 'Bombos', '7', 'Millenium', 'percusion', '29', 'No', '7', 'f2a919ee7d5dabfdbf63be6a2e7dfc4d.jpeg'),
(15, 'Tuba', '8', 'Jupiter', 'viento', '2777', 'No', '1', '9c669fcbca2382b23fc71cf4bf93a7e5.jpeg'),
(16, 'Clarinete', '15', 'Yamaha', 'viento', '3998', 'No', '6', 'd6c4e62210d78fdb28461e5c8aa9f172.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

DROP TABLE IF EXISTS `pago`;
CREATE TABLE `pago` (
  `titularcredit` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tarjeta_completa` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `fechaexp` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `codigocv` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `idpago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`titularcredit`, `tarjeta_completa`, `fechaexp`, `codigocv`, `idpago`) VALUES
('angela  hidalgo', 'b8d5cc01170fea5cd15981da0070775f453f9652792cfbff9ea3ae6f0822a801', '19/02/2020', 'a665a45920', 14),
('angela  hidalgo', '23cb3108599d109ba53f99960120af75a2d88c3871a55eacc352ff70a5da05a2', '24/12/2020', 'a665a45920', 15),
('angela  hidalgo', '7bd57ba1110413e35bef8d3b12f71c9caa0d442f3fb071c82301824367a4aede', '20/02/2020', 'a665a45920', 16),
('angela  hidalgo', '97f9d067be46a878e05f516e4344199b7c56a520fb4caad3307c52a608564991', '20/02/2020', 'a665a45920', 17),
('angela  hidalgo', '23cb3108599d109ba53f99960120af75a2d88c3871a55eacc352ff70a5da05a2', '21/02/2020', 'a665a45920', 18),
('angela  hidalgo', '223a8897603464774bfe2e2a1f39b67a8aac5af6c517ec32edb16ae12c5ecf96', '21/02/2020', 'a665a45920', 19),
('angela  hidalgo', 'b78ee679272b10bbd04700e7557e3c583ae5a009d474c279100f1ac2e9d2f4f6', '20/02/2020', 'a665a45920', 20),
('angela  hidalgo', 'b62d6f2ea0d97444d90d103c1acf4b4205c2b07e5f6e14e279c6ac10ecff43d5', '28/02/2020', 'a665a45920', 21),
('angela  hidalgo', 'cd8ce184a9b7f858698fea09e1a12d72c73bba47006cbdb17413bdcd65490b90', '20/02/2020', 'a665a45920', 22),
('angela  hidalgo', 'b62d6f2ea0d97444d90d103c1acf4b4205c2b07e5f6e14e279c6ac10ecff43d5', '28/02/2020', 'dbb1ded63b', 23),
('angela  hidalgo', 'b62d6f2ea0d97444d90d103c1acf4b4205c2b07e5f6e14e279c6ac10ecff43d5', '29/02/2020', 'a665a45920', 24),
('angela  hidalgo', 'b62d6f2ea0d97444d90d103c1acf4b4205c2b07e5f6e14e279c6ac10ecff43d5', '27/02/2020', '114bd151f8', 25),
('angela  hidalgo', 'b62d6f2ea0d97444d90d103c1acf4b4205c2b07e5f6e14e279c6ac10ecff43d5', '27/02/2020', 'a665a45920', 26),
('angela  hidalgo', '39f692072dac0eb627110bded3644a9a44e441ee5a4c0b6f18e8b62bb3a53440', '28/02/2020', '114bd151f8', 27),
('angela  hidalgo', 'b62d6f2ea0d97444d90d103c1acf4b4205c2b07e5f6e14e279c6ac10ecff43d5', '27/02/2020', 'a665a45920', 28),
('angela  hidalgo', 'b62d6f2ea0d97444d90d103c1acf4b4205c2b07e5f6e14e279c6ac10ecff43d5', '27/02/2020', 'a665a45920', 29),
('angela  hidalgo', 'b62d6f2ea0d97444d90d103c1acf4b4205c2b07e5f6e14e279c6ac10ecff43d5', '27/02/2020', 'a665a45920', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` text COLLATE utf8_spanish_ci NOT NULL,
  `email` text COLLATE utf8_spanish_ci NOT NULL,
  `password` text COLLATE utf8_spanish_ci NOT NULL,
  `administrador` text COLLATE utf8_spanish_ci NOT NULL,
  `telefono` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha_alta` text COLLATE utf8_spanish_ci NOT NULL,
  `foto` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `email`, `password`, `administrador`, `telefono`, `fecha_alta`, `foto`) VALUES
(25, 'Angela', 'Hidalgo', 'angela@gmail.com', 'b41cb62ec6767f2e41f9df7a2d161515', 'si', '654654657', '25-01-2020', '61d6bd2799dc64c1d1a467d8f67fe360.jpeg'),
(27, 'Luis', 'ruiz', 'luis@gmail.com', 'b41cb62ec6767f2e41f9df7a2d161515', 'no', '633251469', '25-01-2020', 'c909741265d2d272ba365f9eddd9d47d.jpeg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `instrumentos`
--
ALTER TABLE `instrumentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`idpago`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `instrumentos`
--
ALTER TABLE `instrumentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `idpago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
