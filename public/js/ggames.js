/* GGAMES front-end behaviour: image carousels, modals, inline game detail,
 * admin game form with live image previews, and a tiny price-trend chart.
 * Dependency-free (vanilla JS). */
(function () {
    'use strict';

    /* ---------- helpers ---------- */
    function esc(s) {
        return String(s == null ? '' : s)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    }
    function fmtPrice(p) {
        if (p === null || p === undefined || p === '' || String(p).toLowerCase() === 'gratis') return 'Gratis';
        var n = parseFloat(p);
        return isNaN(n) ? String(p) : n.toFixed(2) + ' CHF';
    }
    function priceValue(p) {
        if (p === null || p === undefined || String(p).toLowerCase() === 'gratis') return 0;
        var n = parseFloat(p);
        return isNaN(n) ? 0 : n;
    }

    /* ---------- carousels (hover auto-advance + manual arrows) ---------- */
    function initCarousel(el) {
        if (!el || el.dataset.carouselReady) return;
        el.dataset.carouselReady = '1';
        var slides = el.querySelectorAll('[data-slide]');
        var dots = el.querySelectorAll('[data-dot]');
        if (slides.length < 2) return;
        var i = 0, timer = null;

        function show(n) {
            i = (n + slides.length) % slides.length;
            slides.forEach(function (s, k) { s.classList.toggle('opacity-0', k !== i); });
            dots.forEach(function (d, k) {
                d.classList.toggle('bg-brand-orange', k === i);
                d.classList.toggle('bg-white/40', k !== i);
            });
        }
        function next() { show(i + 1); }
        function prev() { show(i - 1); }

        el.addEventListener('mouseenter', function () {
            if (timer) return;
            timer = setInterval(next, 1100);
        });
        el.addEventListener('mouseleave', function () {
            clearInterval(timer); timer = null; show(0);
        });
        var nx = el.querySelector('[data-next]'), pv = el.querySelector('[data-prev]');
        if (nx) nx.addEventListener('click', function (e) { e.preventDefault(); e.stopPropagation(); next(); });
        if (pv) pv.addEventListener('click', function (e) { e.preventDefault(); e.stopPropagation(); prev(); });
        show(0);
    }
    function initAllCarousels(root) {
        (root || document).querySelectorAll('[data-carousel]').forEach(initCarousel);
    }

    /* ---------- hero showcase (always-on auto-rotation) ---------- */
    function initShowcase(el) {
        if (!el || el.dataset.showReady) return;
        el.dataset.showReady = '1';
        var slides = el.querySelectorAll('[data-show-slide]');
        var dots = el.querySelectorAll('[data-show-dot]');
        if (slides.length === 0) return;
        var i = 0, timer = null;

        function show(n) {
            i = (n + slides.length) % slides.length;
            slides.forEach(function (s, k) {
                s.classList.toggle('opacity-0', k !== i);
                s.classList.toggle('pointer-events-none', k !== i);
            });
            dots.forEach(function (d, k) {
                d.classList.toggle('w-6', k === i);
                d.classList.toggle('bg-brand-orange', k === i);
                d.classList.toggle('w-2', k !== i);
                d.classList.toggle('bg-white/40', k !== i);
            });
        }
        function next() { show(i + 1); }
        function start() { stop(); if (slides.length > 1) timer = setInterval(next, 4500); }
        function stop() { if (timer) { clearInterval(timer); timer = null; } }

        el.querySelectorAll('[data-show-next]').forEach(function (b) { b.addEventListener('click', function () { next(); start(); }); });
        el.querySelectorAll('[data-show-prev]').forEach(function (b) { b.addEventListener('click', function () { show(i - 1); start(); }); });
        dots.forEach(function (d, k) { d.addEventListener('click', function () { show(k); start(); }); });
        el.addEventListener('mouseenter', stop);
        el.addEventListener('mouseleave', start);
        show(0); start();
    }
    function initAllShowcases(root) {
        (root || document).querySelectorAll('[data-showcase]').forEach(initShowcase);
    }

    /* ---------- modals ---------- */
    function openModal(id) {
        var m = document.getElementById(id);
        if (!m) return;
        m.classList.remove('hidden'); m.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
        var m = document.getElementById(id);
        if (!m) return;
        m.classList.add('hidden'); m.classList.remove('flex');
        document.body.style.overflow = '';
    }
    document.addEventListener('click', function (e) {
        var c = e.target.closest('[data-close-modal]');
        if (c) { closeModal(c.getAttribute('data-close-modal')); }
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.gg-modal:not(.hidden)').forEach(function (m) { closeModal(m.id); });
        }
    });

    /* ---------- inline game detail ---------- */
    function carouselMarkup(images, big) {
        images = images && images.length ? images : ['assets/favicon.ico'];
        var h = big ? 'h-72 sm:h-96' : 'h-44';
        var slides = images.map(function (src, k) {
            return '<img data-slide src="' + esc(src) + '" alt="" class="absolute inset-0 h-full w-full object-cover transition-opacity duration-500 ' + (k === 0 ? '' : 'opacity-0') + '">';
        }).join('');
        var controls = '';
        if (images.length > 1) {
            var dots = images.map(function (_, k) {
                return '<span data-dot class="h-1.5 w-1.5 rounded-full ' + (k === 0 ? 'bg-brand-orange' : 'bg-white/40') + '"></span>';
            }).join('');
            controls =
                '<button data-prev class="absolute left-2 top-1/2 -translate-y-1/2 rounded-full bg-black/50 px-2 py-1 text-white hover:bg-black/70"><i class="fas fa-chevron-left"></i></button>' +
                '<button data-next class="absolute right-2 top-1/2 -translate-y-1/2 rounded-full bg-black/50 px-2 py-1 text-white hover:bg-black/70"><i class="fas fa-chevron-right"></i></button>' +
                '<div class="absolute bottom-2 left-1/2 flex -translate-x-1/2 gap-1.5">' + dots + '</div>';
        }
        return '<div data-carousel class="relative ' + h + ' w-full overflow-hidden rounded-xl bg-neutral-800">' + slides + controls + '</div>';
    }

    function renderDetail(g) {
        var dropped = g.price_dropped && g.previous_price != null;
        var priceBlock =
            '<div class="flex items-center gap-3">' +
                (dropped ? '<span class="text-lg text-neutral-500 line-through">' + esc(fmtPrice(g.previous_price)) + '</span>' : '') +
                '<span class="text-2xl font-bold ' + (String(g.price).toLowerCase() === 'gratis' ? 'text-brand-green' : 'text-white') + '">' + esc(fmtPrice(g.price)) + '</span>' +
                (dropped ? '<span class="chip bg-brand-green/20 text-brand-green"><i class="fas fa-arrow-trend-down"></i> Preis gesenkt</span>' : '') +
            '</div>';

        var buyBtn = '';
        if (g.can_buy) {
            buyBtn = '<a href="buyGame?id=' + g.id + '" class="btn-primary"><i class="fas fa-shopping-bag"></i> ' +
                (String(g.price).toLowerCase() === 'gratis' ? 'Holen' : 'Jetzt kaufen') + '</a>';
        } else if (g.owned) {
            buyBtn = '<span class="btn-green cursor-default"><i class="fas fa-check"></i> Gekauft</span>';
        } else {
            buyBtn = '<a href="login" class="btn-primary"><i class="fas fa-sign-in-alt"></i> Zum Kauf anmelden</a>';
        }

        var friends = '';
        if (g.friends_who_own && g.friends_who_own.length) {
            friends = '<div class="mt-6"><h4 class="mb-2 text-sm font-semibold text-neutral-300"><i class="fas fa-user-group text-brand-green"></i> Freunde, die das Spiel besitzen</h4>' +
                '<div class="flex flex-wrap gap-2">' + g.friends_who_own.map(function (f) {
                    return '<span class="chip bg-neutral-800 text-neutral-200"><i class="fas fa-user text-brand-green"></i> ' + esc(f.username) + '</span>';
                }).join('') + '</div></div>';
        }

        var buyers = '';
        if (g.buyers_per_price && g.buyers_per_price.length) {
            buyers = '<div class="mt-6"><h4 class="mb-2 text-sm font-semibold text-neutral-300"><i class="fas fa-users"></i> Käufe pro Preis</h4>' +
                '<div class="space-y-1">' + g.buyers_per_price.map(function (b) {
                    return '<div class="flex items-center justify-between text-sm"><span class="text-neutral-400">' + esc(fmtPrice(b.price_paid)) + '</span><span class="font-semibold text-neutral-200">' + b.buyers + '×</span></div>';
                }).join('') + '</div></div>';
        }

        var trend = '';
        if (g.price_history && g.price_history.length > 1) {
            trend = '<div class="mt-6"><h4 class="mb-2 text-sm font-semibold text-neutral-300"><i class="fas fa-chart-line text-brand-orange"></i> Preisverlauf</h4>' +
                '<div id="priceChart" class="rounded-lg border border-neutral-800 bg-neutral-950 p-2"></div></div>';
        }

        var recs = '';
        if (g.recommendations && g.recommendations.length) {
            recs = '<div class="mt-8"><h4 class="mb-3 text-sm font-semibold text-neutral-300"><i class="fas fa-thumbs-up text-brand-orange"></i> Empfohlene Spiele</h4>' +
                '<div class="grid grid-cols-2 gap-3 sm:grid-cols-4">' + g.recommendations.map(function (r) {
                    var img = (r.images && r.images[0]) || 'assets/favicon.ico';
                    return '<button onclick="GG.openDetail(' + r.id + ')" class="group text-left">' +
                        '<div class="h-24 w-full overflow-hidden rounded-lg bg-neutral-800"><img src="' + esc(img) + '" class="h-full w-full object-cover transition group-hover:scale-105"></div>' +
                        '<p class="mt-1 truncate text-xs font-medium text-neutral-300">' + esc(r.name) + '</p></button>';
                }).join('') + '</div></div>';
        }

        var apiNote = g.api_enriched ? '<span class="chip bg-brand-orange/20 text-brand-orange"><i class="fas fa-database"></i> RAWG</span>' : '';

        return '' +
            '<div class="grid gap-6 lg:grid-cols-2">' +
                '<div>' + carouselMarkup(g.images, true) + '</div>' +
                '<div>' +
                    '<div class="flex items-start justify-between gap-2">' +
                        '<h2 class="font-display text-2xl text-white">' + esc(g.name) + '</h2>' + apiNote +
                    '</div>' +
                    '<p class="mt-1 text-sm text-neutral-400"><i class="fas fa-code"></i> ' + esc(g.entwickler) + '</p>' +
                    '<div class="mt-4">' + priceBlock + '</div>' +
                    '<div class="mt-4 flex gap-2">' + buyBtn + '</div>' +
                    friends + buyers + trend +
                '</div>' +
            '</div>' +
            '<div class="mt-6"><h4 class="mb-2 text-sm font-semibold text-neutral-300">Beschreibung</h4>' +
                '<p class="leading-relaxed text-neutral-300">' + esc(g.description || 'Keine Beschreibung vorhanden.') + '</p></div>' +
            recs;
    }

    function drawPriceChart(g) {
        var c = document.getElementById('priceChart');
        if (!c || !g.price_history || g.price_history.length < 2) return;
        var pts = g.price_history.map(function (p) { return priceValue(p.price); });
        var w = c.clientWidth || 400, h = 90, pad = 8;
        var max = Math.max.apply(null, pts) || 1, min = Math.min.apply(null, pts);
        var span = (max - min) || 1;
        var step = (w - pad * 2) / (pts.length - 1);
        var coords = pts.map(function (v, k) {
            var x = pad + k * step;
            var y = h - pad - ((v - min) / span) * (h - pad * 2);
            return [x, y];
        });
        var line = coords.map(function (p) { return p[0].toFixed(1) + ',' + p[1].toFixed(1); }).join(' ');
        var dotsSvg = coords.map(function (p) { return '<circle cx="' + p[0].toFixed(1) + '" cy="' + p[1].toFixed(1) + '" r="3" fill="#f97316"/>'; }).join('');
        c.innerHTML =
            '<svg viewBox="0 0 ' + w + ' ' + h + '" class="w-full" preserveAspectRatio="none" style="height:90px">' +
                '<polyline points="' + line + '" fill="none" stroke="#f97316" stroke-width="2"/>' + dotsSvg +
            '</svg>' +
            '<div class="mt-1 flex justify-between text-xs text-neutral-500"><span>' + fmtPrice(g.price_history[0].price) + '</span><span>' + fmtPrice(g.price_history[g.price_history.length - 1].price) + '</span></div>';
    }

    function openDetail(id) {
        openModal('detailModal');
        var body = document.getElementById('detailBody');
        if (body) body.innerHTML = '<div class="p-12 text-center text-neutral-400"><i class="fas fa-spinner fa-spin"></i> Laden…</div>';
        fetch('gameDetail?id=' + encodeURIComponent(id))
            .then(function (r) { return r.json(); })
            .then(function (g) {
                if (!g || g.error) throw new Error('not found');
                body.innerHTML = renderDetail(g);
                initAllCarousels(body);
                drawPriceChart(g);
            })
            .catch(function () {
                if (body) body.innerHTML = '<div class="p-12 text-center text-red-400">Fehler beim Laden des Spiels.</div>';
            });
    }

    /* ---------- admin game form (add / edit) ---------- */
    function addImageInput(value) {
        value = value || '';
        var wrap = document.getElementById('imageInputs');
        if (!wrap) return;
        var row = document.createElement('div');
        row.className = 'flex items-start gap-2';
        row.innerHTML =
            '<div class="h-16 w-24 shrink-0 overflow-hidden rounded-lg border border-neutral-700 bg-neutral-800">' +
                '<img class="gg-prev h-full w-full object-cover ' + (value ? '' : 'hidden') + '" src="' + esc(value) + '">' +
            '</div>' +
            '<input name="images[]" class="input gg-src" placeholder="Bild-URL oder base64-String…" value="' + esc(value) + '">' +
            '<button type="button" class="btn-ghost gg-del" title="Entfernen"><i class="fas fa-times"></i></button>';
        wrap.appendChild(row);
        var inp = row.querySelector('.gg-src'), prev = row.querySelector('.gg-prev');
        inp.addEventListener('input', function () {
            var v = inp.value.trim();
            if (v) { prev.src = v; prev.classList.remove('hidden'); } else { prev.classList.add('hidden'); }
        });
        row.querySelector('.gg-del').addEventListener('click', function () { row.remove(); });
    }
    function resetGameForm() {
        var f = document.getElementById('gameForm');
        if (f) f.reset();
        var wrap = document.getElementById('imageInputs');
        if (wrap) wrap.innerHTML = '';
    }
    function openCreate() {
        resetGameForm();
        document.getElementById('gameFormTitle').textContent = 'Spiel hinzufügen';
        document.getElementById('gameForm').setAttribute('action', 'addGame');
        addImageInput('');
        openModal('gameFormModal');
    }
    function openEdit(id) {
        resetGameForm();
        document.getElementById('gameFormTitle').textContent = 'Spiel bearbeiten';
        document.getElementById('gameForm').setAttribute('action', 'editGame?id=' + id);
        fetch('gameDetail?id=' + encodeURIComponent(id))
            .then(function (r) { return r.json(); })
            .then(function (g) {
                document.getElementById('gf_name').value = g.name || '';
                document.getElementById('gf_entwickler').value = g.entwickler || '';
                document.getElementById('gf_price').value = (String(g.price).toLowerCase() === 'gratis') ? '' : g.price;
                document.getElementById('gf_gratis').checked = (String(g.price).toLowerCase() === 'gratis');
                document.getElementById('gf_description').value = g.description || '';
                (g.images && g.images.length ? g.images : ['']).forEach(addImageInput);
            });
        openModal('gameFormModal');
    }

    /* ---------- expose + boot ---------- */
    window.GG = {
        openModal: openModal, closeModal: closeModal,
        openDetail: openDetail, openCreate: openCreate, openEdit: openEdit,
        addImageInput: addImageInput
    };

    document.addEventListener('DOMContentLoaded', function () {
        initAllCarousels(document);
        initAllShowcases(document);
        var add = document.getElementById('addImageBtn');
        if (add) add.addEventListener('click', function () { addImageInput(''); });
    });
})();
