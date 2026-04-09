@extends('client.layout')
@push('links')
	<title>Accueil ABS-TECHNOLOGIE</title>
		

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="{{ asset('frontend/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
	
	
    <style>
        :root {
            --primary: #0066CC;
            --primary-dark: #004FA3;
            --text-main: #0a1628;
            --text-muted: #6b7a99;
            --border: #e8eef8;
            --bg-light: #f4f7fd;
        }

        body { background: #f8faff; }

        /* ── Breadcrumb ── */
        .pd-breadcrumb {
            padding: 16px 0;
            font-size: 13px;
            color: var(--text-muted);
        }
        .pd-breadcrumb a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color .2s;
        }
        .pd-breadcrumb a:hover { color: var(--primary); }
        .pd-breadcrumb span { margin: 0 8px; }

        /* ── Layout principal ── */
        .pd-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 48px;
            background: #fff;
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 2px 20px rgba(10,22,40,.06);
            margin-bottom: 48px;
        }

        /* ── Galerie ── */
        .pd-gallery {}

        .pd-main-img {
            width: 100%;
            aspect-ratio: 1;
            border-radius: 14px;
            overflow: hidden;
            background: var(--bg-light);
            border: 1px solid var(--border);
            position: relative;
            margin-bottom: 12px;
        }
        .pd-main-img img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform .4s ease;
        }
        .pd-main-img:hover img { transform: scale(1.04); }

        /* Badge sur image principale */
        .pd-img-badge {
            position: absolute;
            top: 14px;
            left: 14px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .04em;
            z-index: 2;
        }
        .badge-promo { background: #FF3D3D; color: #fff; }
        .badge-new   { background: #22c55e; color: #fff; }
        .badge-top   { background: #f59e0b; color: #fff; }

        /* Thumbnails */
        .pd-thumbs {
            display: flex;
            flex-direction: row;
            gap: 10px;
            overflow-x: auto;
            padding-bottom: 4px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        .pd-thumbs::-webkit-scrollbar { display: none; }

        .pd-thumb {
            flex-shrink: 0;
            width: 72px;
            height: 72px;
            border-radius: 10px;
            overflow: hidden;
            border: 2px solid var(--border);
            cursor: pointer;
            transition: border-color .2s, transform .2s;
            background: var(--bg-light);
        }
        .pd-thumb:hover { border-color: var(--primary); transform: translateY(-2px); }
        .pd-thumb.active { border-color: var(--primary); }
        .pd-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* ── Infos produit ── */
        .pd-info {}

        .pd-category {
            font-size: 12px;
            font-weight: 600;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .pd-category::before {
            content: '';
            width: 20px;
            height: 2px;
            background: var(--primary);
            border-radius: 2px;
        }

        .pd-name {
            font-family: 'Montserrat', sans-serif;
            font-size: 26px;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1.3;
            margin-bottom: 16px;
        }

        /* Badges info */
        .pd-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 20px;
        }
        .pd-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            background: var(--bg-light);
            color: var(--text-muted);
            border: 1px solid var(--border);
        }
        .pd-badge.stock-ok  { background: #f0fdf4; color: #16a34a; border-color: #bbf7d0; }
        .pd-badge.stock-low { background: #fff7ed; color: #ea580c; border-color: #fed7aa; }
        .pd-badge.stock-out { background: #fef2f2; color: #dc2626; border-color: #fecaca; }

        /* Prix */
        .pd-price-block {
            display: flex;
            align-items: baseline;
            gap: 14px;
            margin-bottom: 24px;
            padding: 20px;
            background: var(--bg-light);
            border-radius: 14px;
            border: 1px solid var(--border);
        }
        .pd-price-main {
            font-family: 'Montserrat', sans-serif;
            font-size: 32px;
            font-weight: 800;
            color: var(--primary);
        }
        .pd-price-old {
            font-size: 18px;
            color: var(--text-muted);
            text-decoration: line-through;
        }
        .pd-discount {
            background: #FF3D3D;
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
        }

        /* Couleurs */
        .pd-section-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 10px;
            letter-spacing: .04em;
        }
        .pd-colors {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 24px;
        }
        .pd-color-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 7px 14px;
            border-radius: 10px;
            border: 1.5px solid var(--border);
            background: #fff;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-main);
            transition: all .2s;
        }
        .pd-color-btn:hover { border-color: var(--primary); }
        .pd-color-btn.active {
            border-color: var(--primary);
            background: rgba(0,102,204,.06);
            color: var(--primary);
        }
        .pd-color-btn.out { opacity: .4; cursor: not-allowed; }
        .pd-color-dot {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 1px solid rgba(0,0,0,.12);
            flex-shrink: 0;
        }

        /* Quantité + Actions */
        .pd-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }
        .pd-qty {
            display: flex;
            align-items: center;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
        }
        .pd-qty button {
            width: 40px;
            height: 48px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: var(--text-muted);
            transition: all .2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .pd-qty button:hover { background: var(--bg-light); color: var(--primary); }
        .pd-qty input {
            width: 52px;
            height: 48px;
            border: none;
            text-align: center;
            font-size: 15px;
            font-weight: 700;
            color: var(--text-main);
            background: none;
            outline: none;
        }

        .pd-btn-cart {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 14px 24px;
            background: var(--primary);
            color: #fff !important;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all .25s;
            text-decoration: none;
            box-shadow: 0 4px 16px rgba(0,102,204,.3);
        }
        .pd-btn-cart:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,102,204,.4);
            color: #fff !important;
        }
        .pd-btn-cart:disabled {
            background: #c8d4e8;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .pd-btn-wish {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            border: 1.5px solid var(--border);
            background: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
            flex-shrink: 0;
        }
        .pd-btn-wish:hover { border-color: #CC1B1B; background: #fef2f2; }
        .pd-btn-wish.active svg { fill: #CC1B1B; }

        /* Description */
        .pd-desc {
            font-size: 14px;
            line-height: 1.8;
            color: var(--text-muted);
            margin-bottom: 24px;
            border-top: 1px solid var(--border);
            padding-top: 20px;
        }

        /* Infos livraison */
        .pd-delivery {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 16px;
            background: var(--bg-light);
            border-radius: 12px;
            border: 1px solid var(--border);
        }
        .pd-delivery-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: var(--text-muted);
        }
        .pd-delivery-item svg { flex-shrink: 0; color: var(--primary); }

        /* ── Onglets (Description / Spécifications) ── */
        .pd-tabs {
            background: #fff;
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 2px 20px rgba(10,22,40,.06);
            margin-bottom: 48px;
        }
        .pd-tab-nav {
            display: flex;
            gap: 4px;
            border-bottom: 2px solid var(--border);
            margin-bottom: 28px;
        }
        .pd-tab-btn {
            padding: 10px 24px;
            background: none;
            border: none;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-muted);
            cursor: pointer;
            transition: all .2s;
        }
        .pd-tab-btn.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }
        .pd-tab-content { display: none; }
        .pd-tab-content.active { display: block; }

        .pd-spec-table {
            width: 100%;
            border-collapse: collapse;
        }
        .pd-spec-table tr:nth-child(odd) td { background: var(--bg-light); }
        .pd-spec-table td {
            padding: 12px 16px;
            font-size: 14px;
            border-radius: 6px;
        }
        .pd-spec-table td:first-child {
            font-weight: 600;
            color: var(--text-main);
            width: 40%;
        }
        .pd-spec-table td:last-child { color: var(--text-muted); }

        /* ── Produits similaires ── */
        .pd-related {
            margin-bottom: 48px;
        }
        .pd-related-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 22px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .pd-related-title::after {
            content: '';
            flex: 1;
            height: 2px;
            background: var(--border);
            border-radius: 2px;
        }

        .pd-related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .pd-wrapper {
                grid-template-columns: 1fr;
                gap: 24px;
                padding: 20px;
            }
            .pd-name { font-size: 20px; }
            .pd-price-main { font-size: 26px; }
            .pd-thumbs { flex-direction: row !important; }
            .pd-thumb { width: 60px; height: 60px; }
            .pd-actions { flex-wrap: wrap; }
            .pd-btn-cart { flex: 1 0 100%; order: 3; }
            .pd-related-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .pd-related-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }
        }
    </style>


