# 🏥 Sistema de Citas Médicas

Sistema completo de gestión de citas médicas desarrollado con Laravel 12, Jetstream e Inertia.js (Vue 3).

## 🎯 Características Principales

- ✅ **Calendario Semanal Interactivo**: Navegación por semanas con visualización de espacios disponibles
- ✅ **Gestión de Múltiples Médicos**: Soporte para varios médicos con disponibilidad personalizada
- ✅ **Validación de Colisiones**: Prevención automática de citas duplicadas
- ✅ **Flujo de Estados**: Gestión completa del ciclo de vida de las citas
- ✅ **Notificaciones por Email**: Envío automático al crear/aceptar/rechazar citas
- ✅ **Panel Administrativo**: Dashboard completo protegido con autenticación
- ✅ **Diseño Responsive**: Interfaz moderna con Tailwind CSS
- ✅ **SPA con Vue 3**: Experiencia de usuario fluida con Inertia.js

## 📋 Reglas de Negocio Implementadas

### 1. Configuración Global de Duración
```env
APPOINTMENT_DURATION_MINUTES=20
```

### 2. Disponibilidad Semanal por Médico
- Horarios configurables por día de la semana
- Múltiples bloques de disponibilidad (ej: mañana y tarde)

### 3. Prevención de Colisiones
- Un médico no puede tener dos citas pendientes o confirmadas simultáneamente

### 4. Flujos de Estados
- **Flujo Normal**: pendiente → confirmada → completada
- **Flujo Alternativo**: pendiente → rechazada

### 5. Notificaciones Automáticas
- Email al crear cita (estado pendiente)
- Email al aceptar cita (estado confirmada)
- Email al rechazar cita (estado rechazada)

### 6. Seguridad
- Panel administrativo protegido con Laravel Jetstream
- Rutas públicas para agendamiento de citas

## 🚀 Instalación del Proyecto

### Prerrequisitos

Antes de instalar, asegúrate de tener instalado:

- **PHP** >= 8.2
- **Composer** (gestor de dependencias PHP)
- **Node.js** >= 18.x y **NPM**
- **PostgreSQL** >= 14.x
- **Git**

### Paso a Paso

#### 1. Clonar el repositorio

```bash
git clone https://github.com/leonardomrios/AppCitas.git
cd AppCitas
```

#### 2. Instalar dependencias de PHP

```bash
composer install
```

#### 3. Instalar dependencias de Node.js

```bash
npm install
```

#### 4. Configurar variables de entorno

```bash
# Copiar archivo de ejemplo
copy .env.example .env   # Windows
# cp .env.example .env   # Linux/Mac

# Generar key de aplicación
php artisan key:generate
```

#### 5. Configurar base de datos PostgreSQL

Edita el archivo `.env` con tus credenciales de PostgreSQL:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=appcitas
DB_USERNAME=postgres
DB_PASSWORD=tu_contraseña_aqui
```

**Crear la base de datos:**

```sql
-- En PostgreSQL
CREATE DATABASE appcitas;
```

#### 6. Configurar correo electrónico

Para desarrollo, usa **Mailtrap**:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu_username_mailtrap
MAIL_PASSWORD=tu_password_mailtrap
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="leoLaravel@example.com"
MAIL_FROM_NAME="Sistema de Citas"
```

Para producción con **Gmail**:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=tu_app_password
MAIL_ENCRYPTION=tls
```

> **Nota:** Para Gmail, debes crear una [contraseña de aplicación](https://support.google.com/accounts/answer/185833).

#### 7. Configurar duración de citas

En el archivo `.env`:

```env
APPOINTMENT_DURATION_MINUTES=20
```

#### 8. Ejecutar migraciones y seeders

```bash
php artisan migrate --seed
```

Esto creará:
- Tablas de la base de datos
- Usuario administrador
- 3 médicos con disponibilidad
- Citas de ejemplo

#### 9. Compilar assets del frontend

Para **desarrollo** con hot-reload:

```bash
npm run dev
```

Para **producción**:

```bash
npm run build
```

#### 10. Iniciar el servidor

En una terminal nueva:

```bash
php artisan serve
```

La aplicación estará disponible en: `http://127.0.0.1:8000`

### 👤 Credenciales de Acceso

**Usuario Administrador:**
- Email: `admin@clinicagastro.com`
- Password: `password`

**Panel Administrativo:** `http://127.0.0.1:8000/login`

## 🛣️ Rutas del Sistema

### Públicas
- `GET /` - Selector de médico y calendario
- `GET /doctors/{slug}` - Perfil del médico
- `GET /appointments/new` - Formulario de reserva
- `POST /appointments` - Crear cita

