<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Résultats recherche — ABS-TECHNOLOGIE</title>
    @include('client.body.head')
    <style>
        
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
        /* ── Variables ── */
        :root {
            --ink:       #0a0a0f;
            --ink-soft:  #4a4a5a;
            --ink-muted: #9494a8;
            --surface:   #ffffff;
            --surface-2: #f6f6f9;
            --surface-3: #ededf2;
            --accent:    #0055ff;
            --accent-2:  #ff3d5a;
            --accent-glow: rgba(0, 85, 255, 0.12);
            --radius:    12px;
            --radius-lg: 20px;
            --font-display: 'Montserrat', sans-serif;
            --font-body:    'Montserrat', sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: var(--font-body);
            background: var(--surface);
            color: var(--ink);
            -webkit-font-smoothing: antialiased;
        }

        /* ── Search Hero ── */
        .srp-hero {
            background: var(--ink);
            padding: 56px 0 0;
            position: relative;
            overflow: hidden;
        }

        .srp-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 60% 80% at 80% 50%, rgba(0,85,255,0.18) 0%, transparent 60%),
                radial-gradient(ellipse 40% 60% at 20% 80%, rgba(255,61,90,0.10) 0%, transparent 55%);
            pointer-events: none;
        }

        .srp-hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.025'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        .srp-hero-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 32px 40px;
            position: relative;
            z-index: 1;
        }

        .srp-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: rgba(255,255,255,0.4);
            margin-bottom: 24px;
            font-family: var(--font-body);
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .srp-breadcrumb a {
            color: rgba(255,255,255,0.4);
            text-decoration: none;
            transition: color 0.2s;
        }

        .srp-breadcrumb a:hover { color: rgba(255,255,255,0.8); }
        .srp-breadcrumb span { color: rgba(255,255,255,0.2); }

        .srp-title {
            font-family: var(--font-display);
            font-size: clamp(28px, 4vw, 48px);
            font-weight: 600;
            color: #fff;
            line-height: 1.1;
            margin-bottom: 12px;
        }

        .srp-title em {
            font-style: normal;
            color: #5a8fff;
        }

        .srp-meta {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .srp-count {
            font-size: 14px;
            color: rgba(255,255,255,0.5);
            font-weight: 400;
        }

        .srp-count strong {
            color: #fff;
            font-weight: 600;
        }

        /* Search bar inside hero */
        .srp-search-bar {
            margin-top: 28px;
            display: flex;
            max-width: 560px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 50px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            transition: border-color 0.2s, background 0.2s;
        }

        .srp-search-bar:focus-within {
            border-color: rgba(90,143,255,0.6);
            background: rgba(255,255,255,0.12);
        }

        .srp-search-bar input {
            flex: 1;
            background: none;
            border: none;
            outline: none;
            padding: 14px 20px;
            font-size: 14px;
            color: #fff;
            font-family: var(--font-body);
        }

        .srp-search-bar input::placeholder { color: rgba(255,255,255,0.35); }

        .srp-search-bar button {
            background: var(--accent);
            border: none;
            cursor: pointer;
            padding: 0 24px;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            font-family: var(--font-body);
            transition: background 0.2s;
            white-space: nowrap;
        }

        .srp-search-bar button:hover { background: #0044cc; }

        /* ── Layout ── */
        .srp-layout {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 32px 80px;
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 40px;
            align-items: start;
        }

        @media (max-width: 900px) {
            .srp-layout { grid-template-columns: 1fr; }
            .srp-sidebar { display: none; }
            .srp-sidebar.open { display: block; }
        }

        /* ── Sidebar ── */
        .srp-sidebar {
            position: sticky;
            top: 24px;
        }

        .srp-filter-card {
            background: var(--surface);
            border: 1px solid var(--surface-3);
            border-radius: var(--radius-lg);
            overflow: hidden;
        }

        .srp-filter-head {
            padding: 20px 24px 16px;
            border-bottom: 1px solid var(--surface-3);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .srp-filter-head h3 {
            font-family: var(--font-display);
            font-size: 15px;
            font-weight: 600;
            color: var(--ink);
        }

        .srp-reset-link {
            font-size: 12px;
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
        }

        .srp-reset-link.visible {
            opacity: 1;
            pointer-events: auto;
        }

        .srp-filter-section {
            padding: 20px 24px;
            border-bottom: 1px solid var(--surface-3);
        }

        .srp-filter-section:last-child { border-bottom: none; }

        .srp-filter-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--ink-muted);
            margin-bottom: 14px;
        }

        /* Sort select */
        .srp-sort-select {
            width: 100%;
            border: 1px solid var(--surface-3);
            border-radius: 8px;
            padding: 9px 12px;
            font-size: 13px;
            color: var(--ink);
            font-family: var(--font-body);
            background: var(--surface);
            cursor: pointer;
            outline: none;
            transition: border-color 0.2s;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg width='10' height='6' viewBox='0 0 10 6' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%239494a8' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 32px;
        }

        .srp-sort-select:focus { border-color: var(--accent); }

        /* Radio filters */
        .srp-radio-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .srp-radio-list li label {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            font-size: 13px;
            color: var(--ink-soft);
            transition: color 0.15s;
        }

        .srp-radio-list li label:hover { color: var(--ink); }

        .srp-radio-list input[type="radio"] {
            appearance: none;
            width: 16px;
            height: 16px;
            border: 2px solid var(--surface-3);
            border-radius: 50%;
            flex-shrink: 0;
            position: relative;
            cursor: pointer;
            transition: border-color 0.2s;
        }

        .srp-radio-list input[type="radio"]:checked {
            border-color: var(--accent);
            background: var(--accent);
        }

        .srp-radio-list input[type="radio"]:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 5px;
            height: 5px;
            background: #fff;
            border-radius: 50%;
        }

        /* Price range */
        .srp-price-inputs {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .srp-price-inputs input {
            border: 1px solid var(--surface-3);
            border-radius: 8px;
            padding: 8px 10px;
            font-size: 13px;
            color: var(--ink);
            font-family: var(--font-body);
            width: 100%;
            outline: none;
            transition: border-color 0.2s;
        }

        .srp-price-inputs input:focus { border-color: var(--accent); }
        .srp-price-inputs span { color: var(--ink-muted); font-size: 12px; text-align: center; }

        .srp-apply-btn {
            width: 100%;
            background: var(--ink);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px;
            font-size: 13px;
            font-weight: 600;
            font-family: var(--font-body);
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
        }

        .srp-apply-btn:hover { background: var(--accent); }
        .srp-apply-btn:active { transform: scale(0.98); }

        /* ── Main content ── */
        .srp-main {}

        /* Toolbar */
        .srp-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .srp-toolbar-left {
            font-size: 13px;
            color: var(--ink-muted);
        }

        .srp-toolbar-left strong { color: var(--ink); font-weight: 600; }

        /* Active filters chips */
        .srp-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 24px;
        }

        .srp-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            background: var(--accent-glow);
            border: 1px solid rgba(0,85,255,0.2);
            border-radius: 50px;
            font-size: 12px;
            color: var(--accent);
            font-weight: 500;
            text-decoration: none;
            transition: background 0.15s;
        }

        .srp-chip:hover { background: rgba(0,85,255,0.18); }
        .srp-chip svg { width: 10px; height: 10px; }

        /* ── Product grid ── */
        .srp-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        @media (max-width: 1100px) { .srp-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 600px) { .srp-grid { grid-template-columns: 1fr; } }

        /* ── Product card ── */
        .srp-card {
            background: var(--surface);
            border: 1px solid var(--surface-3);
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .srp-card:hover {
            border-color: rgba(0,85,255,0.2);
            box-shadow: 0 8px 32px rgba(0,85,255,0.08), 0 2px 8px rgba(0,0,0,0.06);
            transform: translateY(-2px);
        }

        .srp-card-img {
            position: relative;
            aspect-ratio: 1 / 1;
            background: var(--surface-2);
            overflow: hidden;
        }

        .srp-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .srp-card:hover .srp-card-img img { transform: scale(1.04); }

        /* Overlay with action button */
        .srp-card-overlay {
            position: absolute;
            inset: 0;
            background: rgba(10,10,15,0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .srp-card:hover .srp-card-overlay { opacity: 1; }

        .srp-card-view {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #fff;
            color: var(--ink);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 13px;
            font-weight: 600;
            font-family: var(--font-body);
            cursor: pointer;
            text-decoration: none;
            transform: translateY(6px);
            transition: transform 0.2s;
        }

        .srp-card:hover .srp-card-view { transform: translateY(0); }
        .srp-card-view:hover { background: var(--accent); color: #fff; }

        /* Badge */
        .srp-card-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
            font-family: var(--font-display);
            letter-spacing: 0.02em;
            z-index: 2;
        }

        .srp-badge-promo { background: var(--accent-2); color: #fff; }
        .srp-badge-new   { background: var(--accent); color: #fff; }

        /* Wishlist */
        .srp-card-wish {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 34px;
            height: 34px;
            background: rgba(255,255,255,0.9);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 2;
            transition: background 0.2s, transform 0.2s;
            backdrop-filter: blur(4px);
        }

        .srp-card-wish:hover { background: #fff; transform: scale(1.1); }
        .srp-card-wish.js-addedwish-b2 svg { fill: #e65540; stroke: #e65540; }

        /* Card body */
        .srp-card-body {
            padding: 16px 18px 18px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .srp-card-cat {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--accent);
        }

        .srp-card-name {
            font-family: var(--font-display);
            font-size: 14px;
            font-weight: 500;
            color: var(--ink);
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-decoration: none;
            transition: color 0.15s;
        }

        .srp-card-name:hover { color: var(--accent); }

        mark {
            background: #fff3cd;
            padding: 0 2px;
            border-radius: 2px;
            color: inherit;
        }

        .srp-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-top: auto;
            padding-top: 12px;
            border-top: 1px solid var(--surface-3);
        }

        .srp-card-price {
            display: flex;
            flex-direction: column;
            gap: 1px;
        }

        .srp-price-old {
            font-size: 11px;
            color: var(--ink-muted);
            text-decoration: line-through;
        }

        .srp-price-main {
            font-family: 'Montserrat', sans-serif;
            font-size: 16px;
            font-weight: 800;
            color: #0066cc;
        }

        .srp-price-main.sale { color: var(--accent-2); }

        .srp-card-add {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #b80505;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 12px;
            font-weight: 600;
            font-family: var(--font-body);
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            white-space: nowrap;
        }

        .srp-card-add:hover { background: #8f0303; }
        .srp-card-add:active { transform: scale(0.96); }

        /* ── Empty state ── */
        .srp-empty {
            grid-column: 1 / -1;
            text-align: center;
            padding: 80px 24px;
        }

        .srp-empty-icon {
            width: 80px;
            height: 80px;
            background: var(--surface-2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }

        .srp-empty h3 {
            font-family: var(--font-display);
            font-size: 22px;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 10px;
        }

        .srp-empty p {
            font-size: 14px;
            color: var(--ink-muted);
            margin-bottom: 28px;
        }

        .srp-empty-cta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--ink);
            color: #fff;
            text-decoration: none;
            border-radius: 50px;
            padding: 12px 28px;
            font-size: 14px;
            font-weight: 600;
            font-family: var(--font-body);
            transition: background 0.2s;
        }

        .srp-empty-cta:hover { background: var(--accent); color: #fff; }

        /* ── Pagination ── */
        .srp-pagination {
            display: flex;
            justify-content: center;
            gap: 6px;
            margin-top: 48px;
        }

        /* ── Card entrance animation ── */
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .srp-card {
            animation: cardIn 0.35s ease both;
        }

        .srp-card:nth-child(1) { animation-delay: 0.04s; }
        .srp-card:nth-child(2) { animation-delay: 0.08s; }
        .srp-card:nth-child(3) { animation-delay: 0.12s; }
        .srp-card:nth-child(4) { animation-delay: 0.16s; }
        .srp-card:nth-child(5) { animation-delay: 0.20s; }
        .srp-card:nth-child(6) { animation-delay: 0.24s; }
        .srp-card:nth-child(n+7) { animation-delay: 0.28s; }

        /* ── Mobile filter toggle ── */
        .srp-filter-toggle {
            display: none;
            align-items: center;
            gap: 8px;
            background: var(--surface);
            border: 1px solid var(--surface-3);
            border-radius: 8px;
            padding: 9px 16px;
            font-size: 13px;
            font-weight: 600;
            font-family: var(--font-body);
            color: var(--ink);
            cursor: pointer;
            transition: border-color 0.2s;
        }

        @media (max-width: 900px) { .srp-filter-toggle { display: flex; } }
    </style>
</head>

<body class="animsition">
    @include('client.body.header')

    {{-- ── Hero ── --}}
    <div class="srp-hero">
        <div class="srp-hero-inner">
            <div class="srp-breadcrumb">
                <a href="{{ route('client.index') }}">Accueil</a>
                <span>/</span>
                <a href="{{ route('client.product') }}">Boutique</a>
                <span>/</span>
                <span>Recherche</span>
            </div>

            @if($query)
                <h1 class="srp-title">
                    Résultats pour <em>« {{ $query }} »</em>
                </h1>
            @else
                <h1 class="srp-title">Tous les produits</h1>
            @endif

            <div class="srp-meta">
                <span class="srp-count">
                    <strong>{{ $products->total() }}</strong>
                    résultat{{ $products->total() > 1 ? 's' : '' }} trouvé{{ $products->total() > 1 ? 's' : '' }}
                </span>
            </div>

            {{-- Nouvelle recherche --}}
            <form action="{{ route('client.search') }}" method="GET" class="srp-search-bar">
                @if($category) <input type="hidden" name="category" value="{{ $category }}"> @endif
                @if($brand)    <input type="hidden" name="brand"    value="{{ $brand }}"> @endif
                @if($sort)     <input type="hidden" name="sort"     value="{{ $sort }}"> @endif
                <input type="text" name="q" value="{{ $query }}" placeholder="Nouvelle recherche...">
                <button type="submit">Rechercher</button>
            </form>
        </div>
    </div>

    {{-- ── Layout ── --}}
    <div class="srp-layout">

        {{-- ── Sidebar ── --}}
        <aside class="srp-sidebar" id="srp-sidebar">
            <form method="GET" action="{{ route('client.search') }}" id="filter-form">
                @if($query) <input type="hidden" name="q" value="{{ $query }}"> @endif

                <div class="srp-filter-card">
                    <div class="srp-filter-head">
                        <h3>Filtres</h3>
                        @if($minPrice || $maxPrice || $category || $brand)
                            <a href="{{ route('client.search', ['q' => $query]) }}"
                               class="srp-reset-link visible">
                                Tout effacer
                            </a>
                        @else
                            <a href="#" class="srp-reset-link">Tout effacer</a>
                        @endif
                    </div>

                    {{-- Tri --}}
                    <div class="srp-filter-section">
                        <div class="srp-filter-label">Trier par</div>
                        <select name="sort" class="srp-sort-select"
                                onchange="document.getElementById('filter-form').submit()">
                            <option value="relevance"  {{ $sort === 'relevance'  ? 'selected' : '' }}>Pertinence</option>
                            <option value="newest"     {{ $sort === 'newest'     ? 'selected' : '' }}>Plus récents</option>
                            <option value="price_asc"  {{ $sort === 'price_asc'  ? 'selected' : '' }}>Prix croissant</option>
                            <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                        </select>
                    </div>

                    {{-- Catégorie --}}
                    <div class="srp-filter-section">
                        <div class="srp-filter-label">Catégorie</div>
                        <ul class="srp-radio-list">
                            <li>
                                <label>
                                    <input type="radio" name="category" value=""
                                           {{ !$category ? 'checked' : '' }}
                                           onchange="this.form.submit()">
                                    Toutes les catégories
                                </label>
                            </li>
                            @foreach($categories as $cat)
                            <li>
                                <label>
                                    <input type="radio" name="category" value="{{ $cat->id }}"
                                           {{ $category == $cat->id ? 'checked' : '' }}
                                           onchange="this.form.submit()">
                                    {{ $cat->name }}
                                </label>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Marque --}}
                    <div class="srp-filter-section">
                        <div class="srp-filter-label">Marque</div>
                        <ul class="srp-radio-list">
                            <li>
                                <label>
                                    <input type="radio" name="brand" value=""
                                           {{ !$brand ? 'checked' : '' }}
                                           onchange="this.form.submit()">
                                    Toutes les marques
                                </label>
                            </li>
                            @foreach($brands as $b)
                            <li>
                                <label>
                                    <input type="radio" name="brand" value="{{ $b->id }}"
                                           {{ $brand == $b->id ? 'checked' : '' }}
                                           onchange="this.form.submit()">
                                    {{ $b->name }}
                                </label>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Prix --}}
                    <div class="srp-filter-section">
                        <div class="srp-filter-label">Prix (FCFA)</div>
                        <div class="srp-price-inputs">
                            <input type="number" name="min_price" value="{{ $minPrice }}" placeholder="Min">
                            <span>—</span>
                            <input type="number" name="max_price" value="{{ $maxPrice }}" placeholder="Max">
                        </div>
                        <button type="submit" class="srp-apply-btn">Appliquer</button>
                    </div>

                </div>
            </form>
        </aside>

        {{-- ── Main ── --}}
        <main class="srp-main">

            {{-- Toolbar --}}
            <div class="srp-toolbar">
                <div class="srp-toolbar-left">
                    @if($products->total() > 0)
                        Affichage de <strong>{{ $products->firstItem() }}–{{ $products->lastItem() }}</strong>
                        sur <strong>{{ $products->total() }}</strong> produit{{ $products->total() > 1 ? 's' : '' }}
                    @endif
                </div>
                <button class="srp-filter-toggle" onclick="document.getElementById('srp-sidebar').classList.toggle('open')">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="4" y1="6" x2="20" y2="6"/><line x1="4" y1="12" x2="14" y2="12"/><line x1="4" y1="18" x2="10" y2="18"/>
                    </svg>
                    Filtres
                </button>
            </div>

            {{-- Active filter chips --}}
            @if($category || $brand || $minPrice || $maxPrice)
            <div class="srp-chips">
                @if($category)
                    @php $activeCat = $categories->firstWhere('id', $category); @endphp
                    @if($activeCat)
                    <a href="{{ route('client.search', array_merge(request()->except('category'), ['q' => $query])) }}"
                       class="srp-chip">
                        {{ $activeCat->name }}
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </a>
                    @endif
                @endif
                @if($brand)
                    @php $activeBrand = $brands->firstWhere('id', $brand); @endphp
                    @if($activeBrand)
                    <a href="{{ route('client.search', array_merge(request()->except('brand'), ['q' => $query])) }}"
                       class="srp-chip">
                        {{ $activeBrand->name }}
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </a>
                    @endif
                @endif
                @if($minPrice || $maxPrice)
                <a href="{{ route('client.search', array_merge(request()->except(['min_price','max_price']), ['q' => $query])) }}"
                   class="srp-chip">
                    Prix : {{ $minPrice ?: '0' }} — {{ $maxPrice ?: '∞' }} FCFA
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </a>
                @endif
            </div>
            @endif

            {{-- Grid --}}
            <div class="srp-grid">
                @forelse($products as $product)
                <div class="srp-card">
                    {{-- Image --}}
                    <div class="srp-card-img">
                        @if($product->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                 alt="{{ $product->name }}" loading="lazy">
                        @else
                            <img src="{{ asset('frontend/images/no-image.jpg') }}"
                                 alt="{{ $product->name }}" loading="lazy">
                        @endif

                        {{-- Badge --}}
                        @if($product->compare_price && $product->compare_price > $product->price)
                            @php $disc = round((1 - $product->price / $product->compare_price) * 100); @endphp
                            <span class="srp-card-badge srp-badge-promo">−{{ $disc }}%</span>
                        @elseif($product->created_at->diffInDays(now()) <= 30)
                            <span class="srp-card-badge srp-badge-new">Nouveau</span>
                        @endif

                        {{-- Wishlist --}}
                        <button class="srp-card-wish js-addwish-b2"
                                data-product-id="{{ $product->id }}"
                                title="Ajouter aux favoris">
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none"
                                 stroke="#e65540" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                        </button>

                        {{-- Overlay --}}
                        <div class="srp-card-overlay">
                            <a href="#"
                               class="srp-card-view js-show-modal1"
                               data-product-id="{{ $product->id }}"
                               data-product-name="{{ $product->name }}"
                               data-product-price="{{ $product->price }}"
                               data-product-description="{{ $product->description }}"
                               data-product-images="{{ json_encode($product->images) }}"
                               data-product-colors="{{ json_encode($product->colors) }}"
                               data-product-specs="{{ json_encode($product->specifications ?? []) }}">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                Aperçu rapide
                            </a>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="srp-card-body">
                        <span class="srp-card-cat">{{ $product->category->name ?? 'Produit' }}</span>

                        <a href="{{ route('client.product.detail', $product->id) }}" class="srp-card-name">
                            @if($query)
                                {!! preg_replace('/(' . preg_quote($query, '/') . ')/i', '<mark>$1</mark>', e($product->name)) !!}
                            @else
                                {{ $product->name }}
                            @endif
                        </a>

                        <div class="srp-card-footer">
                            <div class="srp-card-price">
                                @if($product->compare_price && $product->compare_price > $product->price)
                                    <span class="srp-price-old">{{ number_format($product->compare_price, 0, ',', ' ') }} F</span>
                                    <span class="srp-price-main sale">{{ number_format($product->price, 0, ',', ' ') }} F</span>
                                @else
                                    <span class="srp-price-main">{{ number_format($product->price, 0, ',', ' ') }} F</span>
                                @endif
                            </div>

                            <button class="srp-card-add abs-add-to-cart"
                                    data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $product->name }}"
                                    data-product-price="{{ $product->price }}">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2.5">
                                    <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                                    <line x1="3" y1="6" x2="21" y2="6"/>
                                    <path d="M16 10a4 4 0 01-8 0"/>
                                </svg>
                                Ajouter
                            </button>
                        </div>
                    </div>
                </div>

                @empty
                <div class="srp-empty">
                    <div class="srp-empty-icon">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none"
                             stroke="#c8c8d8" stroke-width="1.5">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="M21 21l-4.35-4.35"/>
                        </svg>
                    </div>
                    @if($query)
                        <h3>Aucun résultat pour « {{ $query }} »</h3>
                        <p>Essayez avec d'autres mots-clés ou modifiez vos filtres.</p>
                    @else
                        <h3>Aucun produit trouvé</h3>
                        <p>Modifiez vos critères de recherche.</p>
                    @endif
                    <a href="{{ route('client.product') }}" class="srp-empty-cta">
                        Voir tous les produits
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2.5">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($products->hasPages())
            <div class="srp-pagination">
                {{ $products->appends(request()->query())->links() }}
            </div>
            @endif

        </main>
    </div>

    @include('frontend.modal')
    @include('client.body.footer')
    @include('frontend.productModal')

    <script src="{{ asset('frontend/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/animsition/js/animsition.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/select2/select2.min.js') }}"></script>
    <script>
        $(".js-select2").each(function(){
            $(this).select2({ minimumResultsForSearch: 20, dropdownParent: $(this).next('.dropDownSelect2') });
        });
    </script>
    <script src="{{ asset('frontend/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('frontend/vendor/slick/slick.min.js') }}"></script>
    <script src="{{ asset('frontend/js/slick-custom.js') }}"></script>
    <script src="{{ asset('frontend/vendor/parallax100/parallax100.js') }}"></script>
    <script src="{{ asset('frontend/vendor/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/isotope/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script>
        $('.js-pscroll').each(function(){
            $(this).css({'position':'relative','overflow':'hidden'});
            var ps = new PerfectScrollbar(this, { wheelSpeed:1, scrollingThreshold:1000, wheelPropagation:false });
            $(window).on('resize', function(){ ps.update(); });
        });
    </script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    @include('frontend.global_js')
</body>
</html>