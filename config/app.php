<?php
// ============================================================
// config/app.php — Constantes globales de la aplicación
// ============================================================

define('APP_NAME',    'DGETI — Sistema de Justificantes');
define('APP_VERSION', '1.0.0');
define('APP_URL',     'http://localhost/dgeti-mvc');
define('BASE_PATH',   dirname(__DIR__));
define('SESSION_NAME','dgeti_session');

// Zona horaria
date_default_timezone_set('America/Mexico_City');

// Roles permitidos
define('ROLES', ['alumno', 'docente', 'admin']);

// Motivos de justificante (deben coincidir con el ENUM de la BD)
define('MOTIVOS', ['Salud', 'Comisión', 'Personal']);

// Estados de justificante
define('ESTADOS', ['Generado', 'Entregado', 'Validado']);
