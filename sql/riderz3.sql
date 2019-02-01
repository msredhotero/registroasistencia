-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-01-2019 a las 18:44:21
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
-- Estructura de tabla para la tabla `dbactivacionusuarios`
--

CREATE TABLE IF NOT EXISTS `dbactivacionusuarios` (
`idactivacionusuario` int(11) NOT NULL,
  `refusuarios` int(11) NOT NULL,
  `token` varchar(36) COLLATE utf8_spanish2_ci NOT NULL,
  `vigenciadesde` date NOT NULL,
  `vigenciahasta` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `dbarchivos`
--

INSERT INTO `dbarchivos` (`idarchivo`, `refclientes`, `refcategorias`, `anio`, `mes`, `token`, `type`, `observacion`, `imagen`, `fechacreacion`) VALUES
(8, 24, 1, 2019, 1, 'F770B990-5BAD-4ECD-B089-AF3CBFB621F1', 'image/png', '', '44657128_248808569139147_5634426089334898688_n.png', '2019-01-31 16:16:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbclientes`
--

CREATE TABLE IF NOT EXISTS `dbclientes` (
`idcliente` int(11) NOT NULL,
  `apellido` varchar(120) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(120) COLLATE utf8_spanish2_ci NOT NULL,
  `cuit` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `telefono` varchar(25) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `celular` varchar(25) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `email` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `aceptaterminos` bit(1) NOT NULL DEFAULT b'0',
  `subscripcion` bit(1) NOT NULL DEFAULT b'0',
  `activo` bit(1) DEFAULT b'0'
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `dbclientes`
--

INSERT INTO `dbclientes` (`idcliente`, `apellido`, `nombre`, `cuit`, `telefono`, `celular`, `email`, `aceptaterminos`, `subscripcion`, `activo`) VALUES
(24, 'SAFAR', 'Marcos Saupurein', '31553466', '1698564654', '', 'campochico@aif.org.ar', b'1', b'0', b'1'),
(26, 'ropaldo', 'daniela', '984986', '', '', 'ropaldo@gmail.com', b'1', b'1', b'1');

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `dbusuarios`
--

INSERT INTO `dbusuarios` (`idusuario`, `usuario`, `password`, `refroles`, `email`, `nombrecompleto`, `activo`, `refclientes`) VALUES
(1, 'msredhortero', 'marcos', 1, 'msredhotero@msn.com', 'Saupurein Marcos', b'1', NULL),
(19, 'SAFAR Marcos Saupurein', 'marcos', 3, 'campochico@aif.org.ar', 'SAFAR Marcos Saupurein', b'1', 24),
(20, 'ropaldo daniela', '123456', 3, 'ropaldo@gmail.com', 'ropaldo daniela', b'0', 26);

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
(0, '../categorias/', 'filter_list', 'Categorias', 3, NULL, 'Administrador, Empleado', b'1', b'1', b'1', 0),
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tbcategorias`
--

INSERT INTO `tbcategorias` (`idcategoria`, `categoria`) VALUES
(1, 'Impuestos'),
(2, 'Consultoria');

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
-- Indices de la tabla `dbactivacionusuarios`
--
ALTER TABLE `dbactivacionusuarios`
 ADD PRIMARY KEY (`idactivacionusuario`);

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
-- AUTO_INCREMENT de la tabla `dbactivacionusuarios`
--
ALTER TABLE `dbactivacionusuarios`
MODIFY `idactivacionusuario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `dbarchivos`
--
ALTER TABLE `dbarchivos`
MODIFY `idarchivo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `dbclientes`
--
ALTER TABLE `dbclientes`
MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT de la tabla `dbusuarios`
--
ALTER TABLE `dbusuarios`
MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT de la tabla `images`
--
ALTER TABLE `images`
MODIFY `idfoto` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tbcategorias`
--
ALTER TABLE `tbcategorias`
MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
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
