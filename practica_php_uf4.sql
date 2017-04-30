-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-04-2017 a las 19:41:31
-- Versión del servidor: 5.6.15-log
-- Versión de PHP: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `practica_php_uf4`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `email` varchar(64) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `nom` varchar(64) NOT NULL,
  `cif` varchar(10) NOT NULL,
  `municipi` varchar(32) NOT NULL,
  `clau` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comanda`
--

CREATE TABLE `comanda` (
  `id` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `preu_total` decimal(10,2) NOT NULL,
  `client_id` int(11) NOT NULL,
  `finalitzada` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detall`
--

CREATE TABLE `detall` (
  `id` int(11) NOT NULL,
  `producte_id` int(11) NOT NULL,
  `comanda_id` int(11) NOT NULL,
  `quantitat` int(11) NOT NULL,
  `preu` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producte`
--

CREATE TABLE `producte` (
  `id` int(11) NOT NULL,
  `nom` varchar(32) NOT NULL,
  `descripcio` text NOT NULL,
  `preu` decimal(10,2) NOT NULL,
  `preu_final` decimal(10,2) NOT NULL,
  `imatge` varchar(32) NOT NULL,
  `productor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producte`
--

INSERT INTO `producte` (`id`, `nom`, `descripcio`, `preu`, `preu_final`, `imatge`, `productor_id`) VALUES
(1, 'Vi blanc', 'Vi blanc', '5.00', '6.00', '5904d8150fb6d.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productor`
--

CREATE TABLE `productor` (
  `id` int(11) NOT NULL,
  `nom` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `do` varchar(32) NOT NULL,
  `direccio` varchar(256) NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `imatge` varchar(32) NOT NULL,
  `actiu` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productor`
--

INSERT INTO `productor` (`id`, `nom`, `email`, `do`, `direccio`, `lat`, `lng`, `imatge`, `actiu`) VALUES
(1, 'Productor de Berga', 'hola@qwe.zxc', 'Vi de taula', 'Ronda Moreta, 20, 08600 Berga, Barcelona', 42.1015207, 1.845347, '58ff5ce41b443.jpg', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `comanda`
--
ALTER TABLE `comanda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuari_id` (`client_id`);

--
-- Indices de la tabla `detall`
--
ALTER TABLE `detall`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producte_id` (`producte_id`),
  ADD KEY `comanda_id` (`comanda_id`);

--
-- Indices de la tabla `producte`
--
ALTER TABLE `producte`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productor_id` (`productor_id`);

--
-- Indices de la tabla `productor`
--
ALTER TABLE `productor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `comanda`
--
ALTER TABLE `comanda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `detall`
--
ALTER TABLE `detall`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `producte`
--
ALTER TABLE `producte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `productor`
--
ALTER TABLE `productor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comanda`
--
ALTER TABLE `comanda`
  ADD CONSTRAINT `comanda_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`);

--
-- Filtros para la tabla `detall`
--
ALTER TABLE `detall`
  ADD CONSTRAINT `detall_ibfk_2` FOREIGN KEY (`comanda_id`) REFERENCES `comanda` (`id`),
  ADD CONSTRAINT `detall_ibfk_1` FOREIGN KEY (`producte_id`) REFERENCES `producte` (`id`);

--
-- Filtros para la tabla `producte`
--
ALTER TABLE `producte`
  ADD CONSTRAINT `producte_ibfk_1` FOREIGN KEY (`productor_id`) REFERENCES `productor` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
