
# Sistema-POS-CAJA <a href="https://github.com/willwashburn/phpamo/blob/master/license.txt"><img src="https://camo.githubusercontent.com/017199f6ddb42287521bba1dc11cb5dd8afaa365/68747470733a2f2f696d672e736869656c64732e696f2f7061636b61676973742f6c2f77696c6c776173686275726e2f706870616d6f2e7376673f7374796c653d666c61742d737175617265" alt="MIT License" data-canonical-src="https://img.shields.io/packagist/l/willwashburn/phpamo.svg?style=flat-square" style="max-width:100%;"></a>
Aplicación web de sistema POS y Apertura / Cierre de CAJA. Basado en el framework Codeigniter, Bootstrap y Javascript (JSON, AJAX, CRUD).
## Funcionalidades
<ul>
  <li>CRUD + relevantes</li>
    <ul>
      <li>Menús (niveles) del sistema y vínculo a controladores (módulos).</li>
      <li>Mantenimiento de usuarios, grupos de usuarios, privilegios y acciones.</li>
      <li>Transacciones de pagos.</li>
      <li>Varios (Usuarios, clientes, planes...).</li>
    </ul>
  <li>Impresión ticket de pago con Impresora térmica.</li> 
  <li><a href="https://codeigniter.com/userguide3/database/utilities.html">Backup base de datos</a>.</li>
  <li>Registro de transacciones de solicitudes al servidor.</li>
</ul>

## Requerimientos del servidor
Se recomienda la versión 5.6 o posterior de PHP.</br>
También debería funcionar en 5.4.8, pero le recomendamos encarecidamente que NO ejecute versiones tan antiguas de PHP, debido a posibles problemas de seguridad y rendimiento, así como a la falta de características.
## Framework web
<ul>
  <li>PHP framework <a href="https://github.com/bcit-ci/CodeIgniter">Codeigniter 3.1.7.</a></li>
  <li>UI Framework <a href="https://github.com/twbs/bootstrap">Bootstrap 3.3.7.</a></li>
  <ul><li>Template <a href="https://wrapbootstrap.com/theme/flacto-admin-dashboard-template-WB0C3DCHM">Flacto</a>.</li></ul>
</ul>

## Librerías JavaScript
<ul>
  <li>DataTables</li>
  <li>Modernizr 2.8.3</li>
  <li>Select2</li>
  <li>SweetAlert</li>
  <li>jQuery 2.1.4</li>
  <li>jQuery UI 1.11.4</li>
  <li>Hammer.js 2.0.4</li>
  <li>Lodash 3.1.0</li>
  <li>Parsleyjs</li>
</ul>

## Third Party
<a href="https://github.com/mike42/escpos-php">ESC/POS Print Driver for PHP</a> by Mike42.
## Uso
### Base de datos
<ul>
  <li>Ejecutar <a href="https://github.com/setodimario/Sistema-POS-CAJA/blob/master/files/script_db_modeldb/script-dump-estrucutura-db.sql">script de volcado de dump base de datos</a> (Crear base de datos y estructura)</li>
  <li>Ejecutar <a href="https://github.com/setodimario/Sistema-POS-CAJA/blob/master/files/script_db_modeldb/script-start.sql">script inicial de datos</a></li>
</ul>

### Configuración /application/config
<ul>
  <li>Definir <a href="https://github.com/setodimario/Sistema-POS-CAJA/blob/master/application/config/config.php">base_url</a></li>
</ul>

### Credenciales aplicación
<ul>
  <li>Usuario: superadmin</li>
  <li>Contraseña: 123456</li>
</ul>

## Licencia
MIT con términos de licencia <a href="https://codeigniter.com/userguide3/license.html">Codeigniter</a>.
