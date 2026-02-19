-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 15-02-2026 a las 18:09:56
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `farmaciav1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edad` date NOT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sexo_id` bigint UNSIGNED NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellidos`, `dni`, `edad`, `telefono`, `correo`, `direccion`, `created_at`, `updated_at`, `sexo_id`, `avatar`, `estado`) VALUES
(1, 'Elvis Jose', 'Pavón Zeas', '046140593000H', '1993-05-14', '86479297', 'qemesulocu@mailinator.com', 'Carazo\r\nCarazo', '2025-02-07 23:47:41', '2025-03-01 17:11:04', 1, 'storage/proveedor/p9Z2Mz8w1NmesX32UEtb3VsmYqdXuPhDoWgrBYqM.jpg', 'Activo'),
(2, 'Diana Beattiz ', 'Ramos', '54', '2002-03-02', '52', 'nyludu@mailinator.com', 'Maiores molestiae au', '2025-02-08 00:02:03', '2025-02-12 00:17:28', 2, 'storage/proveedor/Azi4BeqsMBDEYEsr8p9YAze558bmkI21W24sDoXp.jpg', 'Activo'),
(3, 'Magaly del Socorro', 'Martinez Zeledon', '21545465414', '1995-08-17', '86479297', 'magal7@gmail.com', 'Carazo\r\nCarazo', '2025-03-09 00:32:17', '2025-03-17 02:03:13', 2, 'storage/proveedor/qm4UsDa8hSdfZge7iNUuXhOW43ovoNI7jq2edlVW.jpg', 'Activo');

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
(10, '21212M', '2025-02-28', '2025-03-28', 50, 1, 1, '2025-04-05 17:08:41', '2025-03-01 00:56:46'),
(11, '2102', '2025-02-28', '2025-03-28', 60, 2, 2, '2025-02-28 19:26:29', '2025-03-01 01:26:29'),
(13, '2351', '2025-03-08', '2025-03-30', 150, 2, 1, '2025-03-08 17:58:39', '2025-03-08 23:58:39'),
(14, '32526', '2025-03-08', '2025-03-18', 120, 2, 1, '2025-03-08 18:00:38', '2025-03-09 00:00:38'),
(15, '468', '2025-03-08', '2025-03-26', 60, 2, 1, '2025-03-08 18:02:54', '2025-03-09 00:02:54'),
(16, '30200', '2025-03-17', '2025-03-30', 10, 2, 3, '2025-03-17 17:42:02', '2025-03-17 23:42:02'),
(17, '30200', '2025-03-17', '2025-03-30', 10, 2, 3, '2025-03-17 17:42:20', '2025-03-17 23:42:20'),
(18, '30200', '2025-03-17', '2025-03-30', 10, 2, 3, '2025-03-17 17:43:01', '2025-03-17 23:43:01'),
(19, '000101', '2025-03-17', '2025-03-30', 10, 2, 3, '2025-03-17 17:43:53', '2025-03-17 23:43:53'),
(20, '000101', '2025-03-17', '2025-03-30', 10, 2, 3, '2025-03-17 17:44:34', '2025-03-17 23:44:34'),
(21, '302011', '2025-03-17', '2025-03-30', 15, 2, 3, '2025-03-17 17:45:44', '2025-03-17 23:45:44'),
(22, '21201Ñ', '2025-03-17', '2025-03-30', 200, 2, 3, '2025-03-17 17:49:13', '2025-03-17 23:49:13'),
(23, '21201Ñ', '2025-03-17', '2025-03-30', 200, 2, 3, '2025-03-17 17:49:21', '2025-03-17 23:49:21'),
(24, '02310', '2025-03-17', '2025-03-30', 5, 2, 2, '2025-03-17 17:54:18', '2025-03-17 23:54:18'),
(25, '021010', '2025-03-17', '2025-03-28', 15, 1, 3, '2025-03-17 17:59:01', '2025-03-17 23:59:01'),
(26, '451145', '2025-03-17', '2025-04-16', 650, 2, 2, '2025-03-17 18:44:41', '2025-03-18 00:44:41');

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
(16, 1, '2025-09-28', 11, 12, 2, 10, 'Facturado', '2025-03-13 19:59:24', '2025-03-13 19:59:24'),
(17, 12, '2025-05-23', 14, 15, 1, 11, 'cancelado', '2025-03-16 19:57:30', '2025-03-16 19:30:27'),
(18, 24, '2025-05-23', 14, 15, 1, 12, 'cancelado', '2025-03-16 19:58:53', '2025-03-16 19:58:00'),
(19, 24, '2025-05-23', 14, 15, 1, 13, 'cancelado', '2025-03-16 19:59:46', '2025-03-16 19:59:30'),
(20, 150, '2026-11-17', 22, 13, 3, 14, 'Facturado', '2025-03-17 18:20:53', '2025-03-17 18:20:53'),
(21, 50, '2026-11-17', 22, 13, 3, 15, 'Facturado', '2025-03-17 18:22:15', '2025-03-17 18:22:15'),
(22, 24, '2025-05-23', 14, 15, 1, 16, 'Facturado', '2025-03-17 18:30:58', '2025-03-17 18:30:58'),
(23, 1, '2025-09-28', 11, 12, 2, 17, 'Facturado', '2025-03-17 18:33:32', '2025-03-17 18:33:32'),
(24, 1, '2026-11-17', 22, 13, 3, 17, 'Facturado', '2025-03-17 18:33:32', '2025-03-17 18:33:32'),
(25, 1, '2025-05-28', 10, 10, 1, 17, 'Facturado', '2025-03-17 18:33:32', '2025-03-17 18:33:32'),
(26, 1, '2025-07-25', 19, 11, 3, 17, 'Facturado', '2025-03-17 18:33:32', '2025-03-17 18:33:32'),
(27, 1, '2025-06-28', 24, 14, 2, 17, 'Facturado', '2025-03-17 18:33:32', '2025-03-17 18:33:32'),
(28, 1, '2025-05-23', 14, 15, 1, 17, 'Facturado', '2025-03-17 18:33:32', '2025-03-17 18:33:32'),
(29, 1, '2025-09-28', 11, 12, 2, 18, 'Facturado', '2025-03-21 17:07:55', '2025-03-21 17:07:55'),
(30, 1, '2025-09-28', 11, 12, 2, 19, 'Facturado', '2025-03-21 17:08:51', '2025-03-21 17:08:51'),
(31, 1, '2025-09-28', 11, 12, 2, 20, 'Facturado', '2025-03-21 17:12:10', '2025-03-21 17:12:10'),
(32, 1, '2025-09-28', 11, 12, 2, 21, 'Facturado', '2025-03-21 17:14:01', '2025-03-21 17:14:01'),
(33, 1, '2025-09-28', 11, 12, 2, 22, 'Facturado', '2025-03-21 17:14:40', '2025-03-21 17:14:40'),
(34, 1, '2025-09-28', 11, 12, 2, 23, 'Facturado', '2025-03-21 18:02:30', '2025-03-21 18:02:30'),
(35, 10, '2025-09-28', 11, 12, 2, 24, 'Facturado', '2025-04-05 17:12:13', '2025-04-05 17:12:13');

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
  `estado` varchar(100) NOT NULL DEFAULT 'Activo',
  `updated_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `lote`
--

INSERT INTO `lote` (`id`, `codigo`, `cantidad`, `cantidad_lote`, `vencimiento`, `precio_compra`, `id_compra`, `id_producto`, `estado`, `updated_at`, `created_at`) VALUES
(9, '534', 20, 0, '2025-02-28', 30, 10, 12, 'Inactivo', '2025-03-08 16:55:01', '2025-03-01 00:56:46'),
(10, '212', 15, 34, '2025-05-28', 35, 10, 10, 'Activo', '2025-03-17 18:33:32', '2025-03-01 00:56:46'),
(11, '2320235', 25, 32, '2025-09-28', 50, 11, 12, 'Activo', '2025-04-05 17:12:14', '2025-03-01 01:26:29'),
(13, '032302', 1, 1, '2025-08-23', 65, 13, 15, 'Activo', '2025-03-08 17:58:39', '2025-03-08 23:58:39'),
(14, '5313', 120, 98, '2025-05-23', 70, 14, 15, 'Activo', '2025-03-17 18:33:32', '2025-03-09 00:00:38'),
(15, '562', 51, 0, '2025-03-07', 80, 15, 15, 'Inactivo', '2025-03-08 18:04:04', '2025-03-09 00:02:54'),
(16, '02101', 10, 10, '2025-08-31', 65, 16, 11, 'Activo', '2025-03-17 17:42:02', '2025-03-17 23:42:02'),
(17, '02101', 10, 10, '2025-08-31', 65, 17, 11, 'Activo', '2025-03-17 17:42:20', '2025-03-17 23:42:20'),
(18, '02101', 10, 10, '2025-08-31', 65, 18, 11, 'Activo', '2025-03-17 17:43:01', '2025-03-17 23:43:01'),
(19, '0032', 10, 9, '2025-07-25', 65, 19, 11, 'Activo', '2025-03-17 18:33:32', '2025-03-17 23:43:53'),
(20, '0032', 10, 10, '2025-07-25', 65, 20, 11, 'Activo', '2025-03-17 17:44:34', '2025-03-17 23:44:34'),
(21, '02150', 15, 15, '2026-04-17', 45, 21, 10, 'Activo', '2025-03-17 17:45:44', '2025-03-17 23:45:44'),
(22, '302220', 250, 49, '2026-11-17', 6, 22, 13, 'Activo', '2025-03-17 18:33:32', '2025-03-17 23:49:13'),
(23, '302220', 250, 250, '2026-11-17', 6, 23, 13, 'Activo', '2025-03-17 17:49:21', '2025-03-17 23:49:21'),
(24, '02022', 5, 4, '2025-06-28', 5, 24, 14, 'Activo', '2025-03-17 18:33:32', '2025-03-17 23:54:18'),
(25, '233141', 15, 15, '2025-09-19', 75, 25, 11, 'Activo', '2025-03-17 17:59:01', '2025-03-17 23:59:01'),
(26, '32324', 10, 10, '2025-08-30', 65, 26, 13, 'Activo', '2025-03-17 18:44:41', '2025-03-18 00:44:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(5, 'Frasco', 'Activo', '2024-11-03 16:40:50', '2024-11-03 16:40:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `concentracion` varchar(255) DEFAULT NULL,
  `adicional` varchar(255) DEFAULT NULL,
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

INSERT INTO `productos` (`id`, `nombre`, `concentracion`, `adicional`, `precio`, `id_lab`, `id_tip_prod`, `id_present`, `estado`, `avatar`, `updated_at`, `created_at`) VALUES
(10, 'Dextrometorfano', '10mg / 5cc', 'Para Tos', 55, 9, 2, 2, 'Activo', '1735765896.jpg', '2025-03-16 20:05:00', '2024-12-30 18:49:29'),
(11, 'Diclofenac Gel', '100mg', 'Analgesico', 60, 6, 2, 3, 'Activo', '1735766990.jpeg', '2025-03-16 20:06:01', '2024-12-30 18:49:42'),
(12, 'Acetominofen', '500mg', 'Fiebre', 30, 7, 2, 2, 'Activo', '1742083859.png', '2025-03-15 18:10:59', '2024-12-31 16:35:32'),
(13, 'Acetominofen', '500mg', 'Para la fiebre', 30, 3, 2, 1, 'Activo', '1735782547.jpeg', '2025-01-01 19:49:07', '2024-12-31 16:36:07'),
(14, 'Ibuprofeno', '600 mg', 'Dolor', 45, 5, 1, 1, 'Activo', NULL, '2025-03-08 17:56:58', '2025-01-01 19:50:10'),
(15, 'Menaxol', '600 mg', 'Mocos', 60, 4, 1, 3, 'Activo', '1742084617.jpg', '2025-03-15 18:23:37', '2025-01-01 19:50:37'),
(16, 'Animi a voluptatem', 'Voluptatem dolor ips', 'Aute omnis est dolo', 81, 9, 2, 3, 'Activo', NULL, '2025-01-02 17:38:02', '2025-01-02 17:38:02');

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
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(10, 'Diana Beatriz Ramos', '1742084760.jpg', 'diana@gmail.com', NULL, '$2y$10$KEv3tltYUUSH9P7u94k/F.11h79VKmTQSg1olTcCAgDk3F2OYTQmO', 2, 'Activo', NULL, '2025-03-09 00:27:50', '2025-03-16 00:26:00');

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
(7, NULL, 3, 520, 7, NULL, NULL, 'cancelado', '2025-04-15 19:39:25', '2025-03-13 19:06:19'),
(9, NULL, 2, 12, 8, NULL, NULL, 'Facturado', '2025-03-13 19:44:19', '2025-04-10 19:43:21'),
(10, NULL, NULL, 12, 7, NULL, NULL, 'Facturado', '2025-03-19 19:59:24', '2025-03-13 19:59:24'),
(11, NULL, NULL, 720, 10, NULL, NULL, 'cancelado', '2025-03-16 19:57:30', '2025-03-16 19:30:27'),
(12, NULL, NULL, 1440, 8, NULL, NULL, 'cancelado', '2025-03-16 19:58:53', '2025-03-16 19:58:00'),
(13, NULL, NULL, 1440, 7, NULL, NULL, 'cancelado', '2025-03-16 19:59:46', '2025-03-16 19:59:30'),
(14, NULL, 2, 4500, 7, NULL, NULL, 'Facturado', '2025-03-17 18:20:53', '2025-03-17 18:20:53'),
(15, NULL, NULL, 1500, 7, NULL, NULL, 'Facturado', '2025-03-17 18:22:15', '2025-03-17 18:22:15'),
(16, NULL, NULL, 1440, 7, NULL, NULL, 'Facturado', '2025-03-17 18:30:58', '2025-03-17 18:30:58'),
(17, NULL, 3, 280, 7, NULL, NULL, 'Facturado', '2025-03-17 18:33:32', '2025-03-17 18:33:32'),
(18, NULL, 3, 12, 7, NULL, NULL, 'Facturado', '2025-03-21 17:07:55', '2025-03-21 17:07:55'),
(19, NULL, NULL, 12, 7, NULL, NULL, 'Facturado', '2025-03-21 17:08:51', '2025-03-21 17:08:51'),
(20, NULL, NULL, 12, 7, NULL, NULL, 'Facturado', '2025-03-21 17:12:10', '2025-03-21 17:12:10'),
(21, NULL, NULL, 12, 7, NULL, NULL, 'Facturado', '2025-03-21 17:14:01', '2025-03-21 17:14:01'),
(22, NULL, NULL, 12, 7, NULL, NULL, 'Facturado', '2025-03-21 17:14:40', '2025-03-21 17:14:40'),
(23, NULL, NULL, 30, 7, 50, 20, 'Facturado', '2025-03-21 18:02:29', '2025-03-21 18:02:29'),
(24, NULL, NULL, 300, 7, 600, 300, 'Facturado', '2025-04-05 17:12:13', '2025-04-05 17:12:13');

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
(11, 30, 5, 150, 12, 7, '2025-03-13 19:06:19', '2025-03-13 19:06:19'),
(12, 60, 5, 300, 15, 7, '2025-03-13 19:06:19', '2025-03-13 19:06:19'),
(13, 14, 5, 70, 10, 7, '2025-03-13 19:06:19', '2025-03-13 19:06:19'),
(15, 30, 1, 30, 12, 9, '2025-03-13 19:43:21', '2025-03-13 19:43:21'),
(16, 30, 1, 30, 12, 10, '2025-03-13 19:59:24', '2025-03-13 19:59:24'),
(17, 60, 12, 720, 15, 11, '2025-03-16 19:30:27', '2025-03-16 19:30:27'),
(18, 60, 24, 1440, 15, 12, '2025-03-16 19:58:00', '2025-03-16 19:58:00'),
(19, 60, 24, 1440, 15, 13, '2025-03-16 19:59:30', '2025-03-16 19:59:30'),
(20, 30, 150, 4500, 13, 14, '2025-03-17 18:20:53', '2025-03-17 18:20:53'),
(21, 30, 50, 1500, 13, 15, '2025-03-17 18:22:15', '2025-03-17 18:22:15'),
(22, 60, 24, 1440, 15, 16, '2025-03-17 18:30:58', '2025-03-17 18:30:58'),
(23, 30, 1, 30, 12, 17, '2025-03-17 18:33:32', '2025-03-17 18:33:32'),
(24, 30, 1, 30, 13, 17, '2025-03-17 18:33:32', '2025-03-17 18:33:32'),
(25, 55, 1, 55, 10, 17, '2025-03-17 18:33:32', '2025-03-17 18:33:32'),
(26, 60, 1, 60, 11, 17, '2025-03-17 18:33:32', '2025-03-17 18:33:32'),
(27, 45, 1, 45, 14, 17, '2025-03-17 18:33:32', '2025-03-17 18:33:32'),
(28, 60, 1, 60, 15, 17, '2025-03-17 18:33:32', '2025-03-17 18:33:32'),
(29, 30, 1, 30, 12, 18, '2025-03-21 17:07:55', '2025-03-21 17:07:55'),
(30, 30, 1, 30, 12, 19, '2025-03-21 17:08:51', '2025-03-21 17:08:51'),
(31, 30, 1, 30, 12, 20, '2025-03-21 17:12:10', '2025-03-21 17:12:10'),
(32, 30, 1, 30, 12, 21, '2025-03-21 17:14:01', '2025-03-21 17:14:01'),
(33, 30, 1, 30, 12, 22, '2025-03-21 17:14:40', '2025-03-21 17:14:40'),
(34, 30, 1, 30, 12, 23, '2025-03-21 18:02:30', '2025-03-21 18:02:30'),
(35, 30, 10, 300, 12, 24, '2025-04-05 17:12:14', '2025-04-05 17:12:14');

--
-- Índices para tablas volcadas
--

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
  ADD KEY `id_producto` (`id_producto`);

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
  ADD KEY `id_tip_prod` (`id_tip_prod`);

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
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `venta_producto`
--
ALTER TABLE `venta_producto`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

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
  ADD CONSTRAINT `lote_ibfk_2` FOREIGN KEY (`id_compra`) REFERENCES `compras` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_present`) REFERENCES `presentaciones` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`id_lab`) REFERENCES `laboratorios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `productos_ibfk_3` FOREIGN KEY (`id_tip_prod`) REFERENCES `tipos_productos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

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
