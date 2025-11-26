# Guía de Despliegue en Servidor Gratuito (Render.com)
# Guía de Despliegue en Servidor Gratuito (Render.com)

Esta guía te ayudará a publicar tu aplicación Laravel "Calendario Académico" en internet utilizando **Render.com**, que es una de las mejores opciones gratuitas y modernas para Laravel.

## Prerrequisitos

1.  Una cuenta en [GitHub](https://github.com/).
2.  Tener instalado Git en tu computadora (ya lo tienes).

## Paso 0: Subir tu código a GitHub

Ya hemos inicializado el repositorio localmente. Ahora necesitas subirlo a GitHub:

1.  Ve a [GitHub.com](https://github.com/new) y crea un **Nuevo Repositorio**.
    *   Nombre: `calendario-academico` (o lo que prefieras).
    *   Público o Privado (Privado está bien).
    *   **NO** marques "Initialize with README".
2.  Copia los comandos que aparecen bajo el título **"…or push an existing repository from the command line"**.
3.  Pégalos en tu terminal aquí. Serán algo así:
    ```bash
    git remote add origin https://github.com/TU_USUARIO/calendario-academico.git
    git branch -M main
    git push -u origin main
    ```

## Paso 1: Preparar la Base de Datos (PostgreSQL)

Como Render borra los archivos del disco cada vez que se reinicia, **no puedes usar SQLite**. Necesitas una base de datos real.

**Recomendación Principal: Neon.tech (Gratis Permanente)**
Render ofrece una base de datos gratis, pero se borra a los 90 días. **Neon.tech** es mucho mejor porque es gratis para siempre (hasta cierto límite generoso).

1.  Ve a [Neon.tech](https://neon.tech/) y regístrate.
2.  Crea un nuevo proyecto.
3.  Copia la **Connection String** (URL de conexión) que te dan. Se verá como:
    `postgres://usuario:password@ep-algo.aws.neon.tech/neondb?sslmode=require`
4.  ¡Guarda esta URL! La usarás en el siguiente paso.

## Paso 2: Desplegar la Aplicación en Render

Hemos preparado un archivo `render.yaml` y un `Dockerfile` en tu proyecto para facilitar esto.

1.  Ve al [Dashboard de Render](https://dashboard.render.com/).
2.  Haz clic en **New +** y selecciona **Blueprint**.
3.  Conecta tu cuenta de GitHub y selecciona el repositorio `calendario-academico`.
4.  Render detectará automáticamente el archivo `render.yaml`.
5.  Haz clic en **Apply**.

### Configuración de Variables de Entorno

Si el despliegue falla o necesitas configurar la base de datos manualmente:

1.  Ve al Dashboard de Render -> Tu servicio web -> **Environment**.
2.  Asegúrate de tener estas variables (si faltan, agrégalas):

| Clave | Valor |
|-------|-------|
| `APP_KEY` | (Copia la de tu archivo `.env` local o genera una nueva) |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `LOG_CHANNEL` | `stderr` |
| `DB_CONNECTION` | `pgsql` |
| `DB_URL` | **Pega aquí la URL de Neon.tech del Paso 1** |

## Paso 3: Ejecutar Migraciones

Una vez que el despliegue termine (verás "Deploy succeeded" en verde), necesitas crear las tablas en la base de datos.

1.  En el Dashboard de Render, entra a tu servicio web.
2.  Ve a la pestaña **Shell** (o "Connect").
3.  Espera a que conecte y ejecuta:
    ```bash
    php artisan migrate --force
# Guía de Despliegue en Servidor Gratuito (Render.com)
# Guía de Despliegue en Servidor Gratuito (Render.com)

Esta guía te ayudará a publicar tu aplicación Laravel "Calendario Académico" en internet utilizando **Render.com**, que es una de las mejores opciones gratuitas y modernas para Laravel.

## Prerrequisitos

1.  Una cuenta en [GitHub](https://github.com/).
2.  Tener instalado Git en tu computadora (ya lo tienes).

## Paso 0: Subir tu código a GitHub

Ya hemos inicializado el repositorio localmente. Ahora necesitas subirlo a GitHub:

1.  Ve a [GitHub.com](https://github.com/new) y crea un **Nuevo Repositorio**.
    *   Nombre: `calendario-academico` (o lo que prefieras).
    *   Público o Privado (Privado está bien).
    *   **NO** marques "Initialize with README".
2.  Copia los comandos que aparecen bajo el título **"…or push an existing repository from the command line"**.
3.  Pégalos en tu terminal aquí. Serán algo así:
    ```bash
    git remote add origin https://github.com/TU_USUARIO/calendario-academico.git
    git branch -M main
    git push -u origin main
    ```

## Paso 1: Preparar la Base de Datos (PostgreSQL)

Como Render borra los archivos del disco cada vez que se reinicia, **no puedes usar SQLite**. Necesitas una base de datos real.

**Recomendación Principal: Neon.tech (Gratis Permanente)**
Render ofrece una base de datos gratis, pero se borra a los 90 días. **Neon.tech** es mucho mejor porque es gratis para siempre (hasta cierto límite generoso).

1.  Ve a [Neon.tech](https://neon.tech/) y regístrate.
2.  Crea un nuevo proyecto.
3.  Copia la **Connection String** (URL de conexión) que te dan. Se verá como:
    `postgres://usuario:password@ep-algo.aws.neon.tech/neondb?sslmode=require`
4.  ¡Guarda esta URL! La usarás en el siguiente paso.

## Paso 2: Desplegar la Aplicación en Render

Hemos preparado un archivo `render.yaml` y un `Dockerfile` en tu proyecto para facilitar esto.

1.  Ve al [Dashboard de Render](https://dashboard.render.com/).
2.  Haz clic en **New +** y selecciona **Blueprint**.
3.  Conecta tu cuenta de GitHub y selecciona el repositorio `calendario-academico`.
4.  Render detectará automáticamente el archivo `render.yaml`.
5.  Haz clic en **Apply**.

### Configuración de Variables de Entorno

Si el despliegue falla o necesitas configurar la base de datos manualmente:

1.  Ve al Dashboard de Render -> Tu servicio web -> **Environment**.
2.  Asegúrate de tener estas variables (si faltan, agrégalas):

| Clave | Valor |
|-------|-------|
| `APP_KEY` | (Copia la de tu archivo `.env` local o genera una nueva) |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `LOG_CHANNEL` | `stderr` |
| `DB_CONNECTION` | `pgsql` |
| `DB_URL` | **Pega aquí la URL de Neon.tech del Paso 1** |

## Paso 3: Ejecutar Migraciones

Una vez que el despliegue termine (verás "Deploy succeeded" en verde), necesitas crear las tablas en la base de datos.

1.  En el Dashboard de Render, entra a tu servicio web.
2.  Ve a la pestaña **Shell** (o "Connect").
3.  Espera a que conecte y ejecuta:
    ```bash
    php artisan migrate --force
    php artisan db:seed --force
    ```
    *(El segundo comando es para cargar los usuarios y eventos de prueba)*.

4.  ¡Listo! Tu aplicación ya debería estar funcionando en la URL que te da Render (ej: `https://calendario-academico.onrender.com`).

## Solución de Problemas Comunes (Diagnóstico)

Si ves "Deploy Failed" o "Server Error 500", sigue estos pasos:

### 1. Revisar los Logs de Render (CRUCIAL)
Es la única forma de saber qué pasó.
1.  Ve al Dashboard de Render -> Tu servicio.
2.  Haz clic en la pestaña **Logs**.
3.  Busca texto en rojo o errores.

### 2. Errores Comunes

#### "Build Failed" (Fallo al construir)
*   **Causa:** El servidor gratuito de Render tiene poca memoria (512MB) y `npm run build` falla.
*   **Solución YA APLICADA:** He modificado el proyecto para compilar los "assets" (CSS/JS) en tu computadora y subirlos listos.
    *   **Importante:** Si cambias algo de diseño en el futuro, debes ejecutar `npm run build` en tu PC antes de hacer `git push`.

#### "SQLSTATE[08006]... connection refused"
*   **Causa:** La aplicación no puede conectar a la base de datos.
*   **Solución:** Revisa la variable `DB_URL` en la pestaña **Environment**. Asegúrate de que copiaste la "Connection String" correcta de Neon.tech o Render.

#### "500 Server Error" (Pantalla blanca o error genérico)
*   **Causa:** Falta la `APP_KEY` o hay un error de código.
*   **Solución:**
    1.  Revisa que `APP_KEY` esté en las variables de entorno.
    2.  Mira los **Logs** para ver el error específico de Laravel.

#### "Mixed Content" (Estilos no cargan o HTTPS roto)
*   **Causa:** Laravel cree que está en HTTP pero Render usa HTTPS.
*   **Solución:** Agrega la variable de entorno `ASSET_URL` con valor `https://tu-app.onrender.com`.

### 3. ¿Sigue fallando?
Copia las últimas líneas de los **Logs** de Render y pégalas aquí en el chat para que pueda decirte exactamente qué arreglar.
