<?php
// ============================================================
// app/controllers/DashboardController.php
// ============================================================

require_once ROOT . '/app/controllers/BaseController.php';
require_once ROOT . '/app/models/JustificanteModel.php';

class DashboardController extends BaseController {

    private JustificanteModel $model;

    public function __construct() {
        $this->model = new JustificanteModel();
    }

    // GET /dashboard
    public function index(?string $p = null): void {
        $this->requireAuth();

        $user  = $_SESSION['user'];
        $flash = $this->getFlash();

        // Filtrar por número de control si es alumno
        $filters = [];
        if ($user['rol'] === 'alumno') {
            $filters['numero_control'] = $user['matricula'];
        }

        $stats          = $this->model->getStats();
        $recientes      = array_slice($this->model->getAll($filters), 0, 5);

        $this->render('dashboard/index', compact('user', 'flash', 'stats', 'recientes'), 'main');
    }

    // GET /dashboard/perfil
    public function perfil(?string $p = null): void {
        $this->requireAuth();
        $user  = $_SESSION['user'];
        $flash = $this->getFlash();
        $csrf  = $this->csrfToken();
        $this->render('dashboard/perfil', compact('user', 'flash', 'csrf'), 'main');
    }
}
