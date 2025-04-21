# Sistema ci3POS

<div align="center">
  
![badge_status](https://img.shields.io/badge/status-develop-690)
![release_date](https://img.shields.io/badge/release_date-abril_2025-7cacee)
![php_version](https://img.shields.io/badge/php-7.x-7377ad)
![CI_version](https://img.shields.io/badge/Codeigniter-3.1.7-f73900)
![docker](https://img.shields.io/badge/docker-28.04-2492e7)

</div>

Aplicación web de sistema POS y Apertura / Cierre de CAJA. Basado en el framework CodeIgniter, Bootstrap y Javascript (JSON, AJAX).

---

## Funcionalidades
- **CRUD + relevantes**:
  - Menús (niveles) del sistema y vínculo a controladores (módulos).
  - Mantenimiento de usuarios, grupos de usuarios, privilegios y acciones.
  - Transacciones de pagos.
  - Gestión de usuarios, clientes y planes.
- **Impresión de tickets**: Compatible con impresoras térmicas.
- **Backup de base de datos**: Generación de copias de seguridad.
- **Registro de transacciones**: Seguimiento de solicitudes al servidor.

---

## Requerimientos del servidor
- **PHP**: Versión 7.4 o superior.
- **Base de datos**: MySQL 5.7 o superior.
- **Servidor web**: Apache con soporte para mod_rewrite.

---

## Frameworks y librerías
### Backend
- **PHP framework**: [CodeIgniter 3.1.7](https://github.com/bcit-ci/CodeIgniter)

### Frontend
- **UI Framework**: [Bootstrap 3.3.7](https://github.com/twbs/bootstrap)
- **Template**: [Flacto](https://wrapbootstrap.com/theme/flacto-admin-dashboard-template-WB0C3DCHM)

### Librerías JavaScript
- DataTables
- Modernizr 2.8.3
- Select2
- SweetAlert
- jQuery 2.1.4
- jQuery UI 1.11.4
- Hammer.js 2.0.4
- Lodash 3.1.0
- Parsley.js

### Terceros
- [ESC/POS Print Driver for PHP](https://github.com/mike42/escpos-php) por Mike42.

---

## Uso
### Configuración inicial

A continuación se describe algunas configuraciones necesarias para levantar el proyecto en un entorno local

1. **Base de datos**:
   - Ejecutar el [script de estructura](/files/db/01-estructura.sql) para crear la base de datos.
   - Ejecutar el [script inicial de datos](/files/db/02-datos.sql).

2. **Configuración del proyecto**:
   - Editar el archivo `/application/config/config.php` y definir el valor de `base_url`:
     ```php
     $config['base_url'] = 'http://localhost:8080/';
     ```
   - Configurar la conexión a la base de datos en [database.php](/application/config/database.php):
     ```php
     $db['default'] = array(
         'dsn'      => '',
         'hostname' => 'db',
         'username' => 'root',
         'password' => 'root',
         'database' => 'ci_database',
         'dbdriver' => 'mysqli',
         'dbprefix' => '',
         'pconnect' => FALSE,
         'db_debug' => (ENVIRONMENT !== 'production'),
         'cache_on' => FALSE,
         'cachedir' => '',
         'char_set' => 'utf8mb4',
         'dbcollat' => 'utf8mb4_unicode_ci',
         'swap_pre' => '',
         'encrypt'  => FALSE,
         'compress' => FALSE,
         'stricton' => FALSE,
         'failover' => array(),
         'save_queries' => TRUE
     );
     ```

---

### Levantar el proyecto con Docker
1. **Construir las imágenes**:
  ```bash
  docker-compose build
  ```
2. **Levantar los contenedores:**
  ```bash
  docker-compose up -d
  ```
3. **Acceder al sistema:**

* URL: http://localhost:8080
* Credenciales:
  * Usuario: superadmin
  * Contraseña: 123456

## Licencia
<a href="LICENSE">MIT</a> con términos de licencia <a href="https://codeigniter.com/userguide3/license.html">Codeigniter</a>.
