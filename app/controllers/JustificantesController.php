<?php
// ============================================================
// app/controllers/JustificantesController.php
// ============================================================

require_once ROOT . '/app/controllers/BaseController.php';
require_once ROOT . '/app/models/JustificanteModel.php';

class JustificantesController extends BaseController {

    private JustificanteModel $model;

    public function __construct() {
        $this->model = new JustificanteModel();
    }

    // GET /justificantes — Listar todos
    public function index(?string $p = null): void {
        $this->requireAuth();

        $user    = $_SESSION['user'];
        $flash   = $this->getFlash();
        $csrf    = $this->csrfToken();

        $filters = [];
        // Alumno solo ve los suyos
        if ($user['rol'] === 'alumno') {
            $filters['numero_control'] = $user['matricula'];
        }
        // Filtros de búsqueda
        if (!empty($_GET['estado']))  $filters['estado']  = $_GET['estado'];
        if (!empty($_GET['motivo']))  $filters['motivo']  = $_GET['motivo'];
        if (!empty($_GET['search']))  $filters['search']  = $_GET['search'];

        $justificantes = $this->model->getAll($filters);
        $stats         = $this->model->getStats();

        $this->render('justificantes/index',
            compact('user', 'flash', 'csrf', 'justificantes', 'stats', 'filters'),
            'main'
        );
    }

    // GET /justificantes/create
    public function create(?string $p = null): void {
        $this->requireAuth();
        $user  = $_SESSION['user'];
        $flash = $this->getFlash();
        $csrf  = $this->csrfToken();
        $this->render('justificantes/create', compact('user', 'flash', 'csrf'), 'main');
    }

    // POST /justificantes/store
    public function store(?string $p = null): void {
        $this->requireAuth();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('justificantes/create');
        $this->verifyCsrf();

        $data = [
            'nombre_alumno'  => $this->post('nombre_alumno'),
            'grupo'          => $this->post('grupo'),
            'numero_control' => $this->post('numero_control'),
            'motivo'         => $this->post('motivo'),
            'fecha'          => $this->post('fecha'),
        ];

        // Validaciones
        $errors = [];
        if (empty($data['nombre_alumno']))  $errors[] = 'El nombre del alumno es obligatorio.';
        if (empty($data['grupo']))          $errors[] = 'El grupo es obligatorio.';
        if (empty($data['numero_control'])) $errors[] = 'El número de control es obligatorio.';
        if (!in_array($data['motivo'], MOTIVOS)) $errors[] = 'Motivo no válido.';
        if (empty($data['fecha']))          $errors[] = 'La fecha es obligatoria.';

        if ($errors) {
            $this->setFlash('error', implode('<br>', $errors));
            $this->redirect('justificantes/create');
        }

        $folio = $this->model->create($data);

        if ($folio) {
            $this->setFlash('success', "Justificante <strong>{$folio}</strong> creado correctamente.");
        } else {
            $this->setFlash('error', 'Error al crear el justificante. Intenta de nuevo.');
        }

        $this->redirect('justificantes');
    }

    // GET /justificantes/show/{id}
    public function show(?string $id = null): void {
        $this->requireAuth();
        $j = $this->model->getById((int) $id);
        if (!$j) { $this->setFlash('error', 'Justificante no encontrado.'); $this->redirect('justificantes'); }

        $user  = $_SESSION['user'];
        $flash = $this->getFlash();
        $csrf  = $this->csrfToken();
        $this->render('justificantes/show', compact('user', 'flash', 'csrf', 'j'), 'main');
    }

    // GET /justificantes/edit/{id}
    public function edit(?string $id = null): void {
        $this->requireRole('admin', 'docente');
        $j = $this->model->getById((int) $id);
        if (!$j) { $this->setFlash('error', 'Justificante no encontrado.'); $this->redirect('justificantes'); }

        $user  = $_SESSION['user'];
        $flash = $this->getFlash();
        $csrf  = $this->csrfToken();
        $this->render('justificantes/edit', compact('user', 'flash', 'csrf', 'j'), 'main');
    }

    // POST /justificantes/update/{id}
    public function update(?string $id = null): void {
        $this->requireRole('admin', 'docente');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('justificantes');
        $this->verifyCsrf();

        $data = [
            'nombre_alumno'  => $this->post('nombre_alumno'),
            'grupo'          => $this->post('grupo'),
            'numero_control' => $this->post('numero_control'),
            'motivo'         => $this->post('motivo'),
            'fecha'          => $this->post('fecha'),
            'estado'         => $this->post('estado'),
        ];

        if ($this->model->update((int) $id, $data)) {
            $this->setFlash('success', 'Justificante actualizado correctamente.');
        } else {
            $this->setFlash('error', 'Error al actualizar el justificante.');
        }
        $this->redirect('justificantes');
    }

    // POST /justificantes/delete/{id}
    public function delete(?string $id = null): void {
        $this->requireRole('admin');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('justificantes');
        $this->verifyCsrf();

        if ($this->model->delete((int) $id)) {
            $this->setFlash('success', 'Justificante eliminado correctamente.');
        } else {
            $this->setFlash('error', 'Error al eliminar el justificante.');
        }
        $this->redirect('justificantes');
    }
}
