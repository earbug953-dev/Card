// ── NAV SCROLL ─────────────────────────────────────────────
window.addEventListener('scroll', () => {
  document.getElementById('mainNav')?.classList.toggle('scrolled', window.scrollY > 40);
});

// ── SIDEBAR ─────────────────────────────────────────────────
function toggleSidebar() {
  document.getElementById('sidebar')?.classList.toggle('open');
  document.getElementById('sidebarOverlay')?.classList.toggle('open');
}
function closeSidebar() {
  document.getElementById('sidebar')?.classList.remove('open');
  document.getElementById('sidebarOverlay')?.classList.remove('open');
}

// ── MOBILE NAV ──────────────────────────────────────────────
function toggleMobileNav() {
  document.getElementById('mobileNav')?.classList.toggle('open');
}

// ── MODALS ──────────────────────────────────────────────────
function openModal(id) { document.getElementById(id)?.classList.add('open'); }
function closeModal(id) { document.getElementById(id)?.classList.remove('open'); }

document.addEventListener('DOMContentLoaded', () => {
  // Close modal on backdrop click
  document.querySelectorAll('.modal-backdrop').forEach(el => {
    el.addEventListener('click', function (e) {
      if (e.target === this) this.classList.remove('open');
    });
  });

  // Auto-dismiss flash alerts
  setTimeout(() => {
    document.querySelectorAll('#flashAlert, #toastMsg, .toast').forEach(el => {
      el.style.opacity = '0';
      el.style.transition = 'opacity .5s';
      setTimeout(() => el.remove(), 500);
    });
  }, 5000);

  // Animated scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const target = document.querySelector(a.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        document.getElementById('mobileNav')?.classList.remove('open');
      }
    });
  });

  // Intersection observer for animations
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        const delay = parseInt(e.target.dataset.delay || 0);
        setTimeout(() => e.target.classList.add('animated'), delay);
        io.unobserve(e.target);
      }
    });
  }, { threshold: 0.12 });

  document.querySelectorAll('[data-animate]').forEach(el => io.observe(el));
});