@endpush

@section('content')




<div class="container" style="margin-top: 100px; padding-bottom: 60px;">

    {{-- Breadcrumb --}}
    <nav class="pd-breadcrumb">
        <a href="{{ route('client.index') }}">Accueil</a>
        <span>›</span>
        <a href="{{ route('client.product') }}">Produits</a>
        @if($product->category)
            <span>›</span>
            <a href="{{ route('client.product', ['category' => $product->category_id]) }}">
                {{ $product->category->name }}
            </a>
        @endif
        <span>›</span>
        <span style="color: var(--text-main)">{{ Str::limit($product->name, 40) }}</span>
    </nav>

    {{-- Bloc principal --}}
    <div class="pd-wrapper">

        {{-- ── Galerie ── --}}
        <div class="pd-gallery">
            <div class="pd-main-img" id="pd-main-img">

                {{-- Badge --}}
                @if($product->compare_price && $product->compare_price > $product->price)
                    @php $disc = round((1 - $product->price / $product->compare_price) * 100) @endphp
                    <span class="pd-img-badge badge-promo">-{{ $disc }}%</span>
                @elseif($product->created_at->diffInDays(now()) <= 30)
                    <span class="pd-img-badge badge-new">Nouveau</span>
                @elseif($product->is_featured)
                    <span class="pd-img-badge badge-top">Top Vente</span>
                @endif

                @if($product->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                         alt="{{ $product->name }}"
                         id="pd-img-main"
                         fetchpriority="high"
                          loading="lazy">
                @else
                    <img src="{{ asset('frontend/images/no-image.jpg') }}"
                         alt="{{ $product->name }}"
                         id="pd-img-main" loading="lazy">
                @endif
            </div>

            {{-- Thumbnails --}}
            @if($product->images->count() > 1)
            <div class="pd-thumbs" id="pd-thumbs">
                @foreach($product->images as $i => $img)
                <div class="pd-thumb {{ $i === 0 ? 'active' : '' }}"
                     data-src="{{ asset('storage/' . $img->image_path) }}"
                     onclick="pdSwitchImg(this)">
                    <img src="{{ asset('storage/' . $img->image_path) }}"
                         alt="{{ $product->name }}"
                         loading="lazy">
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- ── Infos ── --}}
        <div class="pd-info">

            {{-- Catégorie --}}
            @if($product->category)
            <div class="pd-category">{{ $product->category->name }}</div>
            @endif

            {{-- Nom --}}
            <h1 class="pd-name">{{ $product->name }}</h1>

            {{-- Badges statut --}}
            {{-- <div class="pd-badges">
                @if($product->stock_quantity > 10)
                    <span class="pd-badge stock-ok">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        En stock ({{ $product->stock_quantity }})
                    </span>
                @elseif($product->stock_quantity > 0)
                    <span class="pd-badge stock-low">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                        Plus que {{ $product->stock_quantity }} en stock
                    </span>
                @else
                    <span class="pd-badge stock-out">Rupture de stock</span>
                @endif

                @if($product->brand)
                    <span class="pd-badge">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/></svg>
                        {{ $product->brand->name }}
                    </span>
                @endif
            </div> --}}

            {{-- Prix --}}
            <div class="pd-price-block">
                <span class="pd-price-main">
                    {{ number_format($product->price, 0, ',', ' ') }} FCFA
                </span>
                @if($product->compare_price && $product->compare_price > $product->price)
                    <span class="pd-price-old">
                        {{ number_format($product->compare_price, 0, ',', ' ') }} FCFA
                    </span>
                    <span class="pd-discount">-{{ $disc ?? 0 }}%</span>
                @endif
            </div>

            {{-- Couleurs --}}
            @if($product->colors->isNotEmpty())
            <div class="mb-4">
                <div class="pd-section-label">Couleur disponible</div>
                <div class="pd-colors" id="pd-colors">
                    @foreach($product->colors as $color)
                        @php $stock = $color->pivot->stock_quantity ?? 0; @endphp
                        <button type="button"
                                class="pd-color-btn {{ $stock === 0 ? 'out' : '' }}"
                                data-color-id="{{ $color->id }}"
                                data-stock="{{ $stock }}"
                                {{ $stock === 0 ? 'disabled' : '' }}>
                            <span class="pd-color-dot" style="background: {{ $color->code }}"></span>
                            {{ $color->name }}
                            @if($stock === 0)
                                <small style="color:#dc2626">(épuisé)</small>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Description courte --}}
            @if($product->description)
            <div class="pd-desc">
                {{ Str::limit(strip_tags($product->description), 300) }}
            </div>
            @endif
            
            {{-- Quantité + Actions --}}
            <div class="pd-actions">
                <div class="pd-qty">
                    <button type="button" onclick="pdQtyDown()">−</button>
                    <input type="number" id="pd-qty" value="1" min="1"
                           max="{{ $product->stock_quantity }}">
                    <button type="button" onclick="pdQtyUp({{ $product->stock_quantity }})">+</button>
                </div>

                <button class="pd-btn-cart abs-add-to-cart"
                        id="pd-btn-cart"
                        data-product-id="{{ $product->id }}"
                        data-product-name="{{ $product->name }}"
                        {{ $product->stock_quantity === 0 ? 'disabled' : '' }}>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <path d="M16 10a4 4 0 01-8 0"/>
                    </svg>
                    {{ $product->stock_quantity === 0 ? 'Indisponible' : 'Ajouter au panier' }}
                </button>

                <button class="pd-btn-wish js-addwish-b2"
                        data-product-id="{{ $product->id }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                         stroke="#CC1B1B" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                </button>
            </div>


            {{-- Livraison --}}
            <div class="pd-delivery">
                <div class="pd-delivery-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                    Livraison disponible à Cotonou
                </div>
                <div class="pd-delivery-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Produit authentique & garanti
                </div>
                <div class="pd-delivery-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Showroom : CAMP-GUEZO, Cotonou
                </div>
            </div>

        </div>
    </div>

    {{-- ── Onglets ── --}}
    <div class="pd-tabs">
        <div class="pd-tab-nav">
            <button class="pd-tab-btn active" onclick="pdTab(this, 'desc')">Description</button>
            @if($product->specifications->isNotEmpty())
            <button class="pd-tab-btn" onclick="pdTab(this, 'specs')">Spécifications</button>
            @endif
        </div>

        <div class="pd-tab-content active" id="tab-desc">
            <div style="font-size:15px;line-height:1.9;color:var(--text-muted)">
                {!! nl2br(e(strip_tags($product->description ?? 'Aucune description disponible.'))) !!}
            </div>
        </div>

        @if($product->specifications->isNotEmpty())
        <div class="pd-tab-content" id="tab-specs">
            <table class="pd-spec-table">
                @foreach($product->specifications as $spec)
                <tr>
                    <td>{{ $spec->name }}</td>
                    <td>{{ $spec->value ?? '—' }}</td>
                </tr>
                @endforeach
            </table>
        </div>
        @endif
    </div>

    {{-- ── Produits similaires ── --}}
    @if($relatedProducts->isNotEmpty())
		<div class="ps-grid" id="psGrid">
            @foreach($relatedProducts as $rp)
                <div class="ps-card" data-cat="cat-{{ $rp->category_id }}">

                    {{-- Zone image --}}
                    <a href="{{ route('client.detail.product', $rp->id) }}" class="ps-card-img-link">
                        <div class="ps-card-img">

                            {{-- Image produit --}}
                            @if($rp->images->isNotEmpty())
                                <img
                                    src="{{ asset('storage/' . $rp->images->first()->image_path) }}"
                                    alt="{{ $rp->name }}"
                                    loading="lazy">
                            @else
                                <img
                                    src="{{ asset('frontend/images/no-image.jpg') }}"
                                    alt="{{ $rp->name }}"
                                    loading="lazy">
                            @endif

                            {{-- Badge (Promo > Nouveau > rien) --}}
                            @if($rp->compare_price && $rp->compare_price > $rp->price)
                                @php $discount = round((1 - $rp->price / $rp->compare_price) * 100); @endphp
                                <span class="ps-badge badge-promo">-{{ $discount }}%</span>
                            @elseif($rp->created_at->diffInDays(now()) <= 30)
                                <span class="ps-badge badge-new">Nouveau</span>
                            @elseif($rp->is_featured ?? false)
                                <span class="ps-badge badge-top">Top Vente</span>
                            @endif

                            {{-- Bouton Favori --}}
                            <button class="ps-wish js-addwish-b2"
                                    data-rp-id="{{ $rp->id }}"
                                    title="Ajouter aux favoris">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none"
                                    stroke="#CC1B1B" stroke-width="2">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67
                                            l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06
                                            L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                </svg>
                            </button>

                            {{-- Aperçu rapide (ouvre votre modal existant) --}}
                            <div class="ps-quickview js-show-modal1"
                                data-product-id="{{ $rp->id }}"
                                data-product-name="{{ $rp->name }}"
                                data-product-price="{{ $rp->price }}"
                                data-product-description="{{ $rp->description }}"
                                data-product-images="{{ json_encode($rp->images) }}"
                                data-product-colors="{{ json_encode($rp->colors) }}"
                                data-product-specs="{{ json_encode($rp->specifications) }}">
                                Aperçu rapide
                            </div>

                        </div>{{-- /.ps-card-img --}}
                    </a>
                    {{-- Corps --}}
                    <div class="ps-card-body">
                        <span class="ps-card-cat">
                            {{ $rp->category->name ?? 'Produit' }}
                        </span>

                        <a href="{{ route('client.detail.product', $rp->id) }}" class="ps-card-name-link">
                            <div class="ps-card-name">{{ $rp->name }}</div>
                        </a>
                        {{-- Pastilles couleurs --}}
                        @if($rp->colors->isNotEmpty())
                        <div class="ps-card-colors">
                            @foreach($rp->colors->take(4) as $color)
                            <span class="ps-color-dot"
                                style="background-color:{{ $color->code }}"
                                title="{{ $color->name }}"></span>
                            @endforeach
                            @if($rp->colors->count() > 4)
                            <span style="font-size:11px;color:var(--text-muted)">
                                +{{ $rp->colors->count() - 4 }}
                            </span>
                            @endif
                        </div>
                        @endif

                        {{-- Footer prix + panier --}}
                        <div class="ps-card-footer">

                            <div class="ps-price">
                                @if($rp->compare_price && $rp->compare_price > $rp->price)
                                    <span class="ps-price-old">
                                        {{ number_format($rp->compare_price, 0, ',', ' ') }} F
                                    </span>
                                @endif
                                <span class="ps-price-main">
                                    {{ number_format($rp->price, 0, ',', ' ') }} F
                                </span>
                            </div>

                            {{-- Bouton Ajouter au panier (reprend votre logique JS existante) --}}
                            <button class="ps-add-btn abs-add-to-cart"
                                    data-product-id="{{ $rp->id }}"
                                    data-product-name="{{ $rp->name }}"
                                    data-product-price="{{ $rp->price }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    width="13" height="13" stroke-width="2.5">
                                    <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                                    <line x1="3" y1="6" x2="21" y2="6"/>
                                    <path d="M16 10a4 4 0 01-8 0"/>
                                </svg>
                                Ajouter
                            </button>

                        </div>{{-- /.ps-card-footer --}}

                    </div>{{-- /.ps-card-body --}}

                </div>
            @endforeach
        </div>

    @endif

    
    <div class="ps-view-all">
        <a href="{{ route('client.product') }}" class="ps-view-all-btn">
            Voir tous les produits
            <svg class="arrow" viewBox="0 0 24 24" width="16" height="16"
                fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

