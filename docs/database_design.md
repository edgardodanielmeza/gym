# Diseño de la Base de Datos - Aplicación de Gimnasio

Este documento detalla la estructura de la base de datos para la aplicación de gestión de gimnasios.

## Tabla: `sucursales`

**Propósito:** Almacena información sobre las diferentes sucursales o ubicaciones del gimnasio.

**Columnas:**

| Nombre             | Tipo                          | Restricciones/Notas                                   |
|--------------------|-------------------------------|-------------------------------------------------------|
| `id`               | `INT UNSIGNED`                | PK, Auto Increment, Not Null                          |
| `nombre`           | `VARCHAR(100)`                | Not Null, Unique (`uk_sucursales_nombre`)             |
| `direccion`        | `VARCHAR(255)`                | Not Null                                              |
| `telefono`         | `VARCHAR(20)`                 | Nullable                                              |
| `email`            | `VARCHAR(100)`                | Nullable                                              |
| `horario_apertura` | `TIME`                        | Nullable                                              |
| `horario_cierre`   | `TIME`                        | Nullable                                              |
| `created_at`       | `TIMESTAMP`                   | Not Null, Default `CURRENT_TIMESTAMP`                 |
| `updated_at`       | `TIMESTAMP`                   | Not Null, Default `CURRENT_TIMESTAMP`, On Update `CURRENT_TIMESTAMP` |

**Relaciones Clave:**
*   Una sucursal puede tener muchos usuarios del sistema (`usuarios_sistema`).
*   Una sucursal puede ser la predeterminada para muchos miembros (`miembros`).
*   Una sucursal puede tener muchos dispositivos de acceso (`dispositivos_acceso`).

---

## Tabla: `roles_sistema`

**Propósito:** Define los roles que pueden tener los usuarios del sistema (ej. Administrador, Entrenador).

**Columnas:**

| Nombre       | Tipo           | Restricciones/Notas                                   |
|--------------|----------------|-------------------------------------------------------|
| `id`         | `INT UNSIGNED` | PK, Auto Increment, Not Null                          |
| `nombre_rol` | `VARCHAR(50)`  | Not Null, Unique (`uk_roles_sistema_nombre_rol`)      |
| `descripcion`| `TEXT`         | Nullable                                              |
| `created_at` | `TIMESTAMP`    | Not Null, Default `CURRENT_TIMESTAMP`                 |
| `updated_at` | `TIMESTAMP`    | Not Null, Default `CURRENT_TIMESTAMP`, On Update `CURRENT_TIMESTAMP` |

**Relaciones Clave:**
*   Un rol de sistema puede ser asignado a muchos usuarios del sistema (`usuarios_sistema`).

---

## Tabla: `usuarios_sistema`

**Propósito:** Almacena la información de los usuarios que pueden acceder al sistema de gestión (personal del gimnasio).

**Columnas:**

| Nombre           | Tipo                          | Restricciones/Notas                                   |
|------------------|-------------------------------|-------------------------------------------------------|
| `id`             | `INT UNSIGNED`                | PK, Auto Increment, Not Null                          |
| `sucursal_id`    | `INT UNSIGNED`                | Nullable, FK a `sucursales(id)` (ON DELETE SET NULL, ON UPDATE CASCADE) |
| `rol_id`         | `INT UNSIGNED`                | Not Null, FK a `roles_sistema(id)` (ON DELETE RESTRICT, ON UPDATE CASCADE) |
| `nombre_usuario` | `VARCHAR(50)`                 | Not Null, Unique (`uk_usuarios_sistema_nombre_usuario`)|
| `nombre_completo`| `VARCHAR(100)`                | Not Null                                              |
| `email`          | `VARCHAR(100)`                | Not Null, Unique (`uk_usuarios_sistema_email`)        |
| `password_hash`  | `VARCHAR(255)`                | Not Null (en Laravel se usa `password`)               |
| `activo`         | `BOOLEAN`                     | Not Null, Default `TRUE`                              |
| `created_at`     | `TIMESTAMP`                   | Not Null, Default `CURRENT_TIMESTAMP`                 |
| `updated_at`     | `TIMESTAMP`                   | Not Null, Default `CURRENT_TIMESTAMP`, On Update `CURRENT_TIMESTAMP` |

