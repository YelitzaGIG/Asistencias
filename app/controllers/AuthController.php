<?php
// ============================================================
// app/controllers/AuthController.php
// ============================================================

require_once ROOT . '/app/controllers/BaseController.php';
require_once ROOT . '/app/models/UserModel.php';

class AuthController extends BaseController {

    private UserModel $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    // GET /auth — Pantalla de bienvenida/login
    public function index(?string $p = null): void {
        if (!empty($_SESSION['user'])) {
            $this->redirect('dashboard');
        }
        $flash = $this->getFlash();
        $csrf  = $this->csrfToken();
        $this->render('auth/welcome', compact('flash', 'csrf'), 'auth');
    }

    // GET /auth/login
    public function login(?string $p = null): void {
        if (!empty($_SESSION['user'])) $this->redirect('dashboard');
        $flash = $this->getFlash();
        $csrf  = $this->csrfToken();
        $this->render('auth/login', compact('flash', 'csrf'), 'auth');
    }

    // POST /auth/login
    public function loginpost(?string $p = null): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('auth/login');
        }

        $this->verifyCsrf();

        $email    = filter_var($this->post('email'), FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';
        $rol      = $this->post('rol');

        if (empty($email) || empty($password)) {
            $this->setFlash('error', 'Por favor completa todos los campos.');
            $this->redirect('auth/login');
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user || !$this->userModel->verifyPassword($password, $user['password'])) {
            $this->setFlash('error', 'Correo o contraseña incorrectos.');
            $this->redirect('auth/login');
        }

        // Iniciar sesión
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id'        => $user['id'],
            'nombre'    => $user['nombre'],
            'email'     => $user['email'],
            'rol'       => $user['rol'],
            'grupo'     => $user['grupo'],
            'matricula' => $user['matricula'],
        ];

        $this->setFlash('success', '¡Bienvenido, ' . $user['nombre'] . '!');
        $this->redirect('dashboard');
    }

    // GET /auth/logout
    public function logout(?string $p = null): void {
        $_SESSION = [];
        session_destroy();
        $this->redirect('auth/login');
    }

    // GET /auth/register
    public function register(?string $p = null): void {
        $flash = $this->getFlash();
        $csrf  = $this->csrfToken();
        $this->render('auth/register', compact('flash', 'csrf'), 'auth');
    }

    // POST /auth/register (registro básico demo)
    public function registerpost(?string $p = null): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('auth/register');
        $this->verifyCsrf();
        // En producción: insertar en BD
        $this->setFlash('success', '¡Cuenta creada exitosamente! Ya puedes iniciar sesión.');
        $this->redirect('auth/login');
    }

    // GET /auth/forgotpassword
    public function forgotpassword(?string $p = null): void {
        $flash = $this->getFlash();
        $csrf  = $this->csrfToken();
        $this->render('auth/forgot', compact('flash', 'csrf'), 'auth');
    }

    // GET /auth/resetpassword
    public function resetpassword(?string $p = null): void {
        $flash = $this->getFlash();
        $csrf  = $this->csrfToken();
        $this->render('auth/reset', compact('flash', 'csrf'), 'auth');
    }

    // POST /auth/resetpost
    public function resetpost(?string $p = null): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('auth/resetpassword');
        $this->verifyCsrf();
        $this->setFlash('success', 'Contraseña actualizada correctamente.');
        $this->redirect('auth/login');
    }
}
