<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation — ABS-TECHNOLOGIE</title>
    @include('client.body.head')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --gold:        #0066CC;
            --gold-light:  #b80505;
            --gold-dark:   #8B6914;
            --bg:          #0E0E12;
            --bg-card:     #16161D;
            --bg-card2:    #1C1C26;
            --border:      rgba(200,169,110,.18);
            --border-soft: rgba(255,255,255,.06);
            --text:        #F0EDE8;
            --text-muted:  #7C7A82;
            --text-dim:    #4A4852;
            --success:     #4CAF76;
            --warn:        #E8A838;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            /* background: #f0eeee; */
            color: #f0eeee;
            font-family: 'DM Sans', sans-serif;
            font-weight: 300;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* ── BACKGROUND TEXTURE ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 20% 0%, rgba(200,169,110,.07) 0%, transparent 70%),
                radial-gradient(ellipse 40% 60% at 80% 100%, rgba(113,127,224,.05) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        /* ── WRAPPER ── */
        .confirm-wrapper {
            position: relative;
            z-index: 1;
            max-width: 780px;
            margin: 0 auto;
            padding: 60px 20px 100px;
        }

        /* ── BRAND BAR ── */
        .brand-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 56px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-soft);
            opacity: 0;
            animation: fadeUp .6s ease forwards;
        }
        .brand-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 22px;
            font-weight: 600;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: #fff;
        }
        .brand-back {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            letter-spacing: .06em;
            color: #fff
            text-decoration: none;
            transition: color .25s;
        }
        .brand-back:hover { color: #fff; }
        .brand-back svg { width: 14px; height: 14px; }

        /* ── HERO BANNER ── */
        .hero {
            margin-top: 5rem;
            text-align: center;
            padding: 0 0 0px;
            opacity: 0;
            animation: fadeUp .7s .1s ease forwards;
        }

        .check-ring {
            position: relative;
            width: 96px;
            height: 96px;
            margin: 0 auto 28px;
        }
        .check-ring svg.ring {
            position: absolute;
            inset: 0;
            animation: spinIn .8s .2s cubic-bezier(.34,1.56,.64,1) both;
        }
        .check-ring .inner {
            position: absolute;
            inset: 10px;
            border-radius: 50%;
            background: linear-gradient(135deg, #b80505, #b80505);
            display: flex;
            align-items: center;
            justify-content: center;
            animation: popIn .5s .4s cubic-bezier(.34,1.56,.64,1) both;
        }
        .check-ring .inner svg { width: 32px; height: 32px; }

        @keyframes spinIn {
            from { transform: rotate(-90deg) scale(.6); opacity: 0; }
            to   { transform: rotate(0deg)  scale(1);   opacity: 1; }
        }
        @keyframes popIn {
            from { transform: scale(0); opacity: 0; }
            to   { transform: scale(1); opacity: 1; }
        }

        .hero-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(32px, 6vw, 48px);
            font-weight: 300;
            letter-spacing: .02em;
            line-height: 1.15;
            color: black;
            margin-bottom: 14px;
        }
        .hero-title span { color: #0066CC; font-weight: 600; }

        .hero-sub {
            font-size: 14px;
            color: #000000;
            line-height: 1.7;
            max-width: 440px;
            margin: 0 auto 24px;
        }
        .hero-sub strong { color: var(--gold-light); font-weight: 400; }

        .order-pill {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: transparent;
            border: 1px solid #fff;
            border-radius: 100px;
            padding: 8px 22px;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 500;
            letter-spacing: .12em;
            color: #fff;
        }
        .order-pill .dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #fff;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%,100% { opacity:1; transform:scale(1); }
            50%      { opacity:.4; transform:scale(1.4); }
        }

        /* ── DIVIDER ── */
        .gold-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 36px;
            opacity: 0;
            animation: fadeUp .6s .2s ease forwards;
        }
        .gold-divider::before,
        .gold-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--border));
        }
        .gold-divider::after {
            background: linear-gradient(to left, transparent, var(--border));
        }
        .gold-divider span {
            font-size: 12px;
            letter-spacing: 1rem;
            text-transform: uppercase;
            color: var(--text-dim);
            font-weight: 700;
        }

        /* ── CARD ── */
        .card {
            background: #0066CC;
            border: 1px solid var(--border-soft);
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 16px;
            opacity: 0;
            animation: fadeUp .6s ease forwards;
            box-shadow: 0 1px 5px 0px rgba(0,0,0,0.2);
        }
        .card:nth-child(3) { animation-delay: .25s; }
        .card:nth-child(4) { animation-delay: .35s; }
        .card:nth-child(5) { animation-delay: .45s; }

        .card-header {
            padding: 20px 28px;
            border-bottom: 1px solid var(--border-soft);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .card-header-icon {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: rgba(200,169,110,.1);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-header-icon svg { width: 15px; height: 15px; color: #fff; }
        .card-header-label {
            font-size: 10px;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: #fff
            font-weight: 500;
        }

        .card-body { padding: 24px 28px; }

        /* ── TWO-COL INFO ── */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
        }
        @media(max-width:560px) { .info-grid { grid-template-columns: 1fr; } }

        .info-col {
            padding: 20px 28px;
        }
        .info-col + .info-col {
            border-left: 1px solid var(--border-soft);
        }
        @media(max-width:560px) {
            .info-col + .info-col {
                border-left: none;
                border-top: 1px solid var(--border-soft);
            }
        }

        .info-label {
            font-size: 12px;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: #fff;
            font-weight: 600;
            margin-bottom: 12px;
        }
        .info-value {
            font-size: 14px;
            color: #f0eeee;
            line-height: 1.8;
        }
        .info-value strong { font-weight: 500; color: #f0eeee; }
        .info-value a { color: var(--gold-light); text-decoration: none; }

        /* ── STATUS BADGE ── */
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: .04em;
            margin-top: 8px;
        }
        .badge-warn {
            background: rgba(232,168,56,.12);
            border: 1px solid rgba(232,168,56,.3);
            color: var(--warn);
        }
        .badge-success {
            background: rgba(76,175,118,.12);
            border: 1px solid rgba(76,175,118,.3);
            color: var(--success);
        }

        /* ── PAYMENT NOTICE ── */
        .payment-notice {
            margin-top: 14px;
            padding: 14px 16px;
            border-radius: 10px;
            font-size: 13px;
            line-height: 1.6;
        }
        .payment-notice.mobile {
            background: rgba(232,168,56,.07);
            border: 1px solid rgba(232,168,56,.2);
            color: #f9cb6c ;
        }
        .payment-notice.bank {
            background: rgba(100,160,220,.07);
            border: 1px solid rgba(100,160,220,.2);
            color: #7AADDA;
        }
        .payment-notice strong { font-weight: 500; }

        /* ── ITEMS LIST ── */
        .items-header {
            padding: 20px 28px 0;
            font-size: 12px;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: #fff;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .item-row {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 28px;
            border-bottom: 1px solid var(--border-soft);
            transition: background .2s;
        }
        .item-row:last-child { border-bottom: none; }
        .item-row:hover { background: rgba(255,255,255,.02); }

        .item-img {
            width: 52px; height: 52px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid var(--border-soft);
            flex-shrink: 0;
        }
        .item-placeholder {
            width: 52px; height: 52px;
            border-radius: 8px;
            background: var(--bg-card2);
            border: 1px solid var(--border-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .item-placeholder svg { width: 20px; height: 20px; color: var(--text-dim); }

        .item-info { flex: 1; min-width: 0; }
        .item-name {
            font-size: 15px;
            font-weight: 500;
            color: #f0eeee;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .item-color {
            font-size: 12px;
            color: #fff
            margin-top: 3px;
        }
        .item-qty {
            font-size: 13px;
            color: #b1b0b5;
            margin-top: 3px;
        }
        .item-total {
            font-size: 18px;
            font-weight: 800;
            color: #800000;
            flex-shrink: 0;
        }

        /* ── TOTALS ── */
        .totals {
            padding: 20px 28px;
            background: #0066CC;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            color: #fff
            margin-bottom: 10px;
        }
        .total-row.grand {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
            font-size: 18px;
            color: #f0eeee;
            font-family: 'Cormorant Garamond', serif;
            font-weight: 800;
        }
        .total-row.grand .amount { color: #fff; font-size: 22px; }
        .shipping-note {
            display: inline-block;
            font-size: 11px;
            color: var(--warn);
            border: 1px solid rgba(232,168,56,.25);
            background: rgba(232,168,56,.06);
            border-radius: 100px;
            padding: 2px 10px;
        }

        /* ── ACTIONS ── */
        .actions {
            display: flex;
            gap: 12px;
            margin-top: 32px;
            opacity: 0;
            animation: fadeUp .6s .55s ease forwards;
        }
        @media(max-width:480px) { .actions { flex-direction: column; } }

        .btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 15px 24px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            letter-spacing: .06em;
            text-decoration: none;
            transition: all .25s ease;
            cursor: pointer;
            border: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, #0066cc, #cfe7fd);
            color: #fff;
        }
        .btn-primary:hover {
            box-shadow: 0 8px 28px rgba(200,169,110,.3);
            transform: translateY(-2px);
            color: #0E0E12;
        }
        .btn-ghost {
            background: #b80505;
            border: 1px solid var(--border);
            color: #fff
        }
        .btn-ghost:hover {
            border-color: #fff;
            color: #fff;
            transform: translateY(-2px);
        }
        .btn svg { width: 16px; height: 16px; }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity:0; transform:translateY(18px); }
            to   { opacity:1; transform:translateY(0); }
        }
    </style>
</head>
<body class="animsition">

    @include('client.body.header')
    @include('frontend.modal')

    <div class="confirm-wrapper">

        {{-- Brand bar --}}
        {{-- <div class="brand-bar">
            <span class="brand-name">ABS-Technologie</span>
            <a href="{{ route('client.index') }}" class="brand-back">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Retour à l'accueil
            </a>
        </div> --}}

        {{-- Hero --}}
        <div class="hero">
            <div class="check-ring">
                <svg class="ring" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="48" cy="48" r="46" stroke="url(#goldGrad)" stroke-width="1.5" stroke-dasharray="4 6" stroke-linecap="round"/>
                    <defs>
                        <linearGradient id="goldGrad" x1="0" y1="0" x2="96" y2="96">
                            <stop stop-color="#C8A96E"/>
                            <stop offset="1" stop-color="#8B6914"/>
                        </linearGradient>
                    </defs>
                </svg>
                <div class="inner">
                    <svg fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>

            <h1 class="hero-title">Commande <span>confirmée</span></h1>
            <p class="hero-sub">
                Merci pour votre confiance. Une confirmation a été envoyée à
                <strong>{{ $order->shipping_email }}</strong>.
            </p>
            <div class="order-pill">
                <span class="dot"></span>
                {{ $order->order_number }}
            </div>
        </div>

        {{-- Divider --}}
        <div class="gold-divider"><span>Détails de la commande</span></div>

        {{-- Livraison + Paiement --}}
        <div class="card">
            <div class="info-grid">
                {{-- Livraison --}}
                <div class="info-col">
                    <div class="info-label">Adresse de livraison</div>
                    <div class="info-value">
                        <strong>{{ $order->shipping_fullname }}</strong><br>
                        {{ $order->shipping_address }}<br>
                        {{ $order->shipping_city }}, {{ $order->shipping_country }}<br>
                        <a href="tel:{{ $order->shipping_phone }}">{{ $order->shipping_phone }}</a>
                    </div>
                    @if($order->shipping_notes)
                        <div style="font-size:12px;color:var(--text-dim);margin-top:10px;font-style:italic">
                            {{ $order->shipping_notes }}
                        </div>
                    @endif
                </div>

                {{-- Paiement --}}
                <div class="info-col">
                    <div class="info-label">Paiement</div>
                    <div class="info-value">
                        {{ $order->payment_label }}
                    </div>
                    <span class="badge {{ $order->status === 'pending' ? 'badge-warn' : 'badge-success' }}">
                        {{ $order->status_label }}
                    </span>

                    @if($order->payment_method === 'mobile_money')
                        <div class="payment-notice mobile">
                            Envoyez le montant au&nbsp;: <strong>+229 96 71 66 79</strong><br>
                            Référence&nbsp;: <strong>{{ $order->order_number }}</strong>
                        </div>
                    @elseif($order->payment_method === 'bank_transfer')
                        <div class="payment-notice bank">
                            🏦 Coordonnées bancaires envoyées à <strong>{{ $order->shipping_email }}</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Articles --}}
        <div class="card">
            <div class="items-header">
                Articles &nbsp;·&nbsp; {{ $order->items->count() }} produit{{ $order->items->count() > 1 ? 's' : '' }}
            </div>

            @foreach($order->items as $item)
            <div class="item-row">
                @if($item->product_image)
                    <img class="item-img"
                         src="{{ asset('storage/'.$item->product_image) }}"
                         alt="{{ $item->product_name }}">
                @else
                    <div class="item-placeholder">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif

                <div class="item-info">
                    <div class="item-name">{{ $item->product_name }}</div>
                    @if($item->color_name)
                        <div class="item-color">Couleur : {{ $item->color_name }}</div>
                    @endif
                    <div class="item-qty">{{ $item->quantity }} × {{ number_format($item->unit_price, 0, ',', ' ') }} FCFA</div>
                </div>

                <div class="item-total">{{ number_format($item->total_price, 0, ',', ' ') }} FCFA</div>
            </div>
            @endforeach

            {{-- Totals --}}
            <div class="totals">
                <div class="total-row">
                    <span>Sous-total</span>
                    <span>{{ number_format($order->subtotal, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="total-row">
                    <span>Livraison</span>
                    <span class="shipping-note">À régler au livreur</span>
                </div>
                <div class="total-row grand">
                    <span>Total payé</span>
                    <span class="amount">{{ number_format($order->total, 0, ',', ' ') }} FCFA</span>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="actions">
            <a href="{{ route('client.my.orders') }}" class="btn btn-primary">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Mes commandes
            </a>
            <a href="{{ route('client.index') }}" class="btn btn-ghost">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10h5v-6h4v6h5V10"/>
                </svg>
                Accueil
            </a>
        </div>

    </div>

    @include('client.body.footer')

    <script src="{{ asset('frontend/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/animsition/js/animsition.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    @include('frontend.global_js')
</body>
</html>