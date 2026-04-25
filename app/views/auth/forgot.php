<?php /* app/views/auth/forgot.php */ ?>
<div class="auth-split">
  <div class="auth-brand-panel">
    <div class="brand-panel-content">
      <svg viewBox="0 0 120 120" class="brand-gear" xmlns="http://www.w3.org/2000/svg">
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
      <h2 class="brand-panel-title">DGETI</h2>
      <p class="brand-panel-sub">Recupera el acceso a<br>tu cuenta institucional</p>
    </div>
  </div>

  <div class="auth-form-panel">
    <a href="<?= APP_URL ?>/public/auth/login" class="back-link">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
      Regresar al login
    </a>
    <h1 class="form-heading">Recuperar contraseña</h1>
    <p class="form-subheading">Ingresa tu correo y te enviaremos un código de recuperación.</p>

    <div class="info-banner">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      El código será enviado al correo institucional registrado en el sistema.
    </div>

    <form method="POST" action="<?= APP_URL ?>/public/auth/forgotpassword" class="auth-form">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
      <div class="field-group">
        <label class="field-label" for="email">Correo electrónico institucional</label>
        <div class="field-wrap">
          <svg class="field-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          <input type="email" id="email" name="email" class="field" placeholder="correo@cetis.edu.mx" required>
        </div>
      </div>
      <button type="submit" class="btn-primary btn-full btn-submit">Enviar código de recuperación</button>
    </form>
    <p class="form-caption">Se enviará un código para la recuperación de la contraseña al correo institucional registrado.</p>
  </div>
</div>
