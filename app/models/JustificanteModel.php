<?php
// ============================================================
// app/models/JustificanteModel.php — Modelo de justificantes
// ============================================================

class JustificanteModel {

    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // ── Listar todos (con filtros opcionales) ──
    public function getAll(array $filters = []): array {
        $sql    = 'SELECT * FROM justificantes WHERE 1=1';
        $params = [];

        if (!empty($filters['estado'])) {
            $sql .= ' AND estado = :estado';
            $params[':estado'] = $filters['estado'];
        }
        if (!empty($filters['motivo'])) {
            $sql .= ' AND motivo = :motivo';
            $params[':motivo'] = $filters['motivo'];
        }
        if (!empty($filters['search'])) {
            $sql .= ' AND (nombre_alumno LIKE :s OR numero_control LIKE :s2 OR folio LIKE :s3)';
            $like = '%' . $filters['search'] . '%';
            $params[':s']  = $like;
            $params[':s2'] = $like;
            $params[':s3'] = $like;
        }
        if (!empty($filters['numero_control'])) {
            $sql .= ' AND numero_control = :nc';
            $params[':nc'] = $filters['numero_control'];
        }

        $sql .= ' ORDER BY created_at DESC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // ── Obtener uno por ID ──
    public function getById(int $id): ?array {
        $stmt = $this->db->prepare('SELECT * FROM justificantes WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() ?: null;
    }

    // ── Obtener por folio ──
    public function getByFolio(string $folio): ?array {
        $stmt = $this->db->prepare('SELECT * FROM justificantes WHERE folio = :folio');
        $stmt->execute([':folio' => $folio]);
        return $stmt->fetch() ?: null;
    }

    // ── Crear nuevo justificante ──
    public function create(array $data): bool|string {
        $folio = $this->generateFolio();

        $sql = 'INSERT INTO justificantes 
                    (folio, nombre_alumno, grupo, numero_control, motivo, fecha, estado)
                VALUES
                    (:folio, :nombre, :grupo, :nc, :motivo, :fecha, :estado)';

        $stmt = $this->db->prepare($sql);
        $ok   = $stmt->execute([
            ':folio'  => $folio,
            ':nombre' => $data['nombre_alumno'],
            ':grupo'  => $data['grupo'],
            ':nc'     => $data['numero_control'],
            ':motivo' => $data['motivo'],
            ':fecha'  => $data['fecha'],
            ':estado' => 'Generado',
        ]);

        return $ok ? $folio : false;
    }

    // ── Actualizar estado ──
    public function updateEstado(int $id, string $estado): bool {
        if (!in_array($estado, ESTADOS)) return false;
        $stmt = $this->db->prepare('UPDATE justificantes SET estado = :estado WHERE id = :id');
        return $stmt->execute([':estado' => $estado, ':id' => $id]);
    }

    // ── Actualizar registro completo ──
    public function update(int $id, array $data): bool {
        $sql = 'UPDATE justificantes SET
                    nombre_alumno  = :nombre,
                    grupo          = :grupo,
                    numero_control = :nc,
                    motivo         = :motivo,
                    fecha          = :fecha,
                    estado         = :estado
                WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre' => $data['nombre_alumno'],
            ':grupo'  => $data['grupo'],
            ':nc'     => $data['numero_control'],
            ':motivo' => $data['motivo'],
            ':fecha'  => $data['fecha'],
            ':estado' => $data['estado'],
            ':id'     => $id,
        ]);
    }

    // ── Eliminar ──
    public function delete(int $id): bool {
        $stmt = $this->db->prepare('DELETE FROM justificantes WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }

    // ── Estadísticas para dashboard ──
    public function getStats(): array {
        $stats = [];
        $estados = ['Generado', 'Entregado', 'Validado'];
        foreach ($estados as $e) {
            $stmt = $this->db->prepare('SELECT COUNT(*) FROM justificantes WHERE estado = :e');
            $stmt->execute([':e' => $e]);
            $stats[$e] = (int) $stmt->fetchColumn();
        }
        $stmt = $this->db->query('SELECT COUNT(*) FROM justificantes');
        $stats['total'] = (int) $stmt->fetchColumn();
        return $stats;
    }

    // ── Generar folio correlativo ──
    private function generateFolio(): string {
        $stmt = $this->db->query("SELECT folio FROM justificantes ORDER BY id DESC LIMIT 1");
        $last = $stmt->fetchColumn();
        if ($last && preg_match('/JUS-(\d+)/', $last, $m)) {
            $next = (int) $m[1] + 1;
        } else {
            $next = 1;
        }
        return 'JUS-' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }
}
