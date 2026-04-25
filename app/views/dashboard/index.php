<?php /* app/views/dashboard/index.php */
$rol = $user['rol'];
?>
<div class="page-header">
  <div>
    <h1 class="page-title">
      <?php
        $titles = ['alumno' => 'Panel del Alumno', 'docente' => 'Panel del Docente', 'admin' => 'Panel Administrativo'];
        echo $titles[$rol] ?? 'Dashboard';
      ?>
    </h1>
    <p class="page-subtitle">Bienvenido, <strong><?= htmlspecialchars($user['nombre']) ?></strong></p>
  </div>
  <a href="<?= APP_URL ?>/public/justificantes/create" class="btn-primary">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Nuevo Justificante
  </a>
</div>

<!-- Stats cards -->
<div class="stats-grid">
  <div class="stat-card animate-pop" style="--delay:.05s">
    <div class="stat-icon-wrap stat-icon--total">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
    </div>
    <div class="stat-body">
      <span class="stat-number"><?= $stats['total'] ?></span>
      <span class="stat-label">Total registros</span>
    </div>
    <div class="stat-trend up">+<?= max(1, $stats['total']) ?> este mes</div>
  </div>

  <div class="stat-card animate-pop" style="--delay:.1s">
    <div class="stat-icon-wrap stat-icon--generado">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    </div>
    <div class="stat-body">
      <span class="stat-number"><?= $stats['Generado'] ?></span>
      <span class="stat-label">Generados</span>
    </div>
    <span class="stat-badge badge-generado">Pendientes</span>
  </div>

  <div class="stat-card animate-pop" style="--delay:.15s">
    <div class="stat-icon-wrap stat-icon--entregado">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13"/><path d="M22 2L15 22 11 13 2 9l20-7z"/></svg>
    </div>
    <div class="stat-body">
      <span class="stat-number"><?= $stats['Entregado'] ?></span>
      <span class="stat-label">Entregados</span>
    </div>
    <span class="stat-badge badge-entregado">En proceso</span>
  </div>

  <div class="stat-card animate-pop" style="--delay:.2s">
    <div class="stat-icon-wrap stat-icon--validado">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
    </div>
    <div class="stat-body">
      <span class="stat-number"><?= $stats['Validado'] ?></span>
      <span class="stat-label">Validados</span>
    </div>
    <span class="stat-badge badge-validado">Completados</span>
  </div>
</div>

<!-- Justificantes recientes -->
<div class="section-card">
  <div class="section-header">
    <h2 class="section-title">Justificantes recientes</h2>
    <a href="<?= APP_URL ?>/public/justificantes" class="btn-outline">Ver todos</a>
  </div>

  <?php if (empty($recientes)): ?>
  <div class="empty-state">
    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
    <p>No hay justificantes registrados aún.</p>
    <a href="<?= APP_URL ?>/public/justificantes/create" class="btn-primary">Crear el primero</a>
  </div>
  <?php else: ?>
  <div class="table-responsive">
    <table class="data-table">
      <thead>
        <tr>
          <th>Folio</th>
          <th>Alumno</th>
          <th>Grupo</th>
          <th>Motivo</th>
          <th>Fecha</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($recientes as $j): ?>
        <tr>
          <td><span class="folio-tag"><?= htmlspecialchars($j['folio']) ?></span></td>
          <td><?= htmlspecialchars($j['nombre_alumno']) ?></td>
          <td><span class="grupo-tag"><?= htmlspecialchars($j['grupo']) ?></span></td>
          <td><?= htmlspecialchars($j['motivo']) ?></td>
          <td><?= date('d/m/Y', strtotime($j['fecha'])) ?></td>
          <td><span class="badge-estado badge-<?= strtolower($j['estado']) ?>"><?= $j['estado'] ?></span></td>
          <td>
            <a href="<?= APP_URL ?>/public/justificantes/show/<?= $j['id'] ?>" class="btn-action" title="Ver detalle">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

<!-- User info card -->
<div class="section-card profile-mini">
  <div class="profile-mini-avatar"><?= mb_strtoupper(mb_substr($user['nombre'], 0, 1)) ?></div>
  <div class="profile-mini-info">
    <h3><?= htmlspecialchars($user['nombre']) ?></h3>
    <p><?= htmlspecialchars($user['email']) ?></p>
    <div class="profile-mini-meta">
      <span class="badge-role badge-<?= $rol ?>"><?= ucfirst($rol) ?></span>
      <?php if ($user['grupo'] !== 'N/A'): ?>
      <span class="meta-chip">Grupo: <?= htmlspecialchars($user['grupo']) ?></span>
      <?php endif; ?>
      <span class="meta-chip">Matrícula: <?= htmlspecialchars($user['matricula']) ?></span>
    </div>
  </div>
  <a href="<?= APP_URL ?>/public/dashboard/perfil" class="btn-outline">Editar perfil</a>
</div>
