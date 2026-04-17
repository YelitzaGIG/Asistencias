<?php
/**
 * core/Router.php
 * Enrutador simple que mapea las peticiones GET/POST
 * a los controladores y métodos correspondientes.
 *
 * Parámetros esperados en la URL:
 *   ?controller=justificante&action=index
 *   ?controller=justificante&action=create
 *   etc.
 */
class Router
{
    /**
     * Despacha la solicitud al controlador y método correctos.
     * Si no se especifica controlador o acción, usa los valores por defecto.
     */
    public static function dispatch(): void
    {
        // Leer parámetros de la URL (GET)
        $controller = $_GET['controller'] ?? 'justificante';
        $action     = $_GET['action']     ?? 'index';

        // Sanitizar para evitar directory traversal
        $controller = preg_replace('/[^a-zA-Z0-9_]/', '', $controller);
        $action     = preg_replace('/[^a-zA-Z0-9_]/', '', $action);

        // Construir el nombre de la clase del controlador (PascalCase + Controller)
        $controllerClass = ucfirst(strtolower($controller)) . 'Controller';
        $controllerFile  = __DIR__ . '/../controllers/' . $controllerClass . '.php';

        // Verificar que el archivo del controlador exista
        if (!file_exists($controllerFile)) {
            self::notFound("Controlador '$controllerClass' no encontrado.");
            return;
        }

        require_once $controllerFile;

        // Verificar que la clase exista
        if (!class_exists($controllerClass)) {
            self::notFound("Clase '$controllerClass' no definida.");
            return;
        }

        $controllerObj = new $controllerClass();

        // Verificar que el método (acción) exista en el controlador
        if (!method_exists($controllerObj, $action)) {
            self::notFound("Acción '$action' no encontrada en '$controllerClass'.");
            return;
        }

        // Ejecutar el método
        $controllerObj->$action();
    }

    /**
     * Muestra un mensaje de error 404 simple.
     */
    private static function notFound(string $mensaje): void
    {
        http_response_code(404);
        echo '<div style="font-family:sans-serif;padding:2rem;color:#c0392b;">
                <h2>404 – Página no encontrada</h2>
                <p>' . htmlspecialchars($mensaje) . '</p>
                <a href="' . BASE_URL . '">← Volver al inicio</a>
              </div>';
    }
}
