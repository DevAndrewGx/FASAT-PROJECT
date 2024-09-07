-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: test_fast5
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `alertas_productos`
--

DROP TABLE IF EXISTS `alertas_productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alertas_productos` (
  `id_alerta` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto_inventario` int(11) DEFAULT NULL,
  `umbral_minimo` int(11) DEFAULT NULL,
  `fecha_alerta` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` enum('pendiente','Resuelta') DEFAULT 'pendiente',
  PRIMARY KEY (`id_alerta`),
  KEY `id_producto_inventario` (`id_producto_inventario`),
  CONSTRAINT `alertas_productos_ibfk_1` FOREIGN KEY (`id_producto_inventario`) REFERENCES `productos_inventario` (`id_pinventario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alertas_productos`
--

LOCK TABLES `alertas_productos` WRITE;
/*!40000 ALTER TABLE `alertas_productos` DISABLE KEYS */;
/*!40000 ALTER TABLE `alertas_productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(50) NOT NULL,
  `tipo_categoria` enum('Productos','Ingredientes') DEFAULT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (2,'Bebidas','Productos'),(3,'Postres','Productos'),(4,'Comida rapida','Productos'),(5,'Platos principales','Productos'),(6,'x',''),(7,'x',''),(8,'v',''),(9,'Pruebaaa','Productos'),(10,'x','Ingredientes'),(11,'x',''),(12,'FFFF',''),(13,'J','Productos'),(14,'g','Productos'),(15,'T','Productos'),(16,'U',''),(17,'FINAL','Productos'),(18,'CV','Productos'),(19,'CV','Productos'),(20,'GG','Productos'),(21,'2','Productos'),(22,'1','Productos'),(23,'r','Productos'),(24,'YUY','Productos');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados_usuarios`
--

DROP TABLE IF EXISTS `estados_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados_usuarios` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` enum('Activo','Inactivo','Pendiente') DEFAULT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados_usuarios`
--

LOCK TABLES `estados_usuarios` WRITE;
/*!40000 ALTER TABLE `estados_usuarios` DISABLE KEYS */;
INSERT INTO `estados_usuarios` VALUES (1,'Activo'),(2,'Inactivo'),(3,'Pendiente');
/*!40000 ALTER TABLE `estados_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fotos`
--

DROP TABLE IF EXISTS `fotos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fotos` (
  `id_foto` int(11) NOT NULL AUTO_INCREMENT,
  `foto` varchar(255) DEFAULT NULL,
  `tipo` enum('Ingredientes','Productos','Usuarios') NOT NULL,
  PRIMARY KEY (`id_foto`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fotos`
--

LOCK TABLES `fotos` WRITE;
/*!40000 ALTER TABLE `fotos` DISABLE KEYS */;
INSERT INTO `fotos` VALUES (80,'645e8b88b17f80b60b433725e111fd38.jpg','Usuarios'),(81,'d63a38c7d0811383256f7a896ac6713c.jpg','Usuarios'),(82,'d63a38c7d0811383256f7a896ac6713c.jpg','Usuarios'),(83,'e85b07930d6f53e5ebe055ec50acb446.jpg','Usuarios'),(84,'e85b07930d6f53e5ebe055ec50acb446.jpg','Usuarios'),(88,'1e71969ba02afe0babb0bc143ad2ee1f.jpg','Usuarios'),(92,'7987dcec3f89a72f816b99046d186ee7.jpg','Usuarios'),(101,'317e0aa0f2ab6ab10f6ef7faa14e9019.jpg','Usuarios'),(102,'2943040d51228272181441351cff4cd0.jpg','Usuarios'),(103,'d4c259347a2dec6cda9f8cf217803b4a.jpg','Usuarios'),(106,'4d306c8d1520cbe8c530626fa49d4b43.jpg','Usuarios'),(107,'9b3e792cdea8ff193f9f8cd168629ed2.jpg','Usuarios'),(108,'02445ff461713f952e611007808ed782.jpg','Usuarios'),(109,'ac7a7de78b4f7f450dad02f49fb6c60c.jpg','Usuarios'),(110,'fb5d603590a55161183e7192803f0021.jpg','Usuarios'),(112,'c6b95a18adee1fc6ee5f7c4a720c9bda.jpg','Usuarios');
/*!40000 ALTER TABLE `fotos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gastos`
--

DROP TABLE IF EXISTS `gastos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gastos` (
  `id_gasto` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `concepto` varchar(255) DEFAULT NULL,
  `valor_compra` decimal(10,0) DEFAULT NULL,
  `medio_pago` enum('Efectivo','Tarjeta de credito','Tarjeta de debito') DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_gasto`),
  KEY `id_proveedor` (`id_proveedor`),
  KEY `id_categoria` (`id_categoria`),
  CONSTRAINT `gastos_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`),
  CONSTRAINT `gastos_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `gastos_categoria` (`id_categoria_gasto`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gastos`
--

LOCK TABLES `gastos` WRITE;
/*!40000 ALTER TABLE `gastos` DISABLE KEYS */;
/*!40000 ALTER TABLE `gastos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gastos_categoria`
--

DROP TABLE IF EXISTS `gastos_categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gastos_categoria` (
  `id_categoria_gasto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_categoria_gasto`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gastos_categoria`
--

LOCK TABLES `gastos_categoria` WRITE;
/*!40000 ALTER TABLE `gastos_categoria` DISABLE KEYS */;
INSERT INTO `gastos_categoria` VALUES (1,'Alimentos'),(2,'Suministros'),(3,'Servicios'),(4,'Otros');
/*!40000 ALTER TABLE `gastos_categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horarios`
--

DROP TABLE IF EXISTS `horarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `horarios` (
  `id_horario` int(11) NOT NULL AUTO_INCREMENT,
  `hora_entrada` varchar(50) DEFAULT NULL,
  `hora_salida` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_horario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horarios`
--

LOCK TABLES `horarios` WRITE;
/*!40000 ALTER TABLE `horarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `horarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingredientes_inventario`
--

DROP TABLE IF EXISTS `ingredientes_inventario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ingredientes_inventario` (
  `id_ingrediente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `unidad_de_medida` enum('KG','L','Unid.') DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_ingrediente`),
  KEY `id_categoria` (`id_categoria`),
  KEY `id_proveedor` (`id_proveedor`),
  CONSTRAINT `ingredientes_inventario_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`),
  CONSTRAINT `ingredientes_inventario_ibfk_2` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredientes_inventario`
--

LOCK TABLES `ingredientes_inventario` WRITE;
/*!40000 ALTER TABLE `ingredientes_inventario` DISABLE KEYS */;
/*!40000 ALTER TABLE `ingredientes_inventario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mesa`
--

DROP TABLE IF EXISTS `mesa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mesa` (
  `id_mesa` int(11) NOT NULL AUTO_INCREMENT,
  `id_mesero` int(11) DEFAULT NULL,
  `numero_mesa` varchar(50) NOT NULL,
  `estado` enum('ABIERTA','EN VENTA') DEFAULT NULL,
  `capacidad` varchar(50) NOT NULL,
  PRIMARY KEY (`id_mesa`),
  KEY `id_mesero` (`id_mesero`),
  CONSTRAINT `mesa_ibfk_1` FOREIGN KEY (`id_mesero`) REFERENCES `usuarios` (`documento`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mesa`
--

LOCK TABLES `mesa` WRITE;
/*!40000 ALTER TABLE `mesa` DISABLE KEYS */;
/*!40000 ALTER TABLE `mesa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movimientos_productos`
--

DROP TABLE IF EXISTS `movimientos_productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `movimientos_productos` (
  `id_movimiento` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto_inventario` int(11) DEFAULT NULL,
  `tipo` enum('Entrada','Salida','Transferencia') DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha_movimiento` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_movimiento`),
  KEY `id_producto_inventario` (`id_producto_inventario`),
  CONSTRAINT `movimientos_productos_ibfk_1` FOREIGN KEY (`id_producto_inventario`) REFERENCES `productos_inventario` (`id_pinventario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movimientos_productos`
--

LOCK TABLES `movimientos_productos` WRITE;
/*!40000 ALTER TABLE `movimientos_productos` DISABLE KEYS */;
/*!40000 ALTER TABLE `movimientos_productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `id_mesa` int(11) DEFAULT NULL,
  `estado` enum('Pendiente','Completado') DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `id_mesa` (`id_mesa`),
  CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_mesa`) REFERENCES `mesa` (`id_mesa`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos_productos`
--

DROP TABLE IF EXISTS `pedidos_productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos_productos` (
  `id_pedido_pinventario` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) DEFAULT NULL,
  `id_pinventario` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  PRIMARY KEY (`id_pedido_pinventario`),
  KEY `id_pedido` (`id_pedido`),
  KEY `id_pinventario` (`id_pinventario`),
  CONSTRAINT `pedidos_productos_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`),
  CONSTRAINT `pedidos_productos_ibfk_2` FOREIGN KEY (`id_pinventario`) REFERENCES `productos_inventario` (`id_pinventario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos_productos`
--

LOCK TABLES `pedidos_productos` WRITE;
/*!40000 ALTER TABLE `pedidos_productos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedidos_productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_inventario`
--

DROP TABLE IF EXISTS `productos_inventario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos_inventario` (
  `id_pinventario` int(11) NOT NULL AUTO_INCREMENT,
  `id_foto` int(11) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `id_subcategoria` int(11) DEFAULT NULL,
  `id_stock` int(11) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `permitir_sin_vender` enum('SI','NO') DEFAULT NULL,
  PRIMARY KEY (`id_pinventario`),
  KEY `id_proveedor` (`id_proveedor`),
  KEY `id_foto` (`id_foto`),
  KEY `fk_categoria` (`id_categoria`),
  KEY `fk_stock` (`id_stock`),
  KEY `id_subcategoria` (`id_subcategoria`),
  CONSTRAINT `fk_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`),
  CONSTRAINT `fk_stock` FOREIGN KEY (`id_stock`) REFERENCES `stock_inventario` (`id_stock`),
  CONSTRAINT `productos_inventario_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`),
  CONSTRAINT `productos_inventario_ibfk_2` FOREIGN KEY (`id_foto`) REFERENCES `fotos` (`id_foto`),
  CONSTRAINT `productos_inventario_ibfk_3` FOREIGN KEY (`id_subcategoria`) REFERENCES `sub_categorias` (`id_sub_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_inventario`
--

LOCK TABLES `productos_inventario` WRITE;
/*!40000 ALTER TABLE `productos_inventario` DISABLE KEYS */;
/*!40000 ALTER TABLE `productos_inventario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_menu`
--

DROP TABLE IF EXISTS `productos_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos_menu` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) DEFAULT NULL,
  `id_foto` int(11) DEFAULT NULL,
  `codigo` int(11) DEFAULT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `precio` int(11) NOT NULL,
  PRIMARY KEY (`id_producto`),
  KEY `id_categoria` (`id_categoria`),
  KEY `id_foto` (`id_foto`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_menu`
--

LOCK TABLES `productos_menu` WRITE;
/*!40000 ALTER TABLE `productos_menu` DISABLE KEYS */;
INSERT INTO `productos_menu` VALUES (1,1,1,101,'Salmón a la Parrilla','Filete de salmón fresco a la parrilla con guarnición de vegetales.',26),(2,2,2,102,'Vino Tinto Reserva','Botella de vino tinto reserva, perfecto para acompañar tus comidas.',36),(3,3,3,103,'Torta de Chocolate','Deliciosa torta de chocolate casera con cobertura de ganache.',13),(4,4,2,104,'Café Americano','Taza de café americano recién preparado.',4);
/*!40000 ALTER TABLE `productos_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_menu_inventario`
--

DROP TABLE IF EXISTS `productos_menu_inventario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos_menu_inventario` (
  `id_producto_menu` int(11) DEFAULT NULL,
  `id_producto_inventario` int(11) DEFAULT NULL,
  `cantidad_necesaria` decimal(10,2) NOT NULL,
  KEY `id_producto_menu` (`id_producto_menu`),
  KEY `id_producto_inventario` (`id_producto_inventario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_menu_inventario`
--

LOCK TABLES `productos_menu_inventario` WRITE;
/*!40000 ALTER TABLE `productos_menu_inventario` DISABLE KEYS */;
INSERT INTO `productos_menu_inventario` VALUES (1,1,1.00),(2,2,1.00),(3,3,2.00),(4,4,1.00),(1,1,1.00),(2,2,1.00),(3,3,2.00),(4,4,1.00);
/*!40000 ALTER TABLE `productos_menu_inventario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id_proveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedores`
--

LOCK TABLES `proveedores` WRITE;
/*!40000 ALTER TABLE `proveedores` DISABLE KEYS */;
INSERT INTO `proveedores` VALUES (1,'Proveedor A','Calle 123, Ciudad','123456789','proveedora@example.com'),(2,'Proveedor B','Avenida Principal, Ciudad','987654321','proveedorb@example.com'),(3,'Proveedor C','Calle Secundaria, Ciudad','456789123','proveedorc@example.com'),(4,'Proveedor D','Boulevard Central, Ciudad','654321987','proveedord@example.com');
/*!40000 ALTER TABLE `proveedores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recetas`
--

DROP TABLE IF EXISTS `recetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recetas` (
  `id_receta` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) DEFAULT NULL,
  `id_ingrediente` int(11) DEFAULT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_receta`),
  KEY `id_producto` (`id_producto`),
  KEY `id_ingrediente` (`id_ingrediente`),
  CONSTRAINT `recetas_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos_inventario` (`id_pinventario`),
  CONSTRAINT `recetas_ibfk_2` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingredientes_inventario` (`id_ingrediente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recetas`
--

LOCK TABLES `recetas` WRITE;
/*!40000 ALTER TABLE `recetas` DISABLE KEYS */;
/*!40000 ALTER TABLE `recetas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `rol` enum('Administrador','Mesero','Cheff','Cajero') NOT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrador'),(2,'Mesero'),(3,'Cheff'),(4,'Cajero');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_inventario`
--

DROP TABLE IF EXISTS `stock_inventario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stock_inventario` (
  `id_stock` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` int(11) NOT NULL,
  `cantidad_minima` int(11) NOT NULL,
  `cantidad_disponible` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_stock`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_inventario`
--

LOCK TABLES `stock_inventario` WRITE;
/*!40000 ALTER TABLE `stock_inventario` DISABLE KEYS */;
/*!40000 ALTER TABLE `stock_inventario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_categorias`
--

DROP TABLE IF EXISTS `sub_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sub_categorias` (
  `id_sub_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_sub_categoria`),
  KEY `id_categoria` (`id_categoria`),
  CONSTRAINT `sub_categorias_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_categorias`
--

LOCK TABLES `sub_categorias` WRITE;
/*!40000 ALTER TABLE `sub_categorias` DISABLE KEYS */;
INSERT INTO `sub_categorias` VALUES (5,NULL,NULL),(6,NULL,NULL),(7,NULL,NULL),(8,'r',23);
/*!40000 ALTER TABLE `sub_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id_rol` int(11) DEFAULT NULL,
  `id_estado` int(11) DEFAULT NULL,
  `documento` int(11) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_de_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `id_foto` int(11) DEFAULT NULL,
  `token_password` varchar(250) DEFAULT NULL,
  `password_request` int(11) DEFAULT 0,
  `intentos_fallidos` int(11) DEFAULT 0,
  PRIMARY KEY (`documento`),
  KEY `id_rol` (`id_rol`),
  KEY `id_estado` (`id_estado`),
  KEY `id_foto` (`id_foto`),
  CONSTRAINT `fK_foto` FOREIGN KEY (`id_foto`) REFERENCES `fotos` (`id_foto`) ON DELETE CASCADE,
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`),
  CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`id_estado`) REFERENCES `estados_usuarios` (`id_estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,1,1,'a','a','1','a@example.com','123','2024-06-21 15:09:23',NULL,NULL,NULL,0),(2,1,15,'Mesero','Rios','3027066408','Juan@gmail.com','$2y$10$vld66BO7Wp2L8y8nIgX6JO7hF1DuRwZxRfaWoeFg7DJ9JJKazT70m','2024-07-04 09:07:17',101,NULL,NULL,0),(1,1,22,'Dave','.','22','damerchan99@soy.sena.edu.co','$2y$10$WYVi7JIdURgsgE3LGXvyBOXRdCKCph7IyTrbjACe7hgvmoLdGNP1W','2024-07-06 10:53:00',108,'',0,0),(1,1,33,'TEST','CORREO','4545','fastSoftware2024@outlook.com','$2y$10$qFmF9bDUvOYw87oELwftdOyuxj.Gmnxacy7ME1QotbLr66zIlo8w6','2024-08-03 23:23:24',109,'13485639d766a12a9723019834ad4b6b',1,0),(1,1,66,'admin','.','123','admin@x.com','$2y$10$ahr/ISAE81WgniFI27ysS.vY9xZlEZi/wAVuA80riLWaYXlngKWyS','2024-08-19 19:06:45',110,NULL,0,0),(1,1,90,'admin2@x.com','x','123','admin2@x.com','$2y$10$g.MTUws014kqmZikJdDox.Mi2tkHXY/v4q.tImwmhzFcKtsyDYLNu','2024-08-24 17:33:46',112,NULL,0,0);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venta`
--

DROP TABLE IF EXISTS `venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `venta` (
  `id_venta` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) DEFAULT NULL,
  `total` decimal(10,0) NOT NULL,
  `subTotal` decimal(10,0) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `IVA` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_venta`),
  KEY `id_pedido` (`id_pedido`),
  CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venta`
--

LOCK TABLES `venta` WRITE;
/*!40000 ALTER TABLE `venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `venta` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-06 22:49:13
