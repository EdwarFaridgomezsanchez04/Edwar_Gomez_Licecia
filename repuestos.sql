-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-04-2025 a las 17:31:45
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `repuestos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `cedula` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`cedula`, `nombre`, `telefono`, `direccion`) VALUES
(823923, 'wpfkld', '0320', 'ibague'),
(1126718, 'asfalk', '123123', 'akalskd'),
(1245623, 'Juan Sebastian', '3212444321', 'B/los tunjos'),
(9349042, 'Farid', '2319293', 'centro'),
(11231321, 'mateo andres', '21012010021', 'ibague'),
(112023932, 'mateo', '3212444321', 'B/los tunjos'),
(1105490390, 'Andres ', '312344532', 'Barrio El jordan'),
(1109490190, 'Francy', '312344333', 'Barrio San Carlos'),
(1109490192, 'Edwar', '3212444321', 'B/los tunjos'),
(1109490390, 'Alvaro Forero', '3212444321', 'B/los tunjos'),
(1109491416, 'Edwar Farid Gomez Sanchez', '3102331487', 'Barrio los tunjos'),
(2147483647, 'Marco Antonio', '321456789', 'B/confenalco');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` decimal(10,0) DEFAULT NULL,
  `subtotal` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id`, `id_venta`, `id_producto`, `cantidad`, `precio_unitario`, `subtotal`) VALUES
(2, 10, NULL, 2, 32000, 64000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id_empresa` int(11) NOT NULL,
  `empresa` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id_empresa`, `empresa`) VALUES
(1329812, 'Almacen Aranda'),
(12346542, 'Camila motosport'),
(67584903, 'Moyano caremonda'),
(92929292, 'empresa rocha'),
(123456780, 'Moto2'),
(123456789, 'Moto1'),
(2147483647, 'Motoracer_almacen');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_licencia`
--

CREATE TABLE `estado_licencia` (
  `id_estado` int(11) NOT NULL,
  `estado` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_licencia`
--

INSERT INTO `estado_licencia` (`id_estado`, `estado`) VALUES
(1, 'Activa'),
(2, 'Expirada'),
(3, 'Suspendida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `licencia`
--

CREATE TABLE `licencia` (
  `id_licencia` varchar(21) NOT NULL,
  `tipo_licencia` int(11) NOT NULL,
  `fecha_inicio` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_fin` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_estado` int(11) DEFAULT NULL,
  `nit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `licencia`
--

INSERT INTO `licencia` (`id_licencia`, `tipo_licencia`, `fecha_inicio`, `fecha_fin`, `id_estado`, `nit`) VALUES
('0c3d5daf96736fd88eb8', 4, '2025-04-24 14:39:19', '2027-04-24 05:00:00', 1, 1329812),
('5f1b90a8328efadd71ef', 3, '2025-04-24 21:46:24', '2026-04-24 05:00:00', 1, 2147483647),
('756e52af047078a1f67d', 4, '2025-04-24 13:58:39', '2027-04-24 05:00:00', 1, 1329812),
('79699634ff422dcb4212', 2, '2025-04-24 20:26:51', '2025-10-21 05:00:00', 1, 12346542),
('b9d6f4326af9676749ca', 2, '2025-04-25 02:55:12', '2025-10-21 05:00:00', 1, 67584903),
('c3ef366cce0fa72823e9', 4, '2025-04-25 00:06:41', '2027-04-24 05:00:00', 1, 92929292),
('d94c0d2f5269dea26261', 4, '2025-04-24 17:27:06', '2027-04-24 05:00:00', 1, 1329812);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `codigo_barras` varchar(50) NOT NULL,
  `codigo` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `stock`, `codigo_barras`, `codigo`) VALUES
(104, 'Kit Medio Dt 125', 'Kit medio Cabeza de fuerza Dt-k125 ', 12000.00, 120, 'PROD-000104', 17455856826),
(105, 'Retenedores', 'Retenedores de Motor', 30000.00, 45, 'PROD-000105', 17455857415),
(106, 'Marcador', 'marcador', 12000.00, 12, 'PROD-000106', 17455864186),
(107, 'Piston', 'piston', 32000.00, 20, 'PROD-000107', 7706616024937);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_licencia`
--

CREATE TABLE `tipo_licencia` (
  `id_tipo` int(11) NOT NULL,
  `tipo` varchar(11) NOT NULL,
  `valor` bigint(20) NOT NULL,
  `duracion_dias` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_licencia`
