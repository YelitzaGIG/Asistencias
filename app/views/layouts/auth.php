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
<link rel="stylesheet" href="<?= APP_URL ?>/public/css/auth.css">
</head>
<body class="auth-body">
  <div class="auth-bg">
    <div class="gear-decor gear-1"></div>
    <div class="gear-decor gear-2"></div>
    <div class="grain-overlay"></div>
  </div>

  <?php if (!empty($flash)): ?>
  <div class="toast toast-<?= $flash['type'] ?> show" id="globalToast">
    <?= $flash['msg'] ?>
  </div>
  <?php endif; ?>

  <?= $content ?>

  <script src="<?= APP_URL ?>/public/js/app.js"></script>
</body>
</html>