**Relaciones Clave:**
*   Un usuario del sistema opcionalmente pertenece a una `sucursal` (`sucursal_id`).
*   Un usuario del sistema obligatoriamente pertenece a un `rol_sistema` (`rol_id`).
*   Un usuario del sistema puede registrar muchos `pagos`.

---

## Tabla: `tipos_membresia`

**Propósito:** Define los diferentes tipos de membresías que ofrece el gimnasio (ej. Mensual, Anual, VIP).

**Columnas:**

| Nombre          | Tipo                          | Restricciones/Notas                                   |
|-----------------|-------------------------------|-------------------------------------------------------|
| `id`            | `INT UNSIGNED`                | PK, Auto Increment, Not Null                          |
| `nombre`        | `VARCHAR(100)`                | Not Null, Unique (`uk_tipos_membresia_nombre`)        |
| `descripcion`   | `TEXT`                        | Nullable                                              |
| `duracion_dias` | `INT UNSIGNED`                | Not Null                                              |
| `precio`        | `DECIMAL(10, 2)`              | Not Null                                              |
| `activa`        | `BOOLEAN`                     | Not Null, Default `TRUE`                              |
| `created_at`    | `TIMESTAMP`                   | Not Null, Default `CURRENT_TIMESTAMP`                 |
| `updated_at`    | `TIMESTAMP`                   | Not Null, Default `CURRENT_TIMESTAMP`, On Update `CURRENT_TIMESTAMP` |

**Relaciones Clave:**
*   Un tipo de membresía puede estar asociado a muchas `membresias` de miembros.

---

## Tabla: `miembros`

**Propósito:** Almacena la información de los clientes o miembros del gimnasio.

**Columnas:**

| Nombre                      | Tipo                                                       | Restricciones/Notas                                   |
|-----------------------------|------------------------------------------------------------|-------------------------------------------------------|
| `id`                        | `INT UNSIGNED`                                             | PK, Auto Increment, Not Null                          |
| `sucursal_predeterminada_id`| `INT UNSIGNED`                                             | Not Null, FK a `sucursales(id)` (ON DELETE RESTRICT, ON UPDATE CASCADE) |
| `numero_identificacion`     | `VARCHAR(50)`                                              | Nullable, Unique (`uk_miembros_numero_identificacion`)|
| `nombre`                    | `VARCHAR(100)`                                             | Not Null                                              |
| `apellidos`                 | `VARCHAR(100)`                                             | Not Null                                              |
| `fecha_nacimiento`          | `DATE`                                                     | Nullable                                              |
| `genero`                    | `ENUM('Masculino', 'Femenino', 'Otro', 'Prefiero no decirlo')` | Nullable                                              |
| `direccion`                 | `VARCHAR(255)`                                             | Nullable                                              |
| `telefono`                  | `VARCHAR(20)`                                              | Not Null                                              |
| `email`                     | `VARCHAR(100)`                                             | Not Null, Unique (`uk_miembros_email`)                |
| `fecha_registro`            | `DATE`                                                     | Not Null                                              |
| `foto_perfil_url`           | `VARCHAR(255)`                                             | Nullable                                              |
| `notas_adicionales`         | `TEXT`                                                     | Nullable                                              |
| `activo`                    | `BOOLEAN`                                                  | Not Null, Default `TRUE`                              |
| `created_at`                | `TIMESTAMP`                                                | Not Null, Default `CURRENT_TIMESTAMP`                 |
| `updated_at`                | `TIMESTAMP`                                                | Not Null, Default `CURRENT_TIMESTAMP`, On Update `CURRENT_TIMESTAMP` |

**Relaciones Clave:**
*   Un miembro tiene una `sucursal` predeterminada.
*   Un miembro puede tener muchas `membresias`.
*   Un miembro puede generar muchos `eventos_acceso`.

---

## Tabla: `membresias`

**Propósito:** Registra las membresías activas o pasadas de los miembros.

**Columnas:**

