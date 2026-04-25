<?php /* app/views/justificantes/create.php */ ?>
<div class="page-header">
  <div>
    <h1 class="page-title">Nuevo Justificante</h1>
    <p class="page-subtitle">Registra un nuevo justificante de ausencia</p>
  </div>
  <a href="<?= APP_URL ?>/public/justificantes" class="btn-outline">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
    Regresar
  </a>
</div>

<div class="form-layout">
  <div class="section-card form-card">
    <form method="POST" action="<?= APP_URL ?>/public/justificantes/store" class="create-form" id="createForm">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

      <div class="form-section">
        <h3 class="form-section-title">
          <span class="form-section-num">1</span>
          Datos del alumno
        </h3>
        <div class="field-row">
          <div class="field-group">
            <label class="field-label" for="nombre_alumno">Nombre completo <span class="required">*</span></label>
            <input type="text" id="nombre_alumno" name="nombre_alumno" class="field"
                   placeholder="Apellido Apellido Nombre(s)"
                   value="<?= $user['rol'] === 'alumno' ? htmlspecialchars($user['nombre']) : '' ?>"
                   <?= $user['rol'] === 'alumno' ? 'readonly' : '' ?> required>
          </div>
          <div class="field-group">
            <label class="field-label" for="numero_control">Número de control <span class="required">*</span></label>
            <input type="text" id="numero_control" name="numero_control" class="field"
                   placeholder="21410000"
                   value="<?= $user['rol'] === 'alumno' ? htmlspecialchars($user['matricula']) : '' ?>"
                   <?= $user['rol'] === 'alumno' ? 'readonly' : '' ?> required>
          </div>
        </div>
        <div class="field-group">
          <label class="field-label" for="grupo">Grupo <span class="required">*</span></label>
          <input type="text" id="grupo" name="grupo" class="field"
                 placeholder="Ej: ISC-401, IIA-302"
                 value="<?= $user['rol'] === 'alumno' ? htmlspecialchars($user['grupo']) : '' ?>"
                 <?= $user['rol'] === 'alumno' ? 'readonly' : '' ?> required>
        </div>
      </div>

      <div class="form-section">
        <h3 class="form-section-title">
          <span class="form-section-num">2</span>
          Detalles del justificante
        </h3>
        <div class="field-row">
          <div class="field-group">
            <label class="field-label" for="motivo">Motivo <span class="required">*</span></label>
            <div class="motivo-options">
              <?php foreach (MOTIVOS as $m): ?>
              <label class="motivo-option">
                <input type="radio" name="motivo" value="<?= $m ?>" required>
                <span class="motivo-card">
                  <?php
                    $icons = ['Salud' => '🏥', 'Comisión' => '📋', 'Personal' => '👤'];
                    $desc  = ['Salud' => 'Cita médica o enfermedad', 'Comisión' => 'Representación institucional', 'Personal' => 'Asunto personal o familiar'];
                  ?>
                  <span class="motivo-emoji"><?= $icons[$m] ?></span>
                  <span class="motivo-name"><?= $m ?></span>
                  <span class="motivo-desc"><?= $desc[$m] ?></span>
                </span>
              </label>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <div class="field-group">
          <label class="field-label" for="fecha">Fecha de ausencia <span class="required">*</span></label>
          <input type="date" id="fecha" name="fecha" class="field"
                 value="<?= date('Y-m-d') ?>"
                 max="<?= date('Y-m-d') ?>" required>
        </div>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn-primary btn-lg" id="submitBtn">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
          Registrar Justificante
        </button>
        <a href="<?= APP_URL ?>/public/justificantes" class="btn-ghost">Cancelar</a>
      </div>
    </form>
  </div>

  <div class="form-sidebar">
    <div class="section-card help-card">
      <h3 class="help-title">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        Información
      </h3>
      <ul class="help-list">
        <li>El folio se generará automáticamente.</li>
        <li>El estado inicial será <strong>Generado</strong>.</li>
        <li>Solo docentes y administradores pueden cambiar el estado.</li>
        <li>La fecha no puede ser futura.</li>
      </ul>
    </div>

    <div class="section-card estados-card">
      <h3 class="help-title">Flujo de estados</h3>
      <div class="estado-flow">
        <div class="estado-step">
          <span class="badge-estado badge-generado">Generado</span>
          <span class="flow-arrow">→</span>
          <span class="badge-estado badge-entregado">Entregado</span>
          <span class="flow-arrow">→</span>
          <span class="badge-estado badge-validado">Validado</span>
        </div>
      </div>
    </div>
  </div>
</div>
