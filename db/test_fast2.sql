-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2024 at 10:24 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_fast1`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(50) NOT NULL,
  `sub_categoria` varchar(50) NOT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`, `sub_categoria`, `foto`) VALUES
(1, 'Comida', 'Platos Fuertes', 'ruta/a/la/foto7.jpg'),
(2, 'Comida', 'Entradas', 'ruta/a/la/foto8.jpg'),
(3, 'Bebida', 'No Alcohólicas', 'ruta/a/la/foto9.jpg'),
(4, 'Bebida', 'Alcohólicas', 'ruta/a/la/foto10.jpg'),
(5, 'Postres', 'Helados', 'ruta/a/la/foto11.jpg'),
(6, 'Postres', 'Tortas', 'ruta/a/la/foto12.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `detalles_producto`
--

CREATE TABLE `detalles_producto` (
  `id_ingrediente_producto` int(11) NOT NULL,
  `id_ingrediente` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detalles_producto`
--

INSERT INTO `detalles_producto` (`id_ingrediente_producto`, `id_ingrediente`, `id_producto`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5),
(6, 6, 6);

-- --------------------------------------------------------

--
-- Table structure for table `horarios`
--

CREATE TABLE `horarios` (
  `id_horario` int(11) NOT NULL,
  `hora_entrada` time NOT NULL,
  `hora_salida` time NOT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `horarios`
--

INSERT INTO `horarios` (`id_horario`, `hora_entrada`, `hora_salida`, `id_usuario`) VALUES
(52, '12:34:00', '12:03:00', 57),
(53, '12:34:00', '12:03:00', 58),
(54, '12:34:00', '12:03:00', 59),
(56, '12:34:00', '12:34:00', 61);

-- --------------------------------------------------------

--
-- Table structure for table `ingredientes`
--

CREATE TABLE `ingredientes` (
  `id_ingrediente` int(11) NOT NULL,
  `nombre_ingrediente` varchar(50) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingredientes`
--

INSERT INTO `ingredientes` (`id_ingrediente`, `nombre_ingrediente`, `cantidad`, `precio`, `foto`) VALUES
(1, 'Salmon', 10, '8.00', 'ruta/a/la/foto19.jpg'),
(2, 'Pollo', 20, '6.00', 'ruta/a/la/foto20.jpg'),
(3, 'Lechuga', 30, '2.50', 'ruta/a/la/foto21.jpg'),
(4, 'Agua', 50, '1.00', 'ruta/a/la/foto22.jpg'),
(5, 'Malta', 15, '3.75', 'ruta/a/la/foto23.jpg'),
(6, 'Vainilla', 25, '4.50', 'ruta/a/la/foto24.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `mesa`
--

CREATE TABLE `mesa` (
  `id_mesa` int(11) NOT NULL,
  `id_mesero` int(11) DEFAULT NULL,
  `numero_mesa` varchar(50) NOT NULL,
  `estado` enum('ABIERTA','EN VENTA') DEFAULT NULL,
  `capacidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mesa`
--

INSERT INTO `mesa` (`id_mesa`, `id_mesero`, `numero_mesa`, `estado`, `capacidad`) VALUES
(1, 2, 'Mesa 1', 'ABIERTA', 4),
(2, 5, 'Mesa 2', 'ABIERTA', 6),
(3, 3, 'Mesa 3', 'ABIERTA', 2),
(4, 2, 'Mesa 4', 'EN VENTA', 4),
(5, 4, 'Mesa 5', 'ABIERTA', 3),
(6, 6, 'Mesa 6', 'EN VENTA', 8);

-- --------------------------------------------------------

--
-- Table structure for table `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_mesa` int(11) DEFAULT NULL,
  `estado` enum('Pendiente','Completado') DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_mesa`, `estado`, `fecha_hora`) VALUES
(1, 1, 'Pendiente', '2024-04-05 17:55:11'),
(2, 2, 'Completado', '2024-04-05 17:55:11'),
(3, 3, 'Pendiente', '2024-04-05 17:55:11'),
(4, 4, 'Completado', '2024-04-05 17:55:11'),
(5, 5, 'Pendiente', '2024-04-05 17:55:11'),
(6, 6, 'Pendiente', '2024-04-05 17:55:11');

-- --------------------------------------------------------

--
-- Table structure for table `pedidos_plato`
--

CREATE TABLE `pedidos_plato` (
  `id_pedido_plato` int(11) NOT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `id_plato` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pedidos_plato`
--

INSERT INTO `pedidos_plato` (`id_pedido_plato`, `id_pedido`, `id_plato`, `cantidad`) VALUES
(1, 1, 1, 2),
(2, 2, 2, 1),
(3, 3, 3, 3),
(4, 4, 4, 1),
(5, 5, 5, 2),
(6, 6, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `codigo` int(11) DEFAULT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `foto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id_producto`, `id_categoria`, `codigo`, `nombre`, `descripcion`, `precio`, `foto`) VALUES
(1, 1, 101, 'Filete de Salmón', 'Filete de salmón fresco servido con vegetales al vapor', '15.50', 'ruta/a/la/foto13.jpg'),
(2, 1, 102, 'Pollo a la Parrilla', 'Pollo marinado y grillado, acompañado de papas fritas', '12.00', 'ruta/a/la/foto14.jpg'),
(3, 2, 201, 'Ensalada César', 'Lechuga romana, crutones, aderezo césar y pollo a la parrilla', '9.75', 'ruta/a/la/foto15.jpg'),
(4, 3, 301, 'Agua Mineral', 'Botella de agua mineral sin gas', '2.00', 'ruta/a/la/foto16.jpg'),
(5, 4, 401, 'Cerveza Artesanal', 'Botella de cerveza artesanal local', '5.50', 'ruta/a/la/foto17.jpg'),
(6, 5, 501, 'Helado de Vainilla', 'Helado cremoso de vainilla con salsa de chocolate', '4.25', 'ruta/a/la/foto18.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `documento` int(11) DEFAULT NULL,
  `rol` enum('Administrador','Mesero','Cheff','Cajero') DEFAULT NULL,
  `estado` enum('Activo','Pendiente','Inactivo') DEFAULT NULL,
  `tipo_documento` enum('CC','CC Extrangeria') DEFAULT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `foto` varchar(200) DEFAULT NULL,
  `fecha_de_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `documento`, `rol`, `estado`, `tipo_documento`, `nombres`, `apellidos`, `telefono`, `direccion`, `correo`, `password`, `foto`, `fecha_de_creacion`) VALUES
(1, 123456789, 'Administrador', 'Activo', 'CC', 'Juan', 'Pérez', '1234567890', 'Calle 123', 'juan@example.com', 'admin', '../../uploads/avatar-03.jpg', '2024-04-05 17:54:01'),
(2, 987654321, 'Mesero', 'Activo', 'CC', 'María', 'López', '9876543210', 'Carrera 456', 'maria@example.com', NULL, '../../uploads/avatar-03.jpg', '2024-04-05 17:54:01'),
(3, 456789123, 'Cheff', 'Activo', 'CC', 'Pedro', 'González', '4567891230', 'Avenida 789', 'pedro@example.com', NULL, '../../uploads/avatar-03.jpg', '2024-04-05 17:54:01'),
(4, 321654987, 'Cajero', 'Activo', 'CC', 'Ana', 'Martínez', '3216549870', 'Calle 135', 'ana@example.com', NULL, '../../uploads/avatar-03.jpg', '2024-04-05 17:54:01'),
(5, 135792468, 'Mesero', 'Activo', 'CC', 'David', 'Ruiz', '1357924680', 'Avenida 246', 'david@example.com', NULL, '../../uploads/avatar-03.jpg', '2024-04-05 17:54:01'),
(6, 246813579, 'Mesero', 'Activo', 'CC', 'Laura', 'García', '2468135790', 'Carrera 789', 'laura@example.com', NULL, '../../uploads/avatar-03.jpg', '2024-04-05 17:54:01'),
(57, 2147483647, 'Cheff', 'Activo', 'CC', 'WW', 'WW', '12341234', '23412323', 'WW@gmasdf', '1234', '../../uploads/avatar-17.jpg', '2024-04-16 08:43:53'),
(58, 2147483647, 'Mesero', 'Activo', 'CC', 'UI', 'UI', '12341234', '23412323', 'UI@gmasdf', '1234', '../../uploads/avatar-13.jpg', '2024-04-16 08:44:51'),
(59, 2147483647, 'Cheff', 'Activo', 'CC', 'YYY', 'YYY', '12341234323', '23412323', 'YY@gmasdf', '1234', '../../uploads/avatar-13.jpg', '2024-04-16 08:47:45'),
(61, 2147483647, 'Mesero', 'Activo', 'CC', 'OOO', 'OOO', '1234', '455', 'OOO@gmail.coms', '1234', '../../uploads/avatar-02.jpg', '2024-04-16 08:51:22');

-- --------------------------------------------------------

--
-- Table structure for table `venta`
--

CREATE TABLE `venta` (
  `id_venta` int(11) NOT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `subTotal` decimal(10,2) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `IVA` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venta`
--

INSERT INTO `venta` (`id_venta`, `id_pedido`, `total`, `subTotal`, `fecha`, `IVA`) VALUES
(1, 1, '50.00', '45.00', '2024-04-05 17:55:48', 5),
(2, 2, '80.00', '72.00', '2024-04-05 17:55:48', 8),
(3, 3, '25.00', '22.50', '2024-04-05 17:55:48', 3),
(4, 4, '120.00', '108.00', '2024-04-05 17:55:48', 12),
(5, 5, '65.00', '58.50', '2024-04-05 17:55:48', 7),
(6, 6, '90.00', '81.00', '2024-04-05 17:55:48', 9);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indexes for table `detalles_producto`
--
ALTER TABLE `detalles_producto`
  ADD PRIMARY KEY (`id_ingrediente_producto`),
  ADD KEY `id_ingrediente` (`id_ingrediente`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indexes for table `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id_horario`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD PRIMARY KEY (`id_ingrediente`);

--
-- Indexes for table `mesa`
--
ALTER TABLE `mesa`
  ADD PRIMARY KEY (`id_mesa`),
  ADD KEY `id_mesero` (`id_mesero`);

--
-- Indexes for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_mesa` (`id_mesa`);

--
-- Indexes for table `pedidos_plato`
--
ALTER TABLE `pedidos_plato`
  ADD PRIMARY KEY (`id_pedido_plato`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_plato` (`id_plato`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indexes for table `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `id_pedido` (`id_pedido`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `detalles_producto`
--
ALTER TABLE `detalles_producto`
  MODIFY `id_ingrediente_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `ingredientes`
--
ALTER TABLE `ingredientes`
  MODIFY `id_ingrediente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mesa`
--
ALTER TABLE `mesa`
  MODIFY `id_mesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pedidos_plato`
--
ALTER TABLE `pedidos_plato`
  MODIFY `id_pedido_plato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `venta`
--
ALTER TABLE `venta`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detalles_producto`
--
ALTER TABLE `detalles_producto`
  ADD CONSTRAINT `detalles_producto_ibfk_1` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingredientes` (`id_ingrediente`),
  ADD CONSTRAINT `detalles_producto_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Constraints for table `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `horarios_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Constraints for table `mesa`
--
ALTER TABLE `mesa`
  ADD CONSTRAINT `mesa_ibfk_1` FOREIGN KEY (`id_mesero`) REFERENCES `usuarios` (`id_usuario`);

--
-- Constraints for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_mesa`) REFERENCES `mesa` (`id_mesa`);

--
-- Constraints for table `pedidos_plato`
--
ALTER TABLE `pedidos_plato`
  ADD CONSTRAINT `pedidos_plato_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`),
  ADD CONSTRAINT `pedidos_plato_ibfk_2` FOREIGN KEY (`id_plato`) REFERENCES `productos` (`id_producto`);

--
-- Constraints for table `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);

--
-- Constraints for table `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