| Nombre                | Tipo                                                       | Restricciones/Notas                                   |
|-----------------------|------------------------------------------------------------|-------------------------------------------------------|
| `id`                  | `INT UNSIGNED`                                             | PK, Auto Increment, Not Null                          |
| `miembro_id`          | `INT UNSIGNED`                                             | Not Null, FK a `miembros(id)` (ON DELETE CASCADE, ON UPDATE CASCADE) |
| `tipo_membresia_id`   | `INT UNSIGNED`                                             | Not Null, FK a `tipos_membresia(id)` (ON DELETE RESTRICT, ON UPDATE CASCADE) |
| `fecha_inicio`        | `DATE`                                                     | Not Null                                              |
| `fecha_fin`           | `DATE`                                                     | Not Null                                              |
| `estado`              | `ENUM('Activa', 'Vencida', 'Cancelada', 'Pendiente de Pago')` | Not Null, Default `'Pendiente de Pago'`               |
| `precio_pagado`       | `DECIMAL(10, 2)`                                           | Nullable                                              |
| `notas`               | `TEXT`                                                     | Nullable                                              |
| `renovacion_automatica`| `BOOLEAN`                                                  | Not Null, Default `FALSE`                             |
| `created_at`          | `TIMESTAMP`                                                | Not Null, Default `CURRENT_TIMESTAMP`                 |
| `updated_at`          | `TIMESTAMP`                                                | Not Null, Default `CURRENT_TIMESTAMP`, On Update `CURRENT_TIMESTAMP` |

**Relaciones Clave:**
*   Una membresía pertenece a un `miembro`.
*   Una membresía es de un `tipo_membresia` específico.
*   Una membresía puede tener asociadas una o varias `facturas`.

---

## Tabla: `dispositivos_acceso`

**Propósito:** Almacena información sobre los dispositivos utilizados para controlar el acceso (ej. torniquetes, lectores QR).

**Columnas:**

| Nombre                  | Tipo                                                 | Restricciones/Notas                                   |
|-------------------------|------------------------------------------------------|-------------------------------------------------------|
| `id`                    | `INT UNSIGNED`                                       | PK, Auto Increment, Not Null                          |
| `sucursal_id`           | `INT UNSIGNED`                                       | Not Null, FK a `sucursales(id)` (ON DELETE CASCADE, ON UPDATE CASCADE) |
| `nombre_dispositivo`    | `VARCHAR(100)`                                       | Not Null                                              |
| `tipo_dispositivo`      | `ENUM('Torniquete', 'Puerta', 'Lector QR', 'Otro')`    | Not Null                                              |
| `ubicacion_descripcion` | `VARCHAR(255)`                                       | Nullable                                              |
| `direccion_ip`          | `VARCHAR(45)`                                        | Nullable                                              |
| `mac_address`           | `VARCHAR(17)`                                        | Nullable, Unique (`uk_dispositivos_acceso_mac`)       |
| `activo`                | `BOOLEAN`                                            | Not Null, Default `TRUE`                              |
| `created_at`            | `TIMESTAMP`                                          | Not Null, Default `CURRENT_TIMESTAMP`                 |
| `updated_at`            | `TIMESTAMP`                                          | Not Null, Default `CURRENT_TIMESTAMP`, On Update `CURRENT_TIMESTAMP` |

**Relaciones Clave:**
*   Un dispositivo de acceso pertenece a una `sucursal`.
*   Un dispositivo de acceso puede registrar muchos `eventos_acceso`.

---

## Tabla: `eventos_acceso`

**Propósito:** Registra cada intento de acceso (entrada o salida) de un miembro a través de un dispositivo.

**Columnas:**

| Nombre             | Tipo                                               | Restricciones/Notas                                   |
|--------------------|----------------------------------------------------|-------------------------------------------------------|
| `id`               | `BIGINT UNSIGNED`                                  | PK, Auto Increment, Not Null                          |
| `miembro_id`       | `INT UNSIGNED`                                     | Not Null, FK a `miembros(id)` (ON DELETE CASCADE, ON UPDATE CASCADE) |
| `dispositivo_id`   | `INT UNSIGNED`                                     | Not Null, FK a `dispositivos_acceso(id)` (ON DELETE RESTRICT, ON UPDATE CASCADE) |
| `timestamp_evento` | `TIMESTAMP`                                        | Not Null, Default `CURRENT_TIMESTAMP`                 |
| `tipo_evento`      | `ENUM('Entrada', 'Salida', 'Intento Fallido')`       | Not Null                                              |
| `acceso_permitido` | `BOOLEAN`                                          | Not Null                                              |
| `motivo_denegacion`| `VARCHAR(255)`                                     | Nullable (si `acceso_permitido` es `FALSE`)           |

