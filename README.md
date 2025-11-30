# Plataforma de Agendamiento de Citas Médicas

Plataforma web completa para agendamiento de citas médicas en gastroenterología desarrollada con Laravel 11.x, Jetstream (Inertia + Vue), y TailwindCSS.

## Características

- ✅ Interfaz pública para pacientes con selector de médicos y calendario semanal
- ✅ Panel administrativo protegido con gestión completa de citas
- ✅ Sistema de estados de citas (pendiente → confirmada → completada / rechazada)
- ✅ Validación de colisiones de horarios
- ✅ Notificaciones por correo electrónico (Mailtrap)
- ✅ Model Binding por slug
- ✅ Duración de citas configurable

## Requisitos

- PHP 8.2 o superior
- Composer
- Node.js y npm
- Base de datos (SQLite, MySQL, PostgreSQL)

## Instalación

1. Clonar el repositorio:
```bash
git clone <repo-url>
cd AppCitas
```

2. Instalar dependencias de PHP:
```bash
composer install
```

3. Instalar dependencias de Node:
```bash
npm install
```

4. Configurar variables de entorno:
```bash
cp .env.example .env
php artisan key:generate
```

5. Configurar la base de datos en `.env`:
```env
DB_CONNECTION=sqlite
# O para MySQL/PostgreSQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=appcitas
# DB_USERNAME=root
# DB_PASSWORD=
```

6. Crear la base de datos SQLite (si usas SQLite):
```bash
touch database/database.sqlite
```

7. Ejecutar migraciones y seeders:
```bash
php artisan migrate --seed
```

8. Configurar Mailtrap para correos (opcional, para desarrollo):
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu_usuario_mailtrap
MAIL_PASSWORD=tu_password_mailtrap
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=noreply@clinicagastro.com
MAIL_FROM_NAME="${APP_NAME}"
```

9. Configurar duración de citas:
```env
APPOINTMENT_DURATION_MINUTES=30
```

10. Compilar assets:
```bash
npm run dev
# O para producción:
npm run build
```

11. Iniciar el servidor de desarrollo:
```bash
php artisan serve
```

## Usuario por Defecto

Después de ejecutar los seeders, puedes iniciar sesión con:

- **Email:** admin@clinicagastro.com
- **Password:** password

## Estructura del Proyecto

- `app/Models/` - Modelos Eloquent (Doctor, Appointment, DoctorAvailability)
- `app/Http/Controllers/` - Controladores
- `app/Services/` - Servicios de lógica de negocio (AppointmentService)
- `app/Mail/` - Clases Mailable para correos
- `database/migrations/` - Migraciones de base de datos
- `database/seeders/` - Seeders con datos de ejemplo
- `resources/js/Pages/` - Páginas Vue con Inertia
- `routes/web.php` - Rutas de la aplicación

## Rutas Principales

### Públicas
- `/` - Página principal con selector de médicos y calendario
- `/doctors/{slug}` - Perfil del médico
- `/appointments/new` - Formulario para crear cita

### Protegidas (requieren autenticación)
- `/dashboard` - Panel administrativo
- `/calendar` - Calendario por médico
- `/appointments` - Gestión de citas
- `/doctors` - CRUD de médicos

## Médicos de Ejemplo

El seeder crea 3 médicos de ejemplo:
- Dr. Carlos Ramírez
- Dra. María González
- Dr. Luis Martínez

Cada médico tiene disponibilidad de Lunes a Viernes:
- Mañana: 9:00 AM - 1:00 PM
- Tarde: 3:00 PM - 7:00 PM

## Licencia

Este proyecto es de código abierto.
