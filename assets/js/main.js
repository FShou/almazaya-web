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

  /* Footer year */
  document.querySelectorAll('[data-year]').forEach(function (el) {
    el.textContent = new Date().getFullYear();
  });
})();
