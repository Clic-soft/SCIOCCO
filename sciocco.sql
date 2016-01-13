-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-01-2016 a las 17:00:08
-- Versión del servidor: 5.5.27
-- Versión de PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `sciocco`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banners`
--

CREATE TABLE IF NOT EXISTS `banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `archivo` varchar(40) NOT NULL,
  `ext` varchar(3) NOT NULL,
  `url` varchar(50) NOT NULL,
  `tipo_apertura` varchar(10) NOT NULL,
  `tipo` int(11) NOT NULL COMMENT '1 banner, 2 :slide',
  `estado` int(11) NOT NULL DEFAULT '1' COMMENT '1:activo, 2 :inactivo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_producto`
--

CREATE TABLE IF NOT EXISTS `categoria_producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_cat` varchar(50) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1' COMMENT '1:activo,2:inactivo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_doc` int(11) NOT NULL,
  `num_doc` varchar(15) NOT NULL,
  `nombres` varchar(40) NOT NULL,
  `apellidos` varchar(40) NOT NULL,
  `fecha_nac` date NOT NULL,
  `fecha_reg` datetime NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `celular` varchar(15) NOT NULL,
  `direccion` varchar(40) NOT NULL,
  `email` varchar(30) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `cod_pais` int(11) NOT NULL,
  `cod_depto` int(11) NOT NULL,
  `cod_ciudad` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE IF NOT EXISTS `empresa` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `nit` int(15) NOT NULL,
  `razon_social` varchar(40) NOT NULL,
  `rep_comercial` varchar(40) NOT NULL,
  `num_contacto` int(15) NOT NULL,
  `celular` int(15) NOT NULL,
  `direccion` varchar(40) NOT NULL,
  `email_contacto` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id`, `nit`, `razon_social`, `rep_comercial`, `num_contacto`, `celular`, `direccion`, `email_contacto`) VALUES
(1, 123456789, 'Sciocco Lingerie', 'Elias Singer', 1234567, 300, 'Calle 61N Nº 3B bis- 65 Apto 303', 'elias.singer73@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `faqs`
--

CREATE TABLE IF NOT EXISTS `faqs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pregunta` varchar(100) NOT NULL,
  `respuesta` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_empresa`
--

CREATE TABLE IF NOT EXISTS `info_empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `info_empresa`
--

INSERT INTO `info_empresa` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Mision', 'mision 2'),
(2, 'vision', 'vision'),
(3, 'Historia', 'historia sciocco');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intro`
--

CREATE TABLE IF NOT EXISTS `intro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `archivo` varchar(50) NOT NULL,
  `ext` varchar(3) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1' COMMENT '1:activo, 2 :inactivo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE IF NOT EXISTS `marca` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proveedor` int(11) NOT NULL,
  `marca` varchar(30) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1' COMMENT '1:activo,2:inactivo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `novedades`
--

CREATE TABLE IF NOT EXISTS `novedades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_novedad` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `archivo` varchar(40) NOT NULL,
  `ext` varchar(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(11) NOT NULL,
  `id_marca` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_subcategoria` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `referencia` varchar(30) NOT NULL,
  `color` varchar(20) NOT NULL,
  `talla` varchar(10) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `precio` int(10) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1' COMMENT '1:activo, 2:inactivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE IF NOT EXISTS `proveedores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_doc` int(11) NOT NULL,
  `num_doc` varchar(15) NOT NULL,
  `razon_social` varchar(50) NOT NULL,
  `rep_comercial` varchar(40) NOT NULL,
  `contacto` varchar(40) NOT NULL,
  `num_contacto` varchar(15) NOT NULL,
  `direccion` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `id_pais` int(11) NOT NULL,
  `id_depto` int(11) NOT NULL,
  `id_ciudad` int(11) NOT NULL,
  `logo_archivo` varchar(40) NOT NULL,
  `logo_ext` varchar(3) NOT NULL,
  `estado` int(1) NOT NULL COMMENT '1:activo, 2:inactivo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `redes_sociales`
--

CREATE TABLE IF NOT EXISTS `redes_sociales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `url` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `redes_sociales`
--

INSERT INTO `redes_sociales` (`id`, `nombre`, `url`) VALUES
(1, 'Facebook', 'www.facebook.com.co'),
(2, 'Instagram', ''),
(3, 'Youtube', 'www.youtube.com'),
(4, 'Pinterest', 'www.pinterest.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `rol`) VALUES
(1, 'administrador'),
(2, 'cliente'),
(3, 'Vendedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategoria_producto`
--

CREATE TABLE IF NOT EXISTS `subcategoria_producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) NOT NULL,
  `nombre_subcategoria` varchar(50) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1' COMMENT '1:activo,2:inactivo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `terminos`
--

CREATE TABLE IF NOT EXISTS `terminos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `terminos`
--

INSERT INTO `terminos` (`id`, `nombre`, `descripcion`) VALUES
(2, 'Proteccion De Datos', '<p>proteccion de datos</p>');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE IF NOT EXISTS `tipo_documento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_doc` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`id`, `tipo_doc`) VALUES
(1, 'Cedula'),
(2, 'Cedula Extranjeria');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_novedad`
--

CREATE TABLE IF NOT EXISTS `tipo_novedad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1' COMMENT '1:activo, 2 inactivo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `tipo_novedad`
--

INSERT INTO `tipo_novedad` (`id`, `nombre`, `estado`) VALUES
(1, 'Colecciones', 1),
(2, 'Tiendas', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(40) NOT NULL,
  `pass` varchar(40) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1' COMMENT '1 activo, 2 inactivo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `pass`, `id_rol`, `estado`) VALUES
(1, 'adminruiz', 'c9369cbf82de476e1bd18e0c497c4be9', 1, 1),
(2, 'cliente', 'c9369cbf82de476e1bd18e0c497c4be9', 2, 1),
(5, 'Adminruiz2', 'c9369cbf82de476e1bd18e0c497c4be9', 3, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
