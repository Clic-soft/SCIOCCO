-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-01-2016 a las 17:48:08
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=111 ;

--
-- Volcado de datos para la tabla `categoria_producto`
--

INSERT INTO `categoria_producto` (`id`, `nombre_cat`, `estado`) VALUES
(1, 'Brasilera ', 1),
(2, 'Top', 1),
(3, 'Brasier', 1),
(4, 'Pijama', 1),
(5, 'Bustier', 1),
(6, 'Ligueros', 1),
(7, 'Camisetas', 1),
(8, 'Descaderada', 1),
(9, 'Brasier Bra', 1),
(11, 'Super Descanso Medio', 1),
(12, 'Talls', 1),
(13, 'Body', 1),
(14, 'Leggins', 1),
(15, 'Blusas', 1),
(31, 'Pantalones', 1),
(32, 'Slack', 1),
(33, 'Calzeta', 1),
(34, 'Sport Socks', 1),
(35, 'Boxer', 1),
(46, 'Pescador', 1),
(47, 'Hipster', 1),
(48, 'Tanga ', 1),
(49, 'Panty', 1),
(56, 'Conjunto', 1),
(57, 'Teddy', 1),
(58, 'Faja ', 1),
(59, 'Levantacola', 1),
(60, 'Cinturillas', 1),
(61, 'Chaleco', 1),
(84, 'Corrector De Postura', 1),
(85, 'Short', 1),
(86, 'Bra ', 1),
(109, 'Vestido Maternidad', 1),
(110, 'Bluson', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `id_tipo_doc`, `num_doc`, `nombres`, `apellidos`, `fecha_nac`, `fecha_reg`, `telefono`, `celular`, `direccion`, `email`, `id_usuario`, `cod_pais`, `cod_depto`, `cod_ciudad`) VALUES
(1, 1, '1144155366', 'andres', 'ruiz', '1992-02-19', '2016-01-14 00:00:00', '1234567', '1234567891', 'cra 1 70-180', 'j_andres272@hotmail.com', 2, 0, 0, 0);

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
-- Estructura de tabla para la tabla `img_productos`
--

