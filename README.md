# MyShop: Joyería - Gestión de tienda con Laravel

Resumen
-------
MyShop es una aplicación web completa para la gestión de la joyería Aristocats, desarrollada con Laravel. Permite administrar productos, categorías, ofertas y usuarios con diferentes roles y permisos. Está pensada como proyecto educativo para practicar Laravel, Eloquent ORM, autenticación, autorización y despliegue con Docker.

Características principales
---------------------------
- Sistema completo de gestión de productos (CRUD) con soporte para múltiples imágenes.
- Gestión de categorías y ofertas con imágenes personalizadas.
- Panel de administración con dashboard organizado y búsquedas avanzadas.
- Sistema de autenticación con tres roles: Admin, Trabjador y Cliente.
- Carruseles interactivos para imágenes de productos y joyas destacadas.
- Barra de búsqueda con filtros avanzados.
- Formularios de contacto y de registro con validaciones.
- Sistema de favoritos y carrito de la compra.

Mejoras y funcionalidades añadidas
----------------------------------
Este proyecto incluye las siguientes mejoras sobre un proyecto base:

### Diseño y experiencia de usuario
- **Cambios de estilos y fuentes general**: Rediseño completo de la interfaz con TailwindCSS.
- **Estilos de tarjetas mejorados**: Tarjetas de producto con efecto hover y botón de corazón para favoritos.
- **Cambio en estilos de CRUDs**: Interfaz moderna y consistente en todos los formularios de gestión.
- **Personalización de imágenes**: Soporte para imágenes personalizadas en productos, categorías y favicon personalizado.

### Gestión de productos
- **Opción de múltiples imágenes**: Los productos pueden tener varias imágenes asociadas.
- **Carrusel de imágenes del producto**: Navegación fluida entre las diferentes fotos de un producto.
- **Ampliar miniatura**: Vista previa mejorada de imágenes en creación y edición de productos.
- **Acceso directo**: Click en la imagen del producto para ver sus detalles.

### Sistema de búsqueda y navegación
- **Barra de búsqueda avanzada**: Búsqueda para categorías, ofertas y productos.
- **Filtros inteligentes**: Sistema de filtros para refinar búsquedas de productos.
- **Acceso a detalles**: Enlaces directos desde el nombre del producto/oferta a su página de detalle.

### Panel de administración
- **Dashboard organizado**: Panel principal con estadísticas y accesos rápidos.
- **CRUD de categorías**: Gestión completa de categorías con imágenes.
- **CRUD de ofertas**: Administración de ofertas y promociones.
- **CRUD de usuarios**: Gestión de usuarios con asignación de roles.
- **Búsqueda y filtros**: Funcionalidad de búsqueda en todos los CRUDs del panel.

### Sistema de roles y permisos
- **Roles funcionales**: Implementación completa de sistema de roles.
- **Tercer rol (Empleado)**: Creación de rol intermedio con permisos específicos.
- **Visualización del rol**: Indicador visual del rol del usuario en la interfaz.
- **Permisos granulares**: Control de acceso específico según el rol.

### Funcionalidades para clientes
- **Formulario de registro**: Clientes pueden registrarse directamente en la plataforma.
- **Formulario de contacto**: Sistema de contacto con validaciones robustas.
- **Carrusel en página de inicio**: Presentación destacada de joyas en la home.

### Gestión de categorías y ofertas
- **Campo de imagen para categorías**: Cada categoría puede tener su imagen representativa.
- **Gestión de ofertas**: Sistema completo para crear y administrar ofertas especiales.

Tecnologías
-----------
- Laravel 11.x
- PHP 8.4
- MySQL 8.0
- Laravel Sail 
- TailwindCSS 3.x
- Vite 5.x
- Laravel Telescope
- Redis
- Composer 2.0+
- Node.js 18+

Estructura del proyecto
-----------------------
Raíz del repositorio:

- `app/` — Código principal de la aplicación Laravel (Models, Controllers, Policies, etc.).
  - `Http/Controllers/` — Controladores de la aplicación.
  - `Models/` — Modelos Eloquent (User, Product, Category, Offer, ProductImage).
  - `Policies/` — Políticas de autorización.
- `resources/` — Recursos frontend (vistas Blade, CSS, JS).
  - `views/` — Plantillas Blade.
  - `css/` y `js/` — Assets compilados con Vite.
- `database/` — Migraciones, seeders y factories.
  - `migrations/` — Esquema de la base de datos.
  - `seeders/` — Datos de prueba.
  - `data/` — Archivos mock para testing.
- `routes/` — Definición de rutas (web.php, auth.php, console.php).
- `public/` — Document root servido por el servidor web.
- `storage/` — Archivos generados (logs, cache, uploads).
- `tests/` — Tests unitarios y de integración.
- `vendor/` — Dependencias de Composer (se genera con `composer install`).
- `compose.yaml` — Configuración Docker Compose.

