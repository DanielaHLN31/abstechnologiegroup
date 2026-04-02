{{--
    ════════════════════════════════════════════════════════
    HERO SEARCH — ABS TECHNOLOGIE
    Remplace le bloc search dans .hero-header (index.blade.php)
    Fonctionnalités :
    - Formulaire GET → route('client.search')
    - Autocomplete AJAX avec suggestions en temps réel
    - Navigation clavier (↑↓ Entrée Échap)
    - Recherches populaires / tendances
    - Design moderne cohérent avec la charte
    ════════════════════════════════════════════════════════
--}}

<style>
/* ══════════════════════════════════════════════
   HERO SEARCH — Design
   ══════════════════════════════════════════════ */
:root {
    --hs-blue:    #0066CC;
    --hs-blue-d:  #004FA3;
    --hs-blue-xl: rgba(0,102,204,.08);
    --hs-red:     #CC1E1E;
    --hs-dark:    #0a1628;
    --hs-muted:   #6b7a99;
    --hs-border:  rgba(0,102,204,.18);
    --hs-radius:  14px;
}

/* ── Wrapper ── */
.hs-wrap {
    width: 100%;
    max-width: 580px;
    position: relative;
    font-family: 'DM Sans', sans-serif;
}

/* ── Champ principal ── */
.hs-form {
    display: flex;
    align-items: center;
    background: rgba(255,255,255,.96);
    border: 2px solid transparent;
    border-radius: var(--hs-radius);
    box-shadow: 0 8px 32px rgba(0,0,0,.12), 0 0 0 0 rgba(0,102,204,0);
    transition: border-color .25s, box-shadow .25s;
    overflow: visible;
    position: relative;
    z-index: 2;
}
.hs-form:focus-within {
    border-color: var(--hs-blue);
    box-shadow: 0 8px 32px rgba(0,0,0,.12), 0 0 0 4px rgba(0,102,204,.15);
}

/* Icône loupe */
.hs-icon {
    width: 52px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    color: var(--hs-muted);
    font-size: 18px;
    pointer-events: none;
    transition: color .2s;
}
.hs-form:focus-within .hs-icon { color: var(--hs-blue); }

/* Input */
.hs-input {
    flex: 1; height: 52px;
    border: none; background: transparent;
    font-family: 'DM Sans', sans-serif;
    font-size: 15px; font-weight: 400;
    color: var(--hs-dark); outline: none;
    padding: 0;
}
.hs-input::placeholder { color: #b0bcd4; }

/* Effacer */
.hs-clear {
    width: 32px; height: 32px; border-radius: 50%;
    border: none; background: #f4f7fd; cursor: pointer;
    display: none; align-items: center; justify-content: center;
    color: var(--hs-muted); font-size: 14px;
    margin-right: 6px; flex-shrink: 0;
    transition: background .2s, color .2s;
}
.hs-clear:hover { background: #e0e8f4; color: var(--hs-dark); }
.hs-clear.visible { display: flex; }

/* Bouton Rechercher */
.hs-btn {
    height: 52px; padding: 0 24px;
    background: var(--hs-blue); color: #fff;
    border: none; border-radius: 0 calc(var(--hs-radius) - 2px) calc(var(--hs-radius) - 2px) 0;
    font-family: 'Montserrat', sans-serif;
    font-size: 14px; font-weight: 700; letter-spacing: .04em;
    cursor: pointer; white-space: nowrap; flex-shrink: 0;
    display: flex; align-items: center; gap: 8px;
    transition: background .2s, transform .15s;
    position: relative; overflow: hidden;
}
.hs-btn::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,.18), transparent);
    transform: translateX(-100%);
    transition: transform .45s ease;
}
.hs-btn:hover::after { transform: translateX(100%); }
.hs-btn:hover { background: var(--hs-blue-d); }
.hs-btn:active { transform: scale(.98); }
.hs-btn svg { transition: transform .2s; }
.hs-btn:hover svg { transform: translateX(3px); }