**Relaciones Clave:**
*   Un evento de acceso es generado por un `miembro`.
*   Un evento de acceso ocurre en un `dispositivo_acceso`.
*   *Nota: Esta tabla no tiene `created_at`/`updated_at` propios, `timestamp_evento` registra la hora del evento.*

---

## Tabla: `facturas`

**Propósito:** Almacena la información de las facturas generadas por las membresías.

**Columnas:**

| Nombre            | Tipo                                                       | Restricciones/Notas                                   |
|-------------------|------------------------------------------------------------|-------------------------------------------------------|
| `id`              | `INT UNSIGNED`                                             | PK, Auto Increment, Not Null                          |
| `membresia_id`    | `INT UNSIGNED`                                             | Not Null, FK a `membresias(id)` (ON DELETE RESTRICT, ON UPDATE CASCADE) |
| `numero_factura`  | `VARCHAR(50)`                                              | Not Null, Unique (`uk_facturas_numero_factura`)       |
| `fecha_emision`   | `DATE`                                                     | Not Null                                              |
| `fecha_vencimiento`| `DATE`                                                     | Not Null                                              |
| `monto_subtotal`  | `DECIMAL(10, 2)`                                           | Not Null                                              |
| `impuestos`       | `DECIMAL(10, 2)`                                           | Not Null, Default `0.00`                              |
| `monto_total`     | `DECIMAL(10, 2)`                                           | Not Null                                              |
| `estado`          | `ENUM('Pendiente', 'Pagada', 'Vencida', 'Cancelada')`        | Not Null, Default `'Pendiente'`                       |
| `notas`           | `TEXT`                                                     | Nullable                                              |
| `created_at`      | `TIMESTAMP`                                                | Not Null, Default `CURRENT_TIMESTAMP`                 |
| `updated_at`      | `TIMESTAMP`                                                | Not Null, Default `CURRENT_TIMESTAMP`, On Update `CURRENT_TIMESTAMP` |

**Relaciones Clave:**
*   Una factura pertenece a una `membresia`.
*   Una factura puede tener muchos `pagos`.

---

## Tabla: `pagos`

**Propósito:** Registra los pagos realizados por los miembros para cubrir las facturas.

**Columnas:**

| Nombre               | Tipo                                                                      | Restriciones/Notas                                   |
|----------------------|---------------------------------------------------------------------------|-------------------------------------------------------|
| `id`                 | `INT UNSIGNED`                                                            | PK, Auto Increment, Not Null                          |
| `factura_id`         | `INT UNSIGNED`                                                            | Not Null, FK a `facturas(id)` (ON DELETE RESTRICT, ON UPDATE CASCADE) |
| `usuario_sistema_id` | `INT UNSIGNED`                                                            | Nullable, FK a `usuarios_sistema(id)` (ON DELETE SET NULL, ON UPDATE CASCADE) |
| `fecha_pago`         | `DATETIME`                                                                | Not Null                                              |
| `monto_pagado`       | `DECIMAL(10, 2)`                                                          | Not Null                                              |
| `metodo_pago`        | `ENUM('Efectivo', 'Tarjeta de Crédito', 'Tarjeta de Débito', 'Transferencia Bancaria', 'Otro')` | Not Null                                              |
| `referencia_pago`    | `VARCHAR(100)`                                                            | Nullable                                              |
| `notas`              | `TEXT`                                                                    | Nullable                                              |
| `created_at`         | `TIMESTAMP`                                                               | Not Null, Default `CURRENT_TIMESTAMP`                 |
| `updated_at`         | `TIMESTAMP`                                                               | Not Null, Default `CURRENT_TIMESTAMP`, On Update `CURRENT_TIMESTAMP` |

**Relaciones Clave:**
*   Un pago pertenece a una `factura`.
*   Un pago es opcionalmente registrado por un `usuario_sistema`.

---
