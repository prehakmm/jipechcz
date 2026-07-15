/* ============================================================
   JIPECH – interaktivita (náhrada React/Framer Motion)
   ============================================================ */
(function () {
  "use strict";

  var CDN = "https://d2xsxph8kpxj0f.cloudfront.net/310519663409095007/oBVC2k3JKqHB8LtcWPftZ3";

  /* ---------- Reveal (framer-motion whileInView) ---------- */
  function initReveal() {
    var els = document.querySelectorAll("[data-reveal]");
    if (!("IntersectionObserver" in window)) {
      els.forEach(function (el) { el.classList.add("is-visible"); });
      return;
    }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) {
          e.target.classList.add("is-visible");
          io.unobserve(e.target);
        }
      });
    }, { threshold: 0, rootMargin: "0px 0px -80px 0px" });
    els.forEach(function (el) { io.observe(el); });
  }

  /* ---------- Mobilní menu ---------- */
  function initMobileMenu() {
    var toggle = document.querySelector("[data-mobile-toggle]");
    var menu = document.querySelector("[data-mobile-menu]");
    if (!toggle || !menu) return;
    var iconMenu = toggle.querySelector("[data-icon-menu]");
    var iconClose = toggle.querySelector("[data-icon-close]");
    function set(open) {
      menu.hidden = !open;
      if (iconMenu) iconMenu.hidden = open;
      if (iconClose) iconClose.hidden = !open;
    }
    toggle.addEventListener("click", function () { set(menu.hidden); });
    menu.querySelectorAll("a").forEach(function (a) {
      a.addEventListener("click", function () { set(false); });
    });
  }

  /* ---------- Galerie dropdown (desktop hover) ---------- */
  function initDropdown() {
    document.querySelectorAll("[data-dropdown]").forEach(function (wrap) {
      var menu = wrap.querySelector("[data-dropdown-menu]");
      if (!menu) return;
      wrap.addEventListener("mouseenter", function () { menu.hidden = false; });
      wrap.addEventListener("mouseleave", function () { menu.hidden = true; });
    });
  }

  /* ---------- Smooth scroll s offsetem na fixed nav ---------- */
  function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(function (a) {
      a.addEventListener("click", function (e) {
        var id = a.getAttribute("href").slice(1);
        if (!id) return;
        var target = document.getElementById(id);
        if (!target) return;
        e.preventDefault();
        target.scrollIntoView({ behavior: "smooth" });
      });
    });
  }

  /* ---------- Galerie + lightbox (homepage) ---------- */
  var GALLERY = [
    { label: "Kuchyně", images: [
      CDN + "/PB050181-scaled_8f3296c9.jpg", CDN + "/PB050180-scaled_54875797.jpg", CDN + "/PB050179-scaled_a2547d7c.jpg",
      CDN + "/PB050178-1-scaled_6b51dbf6.jpg", CDN + "/PB050177-scaled_5a38bb90.jpg", CDN + "/PB050176-scaled_f0b7b779.jpg",
      CDN + "/SAM1650-scaled_349a67f6.jpg", CDN + "/SAM1632-scaled_552fdae0.jpg", CDN + "/SAM1639-scaled_01de02e5.jpg",
      CDN + "/SAM1642-scaled_2885b074.jpg", CDN + "/P8040944-scaled_db728c8a.jpg", CDN + "/P8040943-scaled_41dbc8e1.jpg"
    ]},
    { label: "Obývací pokoje", images: [
      CDN + "/20161002_223515-scaled_dee9e1a6.jpg", CDN + "/20161008_201517-scaled_1673502d.jpg", CDN + "/20161008_201529-scaled_14f2f16e.jpg",
      CDN + "/20161008_201544-scaled_8809d30c.jpg", CDN + "/IMG_20170105_153341-scaled_7872a8b9.jpg", CDN + "/IMG_20170105_153349-scaled_d9ece2f8.jpg"
    ]},
    { label: "Schody", images: [
      CDN + "/2013-04-10-006-scaled_52561fd6.jpg", CDN + "/2013-04-10-007-scaled_5bde440e.jpg", CDN + "/2013-04-10-008-scaled_a2c3c65f.jpg"
    ]},
    { label: "Stoly", images: [
      CDN + "/20150810_202600-scaled_cd7beb90.jpg", CDN + "/20150813_201613-scaled_01178c32.jpg", CDN + "/20150813_201618-scaled_b02336c0.jpg"
    ]},
    { label: "Pergoly", images: [
      CDN + "/20072010124_9df6c56e.jpg", CDN + "/20072010126_35b12829.jpg", CDN + "/20072010128_5fffd019.jpg"
    ]}
  ];

  function initGallery() {
    var tabsWrap = document.querySelector("[data-gallery-tabs]");
    var grid = document.querySelector("[data-gallery-grid]");
    if (!tabsWrap || !grid) return;

    // pokud šablona dodala data-gallery-json, použij ho (WP), jinak default
    var data = GALLERY;
    if (tabsWrap.dataset.galleryJson) {
      try { data = JSON.parse(tabsWrap.dataset.galleryJson); } catch (e) {}
    }

    var active = 0;

    function renderTabs() {
      tabsWrap.innerHTML = "";
      data.forEach(function (cat, i) {
        var btn = document.createElement("button");
        btn.className = "px-5 py-2 rounded-full text-sm font-semibold transition-all";
        btn.style.fontFamily = "'Montserrat', sans-serif";
        btn.style.backgroundColor = i === active ? "oklch(0.62 0.12 55)" : "oklch(0.93 0.02 70)";
        btn.style.color = i === active ? "white" : "oklch(0.40 0.03 45)";
        btn.textContent = cat.label;
        btn.addEventListener("click", function () { active = i; renderTabs(); renderGrid(); });
        tabsWrap.appendChild(btn);
      });
    }

    function renderGrid() {
      grid.innerHTML = "";
      data[active].images.forEach(function (src, i) {
        var cell = document.createElement("div");
        cell.className = "relative overflow-hidden rounded-lg cursor-pointer group";
        cell.style.aspectRatio = "4/3";
        cell.innerHTML =
          '<img src="' + src + '" alt="' + data[active].label + " " + (i + 1) + '" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />' +
          '<div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center" style="background-color: oklch(0.25 0.04 40 / 0.5);">' +
          '<span class="text-white text-sm font-semibold" style="font-family: \'Montserrat\', sans-serif;">Zobrazit</span></div>';
        cell.addEventListener("click", function () { openLightbox(data[active].images, i); });
        grid.appendChild(cell);
      });
    }

    renderTabs();
    renderGrid();
  }

  /* ---------- Lightbox (sdílený) ---------- */
  var lb = { images: [], index: 0, el: null };

  function buildLightbox() {
    var overlay = document.createElement("div");
    overlay.className = "fixed inset-0 z-50 flex items-center justify-center p-4";
    overlay.style.backgroundColor = "oklch(0.1 0 0 / 0.92)";
    overlay.innerHTML =
      '<button data-lb-close class="absolute top-4 right-4 text-white p-2 rounded-full z-10" style="background-color: oklch(0.3 0 0 / 0.6);"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg></button>' +
      '<button data-lb-prev class="absolute left-4 top-1/2 -translate-y-1/2 text-white p-3 rounded-full z-10 transition-all hover:scale-110" style="background-color: oklch(0.3 0 0 / 0.6);"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"></path></svg></button>' +
      '<button data-lb-next class="absolute right-4 top-1/2 -translate-y-1/2 text-white p-3 rounded-full z-10 transition-all hover:scale-110" style="background-color: oklch(0.3 0 0 / 0.6);"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"></path></svg></button>' +
      '<img data-lb-img class="max-w-full max-h-[85vh] rounded-lg shadow-2xl object-contain" src="" alt="Galerie" />' +
      '<div data-lb-counter class="absolute bottom-6 left-1/2 -translate-x-1/2 text-sm font-semibold px-4 py-1.5 rounded-full" style="background-color: oklch(0.2 0 0 / 0.7); color: white; font-family: \'Montserrat\', sans-serif;"></div>';
    overlay.addEventListener("click", function (e) { if (e.target === overlay) closeLightbox(); });
    overlay.querySelector("[data-lb-close]").addEventListener("click", closeLightbox);
    overlay.querySelector("[data-lb-prev]").addEventListener("click", function (e) { e.stopPropagation(); step(-1); });
    overlay.querySelector("[data-lb-next]").addEventListener("click", function (e) { e.stopPropagation(); step(1); });
    overlay.querySelector("[data-lb-img]").addEventListener("click", function (e) { e.stopPropagation(); });
    document.body.appendChild(overlay);
    lb.el = overlay;
  }

  function openLightbox(images, index, counterFmt) {
    if (!lb.el) buildLightbox();
    lb.images = images;
    lb.index = index;
    lb.counterFmt = counterFmt || null;
    lb.el.style.display = "flex";
    update();
  }
  function closeLightbox() { if (lb.el) lb.el.style.display = "none"; }
  function step(d) { lb.index = (lb.index + d + lb.images.length) % lb.images.length; update(); }
  function update() {
    lb.el.querySelector("[data-lb-img]").src = lb.images[lb.index];
    var c = lb.el.querySelector("[data-lb-counter]");
    c.textContent = lb.counterFmt ? lb.counterFmt(lb.index, lb.images.length) : (lb.index + 1) + " / " + lb.images.length;
  }
  document.addEventListener("keydown", function (e) {
    if (!lb.el || lb.el.style.display === "none") return;
    if (e.key === "ArrowRight") step(1);
    else if (e.key === "ArrowLeft") step(-1);
    else if (e.key === "Escape") closeLightbox();
  });
  // vystavit pro kuchyne.js
  window.JIPECH = window.JIPECH || {};
  window.JIPECH.openLightbox = openLightbox;

  /* ---------- Cenový posuvník ---------- */
  function initSliders() {
    document.querySelectorAll("[data-slider]").forEach(function (wrap) {
      var input = wrap.querySelector('input[type="range"]');
      var fill = wrap.querySelector("[data-slider-fill]");
      var thumb = wrap.querySelector("[data-slider-thumb]");
      if (!input) return;
      var min = Number(input.min), max = Number(input.max);
      var form = wrap.closest("form");
      var valueEl = form ? form.querySelector("[data-budget-value]") : null;
      function fmt(v) { return v >= max ? (max.toLocaleString("cs-CZ") + " Kč+") : (v.toLocaleString("cs-CZ") + " Kč"); }
      function upd() {
        var v = Number(input.value);
        var pct = ((v - min) / (max - min)) * 100;
        if (fill) fill.style.width = pct + "%";
        if (thumb) thumb.style.left = "calc(" + pct + "% - 10px)";
        if (valueEl) valueEl.textContent = fmt(v);
      }
      input.addEventListener("input", upd);
      upd();
    });
  }

  /* ---------- Dropzone / seznam souborů ---------- */
  function initDropzones() {
    document.querySelectorAll("[data-dropzone]").forEach(function (zone) {
      var input = zone.querySelector('input[type="file"]');
      var list = zone.parentElement.querySelector("[data-file-list]");
      if (!input) return;
      var files = [];
      function render() {
        if (!list) return;
        list.innerHTML = "";
        files.forEach(function (file, idx) {
          var li = document.createElement("li");
          li.className = "flex items-center justify-between gap-3 px-3 py-2 rounded-lg";
          li.style.backgroundColor = "oklch(0.95 0.02 70)";
          li.innerHTML =
            '<div class="flex items-center gap-2 min-w-0">' +
            '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: oklch(0.62 0.12 55); flex-shrink:0;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>' +
            '<span class="text-xs truncate" style="color: oklch(0.35 0.04 50);">' + file.name + '</span>' +
            '<span class="text-xs flex-shrink-0" style="color: oklch(0.60 0.03 55);">(' + (file.size / 1024).toFixed(0) + ' kB)</span></div>' +
            '<button type="button" class="flex-shrink-0 w-5 h-5 rounded-full flex items-center justify-center hover:opacity-80 transition-opacity" style="background-color: oklch(0.577 0.245 27.325 / 0.15); color: oklch(0.577 0.245 27.325);"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>';
          li.querySelector("button").addEventListener("click", function (e) {
            e.stopPropagation(); files.splice(idx, 1); render(); syncInput();
          });
          list.appendChild(li);
        });
      }
      function syncInput() {
        var dt = new DataTransfer();
        files.forEach(function (f) { dt.items.add(f); });
        input.files = dt.files;
      }
      function add(fileList) {
        Array.prototype.slice.call(fileList).forEach(function (f) {
          if (f.size <= 10 * 1024 * 1024) files.push(f);
        });
        files = files.slice(0, 5);
        render(); syncInput();
      }
      zone.addEventListener("click", function () { input.click(); });
      zone.addEventListener("dragover", function (e) { e.preventDefault(); zone.style.borderColor = "oklch(0.62 0.12 55)"; zone.style.backgroundColor = "oklch(0.96 0.03 70)"; });
      zone.addEventListener("dragleave", function () { zone.style.borderColor = "oklch(0.82 0.04 65)"; zone.style.backgroundColor = "oklch(0.98 0.01 80)"; });
      zone.addEventListener("drop", function (e) { e.preventDefault(); zone.style.borderColor = "oklch(0.82 0.04 65)"; zone.style.backgroundColor = "oklch(0.98 0.01 80)"; add(e.dataTransfer.files); });
      input.addEventListener("change", function () { add(input.files); });
    });
  }

  /* ---------- Odeslání formuláře ---------- */
  function successHtml(type) {
    var bigText = type === "b2b"
      ? { title: "Firemní poptávka odeslána!", text: "Děkujeme za váš zájem o spolupráci. Ozveme se vám do 24 hodin v pracovní dny. Pro rychlejší odpověď nás zavolejte.", pad: "p-12", icon: 64 }
      : { title: "Poptávka odeslána!", text: "Děkujeme za vaši poptávku. Ozveme se vám co nejdříve. Pro rychlejší odpověď nás neváhejte zavolat.", pad: "p-10", icon: 56 };
    return '<div class="rounded-xl ' + bigText.pad + ' text-center" style="background-color: oklch(0.99 0.005 80);">' +
      '<svg width="' + bigText.icon + '" height="' + bigText.icon + '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-auto mb-4" style="color: oklch(0.32 0.09 145);"><path d="M21.801 10A10 10 0 1 1 17 3.335"></path><path d="m9 11 3 3L22 4"></path></svg>' +
      '<h3 class="text-2xl font-bold mb-3" style="font-family: \'Playfair Display\', serif;">' + bigText.title + '</h3>' +
      '<p class="text-base mb-6" style="color: oklch(0.40 0.03 45);">' + bigText.text + '</p>' +
      '<a href="tel:+420603265873" class="inline-flex items-center gap-2 px-6 py-3 rounded font-bold" style="background-color: oklch(0.32 0.09 145); color: white; font-family: \'Montserrat\', sans-serif;">' +
      '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>' +
      '+420 603 265 873</a></div>';
  }

  function initForms() {
    document.querySelectorAll("[data-contact-form]").forEach(function (form) {
      form.addEventListener("submit", function (e) {
        e.preventDefault();
        var errEl = form.querySelector("[data-form-error]");
        if (errEl) { errEl.style.display = "none"; }
        var type = form.getAttribute("data-form-type") || "main";
        function done() { form.outerHTML = successHtml(type); }
        function fail(msg) { if (errEl) { errEl.textContent = msg; errEl.style.display = "block"; } }

        if (window.JIPECH_DATA && form.dataset.ajax === "1") {
          var fd = new FormData(form);
          fd.append("action", "jipech_submit");
          var btn = form.querySelector('button[type="submit"]');
          if (btn) { btn.disabled = true; }
          fetch(window.JIPECH_DATA.ajaxUrl, { method: "POST", credentials: "same-origin", body: fd })
            .then(function (r) { return r.json(); })
            .then(function (res) {
              if (res && res.success) { done(); }
              else { fail(res && res.data ? res.data.message : "Odeslání se nezdařilo."); if (btn) { btn.disabled = false; } }
            })
            .catch(function () { fail("Odeslání se nezdařilo. Zavolejte nám prosím."); if (btn) { btn.disabled = false; } });
        } else {
          // Statická verze bez backendu – simulace úspěchu.
          done();
        }
      });
    });
  }

  document.addEventListener("DOMContentLoaded", function () {
    initReveal();
    initMobileMenu();
    initDropdown();
    initSmoothScroll();
    initGallery();
    initSliders();
    initDropzones();
    initForms();
  });
})();
