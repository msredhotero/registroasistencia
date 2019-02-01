-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-01-2019 a las 17:50:10
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `riderz`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbarchivos`
--

CREATE TABLE IF NOT EXISTS `dbarchivos` (
`idarchivo` int(11) NOT NULL,
  `refclientes` int(11) NOT NULL,
  `refcategorias` int(11) NOT NULL,
  `anio` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `token` varchar(36) NOT NULL,
  `type` varchar(45) DEFAULT NULL,
  `observacion` varchar(150) DEFAULT NULL,
  `imagen` varchar(149) DEFAULT NULL,
  `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `dbarchivos`
--

INSERT INTO `dbarchivos` (`idarchivo`, `refclientes`, `refcategorias`, `anio`, `mes`, `token`, `type`, `observacion`, `imagen`, `fechacreacion`) VALUES
(1, 3, 1, 2018, 8, 'F77D3BB4-1CC5-4DD4-B3C9-8876F008B605', 'application/pdf', '', 'aaaa3.pdf', '2018-09-10 06:13:47'),
(2, 3, 1, 2018, 9, '25B963E1-AEC6-438F-A410-BFEE6261FF2F', 'application/pdf', '', '10012018109518_72969.pdf', '2018-09-17 10:14:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbclientes`
--

CREATE TABLE IF NOT EXISTS `dbclientes` (
`idcliente` int(11) NOT NULL,
  `apellido` varchar(120) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(120) COLLATE utf8_spanish2_ci NOT NULL,
  `cuit` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `direccion` varchar(180) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `telefono` varchar(25) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `celular` varchar(25) COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `dbclientes`
--

INSERT INTO `dbclientes` (`idcliente`, `apellido`, `nombre`, `cuit`, `direccion`, `telefono`, `celular`, `email`) VALUES
(3, 'Acciarri', 'Eduardo', '20147249978', 'Carreras 575', '03465490107', '3465554433', 'accairri@hotmail.com'),
(4, 'apellido1', 'nombre1', '11111111111', 'direccion 001', '03465111111', '0346515101111', 'email01@probando.com'),
(5, 'apellido2', 'Nombre2', '22222222222', '', '03465222222', '0346515222222', 'wmail2@probando2.com'),
(6, 'Apellido3', 'Nombre 3', '33333333333', 'direccion 3', '', '0346515333333', 'probando3@gmail.com'),
(7, 'apellido4', 'nombre4', '44444444444', 'direccion 004', '03465444444', '', 'email4@gmail.com'),
(8, 'Apellido5', 'Nombre5', '55555555555', 'direccion 5', '03465555555', '0346515555555', 'email5'),
(9, 'Apellido6 ', 'Nombre6', '66666666666', 'direccion 6', '03465666666', '0346515666666', 'email6@gmail'),
(10, 'Apellido7', 'nombre7', 'cuit', 'direccion 7', '03465777777', '0346515777777', 'email7@yahoo.com'),
(11, 'asdasd', 'asdasd', '22325569871', '', '', '2342352', 'msredhotero@msn.com'),
(12, 'asd', 'asdasd', '22325569871', '', '', '2342352', 'msredhotero@msn.com'),
(13, 'asdasd', 'asdasd', '22325569871', '', '', '2342352', 'msredhotero@msn.com'),
(14, 'safsdf', 'sdfsdf', '22325569871', '', '', '2342352', 'aranzazu@aif.org.ar'),
(15, 'asdasd', 'sadasd', '23325569871', '', '', '2342352', 'aranjuez@aif.org.ar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbusuarios`
--

CREATE TABLE IF NOT EXISTS `dbusuarios` (
`idusuario` int(11) NOT NULL,
  `usuario` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `refroles` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nombrecompleto` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `activo` bit(1) DEFAULT b'0',
  `refclientes` int(11) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `dbusuarios`
--

INSERT INTO `dbusuarios` (`idusuario`, `usuario`, `password`, `refroles`, `email`, `nombrecompleto`, `activo`, `refclientes`) VALUES
(1, 'msredhortero', 'marcos', 1, 'msredhotero@msn.com', 'Saupurein Marcos', b'1', NULL),
(6, 'guilleW', 'guille83', 2, 'weeyewyder@gmail.com', 'Guillermo Wyder', b'1', 0),
(7, 'apellido1 nombre1', 'apellido1', 3, 'email01@probando.com', 'apellido1 nombre1', b'1', 4),
(8, 'apellido2 Nombre2', 'probando2', 3, 'wmail2@probando2.com', 'apellido2 Nombre2', b'1', 5),
(9, 'Apellido3 Nombre 3', 'probando3', 3, 'probando3@gmail.com', 'Apellido3 Nombre 3', b'1', 6),
(10, 'apellido4 nombre4', 'probando4', 3, 'email4@gmail.com', 'apellido4 nombre4', b'1', 7),
(11, 'Apellido5 Nombre5', 'probando5', 3, 'email5', 'Apellido5 Nombre5', b'1', 8),
(12, 'Apellido6  Nombre6', 'probando6', 3, 'email6@gmail', 'Apellido6  Nombre6', b'1', 9),
(13, 'Apellido7 nombre7', 'probando7', 3, 'email7@yahoo.com', 'Apellido7 nombre7', b'1', 10),
(14, 'asdasd asdasd', 'asdq3', 3, 'msredhotero@msn.com', 'asdasd asdasd', b'1', 11),
(15, 'asd asdasd', 'asdasd', 3, 'msredhotero@msn.com', 'asd asdasd', b'1', 12),
(16, 'asdasd asdasd', 'asdasd', 3, 'msredhotero@msn.com', 'asdasd asdasd', b'1', 13),
(17, 'safsdf sdfsdf', 'asdwqe', 3, 'aranzazu@aif.org.ar', 'safsdf sdfsdf', b'1', 14),
(18, 'asdasd sadasd', 'asdasd', 3, 'aranjuez@aif.org.ar', 'asdasd sadasd', b'1', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `images`
--

CREATE TABLE IF NOT EXISTS `images` (
`idfoto` int(11) NOT NULL,
  `refproyecto` int(11) NOT NULL,
  `refuser` int(11) NOT NULL,
  `imagen` varchar(149) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `principal` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `predio_menu`
--

CREATE TABLE IF NOT EXISTS `predio_menu` (
  `idmenu` int(11) NOT NULL,
  `url` varchar(65) COLLATE utf8_spanish_ci NOT NULL,
  `icono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Orden` smallint(6) DEFAULT NULL,
  `hover` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `permiso` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `administracion` bit(1) DEFAULT NULL,
  `torneo` bit(1) DEFAULT NULL,
  `reportes` bit(1) DEFAULT NULL,
  `grupo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `predio_menu`
--

INSERT INTO `predio_menu` (`idmenu`, `url`, `icono`, `nombre`, `Orden`, `hover`, `permiso`, `administracion`, `torneo`, `reportes`, `grupo`) VALUES
(13, '../index.php', 'dashboard', 'Dashboard', 1, NULL, 'Administrador, Arbitro, Empleado', b'0', b'1', b'0', 0),
(19, '../clientes/', 'people_outline', 'Clientes', 2, NULL, 'Administrador, Empleado', b'1', b'0', b'0', 0),
(20, '../usuarios/', 'account_circle', 'Usuarios', 12, NULL, 'Administrador, Empleado', b'1', b'0', b'0', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcategorias`
--

CREATE TABLE IF NOT EXISTS `tbcategorias` (
`idcategoria` int(11) NOT NULL,
  `categoria` varchar(50) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tbcategorias`
--

INSERT INTO `tbcategorias` (`idcategoria`, `categoria`) VALUES
(1, 'Impuestos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbconfiguracion`
--

CREATE TABLE IF NOT EXISTS `tbconfiguracion` (
`idconfiguracion` int(11) NOT NULL,
  `razonsocial` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `empresa` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `sistema` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(120) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tbconfiguracion`
--

INSERT INTO `tbconfiguracion` (`idconfiguracion`, `razonsocial`, `empresa`, `sistema`, `direccion`, `telefono`, `email`) VALUES
(1, 'RIDERZ', 'RIDERZ', 'RIDERZ', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbroles`
--

CREATE TABLE IF NOT EXISTS `tbroles` (
`idrol` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `activo` bit(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbroles`
--

INSERT INTO `tbroles` (`idrol`, `descripcion`, `activo`) VALUES
(1, 'Administrador', b'1'),
(2, 'Empleado', b'1'),
(3, 'Cliente', b'1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `dbarchivos`
--
ALTER TABLE `dbarchivos`
 ADD PRIMARY KEY (`idarchivo`);

--
-- Indices de la tabla `dbclientes`
--
ALTER TABLE `dbclientes`
 ADD PRIMARY KEY (`idcliente`);

--
-- Indices de la tabla `dbusuarios`
--
ALTER TABLE `dbusuarios`
 ADD PRIMARY KEY (`idusuario`), ADD KEY `fk_dbusuarios_tbroles1_idx` (`refroles`);

--
-- Indices de la tabla `images`
--
ALTER TABLE `images`
 ADD PRIMARY KEY (`idfoto`);

--
-- Indices de la tabla `predio_menu`
--
ALTER TABLE `predio_menu`
 ADD PRIMARY KEY (`idmenu`);

--
-- Indices de la tabla `tbcategorias`
--
ALTER TABLE `tbcategorias`
 ADD PRIMARY KEY (`idcategoria`);

--
-- Indices de la tabla `tbconfiguracion`
--
ALTER TABLE `tbconfiguracion`
 ADD PRIMARY KEY (`idconfiguracion`);

--
-- Indices de la tabla `tbroles`
--
ALTER TABLE `tbroles`
 ADD PRIMARY KEY (`idrol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dbarchivos`
--
ALTER TABLE `dbarchivos`
MODIFY `idarchivo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `dbclientes`
--
ALTER TABLE `dbclientes`
MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT de la tabla `dbusuarios`
--
ALTER TABLE `dbusuarios`
MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT de la tabla `images`
--
ALTER TABLE `images`
MODIFY `idfoto` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tbcategorias`
--
ALTER TABLE `tbcategorias`
MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tbconfiguracion`
--
ALTER TABLE `tbconfiguracion`
MODIFY `idconfiguracion` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tbroles`
--
ALTER TABLE `tbroles`
MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