CREATE TABLE IF NOT EXISTS `img_productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `archivo` varchar(40) NOT NULL,
  `ext` varchar(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `img_productos`
--

INSERT INTO `img_productos` (`id`, `id_producto`, `archivo`, `ext`) VALUES
(1, 1, 'b748b2f6f8f9a1a2d8dbe7c7ff3b69cd043faa23', 'jpg'),
(2, 1, '90402f69be8907f12ac28fc7432f1372af3e623c', 'jpg'),
(3, 1, 'b82c98c87774e2a2e2497106a78de3092442eae7', 'jpg'),
(4, 1, 'ec59d78d7fe6eb9da4f895b49deb4ad1db1fd46b', 'jpg');

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
  `archivo` varchar(40) NOT NULL,
  `ext` varchar(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`id`, `id_proveedor`, `marca`, `estado`, `archivo`, `ext`) VALUES
(1, 1, 'Ea', 1, '', ''),
(3, 2, 'Cachet', 1, '', ''),
(5, 2, 'Tall', 1, '', ''),
(7, 4, 'Piel De Mujer', 1, '', ''),
(9, 5, 'B.u.p', 1, '', ''),
(10, 6, 'Maria E', 1, '', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `novedades`
--

INSERT INTO `novedades` (`id`, `id_tipo_novedad`, `nombre`, `descripcion`, `fecha_creacion`, `archivo`, `ext`) VALUES
(1, 2, 'Tienda Sciocco 14 De Calima', '<p>APERTURA DE NUESTRA NUEVA TIENDA EN LA CATORCE DE CALIMA, TIENDA UBICADA EN EL SOTANO DE LA 14 DE CALIMA DISFRUTA DE LOS MARAVILLOSOS DESCUENTOS QUE POR NUESTRA APERTURA VAMOS A OFRECER</p>\r\n<p>&nbsp;</p>\r\n<p>VALIDO DESDE EL 1 DE ENERO AL 7 DE ENERO DEL A&Ntilde;O 2016</p>\r\n<p>SOLO COMPRAS EN LA TIENDA</p>', '2016-01-15 07:37:24', '', ''),
(2, 1, 'Coleccion Kelinda Suava', '<p>COLECCION KELINDA SUAVA CON PRENDAS INTIMAS EN TELA LIGERA</p>', '2016-01-15 08:13:37', 'b748b2f6f8f9a1a2d8dbe7c7ff3b69cd043faa23', 'jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_marca` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_subcategoria` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `referencia` varchar(30) NOT NULL,
  `color` varchar(20) NOT NULL,
  `talla` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `precio` int(10) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1' COMMENT '1:activo, 2:inactivo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `id_marca`, `id_categoria`, `id_subcategoria`, `nombre`, `referencia`, `color`, `talla`, `descripcion`, `precio`, `estado`) VALUES
(1, 1, 1, 1, '', '1', 'azul', 1, '', 10000, 1);

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
  `estado` int(1) NOT NULL DEFAULT '1' COMMENT '1:activo, 2:inactivo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `id_tipo_doc`, `num_doc`, `razon_social`, `rep_comercial`, `contacto`, `num_contacto`, `direccion`, `email`, `id_pais`, `id_depto`, `id_ciudad`, `logo_archivo`, `logo_ext`, `estado`) VALUES
(1, 3, '900438679', 'CLAPA\\''Z S.A.S.', 'Felipe Andres Taborda Yepez', 'Felipe Andres Taborda Yepez', '3092395', 'CLL 64A Nº 28-63', 'Inventarios@ealingerie.com', 0, 0, 0, '', '', 1),
(2, 3, '8600318554', 'TEXTILES SWANTES S.A.', 'Jose Mekler Akerman', 'Olga Lucia Salazar Restrepo', '3647222', 'cr 34 17 a 62 bogota', 'Ollusare@hotmail.com', 0, 0, 0, '', '', 1),
(4, 3, '8050251497', 'COLOMBIA LINGERIE S.A.', 'Claudia Cristina Collazos Gomez', 'Viviana Silva', '5563646', 'cr 34 4 26 cali', 'Asiscomercial@pieldemujer.com', 0, 0, 0, '', '', 1),
(5, 3, '20524875871', 'S & L MODA SOCIEDAD ANONIMA CERRADA', 'Leonardo Romero Arrivillaga', 'Leonardo Romero', '4341450', 'Urb El Artesano, Talladores 23', 'Lz@sophieint.com', 0, 0, 0, '', '', 1),
(6, 3, '11', 'MARIA E', 'Elizabeth Jimenez', 'Elizabeth Jimenez', '3002123428', 'CALLE 79 N 52D-134 ITAGUI', 'Elizabeth.jimenez@fajasmariae.', 0, 0, 0, '', '', 1),
(7, 1, '1', 'OTRO', '', '', '', '', '', 0, 0, 0, '', '', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=123 ;

--
-- Volcado de datos para la tabla `subcategoria_producto`
--

INSERT INTO `subcategoria_producto` (`id`, `id_categoria`, `nombre_subcategoria`, `estado`) VALUES
(1, 1, 'Brasilera ', 1),
(2, 2, 'Top', 1),
(3, 3, 'Brasier', 1),
(5, 3, 'Brasier Bicolor ', 1),
(6, 5, 'Bustier Bicolor ', 1),
(7, 6, 'Ligueros ', 1),
(8, 1, 'Brasilera Bicolor', 1),
(9, 7, 'Camisetas', 1),
(10, 8, 'Descaderada', 1),
(11, 1, 'Brasilera Thong-bicolor', 1),
(12, 9, 'Brasier Bra - Bicolor', 1),
(13, 1, 'Brasilera-thong', 1),
(14, 1, ' Brasilera-thong Estampado-printed', 1),
(15, 1, ' Brasilera-thong Estampado', 1),
(16, 8, ' Descaderada Estampado ', 1),
(17, 9, 'Brasier-bra Estampado', 1),
(18, 9, 'Brasier-bra', 1),
(19, 9, ' Brasier-bra Estampado Printed ', 1),
(20, 3, ' Brasier Copa', 1),
(21, 49, 'Panty Faja Control', 1),
(22, 7, 'Camisa Sara', 1),
(23, 11, 'Super Descanso Medio', 1),
(24, 12, 'Tall Invisible ', 1),
(25, 13, 'Body Invisible Short ', 1),
(26, 14, 'Leggins Splend', 1),
(27, 7, 'Camiseta Control Libre Busto', 1),
(28, 7, 'Camiseta Control', 1),
(29, 7, 'Camiseta Victoria', 1),
(30, 14, 'Leggins Unicolor ', 1),
(31, 13, 'Body Amalia Panty', 1),
(32, 85, 'Short Amalia ', 1),
(33, 7, 'Camiseta Ecodu', 1),
(34, 14, 'Leggins Push Up ', 1),
(35, 2, 'Top Max Suport ', 1),
(36, 2, 'Top Sport ', 1),
(37, 31, 'Pantalon Aladino', 1),
(38, 2, 'Top Stamp', 1),
(39, 14, 'Leggins Estampados', 1),
(40, 2, 'Top No.5', 1),
(41, 32, 'Slack Descanso', 1),
(42, 32, 'Slack Invisible ', 1),
(43, 33, 'Calzeta Baleta  ', 1),
(44, 34, 'Sport Socks ', 1),
(45, 35, 'Boxer Siliconado ', 1),
(46, 46, 'Pescador Urano ', 1),
(47, 7, 'Camiseta Slepware ', 1),
(48, 7, 'Camiseta Control Invisble', 1),
(49, 47, 'Hipster Pauline ', 1),
(50, 48, 'Tanga Pauline', 1),
(51, 49, 'Panty Jovankka', 1),
(52, 49, 'Panty Control Jovankka', 1),
(53, 48, 'Tanga Jovankka', 1),
(54, 48, 'Tanga Basica ', 1),
(55, 47, 'Hipster Basico', 1),
(56, 48, 'Tanga Ruby ', 1),
(57, 3, 'Brasier Pauline', 1),
(58, 3, 'Brasier Jovankka', 1),
(59, 5, 'Bustier Basico ', 1),
(60, 3, 'Brasier Basico ', 1),
(61, 2, 'Top Ruby ', 1),
(62, 3, 'Brasier Senonero', 1),
(63, 3, 'Brasier Fleur ', 1),
(64, 49, 'Panty Fleurs', 1),
(65, 48, 'Tanga Fleurs ', 1),
(66, 3, 'Brasier Dolly ', 1),
(67, 3, 'Brasier Doble Talla Erotico', 1),
(68, 35, 'Boxer Basico ', 1),
(69, 35, 'Boxer Delicacy ', 1),
(70, 56, 'Conjunto Corazon ', 1),
(71, 56, 'Conjunto Silver ', 1),
(72, 57, 'Teddy Erotica', 1),
(73, 57, 'Teddy Clasica', 1),
(74, 58, 'Faja 2', 1),
(75, 58, 'Faja 3', 1),
(76, 59, 'Levantacola', 1),
(77, 60, 'Cinturillas', 1),
(78, 58, 'Faja 1', 1),
(79, 60, 'Cinturilla Senos Libres ', 1),
(80, 59, 'Levantacola Pantorrilla ', 1),
(81, 61, 'Chaleco Hombre  ', 1),
(82, 59, 'Levantacola A Media Pierna   ', 1),
(83, 13, 'Body Brasilero Strapless ', 1),
(84, 3, 'Brasier Materno ', 1),
(85, 84, 'Corrector De Postura Corto ', 1),
(86, 58, 'Faja Cinturilla Libre Senos ', 1),
(87, 58, 'Faja Bsl Senos Libres  ', 1),
(88, 86, 'Bra Copa Realse ', 1),
(89, 85, 'Short Cachetero ', 1),
(90, 60, 'Cinturilla Deportiva ', 1),
(91, 86, 'Bra Copa Reormada', 1),
(92, 86, 'Bra Copa Prehormada', 1),
(93, 60, 'Cinturilla Latex Hombre ', 1),
(94, 58, 'Faja Cachetera Senos Libre ', 1),
(95, 3, 'Brasier Copa Prehormada', 1),
(96, 58, 'Faja Cachetera Senos Libre Espalda Recta ', 1),
(97, 58, 'Faja Body Panty Tanga Senos Libre', 1),
(98, 85, 'Short Capri Con Realce ', 1),
(99, 4, 'Pijama Top Mc ', 1),
(100, 4, 'Pijama Capri ', 1),
(101, 4, 'Pijama Tank Top  ', 1),
(102, 4, 'Pijama Boxer   ', 1),
(103, 4, 'Pijama M3/4 Print  ', 1),
(104, 4, 'Pijama   ', 1),
(105, 4, 'Pijama Pantalon ', 1),
(106, 4, 'Pijama M3/4 Jade', 1),
(107, 4, 'Pijama Pantalon Jade', 1),
(108, 4, 'Pijama Ivory', 1),
(109, 109, 'Vestido Maternidad', 1),
(110, 109, 'Vestido Maternidad Print 1 ', 1),
(111, 109, 'Vestido Maternidad Print 2 ', 1),
(112, 15, 'Blusa Cool Night ', 1),
(113, 85, 'Short Cool Night ', 1),
(114, 15, 'Blusa Ralph Laurent ', 1),
(115, 31, 'Pantalon Ralph Laurent ', 1),
(116, 15, 'Blusa Mara ', 1),
(117, 31, 'Pantalon Mara ', 1),
(118, 110, 'Bluson Cool Night  ', 1),
(119, 15, 'Buso Ralph Laurent ', 1),
(120, 31, 'Pantalon Sudadera Ralph Laurent', 1),
(121, 15, 'Blusa Carole Hochmann', 1),
(122, 31, 'Pantalon Carole Hochmann ', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tallas`
--

CREATE TABLE IF NOT EXISTS `tallas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `talla` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Volcado de datos para la tabla `tallas`
--

INSERT INTO `tallas` (`id`, `talla`) VALUES
(1, '34b'),
(2, '36b'),
(3, '38b'),
(4, 'M'),
(5, 'L'),
(6, 'Xl'),
(7, 'S\n'),
(8, 'U'),
(9, '32b'),
(10, '8-10'),
(11, '9-11'),
(12, 'S-m'),
(13, '36c'),
(14, '38c'),
(15, '34c');

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
(2, 'Cedula Extranjeria'),
(3, 'NIT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_novedad`
--

CREATE TABLE IF NOT EXISTS `tipo_novedad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1' COMMENT '1:activo, 2 inactivo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `pass`, `id_rol`, `estado`) VALUES
(1, 'adminruiz', 'c9369cbf82de476e1bd18e0c497c4be9', 1, 1),
(2, 'cliente', 'c9369cbf82de476e1bd18e0c497c4be9', 2, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
