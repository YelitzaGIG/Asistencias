<?php /* app/views/justificantes/index.php */ ?>
<div class="page-header">
  <div>
    <h1 class="page-title">Justificantes</h1>
    <p class="page-subtitle">Gestión y seguimiento de justificantes de alumnos</p>
  </div>
  <a href="<?= APP_URL ?>/public/justificantes/create" class="btn-primary">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Nuevo
  </a>
</div>

<!-- Filtros -->
<div class="section-card filters-card">
  <form method="GET" action="<?= APP_URL ?>/public/justificantes" class="filters-form" id="filterForm">
    <div class="filter-group">
      <label class="field-label">Buscar</label>
      <div class="field-wrap">
        <svg class="field-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" name="search" class="field" placeholder="Nombre, folio, n° control…" value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
      </div>
    </div>
    <div class="filter-group">
      <label class="field-label">Estado</label>
      <select name="estado" class="field field-select" onchange="this.form.submit()">
        <option value="">Todos</option>
        <?php foreach (ESTADOS as $e): ?>
        <option value="<?= $e ?>" <?= ($filters['estado'] ?? '') === $e ? 'selected' : '' ?>><?= $e ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="filter-group">
      <label class="field-label">Motivo</label>
      <select name="motivo" class="field field-select" onchange="this.form.submit()">
        <option value="">Todos</option>
        <?php foreach (MOTIVOS as $m): ?>
        <option value="<?= $m ?>" <?= ($filters['motivo'] ?? '') === $m ? 'selected' : '' ?>><?= $m ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="filter-actions">
      <button type="submit" class="btn-primary">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        Buscar
      </button>
      <a href="<?= APP_URL ?>/public/justificantes" class="btn-outline">Limpiar</a>
    </div>
  </form>
</div>

<!-- Tabla -->
<div class="section-card">
  <div class="table-meta">
    <span class="table-count"><?= count($justificantes) ?> registro(s) encontrado(s)</span>
  </div>

  <?php if (empty($justificantes)): ?>
  <div class="empty-state">
    <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
    <p>No se encontraron justificantes con los filtros aplicados.</p>
    <a href="<?= APP_URL ?>/public/justificantes" class="btn-outline">Ver todos</a>
  </div>
  <?php else: ?>
  <div class="table-responsive">
    <table class="data-table">
      <thead>
        <tr>
          <th>Folio</th>
          <th>Alumno</th>
          <th>N° Control</th>
          <th>Grupo</th>
          <th>Motivo</th>
          <th>Fecha</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($justificantes as $j): ?>
        <tr>
          <td><span class="folio-tag"><?= htmlspecialchars($j['folio']) ?></span></td>
          <td class="td-name"><?= htmlspecialchars($j['nombre_alumno']) ?></td>
          <td><code class="code-tag"><?= htmlspecialchars($j['numero_control']) ?></code></td>
          <td><span class="grupo-tag"><?= htmlspecialchars($j['grupo']) ?></span></td>
          <td>
            <span class="motivo-tag motivo-<?= strtolower($j['motivo']) ?>">
              <?php
                $iconos = ['Salud' => '🏥', 'Comisión' => '📋', 'Personal' => '👤'];
                echo ($iconos[$j['motivo']] ?? '') . ' ' . $j['motivo'];
              ?>
            </span>
          </td>
          <td><?= date('d/m/Y', strtotime($j['fecha'])) ?></td>
          <td><span class="badge-estado badge-<?= strtolower($j['estado']) ?>"><?= $j['estado'] ?></span></td>
          <td class="td-actions">
            <a href="<?= APP_URL ?>/public/justificantes/show/<?= $j['id'] ?>" class="btn-action btn-action--view" title="Ver">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </a>
            <?php if (in_array($user['rol'], ['admin', 'docente'])): ?>
            <a href="<?= APP_URL ?>/public/justificantes/edit/<?= $j['id'] ?>" class="btn-action btn-action--edit" title="Editar">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </a>
            <?php endif; ?>
            <?php if ($user['rol'] === 'admin'): ?>
            <form method="POST" action="<?= APP_URL ?>/public/justificantes/delete/<?= $j['id'] ?>" class="inline-form" onsubmit="return confirmDelete(this)">
              <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
              <button type="submit" class="btn-action btn-action--delete" title="Eliminar">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
              </button>
            </form>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>
