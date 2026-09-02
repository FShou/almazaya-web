/* Al Mazaya — shared interactions */
(function () {
  'use strict';

  /* Sticky header state */
  var header = document.querySelector('.site-header');
  function onScroll() {
    header.classList.toggle('scrolled', window.scrollY > 8);
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  /* Mobile nav */
  var burger = document.querySelector('.nav-burger');
  var mobileNav = document.querySelector('.mobile-nav');
  var closeBtn = document.querySelector('.mobile-nav .nav-close');
  if (burger && mobileNav) {
    function closeNav() {
      mobileNav.classList.remove('open');
      document.body.style.overflow = '';
      burger.setAttribute('aria-expanded', 'false');
    }
    burger.addEventListener('click', function () {
      var open = mobileNav.classList.toggle('open');
      document.body.style.overflow = open ? 'hidden' : '';
      burger.setAttribute('aria-expanded', open);
    });
    if (closeBtn) {
      closeBtn.addEventListener('click', closeNav);
    }
    mobileNav.addEventListener('click', function (e) {
      if (e.target.closest('a')) {
        closeNav();
      }
    });
  }

  /* Hero slider */
  var slider = document.querySelector('[data-slider]');
  if (slider) {
    var slides = slider.querySelectorAll('.hero-slide');
    var dotsWrap = slider.parentElement.querySelector('.hero-controls');
    var current = 0;
    var timer;

    if (dotsWrap) {
      slides.forEach(function (_, i) {
        var b = document.createElement('button');
        b.className = 'hero-dot' + (i === 0 ? ' current' : '');
        b.setAttribute('aria-label', 'Slide ' + (i + 1));
        b.addEventListener('click', function () { go(i); });
        dotsWrap.appendChild(b);
      });
    }
    var dots = dotsWrap ? dotsWrap.querySelectorAll('.hero-dot') : [];

    function go(i) {
      slides[current].classList.remove('current');
      if (dots[current]) dots[current].classList.remove('current');
      current = (i + slides.length) % slides.length;
      slides[current].classList.add('current');
      if (dots[current]) dots[current].classList.add('current');
      restart();
    }
    function restart() {
      clearInterval(timer);
      timer = setInterval(function () { go(current + 1); }, 6500);
    }
    restart();
  }

  /* Scroll reveal — all pages, per-element threshold via data-reveal */
  var revealEls = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window) {
    revealEls.forEach(function (el) {
      var ratio = parseFloat(el.getAttribute('data-reveal'));
      if (!ratio || ratio <= 0 || ratio > 1) ratio = 0.15;
      var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (en) {
          if (en.isIntersecting && en.intersectionRatio >= ratio) {
            en.target.classList.add('in-view');
            io.unobserve(en.target);
          }
        });
      }, { threshold: [ratio] });
      io.observe(el);
    });
  } else {
    revealEls.forEach(function (el) { el.classList.add('in-view'); });
  }

  /* Pillar cards — toggle open on click */
  var pillars = document.querySelectorAll('[data-pillar]');
  pillars.forEach(function (pillar) {
    pillar.addEventListener('click', function () {
      var wasActive = pillar.classList.contains('active');
      pillars.forEach(function (p) { p.classList.remove('active'); });
      if (!wasActive) pillar.classList.add('active');
    });
  });

  /* Footer year */
  document.querySelectorAll('[data-year]').forEach(function (el) {
    el.textContent = new Date().getFullYear();
  });

  /* Timeline slides — fade & blur the slide being covered, tied to scroll progress */
  (function timelineBlur() {
    var rows = Array.prototype.slice.call(document.querySelectorAll('.hist-row'));
    if (rows.length < 2) return;

    var headerH = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--header-h')) || 74;
    var raf = null;

    function update() {
      raf = null;
      var H = window.innerHeight - headerH;   // slide travel as the next one rises
      var range = H - headerH;
      if (range <= 0) return;

      for (var i = 0; i < rows.length - 1; i++) {
        var next = rows[i + 1].getBoundingClientRect().top;
        var p = Math.min(1, Math.max(0, (H - next) / range));
        var content = rows[i].querySelector('.hist-content');
        if (!content) continue;

        content.style.opacity = String(1 - p);
        content.style.filter = p > 0.001 ? 'blur(' + (p * 6).toFixed(2) + 'px)' : '';
        content.style.willChange = 'opacity, filter';
      }
    }

    function onScroll() {
      if (!raf) raf = requestAnimationFrame(update);
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    update();
  })();
})();
