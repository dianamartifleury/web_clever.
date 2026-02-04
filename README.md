<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


*****************************************************
# Desarrolladores del proyecto
*****************************************************

# 🚀 Nombre del Proyecto

Este es un proyecto desarrollado con [Laravel](https://laravel.com/) y [Laravel Breeze](https://laravel.com/docs/starter-kits#laravel-breeze), una implementación simple de autenticación para Laravel.

## 📦 Tecnologías utilizadas

- PHP 8.1 o superior
- Laravel 10 o superior
- Laravel Breeze
- Composer
- MySQL
- Node.js y npm (para assets: Tailwind CSS, Alpine.js, etc.)
- Git y GitHub

---

## ⚙️ Requisitos previos

Antes de comenzar, asegúrate de tener instalado lo siguiente en tu sistema:

- PHP >= 8.1
- Composer
- Node.js y npm
- MySQL o PostgreSQL
- Git
- Opcional: Laravel Valet o Laravel Sail (Docker)

---

## 🚀 Instalación del proyecto

Sigue estos pasos para clonar y levantar el proyecto en tu entorno local:

### 1. Clonar el repositorio

```bash
git clone https://github.com/DiegoAmaro26/web_clever
cd web_clever


# Clever Trading – Página Web Corporativa

## 📌 Descripción del proyecto

Este proyecto consiste en una **página web corporativa** desarrollada para la empresa **Clever Trading**, cuyo objetivo es presentar la empresa y las **ofertas comerciales** que pone a disposición de los usuarios, así como permitir el contacto mediante un formulario.

La aplicación ha sido desarrollada siguiendo buenas prácticas de desarrollo web, utilizando el framework **Laravel**, con una arquitectura **MVC (Modelo–Vista–Controlador)**.

---

## 👥 Autores

Proyecto desarrollado por:

- Diana Marti Fleury  
- Luis Fernando Garcia Escorcia  
- Diego Amaro López  

---

## 🛠️ Tecnologías utilizadas

### Backend
- PHP  
- Laravel  
- MySQL  

### Frontend
- HTML  
- CSS  
- Bootstrap  

### Otras tecnologías
- Node.js  
- Composer  
- NPM  
- Librería `maatwebsite/excel`  
- Asistente de chat con Inteligencia Artificial (ChatGPT)

---

## 🤖 Asistente de chat con Inteligencia Artificial

La página web incorpora un **asistente de chat basado en Inteligencia Artificial**, implementado mediante la integración con **ChatGPT**, con el objetivo de mejorar la experiencia del usuario.

### Funcionalidades del asistente
- Interacción en tiempo real con los usuarios.
- Resolución de dudas relacionadas con la empresa y sus ofertas.
- Soporte informativo automatizado.
- Integración controlada desde el backend mediante Laravel.

---

## 🧱 Arquitectura

La aplicación sigue una **arquitectura MVC**, separando claramente las responsabilidades del sistema:

- **Modelos**: gestión de datos y conexión con la base de datos.
- **Vistas**: representación de la interfaz de usuario.
- **Controladores**: lógica de negocio y gestión de las peticiones.

---

## 🗄️ Base de datos

La base de datos se gestiona mediante **MySQL** y comienza inicialmente **vacía**.  
Las tablas necesarias se crean mediante migraciones y se inicializan con datos básicos utilizando seeders.

### Tablas principales
- `customers`
- `products`
- `categories`
- `customer_metadata`

La conexión con la base de datos se configura a través del archivo `.env`.

---

## ⚙️ Instalación y configuración

### Requisitos previos
- PHP
- Composer
- Node.js y NPM
- MySQL
- Servidor web (Apache o similar)

### Pasos de instalación

1. Clonar el repositorio del proyecto.
2. Instalar las dependencias del backend:
   ```bash
   composer install
3. Instalar las dependencias del frontend:
    npm install
4. Compilar los recursos del frontend:
    npm run dev


5. Configurar el archivo .env con:

    - Claves propias de Laravel.
    - Datos de conexión a la base de datos.
    - Variables adicionales necesarias para el despliegue en servidor.
    - Ejecutar las migraciones y seeders:
    php artisan migrate --seed

##👤 Uso de la página web (Usuarios finales)

Los usuarios finales no necesitan iniciar sesión para utilizar la página web.

### Funcionalidades disponibles

- Visualización de la información corporativa de la empresa Clever Trading.
- Consulta de las ofertas disponibles.
- Envío de consultas mediante un formulario de contacto.
- Interacción con el asistente de chat con Inteligencia Artificial.
- Los datos enviados a través del formulario se almacenan en la base de datos junto con los metadatos recogidos en el momento del envío.

##🔐 Panel de administración

El acceso al panel de administración está restringido exclusivamente a los perfiles de:
- Administrador
- Tester

Desde este panel se pueden gestionar los datos internos de la aplicación y supervisar la información recogida a través de la web.

##📊 Exportación de datos a Excel

La aplicación incluye una funcionalidad para la generación de documentos Excel, implementada mediante la librería maatwebsite/excel.

###Características

Exportación de los datos recogidos desde los formularios de contacto.
Inclusión de los metadatos asociados a cada envío.
Facilita el análisis y tratamiento de la información recopilada.

##🎓 Contexto académico

Este proyecto ha sido desarrollado en el marco de prácticas formativas, aplicando conocimientos de:

- Desarrollo web
- Frameworks backend
- Bases de datos relacionales
- Arquitectura MVC
- Integración de servicios externos
- Aplicación de Inteligencia Artificial a la experiencia de usuario

##📄 Licencia

Este proyecto ha sido desarrollado con fines educativos y formativos.
No está destinado a uso comercial sin la debida autorización.