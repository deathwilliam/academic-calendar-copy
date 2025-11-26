# Manual de Usuario - Calendario Académico

## Tabla de Contenidos

1. [Guía Rápida](#guía-rápida)
2. [Introducción](#introducción)
3. [Acceso al Sistema](#acceso-al-sistema)
4. [Roles y Permisos](#roles-y-permisos)
5. [Gestión de Eventos](#gestión-de-eventos)
6. [Calendario Público](#calendario-público)
7. [Historial de Auditoría](#historial-de-auditoría)
8. [Exportación PDF](#exportación-pdf)
9. [Solución de Problemas](#solución-de-problemas)
10. [Preguntas Frecuentes](#preguntas-frecuentes)

---

## Guía Rápida

### Para Administradores

**Crear un Evento:**
1. Iniciar sesión → Ir a "Events"
2. Clic en "Create New Event"
3. Llenar formulario → Marcar "Publicar inmediatamente"
4. Guardar

**Publicar un Evento:**
1. Ir a "Events"
2. Buscar el evento
3. Clic en botón "Publish"

**Ver Historial:**
1. Ir a "Events"
2. Clic en "History" del evento deseado

### Para Editores

**Editar un Evento:**
1. Iniciar sesión → Ir a "Events"
2. Clic en "Edit" del evento
3. Modificar información
4. Guardar cambios

**Nota:** Los editores NO pueden publicar ni eliminar eventos.

### Para Auditores

**Ver Cambios:**
1. Iniciar sesión → Ir a "Events"
2. Clic en "History" de cualquier evento
3. Revisar historial completo

---

## Introducción

### ¿Qué es el Calendario Académico?

El Calendario Académico es un sistema web diseñado para gestionar eventos académicos de manera centralizada. Permite a diferentes usuarios crear, editar y visualizar eventos importantes como exámenes, vacaciones, reuniones y fechas límite.

### Características Principales

- ✅ Gestión completa de eventos (CRUD)
- ✅ Control de acceso por roles
- ✅ Calendario público sin autenticación
- ✅ Exportación a PDF
- ✅ Historial completo de cambios
- ✅ Reversión de modificaciones
- ✅ Interfaz moderna y responsive

### Requisitos del Sistema

**Para Usuarios:**
- Navegador web moderno (Chrome, Firefox, Edge, Safari)
- Conexión a internet
- Credenciales de acceso

**Para Administradores del Sistema:**
- Servidor web (Apache/Nginx)
- PHP 8.1 o superior
- MySQL 5.7 o superior
- Composer
- Node.js y NPM

---

## Acceso al Sistema

### Iniciar Sesión

1. Abrir el navegador web
2. Ir a la URL del sistema: `http://tu-dominio.com`
3. Clic en "Acceso" o "Iniciar Sesión"
4. Ingresar credenciales:
   - **Email**: tu-email@ejemplo.com
   - **Contraseña**: tu-contraseña
5. Clic en "Log in"

![Pantalla de Login](ejemplo-login.png)

### Cerrar Sesión

1. Clic en tu nombre (esquina superior derecha)
2. Seleccionar "Log Out"

### Recuperar Contraseña

1. En la pantalla de login, clic en "¿Olvidaste tu contraseña?"
2. Ingresar tu email
3. Revisar tu correo electrónico
4. Seguir las instrucciones del email

---

## Roles y Permisos

### Administrador (ADMIN)

**Badge**: 🔴 Rojo

**Permisos:**
- ✅ Crear eventos
- ✅ Editar eventos
- ✅ Eliminar eventos
- ✅ Publicar/Despublicar eventos
- ✅ Ver historial de cambios
- ✅ Revertir cambios

**Credenciales de Prueba:**
- Email: `admin@example.com`
- Password: `password`

### Editor (EDITOR)

**Badge**: 🔵 Azul

**Permisos:**
- ✅ Crear eventos
- ✅ Editar eventos
- ❌ Eliminar eventos
- ❌ Publicar/Despublicar eventos
- ✅ Ver historial de cambios
- ❌ Revertir cambios

**Credenciales de Prueba:**
- Email: `editor@example.com`
- Password: `password`

### Auditor (AUDITOR)

**Badge**: 🟣 Púrpura

**Permisos:**
- ❌ Crear eventos
- ❌ Editar eventos
- ❌ Eliminar eventos
- ❌ Publicar/Despublicar eventos
- ✅ Ver historial de cambios completo
- ❌ Revertir cambios

**Credenciales de Prueba:**
- Email: `auditor@example.com`
- Password: `password`

### Usuario Regular (USER)

**Permisos:**
- ✅ Ver calendario público
- ❌ Sin acceso al panel administrativo

---

## Gestión de Eventos

### Crear un Evento Nuevo

**Paso 1: Acceder al Formulario**
1. Iniciar sesión como Admin o Editor
2. Ir a "Events" en el menú
3. Clic en "Create New Event"

**Paso 2: Llenar el Formulario**

| Campo | Descripción | Obligatorio |
|-------|-------------|-------------|
| **Título** | Nombre del evento | ✅ Sí |
| **Descripción** | Detalles adicionales | ❌ No |
| **Fecha de Inicio** | Cuándo comienza | ✅ Sí |
| **Fecha de Fin** | Cuándo termina | ✅ Sí |
| **Tipo** | Categoría del evento | ✅ Sí |
| **Publicar** | Visible en calendario público | ❌ No |

**Tipos de Eventos Disponibles:**
- 🔵 **General**: Eventos generales
- 🔴 **Exam**: Exámenes
- 🟢 **Holiday**: Vacaciones/Días festivos
- 🟣 **Meeting**: Reuniones
- 🟠 **Deadline**: Fechas límite

**Paso 3: Guardar**
1. Revisar la información
2. Marcar "Publicar inmediatamente" si deseas que sea visible (solo Admin)
3. Clic en "Crear evento"

### Editar un Evento

1. Ir a "Events"
2. Buscar el evento a editar
3. Clic en botón "Edit" (azul)
4. Modificar los campos necesarios
5. Clic en "Actualizar evento"

> [!WARNING]
> **Solo Administradores** pueden cambiar el estado de publicación al editar.

### Eliminar un Evento

> [!CAUTION]
> **Solo Administradores** pueden eliminar eventos. Esta acción NO se puede deshacer.

1. Ir a "Events"
2. Buscar el evento a eliminar
3. Clic en botón "Delete" (rojo)
4. Confirmar la eliminación

### Publicar/Despublicar un Evento

> [!IMPORTANT]
> **Solo Administradores** pueden publicar o despublicar eventos.

**Para Publicar:**
1. Ir a "Events"
2. Buscar el evento (debe tener badge "Draft")
3. Clic en botón "Publish" (verde)

**Para Despublicar:**
1. Ir a "Events"
2. Buscar el evento (debe tener badge "Published")
3. Clic en botón "Unpublish" (gris)

---

## Calendario Público

### Acceder al Calendario

**Sin Iniciar Sesión:**
1. Ir a `http://tu-dominio.com/calendar`
2. Ver todos los eventos publicados

**Desde el Panel:**
1. Iniciar sesión
2. Clic en "Calendario Académico" (logo)
3. Navegar al calendario público

### Navegar por Meses

- **Mes Anterior**: Clic en "← Anterior"
- **Mes Siguiente**: Clic en "Siguiente →"
- **Mes Actual**: Se muestra en el encabezado

### Interpretar el Calendario

**Colores de Eventos:**
- 🔵 Azul = General
- 🔴 Rojo = Examen
- 🟢 Verde = Vacaciones
- 🟣 Púrpura = Reunión
- 🟠 Naranja = Fecha límite

**Leyenda:**
En la parte inferior del calendario se muestra una leyenda con todos los tipos de eventos.

### Próximos Eventos

Debajo del calendario se muestra una lista de los próximos 10 eventos ordenados por fecha.

---

## Historial de Auditoría

### Ver Historial de un Evento

1. Ir a "Events"
2. Buscar el evento deseado
3. Clic en botón "History" (púrpura)

### Información del Historial

Para cada cambio se muestra:
- **Fecha y Hora**: Cuándo se realizó el cambio
- **Usuario**: Quién hizo el cambio
- **Tipo**: Creación, Actualización o Eliminación
- **Valores Anteriores**: Cómo estaba antes
- **Valores Nuevos**: Cómo quedó después

### Revertir un Cambio

> [!CAUTION]
> **Solo Administradores** pueden revertir cambios.

1. Ir al historial del evento
2. Buscar la versión deseada
3. Clic en "Revert to this version"
4. Confirmar la reversión

> [!NOTE]
> Al revertir, el evento volverá exactamente como estaba en ese momento.

---

## Exportación PDF

### Exportar Calendario a PDF

1. Ir al calendario público (`/calendar`)
2. Clic en botón "Exportar PDF" (rojo, esquina superior derecha)
3. El archivo `calendario-academico.pdf` se descargará automáticamente

### Contenido del PDF

El PDF incluye:
- Título del calendario
- Lista de todos los eventos publicados
- Para cada evento:
  - Título
  - Tipo (con color)
  - Descripción
  - Fechas de inicio y fin
- Fecha de generación del documento

### Usos del PDF

- 📄 Imprimir para distribución física
- 📧 Enviar por email
- 📱 Compartir en redes sociales
- 💾 Archivar versiones del calendario

---

## Solución de Problemas

### No puedo iniciar sesión

**Problema**: Mensaje "Credenciales incorrectas"

**Soluciones:**
1. Verificar que el email esté escrito correctamente
2. Verificar que la contraseña sea correcta (distingue mayúsculas/minúsculas)
3. Usar la opción "¿Olvidaste tu contraseña?"
4. Contactar al administrador del sistema

### No veo el botón "Delete"

**Problema**: No aparece el botón para eliminar eventos

**Solución:**
- Solo los **Administradores** pueden eliminar eventos
- Verificar tu rol (debe mostrar badge ROJO "ADMIN")
- Si eres Editor o Auditor, no tendrás este permiso

### No puedo publicar un evento

**Problema**: No aparece el botón "Publish"

**Solución:**
- Solo los **Administradores** pueden publicar eventos
- Los Editores pueden crear eventos pero no publicarlos
- Solicitar a un Administrador que publique el evento

### El calendario público está vacío

**Problema**: No se muestran eventos en `/calendar`

**Soluciones:**
1. Verificar que existan eventos creados
2. Verificar que los eventos estén **publicados** (badge "Published")
3. Los eventos en estado "Draft" no aparecen en el calendario público

### Error al exportar PDF

**Problema**: El PDF no se descarga

**Soluciones:**
1. Verificar que el navegador permita descargas
2. Revisar la carpeta de descargas del navegador
3. Intentar con otro navegador
4. Contactar al administrador del sistema

---

## Preguntas Frecuentes

### ¿Puedo crear eventos recurrentes?

Actualmente el sistema no soporta eventos recurrentes. Debes crear cada evento individualmente.

### ¿Cuántos eventos puedo crear?

No hay límite en la cantidad de eventos que puedes crear.

### ¿Puedo cambiar mi rol?

No. Solo un administrador del sistema puede cambiar roles de usuarios. Contacta al administrador si necesitas cambiar tu rol.

### ¿Se pueden recuperar eventos eliminados?

Sí, si tienes rol de Administrador. Los eventos eliminados quedan registrados en el historial de auditoría y pueden ser restaurados usando la función de reversión.

### ¿Puedo ver quién modificó un evento?

Sí. En el historial de auditoría se registra quién hizo cada cambio, cuándo y qué modificó exactamente.

### ¿El calendario público requiere login?

No. El calendario público en `/calendar` es accesible sin necesidad de iniciar sesión. Solo muestra eventos publicados.

### ¿Puedo personalizar los tipos de eventos?

Los tipos de eventos están predefinidos. Si necesitas tipos adicionales, contacta al administrador del sistema para que los agregue.

### ¿Cómo sé qué rol tengo?

Tu rol se muestra como un badge de color en la página de "Event Management":
- 🔴 ADMIN = Administrador
- 🔵 EDITOR = Editor
- 🟣 AUDITOR = Auditor

---

## Contacto y Soporte

Para soporte técnico o preguntas adicionales:

- **Email**: soporte@tu-institucion.edu
- **Teléfono**: +XX XXX XXX XXXX
- **Horario**: Lunes a Viernes, 9:00 - 17:00

---

## Anexos

### Atajos de Teclado

Actualmente no hay atajos de teclado configurados.

### Glosario

- **CRUD**: Create, Read, Update, Delete (Crear, Leer, Actualizar, Eliminar)
- **Auditoría**: Registro de todos los cambios realizados
- **Badge**: Etiqueta de color que indica el rol o estado
- **Draft**: Borrador, evento no publicado
- **Published**: Publicado, visible en calendario público

### Historial de Versiones

- **v1.0** (2025-11-24): Versión inicial del sistema
  - Gestión de eventos
  - Control de roles
  - Calendario público
  - Exportación PDF
  - Historial de auditoría

---

**Última actualización**: 24 de Noviembre de 2025  
**Versión del Manual**: 1.0
