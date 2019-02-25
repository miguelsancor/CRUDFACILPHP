-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-02-2019 a las 04:40:04
-- Versión del servidor: 10.1.30-MariaDB
-- Versión de PHP: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbpruebaiutum`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ariculo`
--

CREATE TABLE `ariculo` (
  `idarticulo` int(11) NOT NULL,
  `nomarticulo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ariculo`
--

INSERT INTO `ariculo` (`idarticulo`, `nomarticulo`) VALUES
(1, 'Arroz'),
(2, 'Frijol'),
(3, 'Pasta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `codigo` varchar(10) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `lugar_nacimiento` varchar(30) NOT NULL,
  `fecha_nacimiento` varchar(30) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `puesto` varchar(15) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`codigo`, `nombres`, `lugar_nacimiento`, `fecha_nacimiento`, `direccion`, `telefono`, `puesto`, `estado`) VALUES
('111111', 'MIGUEL ANGEL SANCHEZ', 'BOGOTA D.C', '18-01-2019', 'CARARRAR NNNN', '2222 ', 'AQUI', 1),
('1250', 'Juan Campos', 'Santa Ana, El Salvador22', '15-06-1991', '', '70252525', 'Gerente', 2),
('15200', 'Marcos Amaya', 'Santa Salvador', '06-06-2017', 'San Salvador', '12345678', 'Vendedor', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadoventa`
--

CREATE TABLE `estadoventa` (
  `idestado` int(11) NOT NULL,
  `nomestado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estadoventa`
--

INSERT INTO `estadoventa` (`idestado`, `nomestado`) VALUES
(111, 'Compra'),
(222, 'Solicitud');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `nombre_usuario` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`nombre_usuario`, `password`, `estado`) VALUES
('masanchezco', '123', 1),
('dante', '123', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedores`
--

CREATE TABLE `vendedores` (
  `idvendedores` int(11) NOT NULL,
  `nomvendedores` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vendedores`
--

INSERT INTO `vendedores` (`idvendedores`, `nomvendedores`) VALUES
(11, 'Miguel Angel Sanchez'),
(22, 'Juliana Torres'),
(33, 'Luciana Sanchez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `idventas` int(11) NOT NULL,
  `monto` decimal(10,0) NOT NULL,
  `fecha` date NOT NULL,
  `idestadoventa` int(11) NOT NULL,
  `idvendedor` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`idventas`, `monto`, `fecha`, `idestadoventa`, `idvendedor`, `idarticulo`) VALUES
(1111, '4000', '2019-02-03', 111, 22, 1),
(2222, '10000', '2019-02-12', 222, 11, 3),
(3333, '60000', '2019-02-15', 111, 33, 2),
(4444, '20000', '2019-02-21', 222, 33, 2),
(5555, '120000', '2019-02-22', 111, 22, 3),
(6666, '524000', '2019-02-18', 111, 22, 1),
(7777, '1000000', '2019-02-23', 222, 11, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ariculo`
--
ALTER TABLE `ariculo`
  ADD PRIMARY KEY (`idarticulo`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `estadoventa`
--
ALTER TABLE `estadoventa`
  ADD PRIMARY KEY (`idestado`);

--
-- Indices de la tabla `vendedores`
--
ALTER TABLE `vendedores`
  ADD PRIMARY KEY (`idvendedores`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`idventas`),
  ADD KEY `idvendedor` (`idvendedor`),
  ADD KEY `idestadoventa` (`idestadoventa`),
  ADD KEY `idarticulo` (`idarticulo`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`idvendedor`) REFERENCES `vendedores` (`idvendedores`),
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`idestadoventa`) REFERENCES `estadoventa` (`idestado`),
  ADD CONSTRAINT `ventas_ibfk_3` FOREIGN KEY (`idarticulo`) REFERENCES `ariculo` (`idarticulo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