</div>

@endsection


@push('scripts')

	<!--===============================================================================================-->
	<!-- 1. CHARGER JQUERY UNE SEULE FOIS (version la plus récente) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<!--===============================================================================================-->

	<!-- 2. CHARGER BOOTSTRAP (une seule version) -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>




<script>
    /* ── Switcher image principale ── */
    function pdSwitchImg(el) {
        document.getElementById('pd-img-main').src = el.dataset.src;
        document.querySelectorAll('.pd-thumb').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
    }

    /* ── Quantité ── */
    function pdQtyDown() {
        var $q = document.getElementById('pd-qty');
        if (parseInt($q.value) > 1) $q.value = parseInt($q.value) - 1;
    }
    function pdQtyUp(max) {
        var $q = document.getElementById('pd-qty');
        if (parseInt($q.value) < max) $q.value = parseInt($q.value) + 1;
    }

    /* ── Couleur sélectionnée ── */
    var selectedColorId = null;
    document.querySelectorAll('.pd-color-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.pd-color-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            selectedColorId = this.dataset.colorId;
        });
    });

    /* ── Override du bouton panier pour passer quantité et couleur ── */
    // $(document).on('click', '#pd-btn-cart', function(e) {
    //     e.preventDefault();
    //     e.stopPropagation();

    //     @if($product->colors->isNotEmpty())
    //     if (!selectedColorId) {
    //         toastr.warning('Veuillez choisir une couleur.', 'Couleur requise');
    //         return;
    //     }
    //     @endif

    //     var qty = parseInt(document.getElementById('pd-qty').value) || 1;
    //     var $btn = $(this);
    //     var orig = $btn.html();

    //     $btn.html('Ajout en cours...').prop('disabled', true);

    //     $.ajax({
    //         url   : '{{ route("client.cart.add") }}',
    //         method: 'POST',
    //         data  : {
    //             product_id : {{ $product->id }},
    //             quantity   : qty,
    //             color_id   : selectedColorId || '',
    //             _token     : '{{ csrf_token() }}'
    //         },
    //         success: function(res) {
    //             $btn.html(orig).prop('disabled', false);
    //             toastr.success(res.message || 'Produit ajouté au panier.', 'Ajouté !');
    //             if (res.cart_count !== undefined) updateHeaderBadge(res.cart_count);
    //         },
    //         error: function(xhr) {
    //             $btn.html(orig).prop('disabled', false);
    //             toastr.error(xhr.responseJSON?.message || "Erreur lors de l'ajout.", 'Erreur');
    //         }
    //     });
    // });

    /* ── Onglets ── */
    function pdTab(btn, id) {
        document.querySelectorAll('.pd-tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.pd-tab-content').forEach(c => c.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('tab-' + id).classList.add('active');
    }
</script>

@endpush
@stack('scripts')