-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-05-2017 a las 16:47:36
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
  `clau` varchar(32) NOT NULL,
  `facebook_id` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `client`
--

INSERT INTO `client` (`id`, `email`, `pass`, `nom`, `cif`, `municipi`, `clau`, `facebook_id`) VALUES
(1, 'prova@prova.com', '81dc9bdb52d04dc20036dbd8313ed055', 'prova', '0000', 'Subirats', '8f62f5ffe817a27585cf8552d7ff4535', NULL),
(2, 'aaa@aaa.aaa', '81dc9bdb52d04dc20036dbd8313ed055', 'Client1', '487878', 'Avinyonet', '2b652b252c775d3c0f66a5e463005295', NULL),
(4, 'w2.jferre@infomila.info', '81dc9bdb52d04dc20036dbd8313ed055', 'Joan', '787878787', 'Subirats', '03f29a4eb9dc3b263ea8328e61d684bd', NULL);

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

--
-- Volcado de datos para la tabla `comanda`
--

INSERT INTO `comanda` (`id`, `data`, `preu_total`, `client_id`, `finalitzada`) VALUES
(2, '2017-04-30 19:52:17', '20.00', 1, 0),
(3, '2017-05-06 16:32:55', '39.00', 4, 0);

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

--
-- Volcado de datos para la tabla `detall`
--

INSERT INTO `detall` (`id`, `producte_id`, `comanda_id`, `quantitat`, `preu`) VALUES
(1, 1, 2, 4, '5.00'),
(2, 1, 3, 6, '5.00'),
(3, 4, 3, 9, '1.00');

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
  `productor_id` int(11) NOT NULL,
  `eliminat` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producte`
--

INSERT INTO `producte` (`id`, `nom`, `descripcio`, `preu`, `preu_final`, `imatge`, `productor_id`, `eliminat`) VALUES
(1, 'Vi blanc', 'Vi blanc', '5.00', '6.00', '5904d8150fb6d.jpg', 1, 0),
(2, 'vi 2', 'sddasdasdasd', '5.00', '6.00', '590b8d4cb15c0.jpg', 1, 0),
(3, 'vi 3', 'bvbvbvbvbv', '9.00', '10.00', '590b8d62a72b0.jpg', 1, 0),
(4, 'brick de vi', 'brick de vi', '1.00', '2.00', '590b910511517.jpg', 2, 0);

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
  `actiu` tinyint(1) NOT NULL DEFAULT '0',
  `eliminat` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productor`
--

INSERT INTO `productor` (`id`, `nom`, `email`, `do`, `direccio`, `lat`, `lng`, `imatge`, `actiu`, `eliminat`) VALUES
(1, 'Productor de Berga', 'hola@qwe.zxc', 'Vi de taula', 'Ronda Moreta, 20, 08600 Berga, Barcelona', 42.1015207, 1.845347, '58ff5ce41b443.jpg', 1, 0),
(2, 'Don simon', 'donsimon@yahoo.com', 'Vi de taula', 'Alguaire', 41.7294516, 0.554149, '5909fe8c34748.jpg', 1, 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `comanda`
--
ALTER TABLE `comanda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `detall`
--
ALTER TABLE `detall`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `producte`
--
ALTER TABLE `producte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `productor`
--
ALTER TABLE `productor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
  ADD CONSTRAINT `detall_ibfk_1` FOREIGN KEY (`producte_id`) REFERENCES `producte` (`id`),
  ADD CONSTRAINT `detall_ibfk_2` FOREIGN KEY (`comanda_id`) REFERENCES `comanda` (`id`);

--
-- Filtros para la tabla `producte`
--
ALTER TABLE `producte`
  ADD CONSTRAINT `producte_ibfk_1` FOREIGN KEY (`productor_id`) REFERENCES `productor` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
