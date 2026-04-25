-- ============================================================
-- SISTEMA DE JUSTIFICANTES DE ALUMNOS — DGETI
-- database/justificantes_db.sql
-- Compatible con MySQL 5.7+ / MariaDB
-- ============================================================

CREATE DATABASE IF NOT EXISTS justificantes_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE justificantes_db;

-- ============================================================
-- TABLA: justificantes
-- ============================================================
CREATE TABLE IF NOT EXISTS justificantes (
    id              INT(11)         NOT NULL AUTO_INCREMENT,
    folio           VARCHAR(10)     NOT NULL UNIQUE,
    nombre_alumno   VARCHAR(150)    NOT NULL,
    grupo           VARCHAR(20)     NOT NULL,
    numero_control  VARCHAR(20)     NOT NULL,
    motivo          ENUM('Salud','Comisión','Personal') NOT NULL,
    fecha           DATE            NOT NULL,
    estado          ENUM('Generado','Entregado','Validado') NOT NULL DEFAULT 'Generado',
    created_at      TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP       DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY uq_folio (folio),
    KEY idx_numero_control (numero_control),
    KEY idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Tabla principal de justificantes de alumnos';

-- ============================================================
-- DATOS DE EJEMPLO
-- ============================================================
INSERT INTO justificantes (folio, nombre_alumno, grupo, numero_control, motivo, fecha, estado) VALUES
('JUS-0001', 'García López Ana Sofía',      'ISC-401', '21410001', 'Salud',     '2024-03-01', 'Validado'),
('JUS-0002', 'Martínez Pérez Luis Alberto', 'ISC-402', '21410002', 'Comisión',  '2024-03-05', 'Entregado'),
('JUS-0003', 'Hernández Torres María José', 'IIA-301', '21410003', 'Personal',  '2024-03-10', 'Generado'),
('JUS-0004', 'Rodríguez Sánchez Carlos',    'IIA-302', '21410004', 'Salud',     '2024-03-12', 'Generado'),
('JUS-0005', 'López Ramírez Fernanda',      'ISC-403', '21410005', 'Comisión',  '2024-03-15', 'Entregado');
