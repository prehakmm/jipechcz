/* Kuchyně – galerie realizací (WordPress; data z JIPECH_KUCHYNE) */
(function () {
  "use strict";

  var data = (window.JIPECH_KUCHYNE && window.JIPECH_KUCHYNE.realizace) ? window.JIPECH_KUCHYNE.realizace : [];

  var filterWrap = document.querySelector("[data-kuchyne-filter]");
  var grid = document.querySelector("[data-kuchyne-grid]");
  var heading = document.querySelector("[data-kuchyne-heading]");
  var headingTitle = document.querySelector("[data-kuchyne-heading-title]");
  var headingSub = document.querySelector("[data-kuchyne-heading-sub]");
  if (!filterWrap || !grid) return;

  var ALL = [];
  data.forEach(function (r) {
    r.photos.forEach(function (src, i) { ALL.push({ src: src, letter: r.letter, title: r.title, localIdx: i }); });
  });

  var cntR = document.querySelector("[data-count-realizace]");
  var cntP = document.querySelector("[data-count-photos]");
  if (cntR) cntR.textContent = data.length;
  if (cntP) cntP.textContent = ALL.length;

  // Prázdná galerie – ponech výchozí obsah šablony.
  if (!data.length) return;

  var active = "vse";

  function filtered() {
    if (active === "vse") return ALL;
    var r = data.filter(function (x) { return x.title === active; })[0];
    return r ? r.photos.map(function (src, i) { return { src: src, letter: r.letter, title: r.title, localIdx: i }; }) : [];
  }

  function mkBtn(label, id) {
    var b = document.createElement("button");
    b.className = "flex-shrink-0 px-4 py-1.5 rounded-full text-sm font-semibold transition-all";
    b.style.fontFamily = "'Montserrat', sans-serif";
    b.style.backgroundColor = active === id ? "oklch(0.62 0.12 55)" : "oklch(0.93 0.02 70)";
    b.style.color = active === id ? "white" : "oklch(0.35 0.04 45)";
    b.textContent = label;
    b.addEventListener("click", function () { active = id; renderFilter(); renderGrid(); });
    return b;
  }

  function renderFilter() {
    filterWrap.innerHTML = "";
    filterWrap.appendChild(mkBtn("Vše (" + ALL.length + ")", "vse"));
    data.forEach(function (r) {
      filterWrap.appendChild(mkBtn(r.title + " (" + r.photos.length + ")", r.title));
    });
  }

  function renderGrid() {
    var photos = filtered();
    grid.innerHTML = "";
    if (active !== "vse" && heading) {
      heading.hidden = false;
      headingTitle.textContent = active;
      headingSub.textContent = photos.length + " fotografií z této realizace";
    } else if (heading) {
      heading.hidden = true;
    }
    var srcs = photos.map(function (p) { return p.src; });
    var letters = photos.map(function (p) { return p.letter; });
    photos.forEach(function (photo, idx) {
      var cell = document.createElement("div");
      cell.className = "group relative overflow-hidden rounded-lg cursor-pointer";
      cell.style.aspectRatio = "4/3";
      cell.style.backgroundColor = "oklch(0.93 0.02 70)";
      cell.innerHTML =
        '<img src="' + photo.src + '" alt="Kuchyně ' + photo.title + ' – foto ' + (photo.localIdx + 1) + '" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" loading="lazy" />' +
        '<div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-2" style="background: linear-gradient(to top, oklch(0.15 0.04 40 / 0.7) 0%, transparent 60%);">' +
        '<span class="text-xs font-bold text-white" style="font-family: \'Montserrat\', sans-serif;">' + photo.letter + ' · ' + (photo.localIdx + 1) + '</span></div>';
      cell.addEventListener("click", function () {
        window.JIPECH.openLightbox(srcs, idx, function (i, len) {
          return "Realizace " + letters[i] + " · " + (i + 1) + " / " + len;
        });
      });
      grid.appendChild(cell);
    });
  }

  renderFilter();
  renderGrid();
})();
