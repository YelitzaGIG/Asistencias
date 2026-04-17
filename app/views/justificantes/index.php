<?php
/**
 * views/justificantes/index.php
 * Vista del listado de todos los justificantes.
 * Variables disponibles (inyectadas por el controlador):
 *   $justificantes → array de registros
 *   $mensaje       → array ['tipo' => 'success|error', 'texto' => '...']
 */

// ── Calcular estadísticas ────────────────────────────────
$total     = count($justificantes);
$generados  = count(array_filter($justificantes, fn($j) => $j['estado'] === 'Generado'));
$entregados = count(array_filter($justificantes, fn($j) => $j['estado'] === 'Entregado'));
$validados  = count(array_filter($justificantes, fn($j) => $j['estado'] === 'Validado'));

// URL para actualizar estado
$urlUpdateEstado = BASE_URL . '/index.php?controller=justificante&action=updateEstado';
?>

<!-- ── Encabezado de página ──────────────────────────────── -->
<div class="page-header">
  <div>
    <h1 class="page-header__title">Justificantes de Alumnos</h1>
    <p class="page-header__subtitle">Gestión y seguimiento de solicitudes</p>
  </div>
  <a href="<?= BASE_URL ?>/?controller=justificante&action=create" class="btn btn-accent">
    ＋ Nuevo Justificante
  </a>
</div>

<!-- ── Mensaje Flash (éxito / error) ─────────────────────── -->
<?php if (!empty($mensaje)): ?>
  <div class="alert alert-<?= htmlspecialchars($mensaje['tipo']) ?>" data-autohide>
    <?= $mensaje['texto'] ?>
  </div>
<?php endif; ?>

<!-- ── Tarjetas de estadísticas ──────────────────────────── -->
<div class="stats-row">
  <div class="stat-card">
    <span class="stat-card__label">Total</span>
    <span class="stat-card__value"><?= $total ?></span>
  </div>
  <div class="stat-card stat-card--generado">
    <span class="stat-card__label">Generados</span>
    <span class="stat-card__value"><?= $generados ?></span>
  </div>
  <div class="stat-card stat-card--entregado">
    <span class="stat-card__label">Entregados</span>
    <span class="stat-card__value"><?= $entregados ?></span>
  </div>
  <div class="stat-card stat-card--validado">
    <span class="stat-card__label">Validados</span>
    <span class="stat-card__value"><?= $validados ?></span>
  </div>
</div>

<!-- ── Tabla de Justificantes ────────────────────────────── -->
<div class="card" style="padding: 0; overflow: hidden;">
  <div class="table-wrapper">
    <table class="table">
      <thead>
        <tr>
          <th>Folio</th>
          <th>Alumno</th>
          <th>Grupo</th>
          <th>N° Control</th>
          <th>Motivo</th>
          <th>Fecha</th>
          <th>Estado</th>
          <th>Cambiar Estado</th>
        </tr>
      </thead>
      <tbody>

        <?php if (empty($justificantes)): ?>
          <!-- Sin registros -->
          <tr class="empty-row">
            <td colspan="8">
              <div style="display:flex;flex-direction:column;align-items:center;gap:.75rem;padding:2.5rem;">
                <span style="font-size:2.5rem;">📂</span>
                <p>No hay justificantes registrados aún.</p>
                <a href="<?= BASE_URL ?>/?controller=justificante&action=create" class="btn btn-primary btn-sm">
                  Crear el primero
                </a>
              </div>
            </td>
          </tr>

        <?php else: ?>
          <?php foreach ($justificantes as $j): ?>
            <?php
              // Clase CSS para el badge de estado
              $estadoSlug = strtolower($j['estado']);
              // Formatear fecha para mostrar
              $fechaFormato = date('d/m/Y', strtotime($j['fecha']));
            ?>
            <tr>
              <!-- Folio -->
              <td>
                <span class="folio-cell"><?= htmlspecialchars($j['folio']) ?></span>
              </td>

              <!-- Nombre del alumno -->
              <td>
                <span style="font-weight:500;"><?= htmlspecialchars($j['nombre_alumno']) ?></span>
              </td>

              <!-- Grupo -->
              <td><?= htmlspecialchars($j['grupo']) ?></td>

              <!-- Número de control -->
              <td style="font-family:monospace;font-size:.85rem;">
                <?= htmlspecialchars($j['numero_control']) ?>
              </td>

              <!-- Motivo -->
              <td><?= htmlspecialchars($j['motivo']) ?></td>

              <!-- Fecha -->
              <td style="white-space:nowrap;"><?= $fechaFormato ?></td>

              <!-- Badge de estado actual -->
              <td>
                <span class="badge badge-<?= $estadoSlug ?>">
                  <?= htmlspecialchars($j['estado']) ?>
                </span>
              </td>

              <!-- Select para cambiar estado -->
              <td>
                <select
                  class="estado-select"
                  data-id="<?= (int)$j['id'] ?>"
                  data-action="<?= $urlUpdateEstado ?>">
                  <?php foreach (\Justificante::ESTADOS as $est): ?>
                    <option value="<?= $est ?>" <?= $j['estado'] === $est ? 'selected' : '' ?>>
                      <?= $est ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>

      </tbody>
    </table>
  </div><!-- /.table-wrapper -->
</div><!-- /.card -->
