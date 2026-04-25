<?php
// ============================================================
// app/models/UserModel.php — Modelo de usuario (sesión)
// NOTA: En este sistema los usuarios se manejan por sesión.
// Para producción, conectar con tabla `users` en BD.
// ============================================================

class UserModel {

    // Usuarios demo (sustituir por consulta a BD en producción)
    private static array $users = [
        [
            'id'         => 1,
            'nombre'     => 'Administrador DGETI',
            'email'      => 'admin@cetis.edu.mx',
            'password'   => '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // "password"
            'rol'        => 'admin',
            'grupo'      => 'N/A',
            'matricula'  => 'ADMIN-001',
        ],
        [
            'id'         => 2,
            'nombre'     => 'Prof. María Sánchez Ruiz',
            'email'      => 'docente@cetis.edu.mx',
            'password'   => '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'rol'        => 'docente',
            'grupo'      => 'N/A',
            'matricula'  => 'DOC-001',
        ],
        [
            'id'         => 3,
            'nombre'     => 'Juan García López',
            'email'      => 'alumno@cetis.edu.mx',
            'password'   => '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'rol'        => 'alumno',
            'grupo'      => '3-B',
            'matricula'  => 'CETIS-0042',
        ],
    ];

    public function findByEmail(string $email): ?array {
        foreach (self::$users as $u) {
            if ($u['email'] === $email) return $u;
        }
        return null;
    }

    public function verifyPassword(string $password, string $hash): bool {
        return password_verify($password, $hash);
    }

    public function findById(int $id): ?array {
        foreach (self::$users as $u) {
            if ($u['id'] === $id) return $u;
        }
        return null;
    }
}