--

INSERT INTO `tipo_licencia` (`id_tipo`, `tipo`, `valor`, `duracion_dias`) VALUES
(1, 'Demo', 0, 3),
(2, '6 Meses', 30000, 180),
(3, '1 Año', 50000, 365),
(4, '2 Años', 90000, 730);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `cedula` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `contraseña` varchar(500) DEFAULT NULL,
  `roles` enum('Super Admin','Administrador') DEFAULT NULL,
  `id_empresa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`cedula`, `nombre`, `contraseña`, `roles`, `id_empresa`) VALUES
(123, 'lola', '$2y$12$MQogE.7hn2vsdPNR4n0Mjum2zBVsteEAmAyceO2Di4dT8wc.Xcvjy', 'Administrador', 92929292),
(1245623, 'Alex Marin', '$2y$12$.XjVj/HjZbAdMBW9HghMyeANIO.ttgK0MFMI/zEt0ZyNCXrJevf3G', 'Administrador', 123456789),
(123343212, 'Karerly Ruiz ', '$2y$12$kc8IzFSLXxWj7uy/U5YX4.wh.DNNnT6rCxt982k6Y4votRG3SQYWa', 'Administrador', 123456780),
(1102930121, 'Camila Jimenez', '$2y$12$Te2VncqMlMg9KYr1AGJYFOEAQbVQJ9sE7wSRIKp8zj9Tw6yZqUZdC', 'Administrador', 12346542),
(1109490190, 'Francy Sanchez', '$2y$12$fl1G0pPn71FV9iwfWAx/cOSkQLouGSb.STQL69hApwvoBqRAxGOa6', 'Administrador', 123456789),
(1109491416, 'Edwar Gomez', '$2y$12$7Zap3gtG2So.ooOa3.of3eLnd/wyjYflWa..OCIj7Y6UYVtpHDZ3.', 'Super Admin', 1329812),
(1109493212, 'Juan Aranda', '$2y$12$H5Fn.ejgcTS31x.vX6opSOThYVGubIB.z57K55mHnMSX6slNFgoIi', 'Administrador', 1329812),
(1120323230, 'Brian Rocha', '$2y$12$sZCaPXr7A.GPRU18q1aAluoKb5l3tB9ycq8Jxbbw9s.miDZUNs5y.', 'Administrador', 92929292),
(1231231312, 'moyano', '$2y$12$whkQd8KbXJw84IzDPVx7ZOFzkucygq78vOOKPIw3Jo0ZkLCmhnGFy', 'Administrador', 67584903);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `cedula_cliente` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `cedula_cliente`, `fecha`, `total`) VALUES
(2, 112023932, '2025-04-25 11:13:20', 0.00),
(3, 1109490390, '2025-04-25 14:32:49', 0.00),
(4, 9349042, '2025-04-25 14:48:57', 0.00),
(5, 1126718, '2025-04-25 14:54:17', 0.00),
(6, 823923, '2025-04-25 15:08:24', NULL),
(7, 11231321, '2025-04-25 15:11:28', 64000.00),
(8, 11231321, '2025-04-25 15:12:06', 64000.00),
(9, 1109490192, '2025-04-25 15:17:04', 64000.00),
(10, 1109490192, '2025-04-25 15:17:27', 64000.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`cedula`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id_empresa`);

--
-- Indices de la tabla `estado_licencia`
--
ALTER TABLE `estado_licencia`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `licencia`
--
ALTER TABLE `licencia`
  ADD PRIMARY KEY (`id_licencia`),
  ADD KEY `licencia_ibfk_1` (`id_estado`),
  ADD KEY `tipo_licencia` (`tipo_licencia`),
  ADD KEY `nit` (`nit`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_licencia`
--
ALTER TABLE `tipo_licencia`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`cedula`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`cedula_cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `cedula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2147483648;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado_licencia`
--
ALTER TABLE `estado_licencia`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de la tabla `tipo_licencia`
--
ALTER TABLE `tipo_licencia`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `detalle_ventas_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`),
  ADD CONSTRAINT `detalle_ventas_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `licencia`
--
ALTER TABLE `licencia`
  ADD CONSTRAINT `licencia_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado_licencia` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `licencia_ibfk_2` FOREIGN KEY (`tipo_licencia`) REFERENCES `tipo_licencia` (`id_tipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `licencia_ibfk_3` FOREIGN KEY (`nit`) REFERENCES `empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