/* ── Dropdown suggestions ── */
.hs-dropdown {
    position: absolute; top: calc(100% + 6px); left: 0; right: 0;
    background: #fff;
    border: 1.5px solid var(--hs-border);
    border-radius: var(--hs-radius);
    box-shadow: 0 20px 60px rgba(0,0,0,.14);
    z-index: 9999; overflow: hidden;
    display: none;
    animation: hs-drop-in .2s cubic-bezier(.16,1,.3,1) both;
}
.hs-dropdown.open { display: block; }
@keyframes hs-drop-in {
    from { opacity:0; transform:translateY(-6px); }
    to   { opacity:1; transform:translateY(0); }
}

/* Section dans le dropdown */
.hs-drop-section {
    padding: 10px 0 6px;
    border-bottom: 1px solid #f0f4fb;
}
.hs-drop-section:last-child { border-bottom: none; }

.hs-drop-label {
    font-size: 10px; font-weight: 700; letter-spacing: .1em;
    text-transform: uppercase; color: #b0bcd4;
    padding: 0 16px 6px;
    display: flex; align-items: center; gap: 6px;
}
.hs-drop-label svg { width:12px; height:12px; stroke:#b0bcd4; flex-shrink:0; }

/* Item produit (suggestions AJAX) */
.hs-result {
    display: flex; align-items: center; gap: 12px;
    padding: 9px 16px; cursor: pointer;
    transition: background .15s;
    text-decoration: none !important;
}
.hs-result:hover, .hs-result.hs-active {
    background: #f4f7fd;
}
.hs-result-img {
    width: 44px; height: 44px; border-radius: 8px;
    object-fit: cover; flex-shrink: 0;
    background: #f4f7fd;
    border: 1px solid #eef2fb;
}
.hs-result-body { flex: 1; min-width: 0; }
.hs-result-name {
    font-size: 13px; font-weight: 500; color: var(--hs-dark);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.hs-result-name mark {
    background: #fff3cd; color: var(--hs-dark);
    padding: 0 2px; border-radius: 2px; font-weight: 600;
}
.hs-result-cat {
    font-size: 11px; color: var(--hs-muted); margin-top: 2px;
}
.hs-result-price {
    font-family: 'Montserrat', sans-serif;
    font-size: 13px; font-weight: 700;
    color: var(--hs-blue); flex-shrink: 0;
}

/* Item tendance / populaire */
.hs-trend {
    display: flex; align-items: center; gap: 10px;
    padding: 8px 16px; cursor: pointer;
    font-size: 13px; color: var(--hs-dark);
    transition: background .15s; text-decoration: none !important;
}
.hs-trend:hover, .hs-trend.hs-active {
    background: #f4f7fd; color: var(--hs-blue);
}
.hs-trend-icon {
    width: 28px; height: 28px; border-radius: 7px;
    background: var(--hs-blue-xl);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 13px;
}

/* Lien "voir tous" */
.hs-see-all {
    display: flex; align-items: center; justify-content: center; gap: 6px;
    padding: 12px 16px;
    font-size: 13px; font-weight: 600; color: var(--hs-blue);
    text-decoration: none !important;
    border-top: 1px solid #f0f4fb;
    transition: background .15s;
}
.hs-see-all:hover { background: #f4f7fd; }
.hs-see-all svg { width:14px; height:14px; stroke:var(--hs-blue); transition: transform .2s; }
.hs-see-all:hover svg { transform: translateX(4px); }

/* Loader dans dropdown */
.hs-loader {
    display: flex; align-items: center; gap: 10px;
    padding: 16px; font-size: 13px; color: var(--hs-muted);
}
.hs-loader-spin {
    width: 18px; height: 18px;
    border: 2px solid #e0e8f4; border-top-color: var(--hs-blue);
    border-radius: 50%; animation: hs-spin .6s linear infinite;
    flex-shrink: 0;
}
@keyframes hs-spin { to { transform: rotate(360deg); } }

/* Aucun résultat */
.hs-empty {
    padding: 20px 16px; text-align: center;
    font-size: 13px; color: var(--hs-muted);
}
.hs-empty svg { width:32px; height:32px; stroke:#d0d8eb; display:block; margin:0 auto 8px; }

/* ── Tags tendances sous le champ ── */
.hs-tags {
    display: flex; align-items: center; gap: 8px;
    margin-top: 12px; flex-wrap: wrap;
}
.hs-tags-label {
    font-size: 12px; color: rgba(255,255,255,.6);
    white-space: nowrap;
}
.hs-tag {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 13px;
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.22);
    border-radius: 100px;
    font-size: 12px; color: rgba(255,255,255,.85);
    cursor: pointer; text-decoration: none !important;
    transition: background .2s, border-color .2s, color .2s;
    white-space: nowrap;
}
.hs-tag:hover {
    background: rgba(255,255,255,.22);
    border-color: rgba(255,255,255,.4);
    color: #fff;
}

/* Mobile */
@media (max-width: 576px) {
    .hs-btn span { display: none; }
    .hs-btn { padding: 0 16px; }
    .hs-wrap { max-width: 100%; }
}
</style>

{{-- ══════════════ HERO SEARCH ══════════════ --}}
<div class="hs-wrap" id="hs-wrap">

    {{-- Formulaire principal --}}
    <form class="hs-form" id="hs-form"
          action="{{ route('client.search') }}" method="GET"
          autocomplete="off" role="search">

        {{-- Icône loupe --}}
        <div class="hs-icon">
            <i class="zmdi zmdi-search"></i>
        </div>

        {{-- Input --}}
        <input
            type="text"
            name="q"
            id="hs-input"
            class="hs-input"
            placeholder="Rechercher un smartphone, ordinateur, TV…"
            value="{{ request('q') }}"
            aria-label="Rechercher un produit"
            aria-autocomplete="list"
            aria-controls="hs-dropdown"
            spellcheck="false">

        {{-- Bouton effacer --}}
        <button type="button" class="hs-clear" id="hs-clear" aria-label="Effacer">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>

        {{-- Bouton rechercher --}}
        <button type="submit" class="hs-btn" aria-label="Lancer la recherche">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            <span>Rechercher</span>
        </button>

    </form>

    {{-- Dropdown --}}
    <div class="hs-dropdown" id="hs-dropdown" role="listbox"></div>

</div>

{{-- Tags tendances ──────────────────────────────────── --}}
{{-- <div class="hs-tags" id="hs-tags">
    <span class="hs-tags-label">Tendances :</span>
    @php
        $trends = ['Samsung Galaxy', 'iPhone', 'Ordinateur', 'Réfrigérateur', 'TV'];
    @endphp
    @foreach($trends as $t)
    <a href="{{ route('client.search', ['q' => $t]) }}"
       class="hs-tag" data-query="{{ $t }}">
        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        {{ $t }}
    </a>
    @endforeach
</div> --}}

{{-- ══ Script autocomplete ══ --}}
<script>
(function () {
    'use strict';

    var input    = document.getElementById('hs-input');
    var dropdown = document.getElementById('hs-dropdown');
    var clearBtn = document.getElementById('hs-clear');
    var form     = document.getElementById('hs-form');

    if (!input || !dropdown) return;

    var timer       = null;
    var activeIdx   = -1;
    var currentItems = [];
    var lastQuery   = '';
    var isOpen      = false;

    /* ── Utilitaires ── */
    function esc(s) {
        return String(s)
            .replace(/&/g,'&amp;').replace(/</g,'&lt;')
            .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }
    function highlight(text, q) {
        if (!q) return esc(text);
        return esc(text).replace(
            new RegExp('(' + q.replace(/[.*+?^${}()|[\]\\]/g,'\\$&') + ')', 'gi'),
            '<mark>$1</mark>'
        );
    }

    /* ── Afficher/masquer le bouton effacer ── */
    function updateClear() {
        clearBtn.classList.toggle('visible', input.value.length > 0);
    }
    clearBtn.addEventListener('click', function () {
        input.value = '';
        input.focus();
        updateClear();
        showDefault();
    });
    input.addEventListener('input', updateClear);
    updateClear();

    /* ── Ouvrir / fermer ── */
    function open() {
        dropdown.classList.add('open');
        isOpen = true;
        activeIdx = -1;
    }
    function close() {
        dropdown.classList.remove('open');
        isOpen = false;
        activeIdx = -1;
        currentItems = [];
    }

    /* ── Dropdown par défaut (tendances) ── */
    function showDefault() {
        var trends = [
            { q: 'Samsung Galaxy', icon: '📱' },
            { q: 'iPhone',      icon: '📱' },
            { q: 'Ordinateur',    icon: '💻' },
            { q: 'Réfrigérateur',    icon: '❄️' },
            { q: 'TV',       icon: '📺' },
            { q: 'Réseau',  icon: '🏠' },
        ];
        var html = '<div class="hs-drop-section">'
            + '<div class="hs-drop-label">'
            + '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>'
            + 'Recherches populaires</div>';
        trends.forEach(function (t, i) {
            html += '<a href="{{ route("client.search") }}?q=' + encodeURIComponent(t.q)
                + '" class="hs-trend" data-q="' + esc(t.q) + '" data-idx="' + i + '">'
                + '<span class="hs-trend-icon">' + t.icon + '</span>'
                + esc(t.q) + '</a>';
        });
        html += '</div>';
        dropdown.innerHTML = html;
        currentItems = dropdown.querySelectorAll('.hs-trend');
        open();
    }

    /* ── Afficher le loader ── */
    function showLoader() {
        dropdown.innerHTML = '<div class="hs-loader"><div class="hs-loader-spin"></div>Recherche en cours…</div>';
        open();
    }

    /* ── Afficher les résultats ── */
    function showResults(results, q) {
        if (!results.length) {
            dropdown.innerHTML = '<div class="hs-empty">'
                + '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>'
                + 'Aucun résultat pour <strong>"' + esc(q) + '"</strong></div>';
            open();
            return;
        }

        var html = '<div class="hs-drop-section">'
            + '<div class="hs-drop-label">'
            + '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>'
            + results.length + ' résultat' + (results.length > 1 ? 's' : '') + '</div>';

        results.forEach(function (item, i) {
            var imgSrc = item.image || '{{ asset("frontend/images/no-image.jpg") }}';
            // On encode les données JSON en attributs HTML-safe
            var imagesJson = esc(JSON.stringify(item.images || []));
            var colorsJson = esc(JSON.stringify(item.colors || []));
            var specsJson  = esc(JSON.stringify(item.specs  || []));

            html += '<div class="hs-result js-show-modal1"'
                + ' style="cursor:pointer"'
                + ' data-idx="'                  + i                        + '"'
                + ' data-product-id="'           + esc(item.id)             + '"'
                + ' data-product-name="'         + esc(item.name)           + '"'
                + ' data-product-price="'        + esc(item.price)          + '"'
                + ' data-product-description="'  + esc(item.description||'')+ '"'
                + ' data-product-images=\''      + imagesJson               + '\''
                + ' data-product-colors=\''      + colorsJson               + '\''
                + ' data-product-specs=\''       + specsJson                + '\''
                + '>'
                + '<img class="hs-result-img" src="' + esc(imgSrc) + '" alt="' + esc(item.name) + '" loading="lazy">'
                + '<div class="hs-result-body">'
                + '<div class="hs-result-name">' + highlight(item.name, q) + '</div>'
                + (item.category ? '<div class="hs-result-cat">' + esc(item.category) + '</div>' : '')
                + '</div>'
                + '<div class="hs-result-price">' + esc(item.price) + ' FCFA</div>'
                + '</div>';
        });

        html += '</div>'
            + '<a href="{{ route("client.search") }}?q=' + encodeURIComponent(q)
            + '" class="hs-see-all">Voir tous les résultats pour "' + esc(q) + '"'
            + '<svg viewBox="0 0 24 24" fill="none" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>'
            + '</a>';

        dropdown.innerHTML = html;

        // Ferme le dropdown quand on clique sur un résultat
        dropdown.querySelectorAll('.hs-result.js-show-modal1').forEach(function(el) {
            el.addEventListener('click', function() {
                close();
            });
        });

        currentItems = dropdown.querySelectorAll('.hs-result, .hs-see-all');
        open();
    }

    /* ── Fetch AJAX ── */
    function fetchSuggestions(q) {
        showLoader();
        lastQuery = q;

        fetch('{{ route("client.search.suggest") }}?q=' + encodeURIComponent(q), {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            if (q !== lastQuery) return; /* réponse obsolète */
            showResults(Array.isArray(data) ? data : [], q);
        })
        .catch(function () {
            if (q !== lastQuery) return;
            dropdown.innerHTML = '<div class="hs-empty">Erreur de connexion. Réessayez.</div>';
        });
    }

    /* ── Événement input ── */
    input.addEventListener('input', function () {
        clearTimeout(timer);
        var q = this.value.trim();
        if (q.length === 0) { showDefault(); return; }
        if (q.length < 2)   { close(); return; }
        timer = setTimeout(function () { fetchSuggestions(q); }, 280);
    });

    /* ── Focus ── */
    input.addEventListener('focus', function () {
        if (this.value.trim().length >= 2) {
            fetchSuggestions(this.value.trim());
        } else {
            showDefault();
        }
    });

    /* ── Navigation clavier ── */
    input.addEventListener('keydown', function (e) {
        if (!isOpen) return;
        var items = dropdown.querySelectorAll('.hs-result, .hs-trend, .hs-see-all');
        var len   = items.length;

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            activeIdx = (activeIdx + 1) % len;
            setActive(items, activeIdx);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            activeIdx = (activeIdx - 1 + len) % len;
            setActive(items, activeIdx);
        } else if (e.key === 'Enter' && activeIdx >= 0) {
            e.preventDefault();
            var el = items[activeIdx];
            if (el) {
                var href = el.getAttribute('href');
                var dq   = el.getAttribute('data-q');
                if (href && href !== '#') {
                    window.location.href = href;
                } else if (dq) {
                    input.value = dq;
                    form.submit();
                }
            }
        } else if (e.key === 'Escape') {
            close();
            input.blur();
        }
    });

    function setActive(items, idx) {
        items.forEach(function (el, i) {
            el.classList.toggle('hs-active', i === idx);
        });
        if (items[idx]) {
            var href = items[idx].getAttribute('href');
            /* Met à jour visuellement l'input si c'est une tendance */
            var dq = items[idx].getAttribute('data-q');
            if (dq) input.setAttribute('aria-activedescendant', dq);
        }
    }

    /* ── Tags tendances (click) ── */
    document.querySelectorAll('.hs-tag').forEach(function (tag) {
        tag.addEventListener('click', function (e) {
            e.preventDefault();
            var q = this.getAttribute('data-query');
            if (q) {
                input.value = q;
                updateClear();
                fetchSuggestions(q);
                input.focus();
            }
        });
    });

    /* ── Clic extérieur ── */
    document.addEventListener('click', function (e) {
        if (!document.getElementById('hs-wrap').contains(e.target)) {
            close();
        }
    });

    /* ── Soumettre le formulaire ── */
    form.addEventListener('submit', function (e) {
        var q = input.value.trim();
        if (!q) { e.preventDefault(); input.focus(); return; }
        close();
        /* Redirige vers la page de recherche */
    });

    /* Init si valeur pré-remplie (depuis URL) */
    if (input.value.trim().length >= 2) {
        updateClear();
    }

})();
</script>