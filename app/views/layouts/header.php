<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= APP_NAME ?></title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

  <!-- Hoja de estilos principal -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/styles.css" />
</head>
<body>

<!-- ── Encabezado de la aplicación ───────────────────────── -->
<header class="app-header">
  <div class="app-header__brand">
    <div class="app-header__brand-icon">📋</div>
    <span><?= APP_NAME ?></span>
  </div>

  <nav class="app-header__nav">
    <!-- Determina qué enlace está activo según la acción actual -->
    <?php
      $ctrl   = $_GET['controller'] ?? 'justificante';
      $action = $_GET['action']     ?? 'index';
    ?>
    <a href="<?= BASE_URL ?>/?controller=justificante&action=index"
       class="<?= ($action === 'index')  ? 'active' : '' ?>">
      Listado
    </a>
    <a href="<?= BASE_URL ?>/?controller=justificante&action=create"
       class="<?= ($action === 'create') ? 'active' : '' ?>">
      + Nuevo Justificante
    </a>
  </nav>
</header>

<!-- ── Contenido principal ───────────────────────────────── -->
<main class="app-main">
