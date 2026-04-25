<?php
// ============================================================
// app/controllers/BaseController.php — Controlador base
// ============================================================

require_once ROOT . '/config/database.php';

abstract class BaseController {

    // Renderizar una vista con layout
    protected function render(string $view, array $data = [], string $layout = 'main'): void {
        // Extraer variables para la vista
        extract($data);

        $viewFile   = ROOT . '/app/views/' . $view . '.php';
        $layoutFile = ROOT . '/app/views/layouts/' . $layout . '.php';

        if (!file_exists($viewFile)) {
            die('Vista no encontrada: ' . $view);
        }

        // Capturar el contenido de la vista
        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        // Renderizar el layout con el contenido
        if (file_exists($layoutFile)) {
            require $layoutFile;
        } else {
            echo $content;
        }
    }

    // Renderizar vista sin layout (para fragmentos/AJAX)
    protected function renderPartial(string $view, array $data = []): void {
        extract($data);
        $viewFile = ROOT . '/app/views/' . $view . '.php';
        if (file_exists($viewFile)) require $viewFile;
    }

    // Redirigir
    protected function redirect(string $path): void {
        header('Location: ' . APP_URL . '/public/' . ltrim($path, '/'));
        exit;
    }

    // Respuesta JSON
    protected function json(array $data, int $code = 200): void {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Verificar sesión activa
    protected function requireAuth(): void {
        if (empty($_SESSION['user'])) {
            $this->redirect('auth');
        }
    }

    // Verificar rol
    protected function requireRole(string ...$roles): void {
        $this->requireAuth();
        if (!in_array($_SESSION['user']['rol'] ?? '', $roles)) {
            $this->redirect('dashboard');
        }
    }

    // Flash messages
    protected function setFlash(string $type, string $msg): void {
        $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
    }

    protected function getFlash(): ?array {
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $flash;
    }

    // Sanitizar entrada
    protected function sanitize(string $val): string {
        return htmlspecialchars(trim($val), ENT_QUOTES, 'UTF-8');
    }

    // Obtener POST
    protected function post(string $key, string $default = ''): string {
        return $this->sanitize($_POST[$key] ?? $default);
    }

    // CSRF token
    protected function csrfToken(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    protected function verifyCsrf(): void {
        $token = $_POST['csrf_token'] ?? '';
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            $this->setFlash('error', 'Token de seguridad inválido. Intenta de nuevo.');
            $this->redirect('auth');
        }
    }
}