### Protegidas (Admin)
- `GET /home` - Dashboard
- `GET /calendar` - Calendario semanal
- `Resource /doctors` - CRUD médicos
- `Resource /appointments` - Gestión de citas
- `POST /appointments/{slug}/accept` - Aceptar cita
- `POST /appointments/{slug}/reject` - Rechazar cita

## 📧 Configuración de Emails

### Gmail
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=tu_password_de_aplicacion
MAIL_ENCRYPTION=tls
```

### Mailtrap (Desarrollo)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu_username
MAIL_PASSWORD=tu_password
```

## 📚 Documentación Completa

Ver [INSTRUCCIONES_IMPLEMENTACION.md](INSTRUCCIONES_IMPLEMENTACION.md) para:
- Guía de instalación detallada
- Configuración de correos
- Estructura del proyecto
- Solución de problemas
- Personalización del sistema

## 🏗️ Tecnologías Utilizadas

- **Backend**: Laravel 12, Jetstream, Sanctum
- **Frontend**: Vue 3, Inertia.js, Tailwind CSS
- **Base de Datos**: PostgreSQL
- **Autenticación**: Laravel Fortify + Jetstream
- **Emails**: Laravel Mailable
- **Build Tool**: Vite

## 👥 Médicos Precargados

1. **Dr. Carlos Ramírez** - Gastroenterología
2. **Dra. María González** - Gastroenterología  
3. **Dr. Luis Martínez** - Gastroenterología

**Horario por defecto:** Lunes a Viernes, 9:00-13:00 y 15:00-19:00

## 🔧 Comandos Útiles

```bash
# Recrear base de datos
php artisan migrate:fresh --seed

# Limpiar caché
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Modo desarrollo con hot reload
npm run dev

# Compilar para producción
npm run build

# Ejecutar tests
php artisan test

# Verificar errores de código
./vendor/bin/pint
```

## 🐛 Solución de Problemas Comunes

### Error de conexión a PostgreSQL
```bash
# Verificar que PostgreSQL esté corriendo
# Windows: Servicios > PostgreSQL
# Linux: sudo systemctl status postgresql
```

### Error "Class not found"
```bash
composer dump-autoload
php artisan config:clear
```

### Assets no se cargan
```bash
npm run build
php artisan view:clear
```

### Error de permisos en storage
```bash
# Windows (PowerShell como Admin)
icacls "storage" /grant Users:F /t
icacls "bootstrap\cache" /grant Users:F /t

# Linux/Mac
chmod -R 775 storage bootstrap/cache
```

## 📊 Estados de Citas

| Estado | Descripción | Transiciones Permitidas |
|--------|-------------|------------------------|
| `pending` | Cita solicitada | → confirmada, rechazada |
| `confirmed` | Cita aceptada | → completada |
| `completed` | Cita realizada | - |
| `rejected` | Cita rechazada | - |

## 🎨 Capturas de Pantalla

### Página Principal
- Selector de médicos (3 médicos)
- Calendario semanal con navegación
- Espacios disponibles por día

### Panel Administrativo
- Dashboard con estadísticas
- Gestión de citas con filtros
- Calendario por médico
- Acciones: aceptar/rechazar/completar

## 📂 Estructura del Proyecto

```
AppCitas/
├── app/
│   ├── Http/Controllers/     # Controladores
│   ├── Models/              # Modelos Eloquent
│   ├── Services/            # Lógica de negocio
│   └── Mail/                # Plantillas de email
├── database/
│   ├── migrations/          # Migraciones de BD
│   ├── seeders/             # Datos de prueba
│   └── factories/           # Factories para testing
├── resources/
│   ├── js/
│   │   ├── Pages/          # Componentes Vue
│   │   └── Layouts/        # Layouts de la app
│   ├── views/              # Vistas Blade
│   └── css/                # Estilos
├── routes/
│   ├── web.php             # Rutas web
│   └── api.php             # Rutas API
└── config/
    └── appointment.php      # Configuración de citas
```

## 🚀 Despliegue a Producción

### Preparación

```bash
# Compilar assets optimizados
npm run build

# Optimizar autoload
composer install --optimize-autoloader --no-dev

# Cachear configuraciones
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Variables de entorno importantes

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tudominio.com

# Usar conexión segura para sesiones
SESSION_SECURE_COOKIE=true
```

## 📝 Licencia

Este proyecto es de uso educativo/comercial. Desarrollado por Leonardo Ríos.

## 👨‍💻 Autor

**Leonardo Ríos**
- GitHub: [@leonardomrios](https://github.com/leonardomrios)
- Proyecto: [AppCitas](https://github.com/leonardomrios/AppCitas)

## 🤝 Contribuciones

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

---

Desarrollado con ❤️ usando Laravel 12 y Vue 3
