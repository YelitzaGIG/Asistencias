/* ============================================================
   public/js/app.js — DGETI Sistema Institucional
   ============================================================ */

'use strict';

// ── Sidebar toggle ────────────────────────────
function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebarOverlay');
  if (!sidebar) return;
  sidebar.classList.toggle('open');
  if (overlay) overlay.classList.toggle('active');
  document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
}

// ── Show/hide password ────────────────────────
function togglePassword(fieldId) {
  const field = document.getElementById(fieldId);
  if (!field) return;
  field.type = field.type === 'password' ? 'text' : 'password';
}

// ── Fill demo credentials ─────────────────────
function fillDemo(email, rol) {
  const emailField = document.getElementById('email');
  const passField  = document.getElementById('password');
  const rolField   = document.getElementById('rol');
  if (emailField) emailField.value = email;
  if (passField)  passField.value  = 'password';
  if (rolField)   rolField.value   = rol;
  // Feedback visual
  [emailField, passField].forEach(el => {
    if (!el) return;
    el.style.transition = 'background .3s';
    el.style.background = 'rgba(98,17,50,.05)';
    setTimeout(() => { el.style.background = ''; }, 600);
  });
}

// ── Confirm delete ────────────────────────────
function confirmDelete(form) {
  return window.confirm('¿Estás seguro de que deseas eliminar este registro? Esta acción no se puede deshacer.');
}

// ── Toast auto-dismiss ────────────────────────
function initToast() {
  const toast = document.getElementById('globalToast');
  if (!toast) return;
  toast.classList.add('show');
  setTimeout(() => {
    toast.style.transition = 'opacity .4s, transform .4s';
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(12px)';
    setTimeout(() => toast.remove(), 450);
  }, 4000);
}

// ── Ripple effect ─────────────────────────────
function addRipple(e) {
  const btn = e.currentTarget;
  const existing = btn.querySelector('.ripple');
  if (existing) existing.remove();

  const circle = document.createElement('span');
  const d = Math.max(btn.clientWidth, btn.clientHeight);
  const rect = btn.getBoundingClientRect();

  circle.className = 'ripple';
  circle.style.cssText = `
    width:${d}px; height:${d}px;
    left:${e.clientX - rect.left - d/2}px;
    top:${e.clientY - rect.top - d/2}px;
    position:absolute;
    border-radius:50%;
    background:rgba(255,255,255,.25);
    transform:scale(0);
    animation:rippleAnim .55s ease-out;
    pointer-events:none;
    z-index:10;
  `;
  btn.style.position = 'relative';
  btn.style.overflow = 'hidden';
  btn.appendChild(circle);
  setTimeout(() => circle.remove(), 600);
}

// ── Input shake on error ──────────────────────
function shakeInput(el) {
  el.style.animation = 'none';
  el.offsetHeight;
  el.style.animation = 'shake .38s ease';
  el.style.borderColor = 'var(--color-error)';
  setTimeout(() => {
    el.style.animation = '';
    el.style.borderColor = '';
  }, 500);
}

// ── Form validation feedback ──────────────────
function initFormValidation() {
  document.querySelectorAll('.auth-form').forEach(form => {
    form.addEventListener('submit', function(e) {
      let valid = true;
      form.querySelectorAll('[required]').forEach(field => {
        if (!field.value.trim()) {
          shakeInput(field);
          valid = false;
        }
      });
      if (!valid) {
        e.preventDefault();
        return;
      }
      // Disable submit to avoid double submit
      const btn = form.querySelector('[type="submit"]');
      if (btn) {
        btn.disabled = true;
        btn.innerHTML = `
          <svg width="16" height="16" style="animation:spin .8s linear infinite" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
          </svg>
          Procesando...
        `;
        setTimeout(() => { btn.disabled = false; }, 5000);
      }
    });
  });
}

// ── Alert auto close ──────────────────────────
function initAlerts() {
  document.querySelectorAll('.alert').forEach(alert => {
    setTimeout(() => {
      alert.style.transition = 'opacity .4s, transform .4s';
      alert.style.opacity = '0';
      alert.style.transform = 'translateY(-8px)';
      setTimeout(() => alert.remove(), 450);
    }, 5000);
  });
}

// ── Inject CSS keyframes ──────────────────────
function injectKeyframes() {
  if (document.getElementById('js-keyframes')) return;
  const style = document.createElement('style');
  style.id = 'js-keyframes';
  style.textContent = `
    @keyframes rippleAnim { to { transform:scale(2.5); opacity:0; } }
    @keyframes shake { 0%,100%{transform:translateX(0)} 20%{transform:translateX(-6px)} 40%{transform:translateX(6px)} 60%{transform:translateX(-4px)} 80%{transform:translateX(4px)} }
    @keyframes spin { to { transform:rotate(360deg); } }
  `;
  document.head.appendChild(style);
}

// ── Page title sync with sidebar ─────────────
function syncPageTitle() {
  const active = document.querySelector('.nav-item.active span, .nav-item.active');
  const titleEl = document.getElementById('pageTitle');
  if (active && titleEl) {
    const text = active.textContent?.trim();
    if (text) titleEl.textContent = text;
  }
}

// ── Date field: set today as default ─────────
function initDateDefaults() {
  document.querySelectorAll('input[type="date"]:not([value])').forEach(input => {
    input.value = new Date().toISOString().split('T')[0];
  });
}

// ── Animate number counters ───────────────────
function animateCounters() {
  document.querySelectorAll('.stat-number').forEach(el => {
    const target = parseInt(el.textContent, 10);
    if (isNaN(target) || target === 0) return;
    let current = 0;
    const step = Math.ceil(target / 20);
    const timer = setInterval(() => {
      current = Math.min(current + step, target);
      el.textContent = current;
      if (current >= target) clearInterval(timer);
    }, 40);
  });
}

// ── Motivo card keyboard nav ──────────────────
function initMotivoCards() {
  document.querySelectorAll('.motivo-option').forEach(opt => {
    const card = opt.querySelector('.motivo-card');
    const input = opt.querySelector('input[type="radio"]');
    if (!card || !input) return;
    card.setAttribute('tabindex', '0');
    card.addEventListener('keydown', e => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        input.checked = true;
        input.dispatchEvent(new Event('change'));
      }
    });
  });
}

// ── Init ──────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  injectKeyframes();
  initToast();
  initFormValidation();
  initAlerts();
  initDateDefaults();
  animateCounters();
  initMotivoCards();
  syncPageTitle();

  // Ripple on all .btn-primary
  document.querySelectorAll('.btn-primary, .btn-outline').forEach(btn => {
    btn.addEventListener('click', addRipple);
  });

  // Close sidebar on overlay click (also handled inline for safety)
  const overlay = document.getElementById('sidebarOverlay');
  if (overlay) overlay.addEventListener('click', toggleSidebar);

  // Close sidebar on resize back to desktop
  window.addEventListener('resize', () => {
    if (window.innerWidth > 768) {
      const sidebar = document.getElementById('sidebar');
      const ovl = document.getElementById('sidebarOverlay');
      if (sidebar) sidebar.classList.remove('open');
      if (ovl) ovl.classList.remove('active');
      document.body.style.overflow = '';
    }
  });
});
