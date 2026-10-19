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

  /* Desktop dropdown nav — click to open (touch/tablet friendly).
     First click opens the submenu, second click follows the parent link. */
  var dropTriggers = document.querySelectorAll('.main-nav .has-sub > a');
  dropTriggers.forEach(function (trigger) {
    trigger.addEventListener('click', function (e) {
      var item = trigger.parentElement;
      var wasOpen = item.classList.contains('open');
      document.querySelectorAll('.main-nav .has-sub.open').forEach(function (o) { o.classList.remove('open'); });
      if (!wasOpen) {
        e.preventDefault();
        item.classList.add('open');
      }
    });
  });
  document.addEventListener('click', function (e) {
    if (!e.target.closest('.main-nav .has-sub')) {
      document.querySelectorAll('.main-nav .has-sub.open').forEach(function (o) { o.classList.remove('open'); });
    }
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      document.querySelectorAll('.main-nav .has-sub.open').forEach(function (o) { o.classList.remove('open'); });
    }
  });

  /* Filter chips — berita & galeri (items carry data-cat) */
  document.querySelectorAll('.filter-row').forEach(function (row) {
    var chips = row.querySelectorAll('.filter-chip');
    var section = row.closest('section');
    if (!section) return;
    var items = section.querySelectorAll('[data-cat]');
    var empty = section.querySelector('[data-filter-empty]');
    if (!items.length) return;
    chips.forEach(function (chip) {
      chip.addEventListener('click', function () {
        chips.forEach(function (c) { c.classList.remove('active'); });
        chip.classList.add('active');
        var showAll = /semua|all/i.test(chip.textContent);
        var n = 0;
        items.forEach(function (it) {
          var hit = showAll || it.getAttribute('data-cat') === chip.textContent.trim();
          it.style.display = hit ? '' : 'none';
          if (hit) n++;
        });
        if (empty) empty.hidden = n > 0;
      });
    });
  });

  /* Gallery lightbox — full screen: slide through photos + thumbnail previews */
  (function galleryLightbox() {
    var all = Array.prototype.slice.call(document.querySelectorAll('.gallery-bento .img-slot'));
    if (!all.length) return;
    var ov = document.createElement('div');
    ov.className = 'gal-lightbox';
    ov.innerHTML = '<button class="gal-lb-close" aria-label="Tutup">\u00D7</button>' +
      '<span class="gal-lb-count" aria-live="polite"></span>' +
      '<button class="gal-lb-prev" aria-label="Sebelumnya">\u2039</button>' +
      '<button class="gal-lb-next" aria-label="Berikutnya">\u203A</button>' +
      '<div class="gal-lb-stage">' +
        '<figure><img alt=""><figcaption></figcaption></figure>' +
        '<div class="gal-lb-thumbs" role="tablist" aria-label="Pratinjau foto"></div>' +
      '</div>';
    document.body.appendChild(ov);
    var img = ov.querySelector('figure img');
    var cap = ov.querySelector('figcaption');
    var count = ov.querySelector('.gal-lb-count');
    var thumbs = ov.querySelector('.gal-lb-thumbs');
    var items = [], idx = 0;

    function src(el) { var im = el.querySelector('img'); return im ? (im.currentSrc || im.src) : ''; }
    function captionOf(el) {
      var label = el.querySelector('.gal-label');
      var im = el.querySelector('img');
      return label ? label.textContent : (im ? im.alt : '');
    }
    function buildThumbs() {
      thumbs.innerHTML = '';
      items.forEach(function (el, i) {
        var t = document.createElement('button');
        t.type = 'button';
        t.className = 'gal-lb-thumb';
        t.setAttribute('role', 'tab');
        t.setAttribute('aria-label', 'Foto ' + (i + 1));
        var ti = document.createElement('img');
        ti.src = src(el);
        ti.alt = '';
        t.appendChild(ti);
        t.addEventListener('click', function (e) { e.stopPropagation(); show(i); });
        thumbs.appendChild(t);
      });
    }
    function show(i) {
      if (!items.length) return;
      idx = ((i % items.length) + items.length) % items.length;
      var el = items[idx];
      img.src = src(el);
      img.alt = captionOf(el);
      cap.textContent = captionOf(el);
      count.textContent = (idx + 1) + ' / ' + items.length;
      Array.prototype.forEach.call(thumbs.children, function (t, n) {
        t.classList.toggle('active', n === idx);
      });
      var act = thumbs.children[idx];
      if (act && act.scrollIntoView) act.scrollIntoView({ block: 'nearest', inline: 'center' });
    }
    function open(el) {
      items = all.filter(function (x) { return getComputedStyle(x).display !== 'none'; });
      if (!items.length) items = all.slice();
      buildThumbs();
      var i = items.indexOf(el);
      show(i < 0 ? 0 : i);
      ov.classList.add('open');
      document.body.classList.add('modal-open');
    }
    function hide() {
      ov.classList.remove('open');
      document.body.classList.remove('modal-open');
    }
    all.forEach(function (it) {
      it.style.cursor = 'zoom-in';
      it.addEventListener('click', function () { open(it); });
    });
    ov.querySelector('.gal-lb-close').addEventListener('click', hide);
    ov.querySelector('.gal-lb-prev').addEventListener('click', function (e) { e.stopPropagation(); show(idx - 1); });
    ov.querySelector('.gal-lb-next').addEventListener('click', function (e) { e.stopPropagation(); show(idx + 1); });
    ov.addEventListener('click', function (e) {
      if (e.target === ov || e.target.classList.contains('gal-lb-stage')) hide();
    });
    document.addEventListener('keydown', function (e) {
      if (!ov.classList.contains('open')) return;
      if (e.key === 'Escape') hide();
      if (e.key === 'ArrowLeft') show(idx - 1);
      if (e.key === 'ArrowRight') show(idx + 1);
    });
    var sx = 0, sy = 0;
    ov.addEventListener('touchstart', function (e) {
      sx = e.touches[0].clientX; sy = e.touches[0].clientY;
    }, { passive: true });
    ov.addEventListener('touchend', function (e) {
      var dx = e.changedTouches[0].clientX - sx;
      var dy = e.changedTouches[0].clientY - sy;
      if (Math.abs(dx) > 45 && Math.abs(dx) > Math.abs(dy)) show(idx + (dx < 0 ? 1 : -1));
    }, { passive: true });
  })();

  /* Article table of contents — built from h2s, works on any article */
  (function articleToc() {
    var box = document.querySelector('.art-paras, #art-paras');
    if (!box) return;
    var heads = box.querySelectorAll('h2');
    if (heads.length < 2) return;
    var isId = (document.documentElement.lang || 'id').toLowerCase().indexOf('id') === 0;
    function slug(s, i) {
      s = s.toLowerCase().trim().replace(/[^a-z0-9\u00C0-\u024F\u1E00-\u1EFF\s-]/g, '').replace(/[\s-]+/g, '-').replace(/^-+|-+$/g, '');
      return (s || 'bagian') + '-' + (i + 1);
    }
    var nav = document.createElement('nav');
    nav.className = 'art-toc';
    nav.setAttribute('aria-label', isId ? 'Daftar isi' : 'Contents');
    var title = document.createElement('strong');
    title.textContent = isId ? 'Daftar Isi' : 'Contents';
    var ul = document.createElement('ul');
    heads.forEach(function (h, i) {
      if (!h.id) h.id = slug(h.textContent, i);
      var li = document.createElement('li');
      var a = document.createElement('a');
      a.href = '#' + h.id;
      a.textContent = h.textContent;
      li.appendChild(a);
      ul.appendChild(li);
    });
    nav.appendChild(title);
    nav.appendChild(ul);
    box.insertBefore(nav, box.firstChild);
  })();

  /* Overseas map: auto-fit viewBox to dots on mobile (all visible, bigger) */
  (function mapFit() {
    function fit() {
      if (!window.matchMedia('(max-width: 640px)').matches) return;
      var svg = document.querySelector('svg.world-map');
      if (!svg) return;
      var dots = svg.querySelectorAll('.map-dest');
      if (!dots.length) return;
      var minX = 1e9, minY = 1e9, maxX = -1e9, maxY = -1e9;
      dots.forEach(function (g) {
        var c = g.querySelector('circle.map-marker') || g.querySelector('circle');
        if (!c) return;
        var cx = parseFloat(c.getAttribute('cx')), cy = parseFloat(c.getAttribute('cy'));
        if (isNaN(cx) || isNaN(cy)) return;
        minX = Math.min(minX, cx); maxX = Math.max(maxX, cx);
        minY = Math.min(minY, cy); maxY = Math.max(maxY, cy);
      });
      if (minX > maxX) return;
      var pad = 90;
      minX -= pad; minY -= pad; maxX += pad; maxY += pad;
      var w = Math.max(maxX - minX, 320), h = Math.max(maxY - minY, 300);
      minX = Math.max(0, Math.min(minX, 1000 - w));
      minY = Math.max(0, Math.min(minY, 480 - h));
      svg.setAttribute('viewBox', minX + ' ' + minY + ' ' + w + ' ' + h);
      var shell = svg.closest('.map-shell');
      if (shell && shell.scrollWidth > shell.clientWidth + 4) {
        shell.scrollLeft = (shell.scrollWidth - shell.clientWidth) / 2;
      }
    }
    fit();
    var t;
    window.addEventListener('orientationchange', function () { clearTimeout(t); t = setTimeout(fit, 300); });
  })();

  /* Pillar cards — toggle open on click */
  var pillars = document.querySelectorAll('[data-pillar]');
  pillars.forEach(function (pillar) {
    pillar.addEventListener('click', function () {
      var wasActive = pillar.classList.contains('active');
      pillars.forEach(function (p) { p.classList.remove('active'); });
      if (!wasActive) pillar.classList.add('active');
    });
  });

  /* Programs carousel — prev/next under a scroll-snap track */
  var progTrack = document.getElementById('prog-track');
  if (progTrack) {
    var progCard = progTrack.querySelector('.mc-peek');
    var progStep = function () {
      var w = progCard ? progCard.offsetWidth + 18 : 250;
      return w;
    };
    window.progMove = function (dir) {
      progTrack.scrollBy({ left: dir * progStep(), behavior: 'smooth' });
    };
    progTrack.addEventListener('scroll', function () {
      var max = progTrack.scrollWidth - progTrack.clientWidth;
      var atEnd = progTrack.scrollLeft >= max - 4;
      var atStart = progTrack.scrollLeft <= 4;
      progTrack.classList.toggle('is-end', atEnd);
      progTrack.classList.toggle('is-start', atStart);
    });
  }

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
