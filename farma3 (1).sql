-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 21-02-2026 a las 00:34:42
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `farma3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adicionales`
--

CREATE TABLE `adicionales` (
  `id` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8mb4_general_ci DEFAULT 'Activo',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `adicionales`
--

INSERT INTO `adicionales` (`id`, `nombre`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Antipirético', 'Activo', '2026-02-19 18:35:38', '2026-02-19 18:35:38'),
(2, 'Analgésico', 'Activo', '2026-02-19 18:35:38', '2026-02-19 18:35:38'),
(3, 'Antiinflamatorio', 'Activo', '2026-02-19 18:35:38', '2026-02-19 18:35:38'),
(4, 'Antibiótico', 'Activo', '2026-02-19 18:35:38', '2026-02-19 18:35:38'),
(5, 'Antialérgico', 'Activo', '2026-02-19 18:35:38', '2026-02-19 18:35:38'),
(6, 'Antigripal', 'Activo', '2026-02-19 18:35:38', '2026-02-19 18:35:38'),
(7, 'Descongestionante', 'Activo', '2026-02-19 18:35:38', '2026-02-19 18:35:38'),
(8, 'Antitusivo', 'Activo', '2026-02-19 18:35:38', '2026-02-19 18:35:38'),
(9, 'Mucolítico', 'Activo', '2026-02-19 18:35:38', '2026-02-19 18:35:38'),
(10, 'Antiespasmódico', 'Activo', '2026-02-19 18:35:38', '2026-02-19 18:35:38'),
(11, 'Gastroprotector', 'Activo', '2026-02-19 18:35:38', '2026-02-19 18:35:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `edad` date NOT NULL,
  `telefono` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sexo_id` bigint UNSIGNED NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellidos`, `dni`, `edad`, `telefono`, `correo`, `direccion`, `created_at`, `updated_at`, `sexo_id`, `avatar`, `estado`) VALUES
(1, 'Elvis Jose', 'Pavón Zeas', '046140593000H', '1993-05-14', '86479297', 'qemesulocu@mailinator.com', 'Carazo\r\nCarazo', '2025-02-07 23:47:41', '2025-03-01 17:11:04', 1, 'storage/proveedor/p9Z2Mz8w1NmesX32UEtb3VsmYqdXuPhDoWgrBYqM.jpg', 'Activo'),
(2, 'Diana Beattiz ', 'Ramos', '54', '2002-03-02', '52', 'nyludu@mailinator.com', 'Maiores molestiae au', '2025-02-08 00:02:03', '2025-02-12 00:17:28', 2, 'storage/proveedor/Azi4BeqsMBDEYEsr8p9YAze558bmkI21W24sDoXp.jpg', 'Activo'),
(3, 'Magaly del Socorro', 'Martinez Zeledon', '21545465414', '1995-08-17', '86479297', 'magal7@gmail.com', 'Carazo\r\nCarazo', '2025-03-09 00:32:17', '2025-03-17 02:03:13', 2, 'storage/proveedor/qm4UsDa8hSdfZge7iNUuXhOW43ovoNI7jq2edlVW.jpg', 'Activo'),
(4, 'Manuel', 'Tananta Lino', '77432766', '2003-10-14', '939631427', 'xxmanuel.love@gmail.com', 'Aguaytia\r\nUcayali', '2026-02-15 23:23:52', '2026-02-16 00:13:26', 1, 'storage/proveedor/gYk05L3JYFTIESIlVdae46NZIjS75mh4QbfAH7m5.png', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int NOT NULL,
  `codigo` varchar(100) NOT NULL,
  `fecha_compra` date NOT NULL,
  `fecha_entrega` date NOT NULL,
  `total` float NOT NULL,
  `id_estado_pago` int NOT NULL,
  `id_proveedor` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `codigo`, `fecha_compra`, `fecha_entrega`, `total`, `id_estado_pago`, `id_proveedor`, `updated_at`, `created_at`) VALUES
(30, '214', '2026-02-19', '2026-02-19', 30, 1, 1, '2026-02-19 13:04:25', '2026-02-19 19:02:16'),
(31, '21432514', '2026-02-20', '2026-02-20', 292.5, 2, 2, '2026-02-20 12:46:10', '2026-02-20 18:46:10'),
(32, '214', '2026-02-20', '2026-02-20', 162.5, 1, 1, '2026-02-20 13:09:04', '2026-02-20 19:09:04'),
(33, '214', '2026-02-20', '2026-02-20', 1625, 1, 1, '2026-02-20 13:10:09', '2026-02-20 19:10:09'),
(34, '214', '2026-02-20', '2026-02-20', 1625, 1, 1, '2026-02-20 13:10:17', '2026-02-20 19:10:17'),
(35, '214', '2026-02-20', '2026-02-20', 1625, 1, 1, '2026-02-20 13:12:32', '2026-02-20 19:12:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `id` int NOT NULL,
  `det_cantidad` int NOT NULL,
  `det_vencimiento` date NOT NULL,
  `id_det_lote` int NOT NULL,
  `id_det_prod` int NOT NULL,
  `lote_id_prov` int NOT NULL,
  `id_det_venta` int NOT NULL,
  `estado` varchar(100) NOT NULL DEFAULT 'Facturado',
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`id`, `det_cantidad`, `det_vencimiento`, `id_det_lote`, `id_det_prod`, `lote_id_prov`, `id_det_venta`, `estado`, `updated_at`, `created_at`) VALUES
(51, 4, '2026-02-18', 30, 18, 1, 35, 'Facturado', '2026-02-19 15:40:13', '2026-02-19 15:40:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_pago`
--

CREATE TABLE `estado_pago` (
  `id` int NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `estado_pago`
--

INSERT INTO `estado_pago` (`id`, `nombre`) VALUES
(1, 'Cancelado'),
(2, 'No Cancelado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `laboratorios`
--

CREATE TABLE `laboratorios` (
  `id` int NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'Activo',
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `laboratorios`
--

INSERT INTO `laboratorios` (`id`, `nombre`, `foto`, `estado`, `updated_at`, `created_at`) VALUES
(1, 'Laboratorio Ramos', NULL, 'Inactivo', '2024-11-02 16:41:18', '2024-11-02 22:29:02'),
(2, 'Laboratorio Solka', NULL, 'Inactivo', '2024-11-02 16:40:00', '2024-11-02 22:29:02'),
(3, 'Laboratorios Suizos', NULL, 'Inactivo', '2024-11-02 16:43:05', '2024-11-02 22:29:02'),
(4, 'Laboratorios Lannacher', NULL, 'Inactivo', '2024-11-02 16:43:12', '2024-11-02 22:29:02'),
(5, 'Laboratorio La Sante', NULL, 'Inactivo', '2024-11-02 16:56:25', '2024-11-02 22:29:02'),
(6, 'Laboratorios López', 'laboratorios/w1KvpFt1qgowHu80sLCAYH5BhkA56ezPdFZJTJZA.png', 'Activo', '2024-11-03 14:54:59', '2024-11-02 22:29:02'),
(7, 'Laboratorios Ramos S.A.', 'laboratorios/T6NWa7WyIOTWELWy2kI7w6OoHxspv7UfYOJnQJhR.webp', 'Activo', '2024-11-03 14:55:08', '2024-11-02 22:29:02'),
(8, 'Laboratorios Panter', 'laboratorios/br24Z2vLvXMi2QBxUlSlVHfeg0vUnpGhELr7fcfW.png', 'Activo', '2024-11-03 14:53:45', '2024-11-02 22:29:02'),
(9, 'Laboratorios Mejía', NULL, 'Inactivo', '2024-11-02 16:56:31', '2024-11-02 22:29:02'),
(10, 'Laboratorio Kielsa', NULL, 'Inactivo', '2024-11-02 16:40:36', '2024-11-02 22:29:02'),
(15, 'Canola Life', 'default.png', 'Inactivo', '2025-04-05 17:09:59', '2025-04-05 23:09:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lote`
--

CREATE TABLE `lote` (
  `id` int NOT NULL,
  `codigo` varchar(100) NOT NULL,
  `cantidad` int NOT NULL,
  `cantidad_lote` int NOT NULL,
  `vencimiento` date NOT NULL,
  `precio_compra` int NOT NULL,
  `id_compra` int NOT NULL,
  `id_producto` int NOT NULL,
  `id_unidad` int DEFAULT NULL,
  `estado` varchar(100) NOT NULL DEFAULT 'Activo',
  `updated_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `lote`
--

INSERT INTO `lote` (`id`, `codigo`, `cantidad`, `cantidad_lote`, `vencimiento`, `precio_compra`, `id_compra`, `id_producto`, `id_unidad`, `estado`, `updated_at`, `created_at`) VALUES
(30, '214124', 25, 18, '2026-02-18', 1, 30, 18, NULL, 'Activo', '2026-02-19 15:40:13', '2026-02-19 19:02:16'),
(31, '211456', 65, 65, '2026-02-20', 5, 31, 20, NULL, 'Activo', '2026-02-20 12:46:10', '2026-02-20 18:46:10'),
(32, '123', 65, 65, '2026-02-20', 25, 35, 20, 5, 'Activo', '2026-02-20 13:12:32', '2026-02-20 19:12:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medidas`
--

CREATE TABLE `medidas` (
  `id` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `abreviatura` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8mb4_general_ci DEFAULT 'Activo',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medidas`
--

INSERT INTO `medidas` (`id`, `nombre`, `abreviatura`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Miligramo', 'mg', 'Activo', '2026-02-20 17:20:47', '2026-02-20 17:20:47'),
(2, 'Gramo', 'g', 'Activo', '2026-02-20 17:20:47', '2026-02-20 17:20:47'),
(3, 'Mililitro', 'ml', 'Activo', '2026-02-20 17:20:47', '2026-02-20 17:20:47'),
(4, 'Litro', 'L', 'Activo', '2026-02-20 17:20:47', '2026-02-20 17:20:47'),
(5, 'Unidad', 'und', 'Activo', '2026-02-20 17:20:47', '2026-02-20 17:20:47'),
(6, 'Caja', 'caja', 'Activo', '2026-02-20 17:20:47', '2026-02-20 17:20:47'),
(7, 'Frasco', 'frasco', 'Activo', '2026-02-20 17:20:47', '2026-02-20 17:20:47'),
(8, 'Tableta', 'tab', 'Activo', '2026-02-20 17:20:47', '2026-02-20 17:20:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_02_05_185816_create_clientes_table', 1),
(2, '2025_02_05_190252_create_sexos_table', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('xxmanuel.love@gmail.com', '$2y$10$e2.fGQfeokoqnPrsIPsAz.YdkIBL0cWm7jkPqvzbConp/uOX0zK6O', '2026-02-18 20:57:59'),
('zeaselvis7@gmail.com', '$2y$10$j45Ge.I2plhHcYFm/fHVWese2zSvf8Dq9NqkEvy6a4SrSKqtwyKPC', '2025-03-23 00:11:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentaciones`
--

CREATE TABLE `presentaciones` (
  `id` int NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'Activo',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `presentaciones`
--

INSERT INTO `presentaciones` (`id`, `nombre`, `estado`, `updated_at`, `created_at`) VALUES
(1, 'Tabletas', 'Activo', '2024-11-03 16:22:19', '2024-11-03 16:22:19'),
(2, 'Ampollas', 'Activo', '2024-11-03 16:22:37', '2024-11-03 16:22:37'),
(3, 'Sobres', 'Activo', '2024-11-03 16:27:30', '2024-11-03 16:27:30'),
(4, 'Frasco', 'Inactivo', '2024-11-03 16:40:39', '2024-11-03 16:27:38'),
(5, 'Frasco', 'Activo', '2024-11-03 16:40:50', '2024-11-03 16:40:50'),
(6, 'Cápsulas', 'Activo', '2026-02-18 14:47:18', '2026-02-18 14:47:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `concentracion` varchar(255) DEFAULT NULL,
  `id_adicional` int DEFAULT NULL,
  `precio` float NOT NULL,
  `id_lab` int NOT NULL,
  `id_tip_prod` int NOT NULL,
  `id_present` int NOT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'Activo',
  `avatar` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `concentracion`, `id_adicional`, `precio`, `id_lab`, `id_tip_prod`, `id_present`, `estado`, `avatar`, `updated_at`, `created_at`) VALUES
(10, 'Dextrometorfano', '10mg / 5cc', NULL, 55, 9, 2, 2, 'Activo', '1735765896.jpg', '2025-03-16 20:05:00', '2024-12-30 18:49:29'),
(11, 'Diclofenac Gel', '100mg', NULL, 60, 6, 2, 3, 'Activo', '1735766990.jpeg', '2025-03-16 20:06:01', '2024-12-30 18:49:42'),
(12, 'Acetominofen', '500mg', NULL, 30, 7, 2, 2, 'Inactivo', '1742083859.png', '2025-03-15 18:10:59', '2024-12-31 16:35:32'),
(13, 'Acetominofen', '500mg', NULL, 30, 3, 2, 1, 'Inactivo', '1735782547.jpeg', '2025-01-01 19:49:07', '2024-12-31 16:36:07'),
(14, 'Ibuprofeno', '600 mg', NULL, 45, 5, 1, 1, 'Activo', NULL, '2025-03-08 17:56:58', '2025-01-01 19:50:10'),
(15, 'Menaxol', '600 mg', NULL, 60, 4, 1, 3, 'Activo', '1742084617.jpg', '2025-03-15 18:23:37', '2025-01-01 19:50:37'),
(16, 'Animi a voluptatem', 'Voluptatem dolor ips', NULL, 81, 9, 2, 3, 'Activo', NULL, '2025-01-02 17:38:02', '2025-01-02 17:38:02'),
(17, 'Paracetamol', '500 mg', 2, 5, 1, 2, 1, 'Activo', '1771199596.jpg', '2026-02-20 09:17:10', '2026-02-15 18:36:27'),
(18, 'Paracetamol', '500 mg', 2, 0.5, 1, 1, 1, 'Activo', '1771443456.jpg', '2026-02-19 15:24:34', '2026-02-18 14:37:16'),
(19, 'Ibuprofeno', '400 mg', NULL, 0.8, 1, 2, 1, 'Activo', NULL, '2026-02-18 14:46:20', '2026-02-18 14:46:20'),
(20, 'Amoxicilina', '500 mg', 1, 2, 1, 2, 6, 'Activo', NULL, '2026-02-19 15:30:15', '2026-02-18 14:47:50'),
(21, 'Dolocordralan', '1 g', NULL, 3, 1, 1, 1, 'Activo', NULL, '2026-02-18 14:48:37', '2026-02-18 14:48:37'),
(22, 'Dextrometorfano Jarabe', '15 mg / 5 ml', NULL, 6, 1, 1, 4, 'Activo', NULL, '2026-02-18 14:49:15', '2026-02-18 14:49:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `telefono` int NOT NULL,
  `correo` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) NOT NULL,
  `estado` varchar(100) NOT NULL DEFAULT 'Activo',
  `avatar` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `telefono`, `correo`, `direccion`, `estado`, `avatar`, `updated_at`, `created_at`) VALUES
(1, 'elvis pavon zeas', 285415, 'lejune@mailinator.com', 'Soluta qui velit ex', 'Activo', 'storage/proveedor/PHJskrct2PllFqTBBKuAKlzVZbwCmhfcrZLQHe6q.jpg', '2025-03-08 18:30:11', '2025-01-03 18:55:37'),
(2, 'Alexander Muñoz', 325654, 'zeaselvis7@gmail.com', 'Carazo', 'Activo', 'storage/proveedor/9BfE3F6qbjLOs5wH3wBU1rgpva3JzxHz098ztc6O.png', '2025-03-08 18:32:59', '2025-01-03 18:55:54'),
(3, 'Jose Antonio Perez', 5824216, 'Juan@gmail.com', 'Carazo', 'Activo', NULL, '2025-03-08 18:31:02', '2025-03-08 18:31:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sexos`
--

CREATE TABLE `sexos` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sexos`
--

INSERT INTO `sexos` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Masculino', NULL, NULL),
(2, 'Femenino', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos`
--

CREATE TABLE `tipos` (
  `id` int NOT NULL,
  `nombre` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `tipos`
--

INSERT INTO `tipos` (`id`, `nombre`) VALUES
(1, 'Root'),
(2, 'Farmaceutico'),
(3, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_productos`
--

CREATE TABLE `tipos_productos` (
  `id` int NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'Activo',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `tipos_productos`
--

INSERT INTO `tipos_productos` (`id`, `nombre`, `estado`, `updated_at`, `created_at`) VALUES
(1, 'Comercial', 'Activo', '2024-11-03 15:27:09', '2024-11-03 15:27:09'),
(2, 'Generico', 'Activo', '2024-11-03 15:58:15', '2024-11-03 15:32:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_tipo` int NOT NULL,
  `estado` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Activo',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `avatar`, `email`, `email_verified_at`, `password`, `id_tipo`, `estado`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Grethel del carmen Treminio Gonzalez', '', 'docente@gmail.com', NULL, '$2y$10$oBa/EpxJw.0Zfpu74by2Iu/NHkR/YwQNaf3EnLxlvFhBXYZRnrbsm', 2, 'Inactivo', NULL, '2024-06-28 13:27:26', '2024-10-14 23:48:29'),
(3, 'Manuel Maglevi Borge Rubios', '', 'ucmejb19@gmail.com', NULL, '$2y$10$bOCEiGzffReQAWE6lb4a2Oa6CnI6Z7Hu9C.WqeQbJtt1Y.swibQAm', 3, 'Inactivo', NULL, '2024-06-28 13:27:57', '2024-10-14 23:48:26'),
(7, 'Elvis José Pavón Zeas', '1728947793.jpg', 'zeaselvis7@gmail.com', NULL, '$2y$10$GBhjjkkdAJ.DTAA.WGjhVO1QffMQ97kX2DVN4BLF.aekkFsrZC1oC', 1, 'Activo', NULL, '2024-10-08 00:50:41', '2025-03-22 23:23:41'),
(8, 'prueba', '1741480017.jpg', 'prueba@gmail.com', NULL, '$2y$10$dVLZfCKrCVOyE8io6t6V0OfQjLvvQ5cxqJqGtSHTrU048ynI4I4Vu', 3, 'Activo', NULL, '2024-10-14 23:44:28', '2025-03-09 00:26:57'),
(10, 'Diana Beatriz Ramos', '1742084760.jpg', 'diana@gmail.com', NULL, '$2y$10$KEv3tltYUUSH9P7u94k/F.11h79VKmTQSg1olTcCAgDk3F2OYTQmO', 2, 'Activo', NULL, '2025-03-09 00:27:50', '2025-03-16 00:26:00'),
(11, 'Manuel', '1771200919.jpg', 'xxmanuel.love@gmail.com', NULL, '$2y$10$Mb.hxQBcNvPVQhxSMRmKju0Uohd0e0yiuGwdH/if9UzgyK/4NOmCK', 1, 'Activo', NULL, '2026-02-15 22:13:57', '2026-02-18 17:42:50'),
(12, 'Gise del alguila rodriguez', '1771201594.png', 'gise.love@gmail.com', NULL, '$2y$10$qfiapEqlqkOpx3.UBLvZPeTipt4/UlFQtAdYxmPiF6YsrsKeaKTZ.', 2, 'Activo', NULL, '2026-02-16 00:26:17', '2026-02-16 00:26:34'),
(13, 'jefferson lino', '1771252597.png', 'jefferson.love@gmail.com', NULL, '$2y$10$KaA/4O3bgKJXx/zMwoGiTOctoFF7pYcZLv9T5zXpBJuzNr7QGLCeK', 3, 'Activo', NULL, '2026-02-16 14:35:55', '2026-02-16 14:36:37'),
(14, 'Tito Saboya', NULL, 'xxmanuel123.love@gmail.com', NULL, '$2y$10$zyZ82HwpqTagKYGNb0hTZebDlFimLXPfzNNy/hcvCbKxaT1qqv0e2', 3, 'Activo', NULL, '2026-02-18 21:02:33', '2026-02-18 21:04:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `id` int NOT NULL,
  `cliente_no_reg` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `id_cliente` int DEFAULT NULL,
  `total` float DEFAULT NULL,
  `vendedor` int NOT NULL,
  `pago` float DEFAULT NULL,
  `vuelto` float DEFAULT NULL,
  `estado` varchar(100) NOT NULL DEFAULT 'Facturado',
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`id`, `cliente_no_reg`, `id_cliente`, `total`, `vendedor`, `pago`, `vuelto`, `estado`, `updated_at`, `created_at`) VALUES
(35, NULL, NULL, 2, 7, 4, 2, 'Facturado', '2026-02-19 15:40:13', '2026-02-19 15:40:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_producto`
--

CREATE TABLE `venta_producto` (
  `id` int NOT NULL,
  `precio` float NOT NULL,
  `cantidad` int NOT NULL,
  `subtotal` float NOT NULL,
  `id_producto` int NOT NULL,
  `id_venta` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `venta_producto`
--

INSERT INTO `venta_producto` (`id`, `precio`, `cantidad`, `subtotal`, `id_producto`, `id_venta`, `updated_at`, `created_at`) VALUES
(51, 0.5, 4, 2, 18, 35, '2026-02-19 15:40:13', '2026-02-19 15:40:13');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `adicionales`
--
ALTER TABLE `adicionales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clientes_dni_unique` (`dni`),
  ADD KEY `sexo_id` (`sexo_id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_estado_pago` (`id_estado_pago`,`id_proveedor`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_det_venta` (`id_det_venta`),
  ADD KEY `id_det_lote` (`id_det_lote`,`id_det_prod`,`lote_id_prov`),
  ADD KEY `lote_id_prov` (`lote_id_prov`),
  ADD KEY `id_det_prod` (`id_det_prod`);

--
-- Indices de la tabla `estado_pago`
--
ALTER TABLE `estado_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `laboratorios`
--
ALTER TABLE `laboratorios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lote`
--
ALTER TABLE `lote`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_compra` (`id_compra`,`id_producto`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_unidad` (`id_unidad`);

--
-- Indices de la tabla `medidas`
--
ALTER TABLE `medidas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_lab` (`id_lab`,`id_tip_prod`,`id_present`),
  ADD KEY `id_present` (`id_present`),
  ADD KEY `id_tip_prod` (`id_tip_prod`),
  ADD KEY `id_adicional` (`id_adicional`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sexos`
--
ALTER TABLE `sexos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos`
--
ALTER TABLE `tipos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos_productos`
--
ALTER TABLE `tipos_productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `id_tipo` (`id_tipo`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendedor` (`vendedor`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `venta_producto`
--
ALTER TABLE `venta_producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`,`id_venta`),
  ADD KEY `id_venta` (`id_venta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `adicionales`
--
ALTER TABLE `adicionales`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `estado_pago`
--
ALTER TABLE `estado_pago`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `laboratorios`
--
ALTER TABLE `laboratorios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `lote`
--
ALTER TABLE `lote`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `medidas`
--
ALTER TABLE `medidas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sexos`
--
ALTER TABLE `sexos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipos`
--
ALTER TABLE `tipos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipos_productos`
--
ALTER TABLE `tipos_productos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `venta_producto`
--
ALTER TABLE `venta_producto`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`sexo_id`) REFERENCES `sexos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`id_estado_pago`) REFERENCES `estado_pago` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `detalle_venta_ibfk_1` FOREIGN KEY (`id_det_venta`) REFERENCES `venta` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `detalle_venta_ibfk_2` FOREIGN KEY (`id_det_lote`) REFERENCES `lote` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `detalle_venta_ibfk_3` FOREIGN KEY (`lote_id_prov`) REFERENCES `proveedores` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `detalle_venta_ibfk_4` FOREIGN KEY (`id_det_prod`) REFERENCES `productos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `lote`
--
ALTER TABLE `lote`
  ADD CONSTRAINT `lote_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `lote_ibfk_2` FOREIGN KEY (`id_compra`) REFERENCES `compras` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `lote_ibfk_3` FOREIGN KEY (`id_unidad`) REFERENCES `medidas` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_present`) REFERENCES `presentaciones` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`id_lab`) REFERENCES `laboratorios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `productos_ibfk_3` FOREIGN KEY (`id_tip_prod`) REFERENCES `tipos_productos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `productos_ibfk_4` FOREIGN KEY (`id_adicional`) REFERENCES `adicionales` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`vendedor`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `venta_producto`
--
ALTER TABLE `venta_producto`
  ADD CONSTRAINT `venta_producto_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `venta_producto_ibfk_2` FOREIGN KEY (`id_venta`) REFERENCES `venta` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
