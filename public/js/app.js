/**
 * public/js/app.js
 * Lógica del lado del cliente para el módulo de Justificantes
 */

document.addEventListener('DOMContentLoaded', () => {

  // ── 1. Auto-ocultar mensajes flash ──────────────────────────
  const alerts = document.querySelectorAll('.alert[data-autohide]');
  alerts.forEach(alert => {
    setTimeout(() => {
      alert.style.transition = 'opacity .5s ease, transform .5s ease';
      alert.style.opacity = '0';
      alert.style.transform = 'translateY(-6px)';
      setTimeout(() => alert.remove(), 500);
    }, 4500);
  });

  // ── 2. Confirmar cambio de estado ───────────────────────────
  const estadoSelects = document.querySelectorAll('.estado-select');
  estadoSelects.forEach(select => {
    // Guardar el valor original al hacer foco
    select.addEventListener('focus', function () {
      this.dataset.original = this.value;
    });

    select.addEventListener('change', function () {
      const nuevo    = this.value;
      const original = this.dataset.original;
      const folio    = this.closest('tr')?.querySelector('.folio-cell')?.textContent?.trim() || '';

      const confirmar = confirm(`¿Cambiar estado de ${folio} a "${nuevo}"?`);
      if (!confirmar) {
        // Revertir al valor original si el usuario cancela
        this.value = original;
        return;
      }

      // Enviar formulario oculto con los datos
      const form   = document.createElement('form');
      form.method  = 'POST';
      form.action  = this.dataset.action;

      const fId    = document.createElement('input');
      fId.type     = 'hidden';
      fId.name     = 'id';
      fId.value    = this.dataset.id;

      const fState = document.createElement('input');
      fState.type  = 'hidden';
      fState.name  = 'estado';
      fState.value = nuevo;

      form.appendChild(fId);
      form.appendChild(fState);
      document.body.appendChild(form);
      form.submit();
    });
  });

  // ── 3. Resaltar fila recién creada (si hay folio en URL) ────
  const params  = new URLSearchParams(window.location.search);
  // No hay parámetro específico, pero dejamos el hook listo.

  // ── 4. Validación HTML5 mejorada en el formulario ───────────
  const form = document.querySelector('.js-form-validar');
  if (form) {
    form.addEventListener('submit', function (e) {
      let valid = true;
      const campos = form.querySelectorAll('[required]');
      campos.forEach(campo => {
        if (!campo.value.trim()) {
          campo.classList.add('is-invalid');
          valid = false;
        } else {
          campo.classList.remove('is-invalid');
        }
      });

      if (!valid) {
        e.preventDefault();
        // Hacer scroll al primer campo inválido
        const primero = form.querySelector('.is-invalid');
        primero?.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
    });

    // Remover clase is-invalid al escribir
    form.querySelectorAll('.form-control').forEach(input => {
      input.addEventListener('input', () => input.classList.remove('is-invalid'));
    });
  }

});
