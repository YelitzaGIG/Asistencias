<?php /* app/views/justificantes/edit.php */ ?>
<div class="page-header">
  <div>
    <h1 class="page-title">Editar Justificante</h1>
    <p class="page-subtitle">Folio: <strong><?= htmlspecialchars($j['folio']) ?></strong></p>
  </div>
  <a href="<?= APP_URL ?>/public/justificantes/show/<?= $j['id'] ?>" class="btn-outline">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
    Cancelar
  </a>
</div>

<div class="form-layout">
  <div class="section-card form-card">
    <form method="POST" action="<?= APP_URL ?>/public/justificantes/update/<?= $j['id'] ?>" class="create-form">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

      <div class="form-section">
        <h3 class="form-section-title">
          <span class="form-section-num">1</span>
          Datos del alumno
        </h3>
        <div class="field-row">
          <div class="field-group">
            <label class="field-label">Nombre completo <span class="required">*</span></label>
            <input type="text" name="nombre_alumno" class="field" value="<?= htmlspecialchars($j['nombre_alumno']) ?>" required>
          </div>
          <div class="field-group">
            <label class="field-label">Número de control <span class="required">*</span></label>
            <input type="text" name="numero_control" class="field" value="<?= htmlspecialchars($j['numero_control']) ?>" required>
          </div>
        </div>
        <div class="field-group">
          <label class="field-label">Grupo <span class="required">*</span></label>
          <input type="text" name="grupo" class="field" value="<?= htmlspecialchars($j['grupo']) ?>" required>
        </div>
      </div>

      <div class="form-section">
        <h3 class="form-section-title">
          <span class="form-section-num">2</span>
          Detalles y estado
        </h3>
        <div class="field-row">
          <div class="field-group">
            <label class="field-label">Motivo <span class="required">*</span></label>
            <select name="motivo" class="field field-select" required>
              <?php foreach (MOTIVOS as $m): ?>
              <option value="<?= $m ?>" <?= $j['motivo'] === $m ? 'selected' : '' ?>><?= $m ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="field-group">
            <label class="field-label">Estado <span class="required">*</span></label>
            <select name="estado" class="field field-select" required>
              <?php foreach (ESTADOS as $e): ?>
              <option value="<?= $e ?>" <?= $j['estado'] === $e ? 'selected' : '' ?>><?= $e ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="field-group">
          <label class="field-label">Fecha de ausencia <span class="required">*</span></label>
          <input type="date" name="fecha" class="field" value="<?= $j['fecha'] ?>" required>
        </div>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn-primary btn-lg">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
          Guardar cambios
        </button>
        <a href="<?= APP_URL ?>/public/justificantes" class="btn-ghost">Cancelar</a>
      </div>
    </form>
  </div>

  <div class="form-sidebar">
    <div class="section-card">
      <h3 class="section-title">Datos actuales</h3>
      <div class="current-data">
        <div class="detail-item">
          <span class="detail-key">Folio</span>
          <span class="folio-tag"><?= htmlspecialchars($j['folio']) ?></span>
        </div>
        <div class="detail-item">
          <span class="detail-key">Estado actual</span>
          <span class="badge-estado badge-<?= strtolower($j['estado']) ?>"><?= $j['estado'] ?></span>
        </div>
        <div class="detail-item">
          <span class="detail-key">Creado</span>
          <span><?= date('d/m/Y', strtotime($j['created_at'])) ?></span>
        </div>
      </div>
    </div>
  </div>
</div>
