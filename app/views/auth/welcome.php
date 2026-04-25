<?php /* app/views/auth/welcome.php */ ?>
<div class="auth-center">
  <div class="welcome-logo animate-fadein">
    <div class="logo-gear-wrap">
      <svg viewBox="0 0 120 120" class="logo-gear" xmlns="http://www.w3.org/2000/svg">
        <g fill="none">
          <circle cx="60" cy="60" r="36" stroke="white" stroke-width="3"/>
          <circle cx="60" cy="60" r="22" stroke="white" stroke-width="2.5"/>
          <g stroke="white" stroke-width="3" stroke-linecap="round">
            <line x1="60" y1="18" x2="60" y2="9"/><line x1="60" y1="102" x2="60" y2="111"/>
            <line x1="18" y1="60" x2="9" y2="60"/><line x1="102" y1="60" x2="111" y2="60"/>
            <line x1="30" y1="30" x2="23" y2="23"/><line x1="90" y1="90" x2="97" y2="97"/>
            <line x1="90" y1="30" x2="97" y2="23"/><line x1="30" y1="90" x2="23" y2="97"/>
          </g>
          <path d="M44 55L52 55L52 50L68 60L52 70L52 65L44 65Z" fill="white" opacity=".9"/>
        </g>
        <text x="42" y="55" font-family="Montserrat,sans-serif" font-weight="800" font-size="13" fill="white">DG</text>
        <text x="40" y="71" font-family="Montserrat,sans-serif" font-weight="800" font-size="13" fill="white">ETi</text>
      </svg>
    </div>
    <h1 class="welcome-brand">DGETI</h1>
    <p class="welcome-sub">Sistema Institucional de Justificantes</p>
    <p class="welcome-institute">CETIS 193 · Jaguares</p>
  </div>

  <div class="welcome-card animate-slidein">
    <div class="mascot-strip">
      <div class="mascot-info">
        <span class="mascot-year">NUEVO INGRESO 2026</span>
        <span class="mascot-soon">¡próximamente!</span>
        <span class="mascot-school">JAGUARES · CETIS 193</span>
      </div>
      <span class="mascot-emoji">🐆</span>
    </div>

    <div class="welcome-actions">
      <a href="<?= APP_URL ?>/public/auth/login" class="btn-primary btn-full">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
        Iniciar sesión
      </a>
      <a href="<?= APP_URL ?>/public/auth/register" class="btn-secondary btn-full">Registrarse</a>
      <a href="<?= APP_URL ?>/public/auth/forgotpassword" class="link-sm">¿Olvidaste tu contraseña?</a>
    </div>
  </div>

  <p class="auth-footer">DGETI · Sistema de Gestión Institucional v<?= APP_VERSION ?></p>
</div>
