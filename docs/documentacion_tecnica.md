# Documentación Técnica - Calendario Académico

## Índice

1. [Arquitectura del Sistema](#arquitectura-del-sistema)
2. [Instalación](#instalación)
3. [Configuración](#configuración)
4. [Base de Datos](#base-de-datos)
5. [API y Rutas](#api-y-rutas)
6. [Seguridad](#seguridad)
7. [Mantenimiento](#mantenimiento)
8. [Despliegue](#despliegue)

---

## Arquitectura del Sistema

### Stack Tecnológico

```
┌─────────────────────────────────────┐
│         FRONTEND (Vue 3)            │
│  - Inertia.js                       │
│  - Tailwind CSS                     │
│  - Components: Events, Calendar     │
└─────────────────────────────────────┘
                 ↕
┌─────────────────────────────────────┐
│       BACKEND (Laravel 12)          │
│  - Controllers                      │
│  - Models (Eloquent ORM)            │
│  - Middleware (Auth, Roles)         │
│  - Auditing (Laravel Auditing)      │
└─────────────────────────────────────┘
                 ↕
┌─────────────────────────────────────┐
│      BASE DE DATOS (MySQL)          │
│  - users                            │
│  - events                           │
│  - audits                           │
│  - sessions                         │
└─────────────────────────────────────┘
```

### Patrón de Diseño

- **MVC (Model-View-Controller)**: Arquitectura principal de Laravel
- **Repository Pattern**: Para acceso a datos
- **Middleware Pattern**: Para autenticación y autorización
- **Observer Pattern**: Para auditoría automática

### Componentes Principales

#### Backend
- **Controllers**: `EventController`, `PublicCalendarController`
- **Models**: `User`, `Event`
- **Middleware**: `AdminMiddleware`, `EditorMiddleware`, `AuditorMiddleware`
- **Seeders**: `RoleUsersSeeder`

#### Frontend
- **Pages**: `Events/Index`, `Events/Create`, `Events/Edit`, `Events/Audits`, `Public/Calendar`
- **Layouts**: `AuthenticatedLayout`, `GuestLayout`
- **Components**: Reutilizables de Breeze

---

## Instalación

### Requisitos Previos

```bash
# Verificar versiones
php -v          # PHP 8.1+
composer -v     # Composer 2.x
node -v         # Node.js 18+
npm -v          # NPM 9+
mysql --version # MySQL 5.7+
```

### Instalación Paso a Paso

#### 1. Clonar el Repositorio

```bash
git clone https://github.com/tu-repo/academic-calendar.git
cd academic-calendar
```

#### 2. Instalar Dependencias PHP

```bash
composer install
```

#### 3. Instalar Dependencias JavaScript

```bash
npm install
```

#### 4. Configurar Variables de Entorno

```bash
# Copiar archivo de ejemplo
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate
```

#### 5. Configurar Base de Datos

Editar `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=academic_calendar
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

#### 6. Crear Base de Datos

```bash
# Conectar a MySQL
mysql -u root -p

# Crear base de datos
CREATE DATABASE academic_calendar CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

#### 7. Ejecutar Migraciones

```bash
php artisan migrate
```

#### 8. Ejecutar Seeders

```bash
php artisan db:seed
```

#### 9. Compilar Assets

```bash
# Desarrollo
npm run dev

# Producción
npm run build
```

#### 10. Iniciar Servidor

```bash
php artisan serve
```

Acceder a: `http://127.0.0.1:8000`

---

## Configuración

### Variables de Entorno Importantes

```env
# Aplicación
APP_NAME="Calendario Académico"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com

# Base de Datos
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=academic_calendar
DB_USERNAME=usuario
DB_PASSWORD=contraseña

# Email (para recuperación de contraseña)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-contraseña-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@tu-dominio.com
MAIL_FROM_NAME="${APP_NAME}"

# Sesiones
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Auditoría
AUDIT_ENABLED=true
```

### Configuración de Roles

Los roles se definen en la migración `update_users_role_to_enum.php`:

```php
$table->enum('role', ['admin', 'editor', 'auditor', 'user'])
      ->default('user');
```

### Configuración de Auditoría

Archivo: `config/audit.php`

```php
return [
    'enabled' => env('AUDIT_ENABLED', true),
    'user' => [
        'morph_prefix' => 'user',
        'guards' => ['web'],
    ],
];
```

---

## Base de Datos

### Esquema Completo

```sql
-- Tabla de usuarios
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'editor', 'auditor', 'user') DEFAULT 'user',
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Tabla de eventos
CREATE TABLE events (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    type VARCHAR(255) NOT NULL,
    is_published BOOLEAN DEFAULT FALSE,
    user_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_start_date (start_date),
    INDEX idx_is_published (is_published)
);

-- Tabla de auditorías
CREATE TABLE audits (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    event VARCHAR(255) NOT NULL,
    auditable_type VARCHAR(255) NOT NULL,
    auditable_id BIGINT UNSIGNED NOT NULL,
    old_values TEXT NULL,
    new_values TEXT NULL,
    url TEXT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    tags TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_auditable (auditable_type, auditable_id),
    INDEX idx_user (user_id)
);
```

### Migraciones

```bash
# Ver estado de migraciones
php artisan migrate:status

# Ejecutar migraciones pendientes
php artisan migrate

# Revertir última migración
php artisan migrate:rollback

# Revertir todas y ejecutar de nuevo
php artisan migrate:fresh

# Ejecutar con seeders
php artisan migrate:fresh --seed
```

### Seeders

```bash
# Ejecutar todos los seeders
php artisan db:seed

# Ejecutar seeder específico
php artisan db:seed --class=RoleUsersSeeder
```

---

## API y Rutas

### Rutas Públicas

```php
// Página de bienvenida
GET /

// Calendario público
GET /calendar

// Exportar PDF
GET /calendar/export-pdf
```

### Rutas de Autenticación

```php
// Login
GET /login
POST /login

// Registro
GET /register
POST /register

// Logout
POST /logout

// Recuperar contraseña
GET /forgot-password
POST /forgot-password
GET /reset-password/{token}
POST /reset-password
```

### Rutas de Editor (Admin + Editor)

```php
// Listar eventos
GET /events

// Crear evento
GET /events/create
POST /events

// Editar evento
GET /events/{event}/edit
PATCH /events/{event}
```

### Rutas de Admin (Solo Admin)

```php
// Eliminar evento
DELETE /events/{event}

// Revertir evento
POST /events/{event}/revert/{audit}
```

### Rutas de Auditor (Admin + Editor + Auditor)

```php
// Ver historial
GET /events/{event}/audits
```

### Middleware Aplicado

```php
// Rutas públicas: ninguno
// Rutas de autenticación: guest
// Rutas de editor: auth, editor
// Rutas de admin: auth, admin
// Rutas de auditor: auth, auditor
```

---

## Seguridad

### Autenticación

- **Laravel Breeze**: Sistema de autenticación completo
- **Bcrypt**: Hash de contraseñas
- **CSRF Protection**: Tokens en formularios
- **Session Management**: Sesiones seguras en base de datos

### Autorización

#### Middleware de Roles

```php
// AdminMiddleware
if (auth()->user()->role !== 'admin') {
    abort(403, 'Acción no autorizada');
}

// EditorMiddleware
if (!in_array(auth()->user()->role, ['admin', 'editor'])) {
    abort(403, 'Acción no autorizada');
}

// AuditorMiddleware
if (!in_array(auth()->user()->role, ['admin', 'editor', 'auditor'])) {
    abort(403, 'Acción no autorizada');
}
```

#### Validación en Controladores

```php
// Solo admin puede publicar
if ($validated['is_published'] != $event->is_published) {
    if (auth()->user()->role !== 'admin') {
        abort(403, 'Solo administradores pueden publicar');
    }
}
```

### Protección XSS

- Vue.js escapa automáticamente el HTML
- Validación de entrada en backend
- Sanitización de datos

### Protección SQL Injection

- Eloquent ORM usa prepared statements
- Validación de parámetros
- Type hinting en métodos

### Auditoría de Seguridad

```bash
# Verificar vulnerabilidades en dependencias
composer audit

# Actualizar dependencias de seguridad
composer update --with-dependencies
```

---

## Mantenimiento

### Logs

```bash
# Ver logs en tiempo real
tail -f storage/logs/laravel.log

# Limpiar logs antiguos
php artisan log:clear
```

### Cache

```bash
# Limpiar cache de aplicación
php artisan cache:clear

# Limpiar cache de configuración
php artisan config:clear

# Limpiar cache de rutas
php artisan route:clear

# Limpiar cache de vistas
php artisan view:clear

# Limpiar todo
php artisan optimize:clear
```

### Optimización

```bash
# Cachear configuración
php artisan config:cache

# Cachear rutas
php artisan route:cache

# Cachear vistas
php artisan view:cache

# Optimizar autoloader
composer dump-autoload --optimize
```

### Backups

#### Base de Datos

```bash
# Backup manual
mysqldump -u usuario -p academic_calendar > backup_$(date +%Y%m%d).sql

# Restaurar backup
mysql -u usuario -p academic_calendar < backup_20251124.sql
```

#### Archivos

```bash
# Backup de storage
tar -czf storage_backup_$(date +%Y%m%d).tar.gz storage/

# Backup completo
tar -czf full_backup_$(date +%Y%m%d).tar.gz \
    --exclude='node_modules' \
    --exclude='vendor' \
    .
```

### Monitoreo

```bash
# Verificar estado de la aplicación
php artisan about

# Verificar conexión a base de datos
php artisan db:show

# Ver rutas registradas
php artisan route:list

# Ver eventos registrados
php artisan event:list
```

---

## Despliegue

### Despliegue en Producción

#### 1. Preparar Servidor

```bash
# Actualizar sistema
sudo apt update && sudo apt upgrade -y

# Instalar dependencias
sudo apt install php8.1 php8.1-fpm php8.1-mysql php8.1-xml php8.1-mbstring php8.1-curl nginx mysql-server
```

#### 2. Configurar Nginx

```nginx
server {
    listen 80;
    server_name tu-dominio.com;
    root /var/www/academic-calendar/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### 3. Configurar Permisos

```bash
sudo chown -R www-data:www-data /var/www/academic-calendar
sudo chmod -R 755 /var/www/academic-calendar
sudo chmod -R 775 /var/www/academic-calendar/storage
sudo chmod -R 775 /var/www/academic-calendar/bootstrap/cache
```

#### 4. Configurar Variables de Entorno

```bash
# Editar .env
nano .env

# Configurar para producción
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com
```

#### 5. Optimizar para Producción

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

#### 6. Configurar SSL (Let's Encrypt)

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d tu-dominio.com
```

### Despliegue con Docker

```dockerfile
# Dockerfile
FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --optimize-autoloader --no-dev

RUN npm install && npm run build

CMD php artisan serve --host=0.0.0.0 --port=8000
```

```yaml
# docker-compose.yml
version: '3.8'

services:
  app:
    build: .
    ports:
      - "8000:8000"
    environment:
      - DB_HOST=db
      - DB_DATABASE=academic_calendar
      - DB_USERNAME=root
      - DB_PASSWORD=secret
    depends_on:
      - db

  db:
    image: mysql:8.0
    environment:
      - MYSQL_ROOT_PASSWORD=secret
      - MYSQL_DATABASE=academic_calendar
    volumes:
      - dbdata:/var/lib/mysql

volumes:
  dbdata:
```

---

## Solución de Problemas Técnicos

### Error: "Class not found"

```bash
composer dump-autoload
php artisan clear-compiled
php artisan optimize:clear
```

### Error: "SQLSTATE[HY000] [2002]"

```bash
# Verificar MySQL está corriendo
sudo systemctl status mysql

# Reiniciar MySQL
sudo systemctl restart mysql

# Verificar credenciales en .env
```

### Error: "Permission denied"

```bash
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

---

**Versión**: 1.0  
**Última actualización**: 24 de Noviembre de 2025
