<?php
/**
 * config/database.php
 * Configuración de la conexión a la base de datos MySQL
 * Modifica estas constantes según tu entorno XAMPP
 */

define('DB_HOST',     '127.0.0.1');
define('DB_PORT',     '8080');
define('DB_NAME',     'justificantes_db');
define('DB_USER',     'desarrollo');
define('DB_PASS',     'desarrollo');
define('DB_CHARSET',  'utf8mb4');

/**
 * Constantes globales de la aplicación
 */
define('APP_NAME',    'Sistema de Justificantes');
define('APP_VERSION', '1.0.0');
// URL base: ajusta si tu carpeta no se llama "justificantes"
define('BASE_URL',    'http://localhost/justificantes');
