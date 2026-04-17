<?php
/**
 * index.php – Punto de entrada único de la aplicación (Front Controller)
 *
 * Toda petición HTTP pasa por aquí. Este archivo:
 *  1. Inicia la sesión PHP (para mensajes flash)
 *  2. Carga la configuración
 *  3. Registra el autoloader de clases
 *  4. Delega el enrutamiento al Router
 *
 * Flujo: Navegador → index.php → Router → Controller → Model + View
 */

// ── 1. Iniciar sesión (requerido para mensajes flash) ────────
session_start();

// ── 2. Cargar configuración de la aplicación y base de datos ─
require_once __DIR__ . '/app/config/database.php';

// ── 3. Cargar clases del núcleo ──────────────────────────────
require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/core/Router.php';

/**
 * Autoloader PSR-4 simplificado.
 * Carga automáticamente las clases desde /app/models y /app/controllers
 * cuando se hace `new NombreDeClase()`.
 */
spl_autoload_register(function (string $clase): void {
    // Directorios donde buscar clases
    $directorios = [
        __DIR__ . '/app/models/',
        __DIR__ . '/app/controllers/',
        __DIR__ . '/app/core/',
    ];

    foreach ($directorios as $dir) {
        $archivo = $dir . $clase . '.php';
        if (file_exists($archivo)) {
            require_once $archivo;
            return;
        }
    }
    // Si no se encuentra, PHP lanzará un error fatal naturalmente
});

// ── 4. Despachar la petición al controlador correspondiente ──
Router::dispatch();
