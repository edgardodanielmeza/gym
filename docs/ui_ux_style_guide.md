# Guía de Estilo UI/UX - Aplicación de Gimnasio

Este documento establece las directrices de diseño visual y experiencia de usuario para la aplicación de gestión de gimnasios, con el objetivo de asegurar consistencia, usabilidad y una interfaz de usuario intuitiva y agradable.

## 1. Principios Generales de Diseño

*   **Claridad:** La interfaz debe ser fácil de entender y usar. La información debe presentarse de forma clara y concisa.
*   **Consistencia:** Los elementos de la interfaz y los patrones de interacción deben ser consistentes en toda la aplicación.
*   **Eficiencia:** Los usuarios deben poder completar sus tareas de la manera más rápida y eficiente posible.
*   **Feedback:** La aplicación debe proporcionar retroalimentación clara al usuario sobre sus acciones.
*   **Accesibilidad:** Diseñar pensando en la accesibilidad (WCAG AA como mínimo), considerando contrastes de color, navegación por teclado, y compatibilidad con lectores de pantalla.

## 2. Paleta de Colores

### Colores Primarios
*   **Azul Principal (Acciones Primarias, Enlaces, Foco):** `#007bff` (Bootstrap Blue)
    *   Variaciones más claras/oscuras: `#0056b3` (oscuro), `#58a6ff` (claro)
*   **Gris Oscuro (Texto Principal, Encabezados):** `#212529` (Bootstrap `gray-900`)

### Colores Secundarios
*   **Verde (Éxito, Confirmaciones):** `#28a745` (Bootstrap `green`)
*   **Rojo (Peligro, Errores, Alertas):** `#dc3545` (Bootstrap `red`)
*   **Amarillo (Advertencias, Notificaciones):** `#ffc107` (Bootstrap `yellow`)
*   **Cian (Información, Destacados Secundarios):** `#17a2b8` (Bootstrap `cyan`)

### Colores Neutrales
*   **Blanco:** `#ffffff`
*   **Gris Claro (Fondos de Sección, Líneas Divisorias):** `#f8f9fa` (Bootstrap `gray-100`)
*   **Gris Medio (Bordes de Inputs, Texto Secundario, Placeholders):** `#adb5bd` (Bootstrap `gray-500`)
*   **Gris Oscuro Suave (Texto menos prominente):** `#495057` (Bootstrap `gray-700`)

## 3. Tipografía

*   **Familia de Fuentes Principal:** "Nunito Sans", sans-serif. Alternativas: "Roboto", "Open Sans", "Lato".
    *   Importar desde Google Fonts si es necesario, con pesos 300, 400, 600, 700.
*   **Tamaño de Fuente Base:** `1rem` (generalmente 16px).
*   **Jerarquía de Encabezados:**
    *   `h1`: 2.25rem (36px), Peso 700
    *   `h2`: 1.875rem (30px), Peso 700
    *   `h3`: 1.5rem (24px), Peso 600
    *   `h4`: 1.25rem (20px), Peso 600
*   **Párrafos:** `1rem`, Peso 400. `line-height: 1.6`.
*   **Texto Pequeño/Ayuda:** `0.875rem` (14px), Peso 400, Color Gris Medio.
*   **Enlaces:** Color Azul Principal. Subrayado en `hover` y `focus`, no por defecto.

## 4. Componentes de Interfaz (UI)

### Botones
*   **General:** Altura mínima de 38px. Padding: `0.5rem 1rem`. Border-radius: `0.25rem` (4px). Transiciones suaves para `hover` y `active`.
*   **Primario:** Fondo Azul Principal, texto blanco.
*   **Secundario:** Fondo Gris Claro, texto Gris Oscuro. Borde de 1px Gris Medio.
*   **De Contorno (Outline):** Transparente con borde del color primario/secundario. Texto del color correspondiente.
*   **Peligro:** Fondo Rojo, texto blanco.
*   **Estados:**
    *   `hover`: Ligero oscurecimiento/aclaramiento del color de fondo/borde.
    *   `active`: Efecto de presión más pronunciado.
    *   `disabled`: Opacidad 0.65, cursor `not-allowed`.

