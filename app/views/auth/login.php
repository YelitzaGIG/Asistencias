<?php /* app/views/auth/login.php */ ?>
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
      <p class="brand-panel-sub">Sistema Institucional<br>de Justificantes</p>
    </div>
  </div>

  <div class="auth-form-panel">
    <a href="<?= APP_URL ?>/public/auth" class="back-link">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
      Regresar
    </a>
    <h1 class="form-heading">Iniciar sesión</h1>
    <p class="form-subheading">Ingresa tus credenciales institucionales</p>

    <form method="POST" action="<?= APP_URL ?>/public/auth/loginpost" class="auth-form" id="loginForm">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

      <div class="field-group">
        <label class="field-label" for="email">Correo electrónico institucional</label>
        <div class="field-wrap">
          <svg class="field-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          <input type="email" id="email" name="email" class="field" placeholder="correo@cetis.edu.mx" required autocomplete="email">
        </div>
      </div>

      <div class="field-group">
        <label class="field-label" for="password">Contraseña</label>
        <div class="field-wrap">
          <svg class="field-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          <input type="password" id="password" name="password" class="field" placeholder="••••••••" required autocomplete="current-password">
          <button type="button" class="field-toggle-pass" onclick="togglePassword('password')" tabindex="-1">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
      </div>

      <div class="field-group">
        <label class="field-label" for="rol">Rol</label>
        <div class="field-wrap">
          <svg class="field-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          <select id="rol" name="rol" class="field field-select">
            <option value="alumno">Alumno</option>
            <option value="docente">Docente</option>
            <option value="admin">Administrador</option>
          </select>
        </div>
      </div>

      <button type="submit" class="btn-primary btn-full btn-submit">
        Iniciar sesión
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </button>
    </form>

    <div class="auth-links">
      <a href="<?= APP_URL ?>/public/auth/forgotpassword" class="link-sm">¿Olvidaste tu contraseña?</a>
      <span class="link-divider">·</span>
      <a href="<?= APP_URL ?>/public/auth/register" class="link-sm">Crear cuenta</a>
    </div>

    <div class="demo-credentials">
      <p class="demo-title">Credenciales de prueba:</p>
      <div class="demo-grid">
        <div class="demo-item" onclick="fillDemo('alumno@cetis.edu.mx','alumno')">
          <span class="demo-badge badge-alumno">Alumno</span>
          <span class="demo-email">alumno@cetis.edu.mx</span>
        </div>
        <div class="demo-item" onclick="fillDemo('docente@cetis.edu.mx','docente')">
          <span class="demo-badge badge-docente">Docente</span>
          <span class="demo-email">docente@cetis.edu.mx</span>
        </div>
        <div class="demo-item" onclick="fillDemo('admin@cetis.edu.mx','admin')">
          <span class="demo-badge badge-admin">Admin</span>
          <span class="demo-email">admin@cetis.edu.mx</span>
        </div>
      </div>
      <p class="demo-pass">Contraseña para todos: <code>password</code></p>
    </div>
  </div>
</div>
