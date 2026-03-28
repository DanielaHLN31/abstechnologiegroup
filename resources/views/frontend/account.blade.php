<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Mon Compte ABS-TECHNOLOGIE</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/icons/favicon.png') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/fonts/iconic/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/animate/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/css-hamburgers/hamburgers.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/animsition/css/animsition.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/MagnificPopup/magnific-popup.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/main.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        /* ══════════════════════════════════════════════
           VARIABLES & BASE
        ══════════════════════════════════════════════ */
        :root {
            --primary:   #0066CC;
            --primary-d: #0066CC;
            --danger:    #e65540;
            --success:   #28a745;
            --text:      #333;
            --muted:     #888;
            --border:    #e8e8e8;
            --bg-light:  #f8f8f8;
            --sidebar-w: 270px;
            --radius:    10px;
            --shadow:    0 4px 24px rgba(0,0,0,.07);
        }

        body { background: #f4f5f9; color: var(--text); }

        /* ══════════════════════════════════════════════
           BREADCRUMB
        ══════════════════════════════════════════════ */
        .account-breadcrumb {
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: 14px 0;
        }
        .account-breadcrumb .breadcrumb {
            margin: 0;
            background: none;
            padding: 0;
            font-size: 13px;
        }
        .account-breadcrumb .breadcrumb-item a { color: var(--primary); text-decoration: none; }
        .account-breadcrumb .breadcrumb-item.active { color: var(--muted); }

        /* ══════════════════════════════════════════════
           LAYOUT
        ══════════════════════════════════════════════ */
        .account-wrapper {
            display: flex;
            gap: 28px;
            padding: 40px 0 60px;
            align-items: flex-start;
        }

        /* ══════════════════════════════════════════════
           SIDEBAR
        ══════════════════════════════════════════════ */
        .account-sidebar {
            width: var(--sidebar-w);
            flex-shrink: 0;
            background: #fff;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .sidebar-avatar {
            background: linear-gradient(135deg, var(--primary), var(--primary-d));
            padding: 32px 20px 24px;
            text-align: center;
            color: #fff;
        }
        .sidebar-avatar .avatar-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255,255,255,.25);
            margin: 0 auto 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 700;
            border: 3px solid rgba(255,255,255,.5);
            overflow: hidden;
        }
        .sidebar-avatar .avatar-circle img {
            width: 100%; height: 100%; object-fit: cover;
        }
        .sidebar-avatar h6 {
            font-size: 16px;
            font-weight: 600;
            margin: 0 0 4px;
        }
        .sidebar-avatar small {
            font-size: 12px;
            opacity: .8;
        }

        .sidebar-nav { padding: 12px 0; }
        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 22px;
            color: #555;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all .2s;
            border-left: 3px solid transparent;
        }
        .sidebar-nav a i {
            font-size: 18px;
            width: 22px;
            text-align: center;
            color: var(--muted);
            transition: color .2s;
        }
        .sidebar-nav a:hover {
            background: #f5f6ff;
            color: var(--primary);
            border-left-color: var(--primary);
        }
        .sidebar-nav a:hover i { color: var(--primary); }
        .sidebar-nav a.active {
            background: #f0f2ff;
            color: var(--primary);
            border-left-color: var(--primary);
            font-weight: 600;
        }
        .sidebar-nav a.active i { color: var(--primary); }

        .sidebar-divider {
            height: 1px;
            background: var(--border);
            margin: 8px 0;
        }
        .sidebar-nav a.logout-link { color: var(--danger); }
        .sidebar-nav a.logout-link i { color: var(--danger); }
        .sidebar-nav a.logout-link:hover { background: #fff5f5; border-left-color: var(--danger); }

        /* ══════════════════════════════════════════════
           MAIN CONTENT
        ══════════════════════════════════════════════ */
        .account-main { flex: 1; min-width: 0; }

        .account-section {
            display: none;
            animation: fadeInUp .3s ease;
        }
        .account-section.active { display: block; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ══════════════════════════════════════════════
           CARDS
        ══════════════════════════════════════════════ */
        .account-card {
            background: #fff;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            margin-bottom: 24px;
            overflow: hidden;
        }
        .account-card-header {
            padding: 20px 28px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .account-card-header h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .account-card-header h5 i { color: var(--primary); font-size: 20px; }
        .account-card-body { padding: 28px; }

        /* ══════════════════════════════════════════════
           STATS RAPIDES
        ══════════════════════════════════════════════ */
        .stat-cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px; }
        .stat-card {
            background: #fff;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 22px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(0,0,0,.1); }
        .stat-icon {
            width: 52px; height: 52px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }
        .stat-icon.orders  { background: #eef0ff; color: var(--primary); }
        .stat-icon.wish    { background: #fff0f0; color: var(--danger); }
        .stat-icon.spent   { background: #edfff5; color: var(--success); }
        .stat-info span    { display: block; font-size: 22px; font-weight: 700; color: var(--text); }
        .stat-info small   { font-size: 12px; color: var(--muted); font-weight: 500; }

        /* ══════════════════════════════════════════════
           FORMULAIRE
        ══════════════════════════════════════════════ */
        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: #555;
            margin-bottom: 6px;
            display: block;
        }
        .form-control {
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 11px 15px;
            font-size: 14px;
            color: var(--text);
            transition: border-color .2s, box-shadow .2s;
            background: #fff;
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(113,127,224,.15);
            outline: none;
        }
        .form-control:disabled { background: var(--bg-light); color: var(--muted); }

        .btn-primary-custom {
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 32px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s, transform .1s;
        }
        .btn-primary-custom:hover { background: var(--primary-d); transform: translateY(-1px); }
        .btn-primary-custom:active { transform: translateY(0); }

        .btn-outline-custom {
            background: transparent;
            color: var(--primary);
            border: 1.5px solid var(--primary);
            border-radius: 8px;
            padding: 10px 24px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
        }
        .btn-outline-custom:hover { background: var(--primary); color: #fff; }

        /* ══════════════════════════════════════════════
           AVATAR UPLOAD
        ══════════════════════════════════════════════ */
        .avatar-upload-wrap {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px;
            background: var(--bg-light);
            border-radius: 10px;
            margin-bottom: 28px;
        }
        .avatar-preview {
            width: 80px; height: 80px;
            border-radius: 50%;
            background: var(--border);
            display: flex; align-items: center; justify-content: center;
            font-size: 28px; font-weight: 700; color: var(--primary);
            flex-shrink: 0;
            overflow: hidden;
            border: 3px solid var(--primary);
        }
        .avatar-preview img { width: 100%; height: 100%; object-fit: cover; }
        .avatar-upload-info h6 { font-size: 14px; font-weight: 600; margin-bottom: 6px; }
        .avatar-upload-info p  { font-size: 12px; color: var(--muted); margin: 0 0 10px; }

        /* ══════════════════════════════════════════════
           COMMANDES
        ══════════════════════════════════════════════ */
        .orders-table-wrap { overflow-x: auto; }
        .orders-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        .orders-table th {
            background: var(--bg-light);
            padding: 13px 16px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--muted);
            border-bottom: 2px solid var(--border);
            white-space: nowrap;
        }
        .orders-table td {
            padding: 16px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            color: var(--text);
        }
        .orders-table tr:last-child td { border-bottom: none; }
        .orders-table tr:hover td { background: #fafafe; }

        .order-number { font-weight: 700; color: var(--primary); font-size: 13px; }

        .order-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .order-badge.pending    { background: #fff8e6; color: #e6a817; }
        .order-badge.processing { background: #eef0ff; color: var(--primary); }
        .order-badge.shipped    { background: #e6f4ff; color: #0077cc; }
        .order-badge.delivered  { background: #edfff5; color: var(--success); }
        .order-badge.cancelled  { background: #fff0f0; color: var(--danger); }
        .order-badge::before    { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

        .btn-order-detail {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            background: var(--bg-light);
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text);
            text-decoration: none;
            transition: all .2s;
        }
        .btn-order-detail:hover { background: var(--primary); color: #fff; border-color: var(--primary); text-decoration: none; }

        /* ══════════════════════════════════════════════
           WISHLIST
        ══════════════════════════════════════════════ */
        .wishlist-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }
        .wishlist-card {
            background: var(--bg-light);
            border-radius: var(--radius);
            overflow: hidden;
            border: 1px solid var(--border);
            transition: box-shadow .2s, transform .2s;
            position: relative;
        }
        .wishlist-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.1); transform: translateY(-3px); }
        .wishlist-card-img {
            height: 160px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .wishlist-card-img img { width: 100%; height: 100%; object-fit: contain; padding: 10px; }
        .wishlist-card-body { padding: 14px; }
        .wishlist-card-body h6 {
            font-size: 13px; font-weight: 600;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
            margin-bottom: 6px;
        }
        .wishlist-card-body .price { font-size: 15px; font-weight: 700; color: var(--primary); margin-bottom: 10px; }
        .wishlist-card-actions { display: flex; gap: 8px; }
        .btn-wish-cart {
            flex: 1;
            padding: 8px;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s;
            text-align: center;
        }
        .btn-wish-cart:hover { background: var(--primary-d); }
        .btn-wish-remove {
            width: 34px; height: 34px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            color: var(--danger);
            cursor: pointer;
            font-size: 14px;
            transition: all .2s;
            flex-shrink: 0;
        }
        .btn-wish-remove:hover { background: var(--danger); color: #fff; border-color: var(--danger); }
        .wishlist-badge {
            position: absolute;
            top: 10px; right: 10px;
            background: var(--danger);
            color: #fff;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 7px;
        }

        /* ══════════════════════════════════════════════
           ADRESSES
        ══════════════════════════════════════════════ */
        .address-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px; }
        .address-card {
            border: 2px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
            position: relative;
            transition: border-color .2s;
            cursor: pointer;
        }
        .address-card.default { border-color: var(--primary); }
        .address-card:hover { border-color: var(--primary); }
        .address-card .default-badge {
            position: absolute; top: 12px; right: 12px;
            background: var(--primary); color: #fff;
            font-size: 10px; font-weight: 700;
            padding: 3px 8px; border-radius: 4px;
        }
        .address-card h6 { font-size: 14px; font-weight: 700; margin-bottom: 8px; }
        .address-card p  { font-size: 13px; color: var(--muted); line-height: 1.6; margin: 0 0 14px; }
        .address-card-actions { display: flex; gap: 8px; }
        .btn-addr {
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
            border: 1.5px solid var(--border);
            background: #fff;
            color: var(--text);
        }
        .btn-addr:hover  { border-color: var(--primary); color: var(--primary); }
        .btn-addr.danger:hover { border-color: var(--danger); color: var(--danger); }
        .add-address-card {
            border: 2px dashed var(--border);
            border-radius: var(--radius);
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: border-color .2s, background .2s;
            min-height: 160px;
            color: var(--muted);
            font-size: 14px;
            font-weight: 500;
        }
        .add-address-card i { font-size: 28px; color: var(--border); transition: color .2s; }
        .add-address-card:hover { border-color: var(--primary); background: #f5f6ff; color: var(--primary); }
        .add-address-card:hover i { color: var(--primary); }

        /* ══════════════════════════════════════════════
           MOT DE PASSE — FORCE
        ══════════════════════════════════════════════ */
        .password-strength { margin-top: 8px; }
        .strength-bar {
            height: 4px;
            border-radius: 2px;
            background: var(--border);
            margin-bottom: 6px;
            overflow: hidden;
        }
        .strength-fill {
            height: 100%;
            border-radius: 2px;
            width: 0;
            transition: width .4s, background .4s;
        }
        .strength-fill.weak   { width: 25%; background: var(--danger); }
        .strength-fill.fair   { width: 50%; background: #e6a817; }
        .strength-fill.good   { width: 75%; background: #17a2b8; }
        .strength-fill.strong { width: 100%; background: var(--success); }
        .strength-label { font-size: 12px; color: var(--muted); }

        /* ══════════════════════════════════════════════
           EMPTY STATE
        ══════════════════════════════════════════════ */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--muted);
        }
        .empty-state i { font-size: 56px; color: var(--border); display: block; margin-bottom: 16px; }
        .empty-state h6 { font-size: 16px; font-weight: 600; color: #888; margin-bottom: 8px; }
        .empty-state p  { font-size: 14px; margin-bottom: 20px; }

        /* ══════════════════════════════════════════════
           PASSWORD TOGGLE
        ══════════════════════════════════════════════ */
        .input-group-custom { position: relative; }
        .input-group-custom .form-control { padding-right: 44px; }
        .toggle-password {
            position: absolute;
            right: 14px; top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--muted);
            font-size: 16px;
            transition: color .2s;
        }
        .toggle-password:hover { color: var(--primary); }

        /* ══════════════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════════════ */
        @media (max-width: 991px) {
            .account-wrapper { flex-direction: column; }
            .account-sidebar { width: 100%; }
            .sidebar-nav { display: flex; flex-wrap: wrap; gap: 4px; padding: 12px; }
            .sidebar-nav a { flex: 1 1 auto; border-left: none; border-bottom: 3px solid transparent; border-radius: 8px; justify-content: center; padding: 10px 14px; font-size: 12px; }
            .sidebar-nav a:hover, .sidebar-nav a.active { border-left: none; border-bottom-color: var(--primary); }
            .sidebar-divider { display: none; }
            .stat-cards { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 576px) {
            .stat-cards { grid-template-columns: 1fr; }
            .account-card-body { padding: 18px; }
        }
    </style>
</head>

<body class="animsition">

    @include('client.body.header')


    <div class="container  p-t-80 p-b-80">
        <div class="account-wrapper">

            {{-- ══════════ SIDEBAR ══════════ --}}
            <aside class="account-sidebar">
                <div class="sidebar-avatar">
                    <div class="avatar-circle">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar">
                        @else
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        @endif
                    </div>
                    <h6>{{ auth()->user()->name }}</h6>
                    <small>{{ auth()->user()->email }}</small>
                </div>

                <nav class="sidebar-nav">
                    <a href="#" class="active" data-section="dashboard">
                        <i class="zmdi zmdi-view-dashboard"></i> Tableau de bord
                    </a>
                    <a href="#" data-section="profile">
                        <i class="zmdi zmdi-account"></i> Informations personnelles
                    </a>
                    {{-- <a href="#" data-section="orders">
                        <i class="zmdi zmdi-shopping-cart"></i> Mes commandes
                    </a> --}}
                    <a href="#" data-section="wishlist">
                        <i class="zmdi zmdi-favorite"></i> Ma wishlist
                    </a>
                    <a href="#" data-section="addresses">
                        <i class="zmdi zmdi-pin"></i> Mes adresses
                    </a>
                    <a href="#" data-section="password">
                        <i class="zmdi zmdi-lock"></i> Changer de mot de passe
                    </a>

                    <div class="sidebar-divider"></div>

                    <a href="{{ route('auth.logout') }}" class="logout-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="zmdi zmdi-power"></i> Déconnexion
                    </a>
                    <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="d-none">@csrf</form>
                </nav>
            </aside>

            {{-- ══════════ CONTENU ══════════ --}}
            <main class="account-main">

                {{-- ── 1. TABLEAU DE BORD ── --}}
                <section id="section-dashboard" class="account-section active">

                    {{-- Stats --}}
                    <div class="stat-cards">
                        <div class="stat-card">
                            <div class="stat-icon orders"><i class="zmdi zmdi-shopping-cart"></i></div>
                            <div class="stat-info">
                                <span>{{ $ordersCount ?? 0 }}</span>
                                <small>Commandes</small>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon wish"><i class="zmdi zmdi-favorite"></i></div>
                            <div class="stat-info">
                                <span>{{ $wishlistCount ?? 0 }}</span>
                                <small>Favoris</small>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon spent"><i class="zmdi zmdi-money"></i></div>
                            <div class="stat-info">
                                <span>{{ number_format($totalSpent ?? 0, 0, ',', ' ') }}</span>
                                <small>FCFA dépensés</small>
                            </div>
                        </div>
                    </div>

                    {{-- Dernières commandes --}}
                    <div class="account-card">
                        <div class="account-card-header">
                            <h5><i class="zmdi zmdi-shopping-cart"></i> Dernières commandes</h5>
                            <a href="#" class="stext-106" style="color:var(--primary);font-size:13px" data-section="orders">Voir tout →</a>
                        </div>
                        <div class="account-card-body" style="padding:0">
                            <div class="orders-table-wrap">
                                <table class="orders-table">
                                    <thead>
                                        <tr>
                                            <th>N° Commande</th>
                                            <th>Date</th>
                                            <th>Montant</th>
                                            <th>Statut</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentOrders ?? [] as $order)
                                        <tr>
                                            <td><span class="order-number">#{{ $order->order_number }}</span></td>
                                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                            <td><strong>{{ number_format($order->total, 0, ',', ' ') }} FCFA</strong></td>
                                            <td>
                                                <span class="order-badge {{ $order->status }}">
                                                    @switch($order->status)
                                                        @case('pending')    En attente   @break
                                                        @case('processing') En cours     @break
                                                        @case('shipped')    Expédiée     @break
                                                        @case('delivered')  Livrée       @break
                                                        @case('cancelled')  Annulée      @break
                                                        @default {{ $order->status }}
                                                    @endswitch
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('client.order.show', $order->order_number) }}" class="btn-order-detail">
                                                    <i class="zmdi zmdi-eye"></i> Détail
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5">
                                                <div class="empty-state">
                                                    <i class="zmdi zmdi-shopping-cart"></i>
                                                    <h6>Aucune commande</h6>
                                                    <p>Vous n'avez pas encore passé de commande.</p>
                                                    <a href="{{ route('client.product') }}" class="btn-primary-custom" style="text-decoration:none;display:inline-block">
                                                        Découvrir nos produits
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- ── 2. INFORMATIONS PERSONNELLES ── --}}
                <section id="section-profile" class="account-section">
                    <div class="account-card">
                        <div class="account-card-header">
                            <h5><i class="zmdi zmdi-account"></i> Informations personnelles</h5>
                        </div>
                        <div class="account-card-body">

                            {{-- Avatar --}}
                            {{-- <div class="avatar-upload-wrap">
                                <div class="avatar-preview" id="avatar-preview">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" id="avatar-img">
                                    @else
                                        <span id="avatar-initials">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                    @endif
                                </div>
                                <div class="avatar-upload-info">
                                    <h6>Photo de profil</h6>
                                    <p>JPG, PNG ou GIF — max 2 Mo</p>
                                    <label for="avatar-input" class="btn-outline-custom" style="margin:0;cursor:pointer">
                                        <i class="zmdi zmdi-upload m-r-5"></i> Changer la photo
                                    </label>
                                    <input type="file" id="avatar-input" accept="image/*" class="d-none">
                                </div>
                            </div> --}}

                            <form action="{{ route('client.account.update') }}" method="POST" enctype="multipart/form-data" id="profile-form">
                                @csrf @method('PUT')
                                <input type="file" name="avatar" id="avatar-hidden" class="d-none">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label>Prénom</label>
                                            <input type="text" name="first_name" class="form-control"
                                                value="{{ auth()->user()->first_name ?? '' }}"
                                                placeholder="Votre prénom">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label>Nom</label>
                                            <input type="text" name="last_name" class="form-control"
                                                value="{{ auth()->user()->last_name ?? '' }}"
                                                placeholder="Votre nom">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label>Adresse e-mail</label>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ auth()->user()->email }}"
                                                placeholder="exemple@email.com">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label>Téléphone</label>
                                            <input type="tel" name="phone" class="form-control"
                                                value="{{ auth()->user()->client->phone ?? '' }}"
                                                placeholder="+229 XX XX XX XX">
                                        </div>
                                    </div>
                                    {{-- <div class="col-12">
                                        <div class="form-group mb-4">
                                            <label>Date de naissance</label>
                                            <input type="date" name="birth_date" class="form-control"
                                                value="{{ auth()->user()->client->birth_date ?? '' }}">
                                        </div>
                                    </div> --}}
                                </div>

                                <div class="d-flex gap-3 flex-wrap" style="gap:12px">
                                    <button type="submit" class="btn-primary-custom">
                                        <i class="fa fa-save m-r-6"></i> Enregistrer les modifications
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>

                {{-- ── 3. MES COMMANDES ── --}}
                <section id="section-orders" class="account-section">
                    <div class="account-card">
                        <div class="account-card-header">
                            <h5><i class="zmdi zmdi-shopping-cart"></i> Mes commandes</h5>
                        </div>

                        {{-- Filtres statut --}}
                        <div style="padding:16px 28px; border-bottom:1px solid var(--border); display:flex; gap:8px; flex-wrap:wrap">
                            @foreach(['all' => 'Toutes', 'pending' => 'En attente', 'processing' => 'En cours', 'shipped' => 'Expédiées', 'delivered' => 'Livrées', 'cancelled' => 'Annulées'] as $val => $label)
                            <button class="btn-addr order-status-filter {{ $val === 'all' ? 'active-filter' : '' }}" data-status="{{ $val }}"
                                style="{{ $val === 'all' ? 'border-color:var(--primary);color:var(--primary)' : '' }}">
                                {{ $label }}
                            </button>
                            @endforeach
                        </div>

                        <div class="account-card-body" style="padding:0">
                            <div class="orders-table-wrap">
                                <table class="orders-table">
                                    <thead>
                                        <tr>
                                            <th>N° Commande</th>
                                            <th>Date</th>
                                            <th>Articles</th>
                                            <th>Montant</th>
                                            <th>Statut</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="orders-tbody">
                                        @forelse($orders ?? [] as $order)
                                        <tr data-status="{{ $order->status }}">
                                            <td><span class="order-number">#{{ $order->order_number }}</span></td>
                                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                            <td>{{ $order->items_count ?? $order->items->count() }} article(s)</td>
                                            <td><strong>{{ number_format($order->total, 0, ',', ' ') }} FCFA</strong></td>
                                            <td>
                                                <span class="order-badge {{ $order->status }}">
                                                    @switch($order->status)
                                                        @case('pending')    En attente @break
                                                        @case('processing') En cours   @break
                                                        @case('shipped')    Expédiée   @break
                                                        @case('delivered')  Livrée     @break
                                                        @case('cancelled')  Annulée    @break
                                                        @default {{ $order->status }}
                                                    @endswitch
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('client.order.show', $order->id) }}" class="btn-order-detail">
                                                    <i class="zmdi zmdi-eye"></i> Voir
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6">
                                                <div class="empty-state">
                                                    <i class="zmdi zmdi-shopping-cart"></i>
                                                    <h6>Aucune commande</h6>
                                                    <p>Vous n'avez encore passé aucune commande.</p>
                                                    <a href="{{ route('client.product') }}" class="btn-primary-custom" style="text-decoration:none;display:inline-block">
                                                        Commencer mes achats
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- ── 4. MA WISHLIST ── --}}
                <section id="section-wishlist" class="account-section">
                    <div class="account-card">
                        <div class="account-card-header">
                            <h5><i class="zmdi zmdi-favorite"></i> Ma wishlist</h5>
                            <span class="stext-106" style="color:var(--muted);font-size:13px">
                                {{ ($wishlistItems ?? collect())->count() }} produit(s)
                            </span>
                        </div>
                        <div class="account-card-body">
                            @if(($wishlistItems ?? collect())->isNotEmpty())
                            <div class="wishlist-grid">
                                @foreach($wishlistItems as $item)
                                <div class="wishlist-card" id="wish-item-{{ $item->product->id }}">
                                    @if($item->product->compare_price && $item->product->compare_price > $item->product->price)
                                    <span class="wishlist-badge">
                                        -{{ round((1 - $item->product->price / $item->product->compare_price) * 100) }}%
                                    </span>
                                    @endif
                                    <div class="wishlist-card-img">
                                        @if($item->product->images->isNotEmpty())
                                            <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" alt="{{ $item->product->name }}">
                                        @else
                                            <i class="zmdi zmdi-image-alt" style="font-size:48px;color:#ddd"></i>
                                        @endif
                                    </div>
                                    <div class="wishlist-card-body">
                                        <h6 title="{{ $item->product->name }}">{{ $item->product->name }}</h6>
                                        <div class="price">{{ number_format($item->product->price, 0, ',', ' ') }} FCFA</div>
                                        <div class="wishlist-card-actions">
                                            <button class="btn-wish-cart" data-product-id="{{ $item->product->id }}">
                                                <i class="zmdi zmdi-shopping-cart m-r-4"></i> Panier
                                            </button>
                                            <button class="btn-wish-remove" data-product-id="{{ $item->product->id }}" title="Retirer">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="empty-state">
                                <i class="zmdi zmdi-favorite-outline"></i>
                                <h6>Votre wishlist est vide</h6>
                                <p>Ajoutez des produits à vos favoris pour les retrouver ici.</p>
                                <a href="{{ route('client.product') }}" class="btn-primary-custom" style="text-decoration:none;display:inline-block">
                                    Explorer la boutique
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </section>

                {{-- ── 5. MES ADRESSES ── --}}
                <section id="section-addresses" class="account-section">
                    <div class="account-card">
                        <div class="account-card-header">
                            <h5><i class="zmdi zmdi-pin"></i> Mon adresse de livraison</h5>
                        </div>
                        <div class="account-card-body">
                            <form action="{{ route('client.account.update') }}" method="POST">
                                @csrf @method('PUT')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-4">
                                            <label>Adresse</label>
                                            <input type="text" name="address" class="form-control"
                                                value="{{ $client->address ?? '' }}"
                                                placeholder="Rue, quartier, numéro...">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label>Ville</label>
                                            <input type="text" name="city" class="form-control"
                                                value="{{ $client->city ?? '' }}"
                                                placeholder="Cotonou">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label>Pays</label>
                                            <input type="text" name="country" class="form-control"
                                                value="{{ $client->country ?? 'Bénin' }}"
                                                placeholder="Bénin">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label>Téléphone</label>
                                            <input type="tel" name="phone" class="form-control"
                                                value="{{ $client->phone ?? '' }}"
                                                placeholder="+229 XX XX XX XX">
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn-primary-custom">
                                    <i class="fa fa-save m-r-6"></i> Enregistrer l'adresse
                                </button>
                            </form>
                        </div>
                    </div>
                </section>

                {{-- ── 6. MOT DE PASSE ── --}}
                <section id="section-password" class="account-section">
                    <div class="account-card">
                        <div class="account-card-header">
                            <h5><i class="zmdi zmdi-lock"></i> Changer de mot de passe</h5>
                        </div>
                        <div class="account-card-body">
                            <form action="{{ route('client.account.password') }}" method="POST" id="password-form">
                                @csrf @method('PUT')
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group mb-4">
                                            <label>Mot de passe actuel</label>
                                            <div class="input-group-custom">
                                                <input type="password" name="current_password" class="form-control" id="current-pwd" placeholder="Votre mot de passe actuel">
                                                <i class="zmdi zmdi-eye toggle-password" data-target="current-pwd"></i>
                                            </div>
                                        </div>

                                        <div class="form-group mb-4">
                                            <label>Nouveau mot de passe</label>
                                            <div class="input-group-custom">
                                                <input type="password" name="password" class="form-control" id="new-pwd" placeholder="Minimum 8 caractères">
                                                <i class="zmdi zmdi-eye toggle-password" data-target="new-pwd"></i>
                                            </div>
                                            <div class="password-strength">
                                                <div class="strength-bar"><div class="strength-fill" id="strength-fill"></div></div>
                                                <span class="strength-label" id="strength-label">Entrez un mot de passe</span>
                                            </div>
                                        </div>

                                        <div class="form-group mb-4">
                                            <label>Confirmer le nouveau mot de passe</label>
                                            <div class="input-group-custom">
                                                <input type="password" name="password_confirmation" class="form-control" id="confirm-pwd" placeholder="Répétez le nouveau mot de passe">
                                                <i class="zmdi zmdi-eye toggle-password" data-target="confirm-pwd"></i>
                                            </div>
                                            <small id="confirm-match" style="font-size:12px;margin-top:4px;display:block"></small>
                                        </div>

                                        <div class="p-3 mb-4" style="background:#f5f6ff;border-radius:8px;border-left:4px solid var(--primary)">
                                            <p style="font-size:13px;color:#555;margin:0">
                                                <strong>Conseils :</strong> Utilisez au moins 8 caractères, incluez des majuscules, 
                                                des chiffres et des caractères spéciaux pour un mot de passe fort.
                                            </p>
                                        </div>

                                        <button type="submit" class="btn-primary-custom">
                                            <i class="zmdi zmdi-lock m-r-6"></i> Mettre à jour le mot de passe
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>

            </main>
        </div>
    </div>

    @include('client.body.footer')

    {{-- Scripts --}}
    <script src="{{ asset('frontend/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/animsition/js/animsition.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/sweetalert/sweetalert.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>

    <script>
    $(document).ready(function () {

        const TOKEN = '{{ csrf_token() }}';

        // ── Config toastr ──────────────────────────────────────────────
        toastr.options = {
            closeButton: true, progressBar: true,
            positionClass: 'toast-bottom-right',
            timeOut: 3500
        };

        // ══════════════════════════════════════════════
        // NAVIGATION SIDEBAR
        // ══════════════════════════════════════════════
        function showSection(name) {
            $('.account-section').removeClass('active');
            $('#section-' + name).addClass('active');
            $('.sidebar-nav a').removeClass('active');
            $('.sidebar-nav a[data-section="' + name + '"]').addClass('active');
            // Scroll haut
            $('html,body').animate({ scrollTop: $('.account-main').offset().top - 20 }, 200);
        }

        $(document).on('click', '[data-section]', function (e) {
            e.preventDefault();
            showSection($(this).data('section'));
        });

        // Lire le hash dans l'URL
        const hash = window.location.hash.replace('#', '');
        if (hash && $('#section-' + hash).length) showSection(hash);

        // ══════════════════════════════════════════════
        // FLASH MESSAGES (Laravel session)
        // ══════════════════════════════════════════════
        @if(session('success'))
            toastr.success('{{ session("success") }}');
        @endif
        @if(session('error'))
            toastr.error('{{ session("error") }}');
        @endif
        @if(session('section'))
            showSection('{{ session("section") }}');
        @endif

        // ══════════════════════════════════════════════
        // AVATAR PREVIEW
        // ══════════════════════════════════════════════
        $('#avatar-input').on('change', function () {
            const file = this.files[0];
            if (!file) return;

            // Copier dans le vrai input du form
            const dt = new DataTransfer();
            dt.items.add(file);
            document.getElementById('avatar-hidden').files = dt.files;

            const reader = new FileReader();
            reader.onload = function (e) {
                $('#avatar-preview').html('<img src="' + e.target.result + '" style="width:100%;height:100%;object-fit:cover;border-radius:50%">');
                // Mettre à jour aussi le sidebar
                $('.sidebar-avatar .avatar-circle').html('<img src="' + e.target.result + '" style="width:100%;height:100%;object-fit:cover;">');
            };
            reader.readAsDataURL(file);
        });

        // ══════════════════════════════════════════════
        // TOGGLE MOT DE PASSE VISIBLE
        // ══════════════════════════════════════════════
        $(document).on('click', '.toggle-password', function () {
            const $input = $('#' + $(this).data('target'));
            const isText = $input.attr('type') === 'text';
            $input.attr('type', isText ? 'password' : 'text');
            $(this).toggleClass('zmdi-eye zmdi-eye-off');
        });

        // ══════════════════════════════════════════════
        // FORCE DU MOT DE PASSE
        // ══════════════════════════════════════════════
        $('#new-pwd').on('input', function () {
            const val = $(this).val();
            const $fill = $('#strength-fill');
            const $label = $('#strength-label');

            let score = 0;
            if (val.length >= 8)            score++;
            if (/[A-Z]/.test(val))          score++;
            if (/[0-9]/.test(val))          score++;
            if (/[^A-Za-z0-9]/.test(val))   score++;

            const levels = [
                { cls: '', label: 'Entrez un mot de passe' },
                { cls: 'weak',   label: 'Faible' },
                { cls: 'fair',   label: 'Moyen' },
                { cls: 'good',   label: 'Bon' },
                { cls: 'strong', label: 'Fort ✓' },
            ];
            const lv = levels[val.length === 0 ? 0 : score] || levels[4];
            $fill.removeClass('weak fair good strong').addClass(lv.cls);
            $label.text(lv.label);
        });

        // Confirmation mot de passe
        $('#confirm-pwd').on('input', function () {
            const match = $(this).val() === $('#new-pwd').val();
            $('#confirm-match')
                .text(match ? '✓ Les mots de passe correspondent' : '✗ Les mots de passe ne correspondent pas')
                .css('color', match ? 'var(--success)' : 'var(--danger)');
        });

        // ══════════════════════════════════════════════
        // FILTRE STATUT COMMANDES
        // ══════════════════════════════════════════════
        $(document).on('click', '.order-status-filter', function () {
            const status = $(this).data('status');
            $('.order-status-filter').css({ 'border-color': 'var(--border)', 'color': 'var(--text)' });
            $(this).css({ 'border-color': 'var(--primary)', 'color': 'var(--primary)' });

            if (status === 'all') {
                $('#orders-tbody tr').show();
            } else {
                $('#orders-tbody tr').hide();
                $('#orders-tbody tr[data-status="' + status + '"]').show();
            }
        });

        // ══════════════════════════════════════════════
        // WISHLIST — Retirer
        // ══════════════════════════════════════════════
        $(document).on('click', '.btn-wish-remove', function () {
            const productId = $(this).data('product-id');
            const $card = $('#wish-item-' + productId);

            $.ajax({
                url: '{{ route("client.wishlist.toggle") }}',
                method: 'POST',
                data: { product_id: productId, _token: TOKEN },
                success: function (res) {
                    $card.fadeOut(300, function () { $(this).remove(); });
                    toastr.info('Produit retiré de la wishlist.', 'Favoris');
                },
                error: function () {
                    toastr.error('Impossible de retirer ce produit.', 'Erreur');
                }
            });
        });

        // ══════════════════════════════════════════════
        // WISHLIST — Ajouter au panier
        // ══════════════════════════════════════════════
        $(document).on('click', '.btn-wish-cart', function () {
            const productId = $(this).data('product-id');
            const $btn = $(this).text('...').prop('disabled', true);

            $.ajax({
                url: '/client/cart/add',
                method: 'POST',
                data: { product_id: productId, quantity: 1, _token: TOKEN },
                success: function (res) {
                    $btn.html('<i class="zmdi zmdi-shopping-cart m-r-4"></i> Panier').prop('disabled', false);
                    toastr.success('Produit ajouté au panier !', 'Panier');
                    if (res.cart_count !== undefined) {
                        $('.js-show-cart').attr('data-notify', res.cart_count);
                    }
                },
                error: function () {
                    $btn.html('<i class="zmdi zmdi-shopping-cart m-r-4"></i> Panier').prop('disabled', false);
                    toastr.error('Impossible d\'ajouter au panier.', 'Erreur');
                }
            });
        });

        // ══════════════════════════════════════════════
        // ADRESSES — Afficher/masquer le formulaire
        // ══════════════════════════════════════════════
        $('#btn-add-address').on('click', function () {
            $('#address-form-title').text('Nouvelle adresse');
            $('#address-form')[0].reset();
            $('#address-id-field').val('');
            $('#address-method').val('POST');
            $('#address-form-card').slideDown(250);
            $('html,body').animate({ scrollTop: $('#address-form-card').offset().top - 20 }, 300);
        });

        $('#btn-cancel-address').on('click', function () {
            $('#address-form-card').slideUp(250);
        });

        // Supprimer adresse
        $(document).on('click', '.btn-delete-address', function () {
            const id = $(this).data('id');
            swal({
                title: 'Supprimer cette adresse ?',
                text: 'Cette action est irréversible.',
                icon: 'warning',
                buttons: { cancel: 'Annuler', confirm: { text: 'Supprimer', value: true } }
            }).then(function (val) {
                if (!val) return;
                $.ajax({
                    url: '/client/address/' + id,
                    method: 'POST',
                    data: { _method: 'DELETE', _token: TOKEN },
                    success: function () {
                        toastr.success('Adresse supprimée.', 'Adresses');
                        setTimeout(() => location.reload(), 800);
                    },
                    error: function () { toastr.error('Impossible de supprimer.', 'Erreur'); }
                });
            });
        });

        // Définir par défaut
        $(document).on('click', '.btn-default-address', function () {
            const id = $(this).data('id');
            $.ajax({
                url: '/client/address/' + id + '/default',
                method: 'POST',
                data: { _token: TOKEN },
                success: function () {
                    toastr.success('Adresse par défaut mise à jour.', 'Adresses');
                    setTimeout(() => location.reload(), 800);
                },
                error: function () { toastr.error('Une erreur est survenue.', 'Erreur'); }
            });
        });

    });
    </script>

    @include('frontend.global_js')
</body>
</html>