<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= APP_NAME ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= APP_URL ?>/public/css/variables.css">
<link rel="stylesheet" href="<?= APP_URL ?>/public/css/base.css">
<link rel="stylesheet" href="<?= APP_URL ?>/public/css/dashboard.css">
</head>
<body class="dash-body">

<?php
$rol    = $_SESSION['user']['rol'] ?? 'alumno';
$nombre = $_SESSION['user']['nombre'] ?? '';
$email  = $_SESSION['user']['email'] ?? '';
// Detectar ruta activa
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$activeDash   = str_contains($uri, '/dashboard');
$activeJust   = str_contains($uri, '/justificantes');
$activePerfil = str_contains($uri, '/perfil');
?>

<!-- ── SIDEBAR ── -->
<nav class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <div class="sidebar-logo-wrap">
      <svg class="sidebar-gear" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg">
        <g fill="none">
          <circle cx="30" cy="30" r="18" stroke="white" stroke-width="2"/>
          <circle cx="30" cy="30" r="11" stroke="white" stroke-width="1.8"/>
          <g stroke="white" stroke-width="2" stroke-linecap="round">
            <line x1="30" y1="9"  x2="30" y2="5"/><line x1="30" y1="51" x2="30" y2="55"/>
            <line x1="9"  y1="30" x2="5"  y2="30"/><line x1="51" y1="30" x2="55" y2="30"/>
            <line x1="15" y1="15" x2="12" y2="12"/><line x1="45" y1="45" x2="48" y2="48"/>
            <line x1="45" y1="15" x2="48" y2="12"/><line x1="15" y1="45" x2="12" y2="48"/>
          </g>
          <path d="M22 27L26 27L26 24L34 30L26 36L26 33L22 33Z" fill="white" opacity=".8"/>
        </g>
      </svg>
      <span class="sidebar-brand">DGETI</span>
    </div>
    <button class="sidebar-close" onclick="toggleSidebar()" aria-label="Cerrar menú">✕</button>
  </div>

  <!-- User mini-card -->
  <div class="sidebar-user">
    <div class="sidebar-avatar">
      <?= mb_strtoupper(mb_substr($nombre, 0, 1)) ?>
    </div>
    <div class="sidebar-user-info">
      <span class="sidebar-username"><?= htmlspecialchars($nombre) ?></span>
      <span class="sidebar-role badge-<?= $rol ?>"><?= ucfirst($rol) ?></span>
    </div>
  </div>

  <nav class="sidebar-nav">
    <a href="<?= APP_URL ?>/public/dashboard" class="nav-item <?= $activeDash && !$activePerfil ? 'active' : '' ?>">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
      Dashboard
    </a>
    <a href="<?= APP_URL ?>/public/justificantes" class="nav-item <?= $activeJust ? 'active' : '' ?>">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
      Justificantes
    </a>
    <?php if ($rol !== 'alumno'): ?>
    <a href="<?= APP_URL ?>/public/justificantes/create" class="nav-item <?= str_contains($uri, 'create') ? 'active' : '' ?>">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
      Nuevo Justificante
    </a>
    <?php else: ?>
    <a href="<?= APP_URL ?>/public/justificantes/create" class="nav-item <?= str_contains($uri, 'create') ? 'active' : '' ?>">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
      Solicitar Justificante
    </a>
    <?php endif; ?>
    <a href="<?= APP_URL ?>/public/dashboard/perfil" class="nav-item <?= $activePerfil ? 'active' : '' ?>">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      Mi Perfil
    </a>
  </nav>

  <div class="sidebar-footer">
    <a href="<?= APP_URL ?>/public/auth/logout" class="nav-item nav-logout">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
      Cerrar sesión
    </a>
  </div>
</nav>

<!-- Overlay para móvil -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- ── CONTENIDO PRINCIPAL ── -->
<div class="main-wrapper">
  <header class="topbar">
    <button class="hamburger" onclick="toggleSidebar()" aria-label="Abrir menú">
      <span></span><span></span><span></span>
    </button>
    <div class="topbar-brand">
      <span class="topbar-title" id="pageTitle">Sistema DGETI</span>
    </div>
    <div class="topbar-actions">
      <span class="topbar-user"><?= htmlspecialchars($nombre) ?></span>
      <a href="<?= APP_URL ?>/public/auth/logout" class="btn-logout-top" title="Cerrar sesión">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
      </a>
    </div>
  </header>

  <main class="page-content">
    <?php if (!empty($flash)): ?>
    <div class="alert alert-<?= $flash['type'] ?> animate-fadein" id="flashMsg">
      <?= $flash['msg'] ?>
      <button onclick="this.parentElement.remove()" class="alert-close">✕</button>
    </div>
    <?php endif; ?>

    <?= $content ?>
  </main>
</div>

<script src="<?= APP_URL ?>/public/js/app.js"></script>
</body>
</html>
