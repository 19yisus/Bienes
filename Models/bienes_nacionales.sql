-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 26-01-2021 a las 16:51:28
-- Versión del servidor: 5.7.24
-- Versión de PHP: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bienes_nacionales`
--
CREATE DATABASE IF NOT EXISTS `bienes_nacionales` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `bienes_nacionales`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bien`
--

CREATE TABLE `bien` (
  `bien_cod` char(7) COLLATE utf8_spanish_ci NOT NULL,
  `bien_des` varchar(90) COLLATE utf8_spanish_ci DEFAULT NULL,
  `bien_catalogo` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `bien_fecha_ingreso` date DEFAULT NULL,
  `bien_precio` decimal(12,2) DEFAULT NULL,
  `bien_depreciacion` decimal(12,2) DEFAULT NULL,
  `bien_estado` tinyint(1) DEFAULT NULL,
  `bien_color_cod` int(11) DEFAULT NULL,
  `bien_serial` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `bien_clasificacion_cod` int(11) DEFAULT NULL,
  `bien_link_bien` char(7) COLLATE utf8_spanish_ci DEFAULT NULL,
  `bien_mod_cod` int(11) DEFAULT NULL,
  `bien_sexo` varchar(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `bien_peso` decimal(5,2) DEFAULT NULL,
  `bien_anio` decimal(4,0) DEFAULT NULL,
  `bien_placa` varchar(6) COLLATE utf8_spanish_ci DEFAULT NULL,
  `bien_terreno` varchar(120) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos`
--

CREATE TABLE `cargos` (
  `car_cod` int(11) NOT NULL,
  `car_des` varchar(90) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `cat_cod` int(11) NOT NULL,
  `cat_des` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasificacion`
--

CREATE TABLE `clasificacion` (
  `cla_cod` int(11) NOT NULL,
  `cla_des` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cla_cat_cod` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colores`
--

CREATE TABLE `colores` (
  `color_cod` int(11) NOT NULL,
  `color_des` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobantes`
--

CREATE TABLE `comprobantes` (
  `com_cod` char(10) COLLATE utf8_spanish_ci NOT NULL,
  `com_tipo` varchar(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `com_estado` tinyint(1) DEFAULT NULL,
  `com_dep_user` int(11) NOT NULL,
  `com_dep_ant` int(11) DEFAULT NULL,
  `com_fecha_comprobante` date NOT NULL,
  `com_num_factura` decimal(8,0) DEFAULT NULL,
  `com_orden_compra` int(11) DEFAULT NULL,
  `com_observacion` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `com_origen` varchar(12) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dependencia`
--

CREATE TABLE `dependencia` (
  `dep_cod` int(11) NOT NULL,
  `dep_des` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `dep_nucleo_cod` int(11) NOT NULL,
  `dep_estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `mar_cod` int(11) NOT NULL,
  `mar_des` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `mar_categoria_cod` int(11) DEFAULT NULL,
  `mar_estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelos`
--

CREATE TABLE `modelos` (
  `mod_cod` int(11) NOT NULL,
  `mod_des` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `mod_marca_cod` int(11) DEFAULT NULL,
  `mod_estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimmientos`
--

CREATE TABLE `movimmientos` (
  `mov_com_incorporacion` char(10) COLLATE utf8_spanish_ci NOT NULL,
  `mov_com_reasignacion` char(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `mov_com_desincorporacion` char(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `mov_bien_cod` char(7) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nucleo`
--

CREATE TABLE `nucleo` (
  `nuc_cod` int(11) NOT NULL,
  `nuc_des` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `nuc_direccion` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nuc_codigo_postal` char(4) COLLATE utf8_spanish_ci NOT NULL,
  `nuc_estado` tinyint(1) NOT NULL,
  `nuc_tipo_nucleo` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `nuc_nucleo_principal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `per_cedula` char(8) COLLATE utf8_spanish_ci NOT NULL,
  `per_nombre` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `per_apellido` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `per_estado` tinyint(1) NOT NULL,
  `per_car_cod` int(11) NOT NULL,
  `per_dep_cod` int(11) NOT NULL,
  `per_telefono` char(11) COLLATE utf8_spanish_ci DEFAULT NULL,
  `per_correo` varchar(120) COLLATE utf8_spanish_ci DEFAULT NULL,
  `per_direccion` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL,
  `per_desde` date NOT NULL,
  `per_hasta` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `user_id` char(8) COLLATE utf8_spanish_ci NOT NULL,
  `user_clave` varchar(70) COLLATE utf8_spanish_ci NOT NULL,
  `user_nombre` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `user_estado` tinyint(1) NOT NULL,
  `user_pregunta1` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `user_respuesta1` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `user_pregunta2` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `user_respuesta2` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `user_permisos` int(11) NOT NULL,
  `user_photo` varchar(60) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`user_id`, `user_clave`, `user_nombre`, `user_estado`, `user_pregunta1`, `user_respuesta1`, `user_pregunta2`, `user_respuesta2`, `user_permisos`, `user_photo`) VALUES
('27132642', '$2y$10$31f.2HexBrc1fMv8nAuMcuQG//w/Qa9kARfEt07MJdQtEAaH80ip6', 'Admin', 1, 'pregunta 1', 'respuesta 1', 'pregunta 2', 'respuesta 2', 5, 'Views/Img/Default/user.png');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bien`
--
ALTER TABLE `bien`
  ADD PRIMARY KEY (`bien_cod`),
  ADD KEY `bien_clasificacion_cod` (`bien_clasificacion_cod`),
  ADD KEY `bien_mod_cod` (`bien_mod_cod`),
  ADD KEY `bien_color_cod` (`bien_color_cod`);

--
-- Indices de la tabla `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`car_cod`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`cat_cod`);

--
-- Indices de la tabla `clasificacion`
--
ALTER TABLE `clasificacion`
  ADD PRIMARY KEY (`cla_cod`),
  ADD KEY `cla_cat_cod` (`cla_cat_cod`);

--
-- Indices de la tabla `colores`
--
ALTER TABLE `colores`
  ADD PRIMARY KEY (`color_cod`);

--
-- Indices de la tabla `comprobantes`
--
ALTER TABLE `comprobantes`
  ADD PRIMARY KEY (`com_cod`),
  ADD KEY `com_dep_user` (`com_dep_user`),
  ADD KEY `com_dep_ant` (`com_dep_ant`);

--
-- Indices de la tabla `dependencia`
--
ALTER TABLE `dependencia`
  ADD PRIMARY KEY (`dep_cod`),
  ADD KEY `dep_nucleo_cod` (`dep_nucleo_cod`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`mar_cod`),
  ADD KEY `mar_categoria_cod` (`mar_categoria_cod`);

--
-- Indices de la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`mod_cod`),
  ADD KEY `mod_marca_cod` (`mod_marca_cod`);

--
-- Indices de la tabla `movimmientos`
--
ALTER TABLE `movimmientos`
  ADD KEY `mov_com_incorporacion` (`mov_com_incorporacion`),
  ADD KEY `mov_com_reasignacion` (`mov_com_reasignacion`),
  ADD KEY `mov_com_desincorporacion` (`mov_com_desincorporacion`),
  ADD KEY `mov_bien_cod` (`mov_bien_cod`);

--
-- Indices de la tabla `nucleo`
--
ALTER TABLE `nucleo`
  ADD PRIMARY KEY (`nuc_cod`),
  ADD KEY `nuc_nucleo_principal` (`nuc_nucleo_principal`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`per_cedula`),
  ADD KEY `per_car_cod` (`per_car_cod`),
  ADD KEY `per_dep_cod` (`per_dep_cod`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`user_id`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bien`
--
ALTER TABLE `bien`
  ADD CONSTRAINT `bien_ibfk_1` FOREIGN KEY (`bien_clasificacion_cod`) REFERENCES `clasificacion` (`cla_cod`) ON UPDATE CASCADE,
  ADD CONSTRAINT `bien_ibfk_2` FOREIGN KEY (`bien_mod_cod`) REFERENCES `modelos` (`mod_cod`) ON UPDATE CASCADE,
  ADD CONSTRAINT `bien_ibfk_3` FOREIGN KEY (`bien_color_cod`) REFERENCES `colores` (`color_cod`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `clasificacion`
--
ALTER TABLE `clasificacion`
  ADD CONSTRAINT `clasificacion_ibfk_1` FOREIGN KEY (`cla_cat_cod`) REFERENCES `categoria` (`cat_cod`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `comprobantes`
--
ALTER TABLE `comprobantes`
  ADD CONSTRAINT `comprobantes_ibfk_1` FOREIGN KEY (`com_dep_user`) REFERENCES `dependencia` (`dep_cod`) ON UPDATE CASCADE,
  ADD CONSTRAINT `comprobantes_ibfk_2` FOREIGN KEY (`com_dep_ant`) REFERENCES `dependencia` (`dep_cod`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `dependencia`
--
ALTER TABLE `dependencia`
  ADD CONSTRAINT `dependencia_ibfk_1` FOREIGN KEY (`dep_nucleo_cod`) REFERENCES `nucleo` (`nuc_cod`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD CONSTRAINT `marcas_ibfk_1` FOREIGN KEY (`mar_categoria_cod`) REFERENCES `categoria` (`cat_cod`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD CONSTRAINT `modelos_ibfk_1` FOREIGN KEY (`mod_marca_cod`) REFERENCES `marcas` (`mar_cod`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `movimmientos`
--
ALTER TABLE `movimmientos`
  ADD CONSTRAINT `movimmientos_ibfk_1` FOREIGN KEY (`mov_com_incorporacion`) REFERENCES `comprobantes` (`com_cod`) ON UPDATE CASCADE,
  ADD CONSTRAINT `movimmientos_ibfk_2` FOREIGN KEY (`mov_com_reasignacion`) REFERENCES `comprobantes` (`com_cod`) ON UPDATE CASCADE,
  ADD CONSTRAINT `movimmientos_ibfk_3` FOREIGN KEY (`mov_com_desincorporacion`) REFERENCES `comprobantes` (`com_cod`) ON UPDATE CASCADE,
  ADD CONSTRAINT `movimmientos_ibfk_4` FOREIGN KEY (`mov_bien_cod`) REFERENCES `bien` (`bien_cod`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `nucleo`
--
ALTER TABLE `nucleo`
  ADD CONSTRAINT `nucleo_ibfk_1` FOREIGN KEY (`nuc_nucleo_principal`) REFERENCES `nucleo` (`nuc_cod`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `personas`
--
ALTER TABLE `personas`
  ADD CONSTRAINT `personas_ibfk_1` FOREIGN KEY (`per_car_cod`) REFERENCES `cargos` (`car_cod`) ON UPDATE CASCADE,
  ADD CONSTRAINT `personas_ibfk_2` FOREIGN KEY (`per_dep_cod`) REFERENCES `dependencia` (`dep_cod`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
