<?php /* app/views/auth/register.php */ ?>
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
      <p class="brand-panel-sub">Crea tu cuenta institucional</p>
    </div>
  </div>

  <div class="auth-form-panel auth-form-panel--scroll">
    <a href="<?= APP_URL ?>/public/auth/login" class="back-link">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
      Regresar
    </a>
    <h1 class="form-heading">Crear cuenta</h1>
    <p class="form-subheading">Completa los datos para registrarte</p>

    <form method="POST" action="<?= APP_URL ?>/public/auth/registerpost" class="auth-form">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

      <div class="field-row">
        <div class="field-group">
          <label class="field-label">Nombres</label>
          <input type="text" name="nombres" class="field" placeholder="Nombre(s)" required>
        </div>
        <div class="field-group">
          <label class="field-label">Apellidos</label>
          <input type="text" name="apellidos" class="field" placeholder="Apellido Apellido" required>
        </div>
      </div>

      <div class="field-row">
        <div class="field-group">
          <label class="field-label">Matrícula / N° Control</label>
          <input type="text" name="matricula" class="field" placeholder="CETIS-0000" required>
        </div>
        <div class="field-group">
          <label class="field-label">Semestre</label>
          <select name="semestre" class="field field-select">
            <?php for ($i = 1; $i <= 6; $i++): ?>
            <option value="<?= $i ?>"><?= $i ?>°</option>
            <?php endfor; ?>
          </select>
        </div>
      </div>

      <div class="field-row">
        <div class="field-group">
          <label class="field-label">Grupo</label>
          <input type="text" name="grupo" class="field" placeholder="Ej: ISC-401">
        </div>
        <div class="field-group">
          <label class="field-label">Rol</label>
          <select name="rol" class="field field-select">
            <option value="alumno">Alumno</option>
            <option value="docente">Docente</option>
          </select>
        </div>
      </div>

      <div class="field-group">
        <label class="field-label">Correo electrónico institucional</label>
        <div class="field-wrap">
          <svg class="field-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          <input type="email" name="email" class="field" placeholder="correo@cetis.edu.mx" required>
        </div>
      </div>

      <div class="field-row">
        <div class="field-group">
          <label class="field-label">Contraseña</label>
          <div class="field-wrap">
            <input type="password" name="password" id="reg-pass" class="field" placeholder="Mín. 8 caracteres" required minlength="8">
            <button type="button" class="field-toggle-pass" onclick="togglePassword('reg-pass')" tabindex="-1">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </div>
        </div>
        <div class="field-group">
          <label class="field-label">Confirmar contraseña</label>
          <div class="field-wrap">
            <input type="password" name="password_confirm" id="reg-pass2" class="field" placeholder="Repetir contraseña" required>
            <button type="button" class="field-toggle-pass" onclick="togglePassword('reg-pass2')" tabindex="-1">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </div>
        </div>
      </div>

      <button type="submit" class="btn-primary btn-full btn-submit">Crear cuenta</button>
    </form>

    <p class="auth-alt-link">¿Ya tienes cuenta? <a href="<?= APP_URL ?>/public/auth/login">Inicia sesión</a></p>
  </div>
</div>
