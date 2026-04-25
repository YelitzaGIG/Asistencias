<?php /* app/views/justificantes/show.php */ ?>
<div class="page-header">
  <div>
    <h1 class="page-title">Detalle del Justificante</h1>
    <p class="page-subtitle">Folio: <strong><?= htmlspecialchars($j['folio']) ?></strong></p>
  </div>
  <div class="header-actions">
    <?php if (in_array($user['rol'], ['admin', 'docente'])): ?>
    <a href="<?= APP_URL ?>/public/justificantes/edit/<?= $j['id'] ?>" class="btn-primary">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
      Editar
    </a>
    <?php endif; ?>
    <a href="<?= APP_URL ?>/public/justificantes" class="btn-outline">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
      Regresar
    </a>
  </div>
</div>

<div class="two-col-layout">
  <div class="section-card">
    <div class="detail-header">
      <span class="folio-tag folio-lg"><?= htmlspecialchars($j['folio']) ?></span>
      <span class="badge-estado badge-<?= strtolower($j['estado']) ?> badge-lg"><?= $j['estado'] ?></span>
    </div>

    <div class="detail-grid">
      <div class="detail-item">
        <span class="detail-key">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          Nombre del alumno
        </span>
        <span class="detail-val"><?= htmlspecialchars($j['nombre_alumno']) ?></span>
      </div>
      <div class="detail-item">
        <span class="detail-key">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          Número de control
        </span>
        <span class="detail-val"><code><?= htmlspecialchars($j['numero_control']) ?></code></span>
      </div>
      <div class="detail-item">
        <span class="detail-key">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          Grupo
        </span>
        <span class="detail-val"><span class="grupo-tag"><?= htmlspecialchars($j['grupo']) ?></span></span>
      </div>
      <div class="detail-item">
        <span class="detail-key">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          Motivo
        </span>
        <span class="detail-val">
          <?php $iconos = ['Salud' => '🏥', 'Comisión' => '📋', 'Personal' => '👤']; ?>
          <span class="motivo-tag motivo-<?= strtolower($j['motivo']) ?>">
            <?= ($iconos[$j['motivo']] ?? '') . ' ' . htmlspecialchars($j['motivo']) ?>
          </span>
        </span>
      </div>
      <div class="detail-item">
        <span class="detail-key">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          Fecha de ausencia
        </span>
        <span class="detail-val"><?= date('d \d\e F \d\e Y', strtotime($j['fecha'])) ?></span>
      </div>
      <div class="detail-item">
        <span class="detail-key">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          Registrado el
        </span>
        <span class="detail-val"><?= date('d/m/Y H:i', strtotime($j['created_at'])) ?></span>
      </div>
      <div class="detail-item">
        <span class="detail-key">Última actualización</span>
        <span class="detail-val"><?= date('d/m/Y H:i', strtotime($j['updated_at'])) ?></span>
      </div>
    </div>
  </div>

  <!-- Timeline de estado -->
  <div>
    <div class="section-card">
      <h3 class="section-title">Estado del justificante</h3>
      <div class="estado-timeline">
        <?php
          $estadoIdx = array_search($j['estado'], ESTADOS);
          foreach (ESTADOS as $idx => $e):
            $done    = $idx <  $estadoIdx;
            $current = $idx === $estadoIdx;
        ?>
        <div class="timeline-step <?= $done ? 'done' : ($current ? 'current' : 'pending') ?>">
          <div class="timeline-dot">
            <?php if ($done): ?>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
            <?php elseif ($current): ?>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="6" fill="currentColor"/></svg>
            <?php else: ?>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="8"/></svg>
            <?php endif; ?>
          </div>
          <div class="timeline-info">
            <span class="timeline-label"><?= $e ?></span>
            <?php if ($current): ?><span class="timeline-current-tag">Estado actual</span><?php endif; ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <?php if ($user['rol'] === 'admin'): ?>
    <div class="section-card">
      <h3 class="section-title">Acciones rápidas</h3>
      <form method="POST" action="<?= APP_URL ?>/public/justificantes/delete/<?= $j['id'] ?>" onsubmit="return confirmDelete(this)">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
        <button type="submit" class="btn-danger btn-full">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
          Eliminar justificante
        </button>
      </form>
    </div>
    <?php endif; ?>
  </div>
</div>
