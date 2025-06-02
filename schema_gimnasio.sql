-- Establecer el modo SQL y la zona horaria para la sesión
SET NAMES utf8mb4;
SET TIME_ZONE='+00:00';
SET FOREIGN_KEY_CHECKS=0;

--
-- Tabla: sucursales
--
DROP TABLE IF EXISTS `sucursales`;
CREATE TABLE `sucursales` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `direccion` VARCHAR(255) NOT NULL,
  `telefono` VARCHAR(20) NULL DEFAULT NULL,
  `email` VARCHAR(100) NULL DEFAULT NULL,
  `horario_apertura` TIME NULL DEFAULT NULL,
  `horario_cierre` TIME NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_sucursales_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tabla: roles_sistema
--
DROP TABLE IF EXISTS `roles_sistema`;
CREATE TABLE `roles_sistema` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre_rol` VARCHAR(50) NOT NULL, -- Ej: Administrador, Entrenador, Recepcionista
  `descripcion` TEXT NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_roles_sistema_nombre_rol` (`nombre_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tabla: usuarios_sistema
--
DROP TABLE IF EXISTS `usuarios_sistema`;
CREATE TABLE `usuarios_sistema` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `sucursal_id` INT UNSIGNED NULL, -- Un usuario puede no estar asignado a una sucursal específica (ej. admin general)
  `rol_id` INT UNSIGNED NOT NULL,
  `nombre_usuario` VARCHAR(50) NOT NULL,
  `nombre_completo` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `activo` BOOLEAN NOT NULL DEFAULT TRUE,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_usuarios_sistema_nombre_usuario` (`nombre_usuario`),
  UNIQUE KEY `uk_usuarios_sistema_email` (`email`),
  INDEX `idx_usuarios_sistema_sucursal_id` (`sucursal_id`),
  INDEX `idx_usuarios_sistema_rol_id` (`rol_id`),
  CONSTRAINT `fk_usuarios_sistema_sucursal_id` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_usuarios_sistema_rol_id` FOREIGN KEY (`rol_id`) REFERENCES `roles_sistema` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tabla: tipos_membresia
--
DROP TABLE IF EXISTS `tipos_membresia`;
CREATE TABLE `tipos_membresia` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL, -- Ej: Mensual, Trimestral, Anual, Acceso Total, Solo Mañanas
  `descripcion` TEXT NULL DEFAULT NULL,
  `duracion_dias` INT UNSIGNED NOT NULL, -- Duración en días (ej: 30, 90, 365)
  `precio` DECIMAL(10, 2) NOT NULL,
  `activa` BOOLEAN NOT NULL DEFAULT TRUE, -- Si el tipo de membresía está disponible para nuevas suscripciones
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_tipos_membresia_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tabla: miembros
--
DROP TABLE IF EXISTS `miembros`;
CREATE TABLE `miembros` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `sucursal_predeterminada_id` INT UNSIGNED NOT NULL,
  `numero_identificacion` VARCHAR(50) NULL DEFAULT NULL, -- DNI, Pasaporte, etc.
  `nombre` VARCHAR(100) NOT NULL,
  `apellidos` VARCHAR(100) NOT NULL,
  `fecha_nacimiento` DATE NULL DEFAULT NULL,
  `genero` ENUM('Masculino', 'Femenino', 'Otro', 'Prefiero no decirlo') NULL DEFAULT NULL,
  `direccion` VARCHAR(255) NULL DEFAULT NULL,
  `telefono` VARCHAR(20) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `fecha_registro` DATE NOT NULL,
  `foto_perfil_url` VARCHAR(255) NULL DEFAULT NULL,
  `notas_adicionales` TEXT NULL DEFAULT NULL,
  `activo` BOOLEAN NOT NULL DEFAULT TRUE, -- Si el miembro está activo en el sistema (no necesariamente con membresía activa)
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_miembros_email` (`email`),
  UNIQUE KEY `uk_miembros_numero_identificacion` (`numero_identificacion`),
  INDEX `idx_miembros_sucursal_predeterminada_id` (`sucursal_predeterminada_id`),
  INDEX `idx_miembros_apellidos_nombre` (`apellidos`, `nombre`),
  CONSTRAINT `fk_miembros_sucursal_predeterminada_id` FOREIGN KEY (`sucursal_predeterminada_id`) REFERENCES `sucursales` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tabla: membresias
--
DROP TABLE IF EXISTS `membresias`;
CREATE TABLE `membresias` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `miembro_id` INT UNSIGNED NOT NULL,
  `tipo_membresia_id` INT UNSIGNED NOT NULL,
  `fecha_inicio` DATE NOT NULL,
  `fecha_fin` DATE NOT NULL,
  `estado` ENUM('Activa', 'Vencida', 'Cancelada', 'Pendiente de Pago') NOT NULL DEFAULT 'Pendiente de Pago',
  `precio_pagado` DECIMAL(10, 2) NULL DEFAULT NULL, -- Puede ser diferente al precio base del tipo_membresia por descuentos
  `notas` TEXT NULL DEFAULT NULL,
  `renovacion_automatica` BOOLEAN NOT NULL DEFAULT FALSE,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_membresias_miembro_id` (`miembro_id`),
  INDEX `idx_membresias_tipo_membresia_id` (`tipo_membresia_id`),
  INDEX `idx_membresias_fecha_fin` (`fecha_fin`),
  INDEX `idx_membresias_estado` (`estado`),
  CONSTRAINT `fk_membresias_miembro_id` FOREIGN KEY (`miembro_id`) REFERENCES `miembros` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_membresias_tipo_membresia_id` FOREIGN KEY (`tipo_membresia_id`) REFERENCES `tipos_membresia` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tabla: dispositivos_acceso
--
DROP TABLE IF EXISTS `dispositivos_acceso`;
CREATE TABLE `dispositivos_acceso` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `sucursal_id` INT UNSIGNED NOT NULL,
  `nombre_dispositivo` VARCHAR(100) NOT NULL,
  `tipo_dispositivo` ENUM('Torniquete', 'Puerta', 'Lector QR', 'Otro') NOT NULL,
  `ubicacion_descripcion` VARCHAR(255) NULL DEFAULT NULL,
  `direccion_ip` VARCHAR(45) NULL DEFAULT NULL,
  `mac_address` VARCHAR(17) NULL DEFAULT NULL,
  `activo` BOOLEAN NOT NULL DEFAULT TRUE,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_dispositivos_acceso_sucursal_id` (`sucursal_id`),
  UNIQUE KEY `uk_dispositivos_acceso_mac` (`mac_address`),
  CONSTRAINT `fk_dispositivos_acceso_sucursal_id` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tabla: eventos_acceso
--
DROP TABLE IF EXISTS `eventos_acceso`;
CREATE TABLE `eventos_acceso` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `miembro_id` INT UNSIGNED NOT NULL,
  `dispositivo_id` INT UNSIGNED NOT NULL,
  `timestamp_evento` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo_evento` ENUM('Entrada', 'Salida', 'Intento Fallido') NOT NULL,
  `acceso_permitido` BOOLEAN NOT NULL,
  `motivo_denegacion` VARCHAR(255) NULL DEFAULT NULL, -- Si acceso_permitido es FALSE
  PRIMARY KEY (`id`),
  INDEX `idx_eventos_acceso_miembro_id` (`miembro_id`),
  INDEX `idx_eventos_acceso_dispositivo_id` (`dispositivo_id`),
  INDEX `idx_eventos_acceso_timestamp_evento` (`timestamp_evento`),
  CONSTRAINT `fk_eventos_acceso_miembro_id` FOREIGN KEY (`miembro_id`) REFERENCES `miembros` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_eventos_acceso_dispositivo_id` FOREIGN KEY (`dispositivo_id`) REFERENCES `dispositivos_acceso` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tabla: facturas
--
DROP TABLE IF EXISTS `facturas`;
CREATE TABLE `facturas` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `membresia_id` INT UNSIGNED NOT NULL,
  `numero_factura` VARCHAR(50) NOT NULL,
  `fecha_emision` DATE NOT NULL,
  `fecha_vencimiento` DATE NOT NULL,
  `monto_subtotal` DECIMAL(10, 2) NOT NULL,
  `impuestos` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
  `monto_total` DECIMAL(10, 2) NOT NULL,
  `estado` ENUM('Pendiente', 'Pagada', 'Vencida', 'Cancelada') NOT NULL DEFAULT 'Pendiente',
  `notas` TEXT NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_facturas_numero_factura` (`numero_factura`),
  INDEX `idx_facturas_membresia_id` (`membresia_id`),
  INDEX `idx_facturas_estado` (`estado`),
  CONSTRAINT `fk_facturas_membresia_id` FOREIGN KEY (`membresia_id`) REFERENCES `membresias` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tabla: pagos
--
DROP TABLE IF EXISTS `pagos`;
CREATE TABLE `pagos` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `factura_id` INT UNSIGNED NOT NULL,
  `usuario_sistema_id` INT UNSIGNED NULL, -- Quién registró el pago
  `fecha_pago` DATETIME NOT NULL,
  `monto_pagado` DECIMAL(10, 2) NOT NULL,
  `metodo_pago` ENUM('Efectivo', 'Tarjeta de Crédito', 'Tarjeta de Débito', 'Transferencia Bancaria', 'Otro') NOT NULL,
  `referencia_pago` VARCHAR(100) NULL DEFAULT NULL, -- Ej: número de transacción, cheque
  `notas` TEXT NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_pagos_factura_id` (`factura_id`),
  INDEX `idx_pagos_usuario_sistema_id` (`usuario_sistema_id`),
  INDEX `idx_pagos_fecha_pago` (`fecha_pago`),
  INDEX `idx_pagos_metodo_pago` (`metodo_pago`),
  CONSTRAINT `fk_pagos_factura_id` FOREIGN KEY (`factura_id`) REFERENCES `facturas` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_pagos_usuario_sistema_id` FOREIGN KEY (`usuario_sistema_id`) REFERENCES `usuarios_sistema` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS=1;