Instrucciones de instalación - Requisitos previos
------------------
- Docker Desktop (incluye Docker Compose)
- Git (para clonar el repositorio)
- Composer 2.x (opcional, solo para instalación local sin Docker)

**Nota:** Laravel Sail gestiona automáticamente PHP, MySQL, Redis y otras dependencias dentro de contenedores Docker.

Instalación con Laravel Sail (Recomendado)
-------------------------------------------

1. Clona el repositorio:

```bash
git clone https://github.com/Didiu92/MYSHOP.git
cd MYSHOP
```

2. Copia el archivo de entorno:

```bash
cp .env.example .env
```

3. Instala las dependencias de Composer (primera vez):

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

4. Inicia Laravel Sail:

```bash
./vendor/bin/sail up -d
```

5. Genera la clave de la aplicación:

```bash
./vendor/bin/sail artisan key:generate
```

6. Ejecuta las migraciones y seeders:

```bash
./vendor/bin/sail artisan migrate --seed
```

7. Instala dependencias de Node.js y compila assets:

```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

8. Crea el enlace simbólico para storage:

```bash
./vendor/bin/sail artisan storage:link
```

9. Abre la aplicación en el navegador:

```
http://localhost
```

**Tip:** Puedes crear un alias para simplificar los comandos:
```bash
alias sail='./vendor/bin/sail'
```
Después podrás usar `sail up`, `sail artisan migrate`, etc.

Instalación sin Docker (local)
------------------------------
1. Clona el repositorio:

```bash
git clone https://github.com/Didiu92/MYSHOP.git
cd MYSHOP
```

2. Instala dependencias de PHP:

```bash
composer install
```

3. Copia el archivo de entorno:

```bash
cp .env.example .env
```

4. Genera la clave de la aplicación:

```bash
php artisan key:generate
```

5. Configura tu base de datos en el archivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=myshop
DB_USERNAME=root
DB_PASSWORD=tu_contraseña
```

6. Ejecuta las migraciones y seeders:

```bash
php artisan migrate --seed
```

7. Instala dependencias de Node.js y compila assets:

```bash
npm install
npm run dev
```

8. Crea el enlace simbólico para storage:

```bash
php artisan storage:link
```

9. Inicia el servidor de desarrollo:

```bash
php artisan serve
```

10. Abre la aplicación en el navegador:

```
http://localhost
```

Uso básico
----------
### 1. Acceso a la aplicación

- Con Laravel Sail: `http://localhost`
- Sin Docker (servidor Laravel): `http://localhost:8000` (o el puerto configurado)

### 2. Usuarios de prueba

| Rol            | Email                  | Contraseña  | Permisos                                    |
|----------------|------------------------|-------------|---------------------------------------------|
| Administrador  | tu@email.com           | password123 | Acceso completo + CRUD de usuarios          |
| Trabajador     | demo@example.com       | password    | Dashboard + listados sin editar             |
| Cliente        | customer@myshop.com    | password123 | Wishlist + carrito tras login               |

### 3. Navegación principal

#### Para todos los usuarios:
- **Página principal**: Catálogo de productos con carrusel de joyas destacadas.
- **Detalle de producto**: Vista completa del producto con carrusel de imágenes.
- **Categorías**: Navegación por categorías con imágenes personalizadas.
- **Ofertas**: Sección de productos en oferta.
- **Búsqueda avanzada**: Barra de búsqueda con filtros múltiples.
- **Formulario de contacto**: Formulario con validaciones para consultas.

#### Para clientes registrados:
- **Favoritos**: Sistema de wishlist con botón de corazón.
- **Perfil**: Gestión de datos personales.

#### Para Empleado:
- **Dashboard**: Panel con estadísticas y accesos rápidos.
- **Gestión de productos**: CRUD completo con múltiples imágenes.
- **Vista previa de imágenes**: Ampliación de miniaturas en formularios.

#### Para Admin:
- **Todo lo anterior** más:
- **Gestión de categorías**: CRUD con imágenes y búsqueda.
- **Gestión de ofertas**: CRUD completo con filtros.
- **Gestión de usuarios**: CRUD con asignación y visualización de roles.
- **Laravel Telescope**: Herramienta de debugging y monitoreo.

### 4. Funcionalidades destacadas

- **Múltiples imágenes por producto**: Sube y gestiona varias fotos para cada producto.
- **Carruseles interactivos**: Navegación fluida entre imágenes.
- **Roles y permisos**: Sistema de autorización granular implementado con Laravel Policies.
- **Búsqueda inteligente**: Filtros combinables para encontrar productos rápidamente.
- **Responsive design**: Interfaz adaptable a todos los dispositivos.


Autora y créditos
-----------------
- Autor: Diana Viñuales Alós
- Repositorio: https://github.com/Didiu92/MYSHOP
- Framework: Laravel (https://laravel.com)

Licencia
--------
Este proyecto se publica bajo la licencia Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0).

