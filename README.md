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

## 🚀 Inicio Rápido

```bash
# 1. Instalar dependencias
composer install
npm install

# 2. Configurar entorno
cp .env.example .env
php artisan key:generate

# 3. Crear base de datos
touch database/database.sqlite
php artisan migrate --seed

# 4. Compilar assets y ejecutar
npm run build
php artisan serve
```

**Credenciales Admin:**
- Email: `admin@clinicagastro.com`
- Password: `password`

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
- **Base de Datos**: SQLite (configurable a MySQL/PostgreSQL)
- **Autenticación**: Laravel Fortify + Jetstream
- **Emails**: Laravel Mailable

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

## 📝 Licencia

Este proyecto es de uso educativo/comercial según los términos acordados.

## 🤝 Contribuciones

Para mejoras o reportar bugs, contactar al equipo de desarrollo.

---

Desarrollado con ❤️ usando Laravel y Vue.js
