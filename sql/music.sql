SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- Base de datos: `music`
CREATE DATABASE IF NOT EXISTS `music` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `music`;

-- tabla `usuarios`
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
  `imagen` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `email`, `password`, `administrador`, `telefono`, `fecha_alta`, `imagen`) VALUES 
('1', 'admin', 'admin' ,'admin@admin.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'si', '658988745', '08/01/2020', ''),
('2', 'pepe', 'pepe' ,'pepe@pepe.com', '7c9e7c1494b2684ab7c19d6aff737e460fa9e98d5a234da1310c97ddf5691834', 'no', '632567895', '08/01/2020', '');


-- Indices 
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
