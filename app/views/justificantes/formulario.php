<?php
/**
 * views/justificantes/formulario.php
 * Vista del formulario para crear un nuevo justificante.
 *
 * Variables disponibles (inyectadas por el controlador):
 *   $folioPreview → Folio pre-generado para vista previa, ej: JUS-0006
 *   $fechaHoy     → Fecha actual en formato Y-m-d
 *   $motivos      → Array con los motivos válidos
 *   $errores      → Array de mensajes de error de validación
 *   $datos        → Array con los datos previos del POST (para repoblar)
 *
 * Función auxiliar para repoblar campos tras un error
 */
$val = fn(string $campo) => htmlspecialchars($datos[$campo] ?? '');
?>

<!-- ── Encabezado de página ──────────────────────────────── -->
<div class="page-header">
  <div>
    <h1 class="page-header__title">Nuevo Justificante</h1>
    <p class="page-header__subtitle">
      Completa el formulario. El folio y la fecha se generan automáticamente.
    </p>
  </div>
  <a href="<?= BASE_URL ?>/?controller=justificante&action=index" class="btn btn-outline">
    ← Volver al listado
  </a>
</div>

<!-- ── Errores de validación ─────────────────────────────── -->
<?php if (!empty($errores)): ?>
  <div class="alert alert-error" data-autohide>
    <div>
      <strong>Por favor corrige los siguientes campos:</strong>
      <ul class="alert-list">
        <?php foreach ($errores as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
<?php endif; ?>

<!-- ── Formulario principal ───────────────────────────────── -->
<div class="card">

  <form
    action="<?= BASE_URL ?>/index.php?controller=justificante&action=store"
    method="POST"
    class="js-form-validar"
    novalidate>

    <div class="form-grid">

      <!-- Folio (solo lectura, generado automáticamente) -->
      <div class="form-group">
        <label class="form-label">Folio Asignado</label>
        <span class="folio-preview"><?= htmlspecialchars($folioPreview) ?></span>
        <small style="color:var(--text-muted);font-size:.78rem;margin-top:.25rem;">
          Se asignará automáticamente al guardar.
        </small>
      </div>

      <!-- Fecha (generada por el servidor, solo informativa) -->
      <div class="form-group">
        <label class="form-label">Fecha de Expedición</label>
        <input
          type="text"
          class="form-control"
          value="<?= date('d/m/Y') ?>"
          readonly
          title="La fecha se asigna automáticamente" />
        <small style="color:var(--text-muted);font-size:.78rem;margin-top:.25rem;">
          Se registra la fecha del día de hoy.
        </small>
      </div>

      <!-- Nombre del alumno -->
      <div class="form-group form-group--full">
        <label for="nombre_alumno" class="form-label">
          Nombre Completo del Alumno <span class="required">*</span>
        </label>
        <input
          type="text"
          id="nombre_alumno"
          name="nombre_alumno"
          class="form-control <?= (!empty($errores) && empty($datos['nombre_alumno'])) ? 'is-invalid' : '' ?>"
          placeholder="Ej: García López Ana Sofía"
          maxlength="150"
          required
          value="<?= $val('nombre_alumno') ?>" />
      </div>

      <!-- Grupo -->
      <div class="form-group">
        <label for="grupo" class="form-label">
          Grupo <span class="required">*</span>
        </label>
        <input
          type="text"
          id="grupo"
          name="grupo"
          class="form-control <?= (!empty($errores) && empty($datos['grupo'])) ? 'is-invalid' : '' ?>"
          placeholder="Ej: ISC-401, 3A"
          maxlength="20"
          required
          value="<?= $val('grupo') ?>" />
      </div>

      <!-- Número de control -->
      <div class="form-group">
        <label for="numero_control" class="form-label">
          Número de Control <span class="required">*</span>
        </label>
        <input
          type="text"
          id="numero_control"
          name="numero_control"
          class="form-control <?= (!empty($errores) && empty($datos['numero_control'])) ? 'is-invalid' : '' ?>"
          placeholder="Ej: 21410001"
          maxlength="20"
          required
          value="<?= $val('numero_control') ?>" />
      </div>

      <!-- Motivo -->
      <div class="form-group">
        <label for="motivo" class="form-label">
          Motivo <span class="required">*</span>
        </label>
        <select
          id="motivo"
          name="motivo"
          class="form-control <?= (!empty($errores) && empty($datos['motivo'])) ? 'is-invalid' : '' ?>"
          required>
          <option value="" disabled <?= empty($datos['motivo']) ? 'selected' : '' ?>>
            — Selecciona un motivo —
          </option>
          <?php foreach ($motivos as $m): ?>
            <option value="<?= $m ?>" <?= ($datos['motivo'] ?? '') === $m ? 'selected' : '' ?>>
              <?= $m ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

    </div><!-- /.form-grid -->

    <!-- Pie del formulario -->
    <div class="form-footer">
      <a href="<?= BASE_URL ?>/?controller=justificante&action=index" class="btn btn-outline">
        Cancelar
      </a>
      <button type="submit" class="btn btn-primary">
        Generar Justificante
      </button>
    </div>

  </form>
</div><!-- /.card -->