### Formularios
*   **Inputs (text, email, password, select, textarea):**
    *   Borde: 1px sólido `#ced4da` (Gris Medio). Border-radius: `0.25rem`.
    *   Padding: `0.5rem 0.75rem`. Altura consistente con botones.
    *   `focus`: Borde Azul Principal, sombra sutil azul (`box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25)`).
*   **Labels:** Encima del campo. Peso 600. Margen inferior `0.25rem`.
*   **Checkbox y Radio:** Estilo personalizado para consistencia visual, manteniendo la accesibilidad.
*   **Mensajes de Validación:**
    *   Errores: Texto Rojo, debajo del campo. Ícono de error opcional.
    *   Éxito: Texto Verde, debajo del campo. Ícono de éxito opcional.
*   **Grupos de Formulario:** Espaciado vertical consistente entre label, input y mensaje de ayuda/error.

### Tarjetas (Cards)
*   Fondo: Blanco.
*   Borde: 1px sólido `#dee2e6` (Gris Claro).
*   Border-radius: `0.375rem` (6px).
*   Sombra: Sutil, ej. `0 0.125rem 0.25rem rgba(0,0,0,.075)`.
*   Padding interno: `1rem` a `1.25rem`.

### Tablas
*   Cabeceras: Texto peso 600, fondo Gris Claro (`#f8f9fa`).
*   Filas: Líneas divisorias sutiles (`#e9ecef`).
*   Hover en Filas (opcional): Ligero cambio de fondo para destacar.
*   Contenido de Celdas: Alineación vertical al medio. Alineación horizontal según tipo de dato (texto a la izquierda, números a la derecha).

## 5. Iconografía

*   Utilizar un set de iconos SVG coherente y moderno (ej. Heroicons, Feather Icons, o Bootstrap Icons).
*   Estilo: Minimalista y lineal preferentemente.
*   Tamaño: Generalmente `1em` o `1.25em` en relación al texto, o tamaños fijos (16px, 20px, 24px).
*   Color: Heredar color del texto o usar colores semánticos (azul para acciones, rojo para peligro).

## 6. Voz y Tono

*   **Claro y Conciso:** Evitar jerga innecesaria. Ser directo.
*   **Amigable y Profesional:** Mantener un tono respetuoso y servicial.
*   **Orientado a la Acción:** Usar verbos imperativos para botones y acciones (Ej: "Guardar Cambios", "Añadir Miembro").
*   **Consistente:** Usar la misma terminología para conceptos idénticos en toda la aplicación.
*   **Mensajes al Usuario:**
    *   Confirmaciones: Positivas y claras.
    *   Errores: Explicar el problema de forma simple y sugerir una solución si es posible. No culpar al usuario.
    *   Alertas: Informativas y no intrusivas a menos que sea crítico.

## 7. Espaciado y Layout

*   **Sistema de Rejilla (Grid):** Basado en 12 columnas (similar a Bootstrap) para layouts responsivos.
*   **Unidad de Espaciado Base:** `0.25rem` (4px). Todos los márgenes y paddings deberían ser múltiplos de esta unidad (4px, 8px, 12px, 16px, 20px, 24px, 32px).
*   **Consistencia:** Mantener espaciados consistentes entre elementos similares y en secciones análogas.
*   **Diseño Responsivo:** Asegurar que la interfaz se adapte y sea usable en diferentes tamaños de pantalla (móvil, tablet, desktop).

## 8. Accesibilidad (A11Y)

*   **Contraste de Color:** Mínimo 4.5:1 para texto normal y 3:1 para texto grande.
*   **Navegación por Teclado:** Todos los elementos interactivos deben ser accesibles y operables mediante teclado.
*   **Indicadores de Foco:** Claros y visibles para todos los elementos enfocables.
*   **Texto Alternativo:** Para todas las imágenes significativas (`alt` tags).
*   **ARIA Roles y Atributos:** Usar donde sea necesario para mejorar la semántica de elementos no estándar.

---
Este documento es una guía viva y se actualizará a medida que la aplicación evolucione.
---
