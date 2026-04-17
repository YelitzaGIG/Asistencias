<?php
/**
 * models/Justificante.php
 * Modelo de datos para la entidad "Justificante".
 * Contiene toda la lógica de acceso a la base de datos.
 * Sigue el patrón Active Record simplificado.
 */
class Justificante
{
    /** @var PDO Conexión a la base de datos */
    private PDO $db;

    /** Nombre de la tabla en BD */
    private string $tabla = 'justificantes';

    /** Estados válidos del justificante */
    public const ESTADOS = ['Generado', 'Entregado', 'Validado'];

    /** Motivos válidos */
    public const MOTIVOS = ['Salud', 'Comisión', 'Personal'];

    public function __construct()
    {
        // Obtener conexión desde el Singleton
        $this->db = Database::getInstance()->getConnection();
    }

    // ----------------------------------------------------------------
    // LECTURAS
    // ----------------------------------------------------------------

    /**
     * Obtiene todos los justificantes ordenados por fecha descendente.
     *
     * @return array Lista de justificantes como arrays asociativos
     */
    public function obtenerTodos(): array
    {
        $sql = "SELECT id, folio, nombre_alumno, grupo, numero_control,
                       motivo, fecha, estado, created_at
                FROM {$this->tabla}
                ORDER BY created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Obtiene un justificante por su ID.
     *
     * @param int $id
     * @return array|false
     */
    public function obtenerPorId(int $id): array|false
    {
        $sql  = "SELECT * FROM {$this->tabla} WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // ----------------------------------------------------------------
    // GENERACIÓN DE FOLIO
    // ----------------------------------------------------------------

    /**
     * Genera el siguiente folio único con formato JUS-XXXX.
     * Busca el último ID en la tabla y suma 1.
     *
     * @return string  Ej: "JUS-0006"
     */
    public function generarFolio(): string
    {
        $sql  = "SELECT MAX(id) AS ultimo FROM {$this->tabla}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $row  = $stmt->fetch();

        $siguiente = ($row['ultimo'] ?? 0) + 1;
        return 'JUS-' . str_pad($siguiente, 4, '0', STR_PAD_LEFT);
    }

    // ----------------------------------------------------------------
    // ESCRITURAS
    // ----------------------------------------------------------------

    /**
     * Guarda un nuevo justificante en la base de datos.
     *
     * @param array $datos Datos validados del formulario
     * @return bool true si se insertó correctamente
     * @throws PDOException si ocurre un error de BD
     */
    public function guardar(array $datos): bool
    {
        $sql = "INSERT INTO {$this->tabla}
                    (folio, nombre_alumno, grupo, numero_control, motivo, fecha, estado)
                VALUES
                    (:folio, :nombre_alumno, :grupo, :numero_control, :motivo, :fecha, 'Generado')";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':folio'          => $datos['folio'],
            ':nombre_alumno'  => $datos['nombre_alumno'],
            ':grupo'          => $datos['grupo'],
            ':numero_control' => $datos['numero_control'],
            ':motivo'         => $datos['motivo'],
            ':fecha'          => $datos['fecha'],
        ]);
    }

    /**
     * Actualiza el estado de un justificante existente.
     *
     * @param int    $id     ID del justificante
     * @param string $estado Nuevo estado (debe estar en self::ESTADOS)
     * @return bool
     */
    public function actualizarEstado(int $id, string $estado): bool
    {
        // Validar que el estado sea uno de los permitidos
        if (!in_array($estado, self::ESTADOS, true)) {
            return false;
        }

        $sql  = "UPDATE {$this->tabla} SET estado = :estado WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':estado' => $estado,
            ':id'     => $id,
        ]);
    }

    // ----------------------------------------------------------------
    // VALIDACIONES
    // ----------------------------------------------------------------

    /**
     * Valida los datos del formulario antes de guardar.
     * Retorna un array con los errores encontrados (vacío = sin errores).
     *
     * @param array $datos Datos del $_POST
     * @return array Errores de validación
     */
    public function validar(array $datos): array
    {
        $errores = [];

        if (empty(trim($datos['nombre_alumno'] ?? ''))) {
            $errores[] = 'El nombre del alumno es obligatorio.';
        } elseif (strlen($datos['nombre_alumno']) > 150) {
            $errores[] = 'El nombre no puede superar 150 caracteres.';
        }

        if (empty(trim($datos['grupo'] ?? ''))) {
            $errores[] = 'El grupo es obligatorio.';
        } elseif (strlen($datos['grupo']) > 20) {
            $errores[] = 'El grupo no puede superar 20 caracteres.';
        }

        if (empty(trim($datos['numero_control'] ?? ''))) {
            $errores[] = 'El número de control es obligatorio.';
        } elseif (!preg_match('/^[A-Za-z0-9\-]{4,20}$/', $datos['numero_control'])) {
            $errores[] = 'El número de control debe tener entre 4 y 20 caracteres alfanuméricos.';
        }

        if (empty($datos['motivo']) || !in_array($datos['motivo'], self::MOTIVOS, true)) {
            $errores[] = 'El motivo seleccionado no es válido.';
        }

        return $errores;
    }
}
