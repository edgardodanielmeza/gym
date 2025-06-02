# API de Control de Acceso - Gimnasio

Esta API permite la integración con dispositivos de control de acceso físico (torniquetes, lectores QR) para verificar el estado de los miembros y registrar eventos de acceso.

## Autenticación

Todas las solicitudes a la API deben incluir un token de API válido en la cabecera `Authorization`:

`Authorization: Bearer <API_TOKEN>`

Los tokens de API se gestionan desde el panel de administración del sistema, sección "Configuración de API".

## Endpoints

### 1. Verificar Acceso de Miembro

Permite verificar si un miembro tiene acceso permitido al gimnasio en el momento actual, basado en su identificador y el dispositivo que realiza la consulta.

*   **Método:** `POST`
*   **URI:** `/api/v1/access/check`
*   **Parámetros de Cabecera:**
    *   `Accept: application/json`
    *   `Content-Type: application/json`
    *   `Authorization: Bearer <API_TOKEN>`
*   **Cuerpo de la Solicitud (JSON):**
    ```json
    {
        "identificador_miembro": "ID_MIEMBRO_O_EMAIL_O_NUMERO_TARJETA",
        "id_dispositivo": "UUID_DEL_DISPOSITIVO_DE_ACCESO"
    }
    ```
    *   `identificador_miembro` (string, requerido): Puede ser el ID numérico del miembro, su email, o un número de tarjeta/identificación único. El sistema intentará resolverlo.
    *   `id_dispositivo` (string, requerido): Identificador único del dispositivo que realiza la consulta. Este ID debe estar pre-registrado en el sistema.

*   **Respuesta Exitosa (200 OK):**
    ```json
    {
        "permitido": true,
        "status_membresia": "Activa", // "Activa", "Vencida", "Próxima a vencer", "Congelada"
        "miembro": {
            "id": 123,
            "nombre": "Juan Ignacio",
            "apellidos": "Pérez García",
            "nombre_membresia": "Gold Anual",
            "fecha_fin_membresia": "2024-12-31"
        },
        "mensaje": "Acceso permitido."
    }
    ```
*   **Respuesta de Acceso Denegado (200 OK con `permitido: false`):**
    ```json
    {
        "permitido": false,
        "status_membresia": "Vencida", // O "No encontrado", "Bloqueado"
        "miembro": { // Puede ser null si el miembro no se encontró
            "id": 456,
            "nombre": "Ana",
            "apellidos": "López",
            "nombre_membresia": "Plan Mensual",
            "fecha_fin_membresia": "2023-10-15"
        },
        "mensaje": "Acceso denegado: Membresía vencida."
    }
    ```
*   **Respuesta de Error (400 Bad Request - ej. datos faltantes, 401 Unauthorized - token inválido/ausente, 404 Not Found - dispositivo no registrado, 500 Internal Server Error):**
    ```json
    {
        "error": "Descripción concisa del error.",
        "detalles": { // Opcional, para más información
            "campo_faltante": "id_dispositivo"
        }
    }
    ```

### 2. Registrar Evento de Acceso

Registra un evento de acceso (entrada, salida, intento fallido) después de una verificación o acción. Este endpoint es llamado por el dispositivo para informar al sistema central.

*   **Método:** `POST`
*   **URI:** `/api/v1/access/log`
*   **Parámetros de Cabecera:**
    *   `Accept: application/json`
    *   `Content-Type: application/json`
    *   `Authorization: Bearer <API_TOKEN>`
*   **Cuerpo de la Solicitud (JSON):**
    ```json
    {
        "miembro_id": 123, // ID numérico del miembro (puede ser null si el intento fue con un identificador no reconocido)
        "dispositivo_id": "UUID_DEL_DISPOSITIVO_DE_ACCESO",
        "tipo_evento": "Entrada", // "Entrada", "Salida", "Intento Fallido"
        "acceso_permitido": true, // boolean, resultado de la acción de acceso
        "timestamp_evento": "2024-07-27T10:30:00Z", // Formato ISO 8601 UTC. Si no se provee, se usa la hora del servidor.
        "motivo_denegacion": null, // String si acceso_permitido es false, ej: "Membresía expirada", "Saldo pendiente"
        "foto_url": "https://path.to/image_capture.jpg" // Opcional, URL a una captura de imagen si el dispositivo la soporta
    }
    ```
*   **Respuesta Exitosa (201 Created):**
    ```json
    {
        "mensaje": "Evento de acceso registrado correctamente.",
        "id_evento_registrado": 78901
    }
    ```
*   **Respuesta de Error (400 Bad Request, 401 Unauthorized, 404 Not Found, 500 Internal Server Error):**
    ```json
    {
        "error": "Descripción del error al registrar el evento."
    }
    ```

## Consideraciones Adicionales

*   **Seguridad:** Utilizar HTTPS para todas las comunicaciones.
*   **Rate Limiting:** Se podrán aplicar límites de tasa de solicitudes por IP o por token de API.
*   **Versionado:** La versión actual de la API es v1. Cambios futuros que rompan la compatibilidad se harán en nuevas versiones (ej. `/api/v2/...`).
*   **Sincronización Horaria:** Es crucial que los dispositivos tengan su hora sincronizada (vía NTP) para la correcta auditoría de `timestamp_evento`.

---
