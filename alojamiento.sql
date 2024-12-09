-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.40 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for sistema_alojamiento
CREATE DATABASE IF NOT EXISTS `sistema_alojamiento` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sistema_alojamiento`;

-- Dumping structure for table sistema_alojamiento.cancelaciones
CREATE TABLE IF NOT EXISTS `cancelaciones` (
  `id_cancelacion` int NOT NULL AUTO_INCREMENT,
  `id_reserva` int NOT NULL,
  `id_usuario` int NOT NULL,
  `fecha_cancelacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `motivo_cancelacion` text NOT NULL,
  PRIMARY KEY (`id_cancelacion`),
  KEY `id_reserva` (`id_reserva`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `cancelaciones_ibfk_1` FOREIGN KEY (`id_reserva`) REFERENCES `reservas` (`id_reserva`) ON DELETE CASCADE,
  CONSTRAINT `cancelaciones_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table sistema_alojamiento.cancelaciones: ~0 rows (approximately)

-- Dumping structure for table sistema_alojamiento.espacios
CREATE TABLE IF NOT EXISTS `espacios` (
  `id_espacio` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text,
  `ubicacion` varchar(255) NOT NULL,
  `capacidad` int NOT NULL,
  `estado` enum('DISPONIBLE','NO DISPONIBLE') DEFAULT 'DISPONIBLE',
  PRIMARY KEY (`id_espacio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table sistema_alojamiento.espacios: ~0 rows (approximately)

-- Dumping structure for table sistema_alojamiento.imagenes_espacios
CREATE TABLE IF NOT EXISTS `imagenes_espacios` (
  `id_imagen` int NOT NULL AUTO_INCREMENT,
  `id_espacio` int NOT NULL,
  `url_imagen` varchar(255) NOT NULL,
  PRIMARY KEY (`id_imagen`),
  KEY `id_espacio` (`id_espacio`),
  CONSTRAINT `imagenes_espacios_ibfk_1` FOREIGN KEY (`id_espacio`) REFERENCES `espacios` (`id_espacio`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table sistema_alojamiento.imagenes_espacios: ~0 rows (approximately)

-- Dumping structure for table sistema_alojamiento.logs_auditoria
CREATE TABLE IF NOT EXISTS `logs_auditoria` (
  `id_log` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `accion` text NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_log`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `logs_auditoria_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table sistema_alojamiento.logs_auditoria: ~0 rows (approximately)

-- Dumping structure for table sistema_alojamiento.notificaciones
CREATE TABLE IF NOT EXISTS `notificaciones` (
  `id_notificacion` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `tipo` enum('CORREO','SMS') DEFAULT NULL,
  `mensaje` text NOT NULL,
  `fecha_envio` datetime DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('ENVIADO','PENDIENTE') DEFAULT 'PENDIENTE',
  PRIMARY KEY (`id_notificacion`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table sistema_alojamiento.notificaciones: ~0 rows (approximately)

-- Dumping structure for table sistema_alojamiento.pagos
CREATE TABLE IF NOT EXISTS `pagos` (
  `id_pago` int NOT NULL AUTO_INCREMENT,
  `id_reserva` int NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `metodo_pago` enum('CREDITO','PAYPAL','TRANSFERENCIA') DEFAULT NULL,
  `estado` enum('PENDIENTE','COMPLETADO','FALLIDO') DEFAULT 'PENDIENTE',
  `fecha_pago` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pago`),
  KEY `id_reserva` (`id_reserva`),
  CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`id_reserva`) REFERENCES `reservas` (`id_reserva`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table sistema_alojamiento.pagos: ~0 rows (approximately)

-- Dumping structure for table sistema_alojamiento.reservas
CREATE TABLE IF NOT EXISTS `reservas` (
  `id_reserva` int NOT NULL AUTO_INCREMENT,
  `id_espacio` int NOT NULL,
  `id_usuario` int NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estado` enum('CONFIRMADA','CANCELADA','PENDIENTE') DEFAULT 'PENDIENTE',
  `observaciones` text,
  PRIMARY KEY (`id_reserva`),
  KEY `id_espacio` (`id_espacio`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_espacio`) REFERENCES `espacios` (`id_espacio`) ON DELETE CASCADE,
  CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table sistema_alojamiento.reservas: ~0 rows (approximately)

-- Dumping structure for table sistema_alojamiento.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id_rol` int NOT NULL AUTO_INCREMENT,
  `nombre_rol` enum('ADMINISTRADOR','GENERAL') NOT NULL,
  PRIMARY KEY (`id_rol`),
  UNIQUE KEY `nombre_rol` (`nombre_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table sistema_alojamiento.roles: ~0 rows (approximately)

-- Dumping structure for table sistema_alojamiento.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `identificacion` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nombre_usuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `clave` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `correo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `id_rol` int DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `id_rol` (`id_rol`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table sistema_alojamiento.usuarios: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
sistema_alojamientologs_auditoria