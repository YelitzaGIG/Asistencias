<?php /* app/views/auth/reset.php */ ?>
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
      <p class="brand-panel-sub">Nueva contraseña</p>
    </div>
  </div>

  <div class="auth-form-panel">
    <a href="<?= APP_URL ?>/public/auth/login" class="back-link">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
      Regresar al login
    </a>
    <h1 class="form-heading">Nueva contraseña</h1>
    <p class="form-subheading">Ingresa el código recibido y tu nueva contraseña.</p>

    <form method="POST" action="<?= APP_URL ?>/public/auth/resetpost" class="auth-form">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

      <div class="field-group">
        <label class="field-label">Código de recuperación</label>
        <input type="text" name="codigo" class="field field-code" placeholder="000000" maxlength="6" required>
      </div>
      <div class="field-group">
        <label class="field-label">Nueva contraseña</label>
        <div class="field-wrap">
          <input type="password" name="password" id="reset-pass" class="field" placeholder="Mínimo 8 caracteres" required minlength="8">
          <button type="button" class="field-toggle-pass" onclick="togglePassword('reset-pass')" tabindex="-1">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
      </div>
      <div class="field-group">
        <label class="field-label">Verificar contraseña</label>
        <div class="field-wrap">
          <input type="password" name="password_confirm" id="reset-pass2" class="field" placeholder="Repetir contraseña" required>
          <button type="button" class="field-toggle-pass" onclick="togglePassword('reset-pass2')" tabindex="-1">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
      </div>
      <button type="submit" class="btn-primary btn-full btn-submit">Realizar cambio de credenciales</button>
    </form>
  </div>
</div>
