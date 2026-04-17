<?php
/**
 * controllers/JustificanteController.php
 * Controlador principal del módulo de Justificantes.
 *
 * Métodos disponibles:
 *   index()        → Lista todos los justificantes
 *   create()       → Muestra el formulario de creación
 *   store()        → Procesa y guarda un nuevo justificante (POST)
 *   updateEstado() → Actualiza el estado de un justificante (POST)
 */

require_once __DIR__ . '/../models/Justificante.php';

class JustificanteController
{
    /** @var Justificante Instancia del modelo */
    private Justificante $modelo;

    public function __construct()
    {
        $this->modelo = new Justificante();
    }

    // ----------------------------------------------------------------
    // index() – Listado de justificantes
    // ----------------------------------------------------------------

    /**
     * Muestra la tabla con todos los justificantes registrados.
     * Ruta: index.php?controller=justificante&action=index
     */
    public function index(): void
    {
        // Obtener todos los registros desde el modelo
        $justificantes = $this->modelo->obtenerTodos();

        // Pasar mensaje de sesión (éxito/error) si existe
        $mensaje = $this->obtenerMensajeSesion();

        // Cargar la vista de listado
        $this->cargarVista('justificantes/index', [
            'justificantes' => $justificantes,
            'mensaje'       => $mensaje,
        ]);
    }

    // ----------------------------------------------------------------
    // create() – Formulario de creación
    // ----------------------------------------------------------------

    /**
     * Muestra el formulario vacío para crear un nuevo justificante.
     * Ruta: index.php?controller=justificante&action=create
     */
    public function create(): void
    {
        // Pre-generar el folio para mostrarlo en el formulario (solo informativo)
        $folioPreview = $this->modelo->generarFolio();
        $fechaHoy     = date('Y-m-d');
        $motivos      = Justificante::MOTIVOS;

        $this->cargarVista('justificantes/formulario', [
            'folioPreview' => $folioPreview,
            'fechaHoy'     => $fechaHoy,
            'motivos'      => $motivos,
            'errores'       => [],
            'datos'         => [],   // Sin datos previos (formulario limpio)
        ]);
    }

    // ----------------------------------------------------------------
    // store() – Guardar justificante (solo POST)
    // ----------------------------------------------------------------

    /**
     * Recibe el POST del formulario, valida y guarda el justificante.
     * Si hay errores, regresa al formulario con los mensajes.
     * Ruta: index.php?controller=justificante&action=store  [POST]
     */
    public function store(): void
    {
        // Solo aceptar peticiones POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('justificante', 'create');
            return;
        }

        // Sanitizar los datos recibidos del formulario
        $datos = [
            'nombre_alumno'  => trim(htmlspecialchars($_POST['nombre_alumno'] ?? '', ENT_QUOTES)),
            'grupo'          => trim(htmlspecialchars($_POST['grupo']          ?? '', ENT_QUOTES)),
            'numero_control' => trim(htmlspecialchars($_POST['numero_control'] ?? '', ENT_QUOTES)),
            'motivo'         => trim($_POST['motivo'] ?? ''),
            'fecha'          => date('Y-m-d'),   // Fecha automática del servidor
        ];

        // Validar con el modelo
        $errores = $this->modelo->validar($datos);

        if (!empty($errores)) {
            // Hay errores: regresar al formulario conservando los datos ingresados
            $folioPreview = $this->modelo->generarFolio();
            $motivos      = Justificante::MOTIVOS;

            $this->cargarVista('justificantes/formulario', [
                'folioPreview' => $folioPreview,
                'fechaHoy'     => $datos['fecha'],
                'motivos'      => $motivos,
                'errores'       => $errores,
                'datos'         => $datos,   // Repoblar el formulario
            ]);
            return;
        }

        // Generar folio único
        $datos['folio'] = $this->modelo->generarFolio();

        try {
            $resultado = $this->modelo->guardar($datos);

            if ($resultado) {
                $this->guardarMensajeSesion('success', "✅ Justificante {$datos['folio']} creado correctamente.");
            } else {
                $this->guardarMensajeSesion('error', '❌ No se pudo guardar el justificante. Inténtalo de nuevo.');
            }
        } catch (PDOException $e) {
            // Error de BD (ej: folio duplicado por condición de carrera)
            $this->guardarMensajeSesion('error', '❌ Error al guardar: ' . htmlspecialchars($e->getMessage()));
        }

        // Redirigir al listado tras guardar
        $this->redirigir('justificante', 'index');
    }

    // ----------------------------------------------------------------
    // updateEstado() – Cambiar estado (solo POST)
    // ----------------------------------------------------------------

    /**
     * Actualiza el estado de un justificante desde la tabla del listado.
     * Ruta: index.php?controller=justificante&action=updateEstado  [POST]
     */
    public function updateEstado(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('justificante', 'index');
            return;
        }

        $id     = filter_input(INPUT_POST, 'id',     FILTER_VALIDATE_INT);
        $estado = trim($_POST['estado'] ?? '');

        // Validar que el ID sea un entero positivo
        if (!$id || $id <= 0) {
            $this->guardarMensajeSesion('error', '❌ ID de justificante inválido.');
            $this->redirigir('justificante', 'index');
            return;
        }

        // Intentar la actualización en el modelo
        $resultado = $this->modelo->actualizarEstado($id, $estado);

        if ($resultado) {
            $this->guardarMensajeSesion('success', "✅ Estado actualizado a <strong>$estado</strong> correctamente.");
        } else {
            $this->guardarMensajeSesion('error', '❌ No se pudo actualizar el estado. Verifica que el estado sea válido.');
        }

        $this->redirigir('justificante', 'index');
    }

    // ----------------------------------------------------------------
    // MÉTODOS AUXILIARES PRIVADOS
    // ----------------------------------------------------------------

    /**
     * Carga un archivo de vista e inyecta las variables.
     *
     * @param string $vista  Ruta relativa dentro de /views (sin .php)
     * @param array  $vars   Variables a extraer en la vista
     */
    private function cargarVista(string $vista, array $vars = []): void
    {
        // extract() convierte las claves del array en variables locales
        extract($vars);

        $rutaVista = __DIR__ . '/../views/' . $vista . '.php';

        if (!file_exists($rutaVista)) {
            die("Vista no encontrada: $rutaVista");
        }

        // Cargar layout: header + contenido + footer
        require __DIR__ . '/../views/layouts/header.php';
        require $rutaVista;
        require __DIR__ . '/../views/layouts/footer.php';
    }

    /**
     * Redirige a un controlador/acción usando la URL base.
     */
    private function redirigir(string $controller, string $action): void
    {
        header("Location: " . BASE_URL . "/index.php?controller={$controller}&action={$action}");
        exit;
    }

    /**
     * Guarda un mensaje en la sesión para mostrarlo tras redirección (Flash message).
     */
    private function guardarMensajeSesion(string $tipo, string $texto): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['mensaje'] = ['tipo' => $tipo, 'texto' => $texto];
    }

    /**
     * Obtiene y elimina el mensaje de sesión (se muestra solo una vez).
     */
    private function obtenerMensajeSesion(): array
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $msg = $_SESSION['mensaje'] ?? [];
        unset($_SESSION['mensaje']);
        return $msg;
    }
}
