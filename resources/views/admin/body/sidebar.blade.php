@php

    $user = Auth::user()->first();

@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo" style="height: 130px;">
        <a href="{{ route('dashboardVendors') }}" class="app-brand-link">
            <img alt="ABS TECHNOLOGIE Logo" width="180" height="100" src="{{ asset('backend/img/logo/logo_abs.png')}}">
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        {{-- ── Tableau de bord ───────────────────────────────────────────── --}}
        @can('view dashboard')
        <li class="menu-item active">
            <a href="{{ route('dashboardVendors') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-layout-dashboard"></i>
                <div>Tableau de bord</div>
            </a>
        </li>
        @endcan

        <li class="menu-header small text-uppercase">
            <div class="divider">
                <div class="divider-text">Menu</div>
            </div>
        </li>

        {{-- ── Gestion des articles ───────────────────────────────────────── --}}
        @can('view products')
        <li class="menu-item {{ in_array($prefix, ['products', '/products', 'tasks', '/tasks']) ? 'active open' : '' }}">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-folders"></i>
                <div>Gestion des articles</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ ($prefix == 'products' || $prefix == '/products') ? 'active' : '' }}">
                    <a href="{{ route('all.products') }}" class="menu-link">
                        <div>Liste des articles</div>
                    </a>
                </li>
            </ul>
        </li>
        @endcan

        {{-- ── Gestion commandes ─────────────────────────────────────────── --}}
        @canany(['view orders', 'view order history'])
        <li class="menu-item {{ in_array($prefix, ['commandes', '/commandes', 'historique', '/historique']) ? 'active open' : '' }}">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-folders"></i>
                <div>Gestion commandes</div>
            </a>
            <ul class="menu-sub">

                @can('view orders')
                <li class="menu-item {{ ($prefix == 'commandes' || $prefix == '/commandes') ? 'active' : '' }}">
                    <a href="{{ route('commandes.index') }}" class="menu-link">
                        <div>Suivi commandes</div>
                        @php $pending = \App\Models\Order::where('status', 'pending')->count(); @endphp
                        @if($pending > 0)
                            <span class="badge bg-warning {{ $pending > 0 ? 'blink-notification' : '' }} ms-2">{{ $pending }}</span>
                        @endif
                    </a>
                </li>
                @endcan

                @can('view order history')
                <li class="menu-item {{ ($prefix == 'historique' || $prefix == '/historique') ? 'active' : '' }}">
                    <a href="{{ route('commandes.historique') }}" class="menu-link">
                        <div>Historique commandes</div>
                    </a>
                </li>
                @endcan

            </ul>
        </li>
        @endcanany

        {{-- ── Paramètres ────────────────────────────────────────────────── --}}
        @canany(['view brands', 'view categories', 'view roles', 'view users'])
        <li class="menu-item {{ in_array($prefix, ['roles', 'users', 'category', 'brand', '/roles', '/users', '/brand', '/category']) ? 'active open' : '' }}">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-settings"></i>
                <div>Paramètres</div>
            </a>
            <ul class="menu-sub">

                @can('view brands')
                <li class="menu-item {{ ($prefix == 'brand' || $prefix == '/brand') ? 'active' : '' }}">
                    <a href="{{ route('all.brand') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-tag"></i>
                        <div>Les marques</div>
                    </a>
                </li>
                @endcan

                @can('view categories')
                <li class="menu-item {{ ($prefix == 'category' || $prefix == '/category') ? 'active' : '' }}">
                    <a href="{{ route('all.category') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-category"></i>
                        <div>Catégories</div>
                    </a>
                </li>
                @endcan

                @can('view roles')
                <li class="menu-item {{ ($prefix == 'roles' || $prefix == '/roles') ? 'active' : '' }}">
                    <a href="{{ route('all.roles') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-shield-check"></i>
                        <div>Rôles</div>
                    </a>
                </li>
                @endcan

                @can('view users')
                <li class="menu-item {{ ($prefix == 'users' || $prefix == '/users') ? 'active' : '' }}">
                    <a href="{{ route('all.users') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-users"></i>
                        <div>Utilisateurs</div>
                    </a>
                </li>
                @endcan

            </ul>
        </li>
        @endcanany

    </ul>
</aside>

<style>

    @keyframes blink-notification {
    0% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.6; transform: scale(1.1); background-color: #ffc107; }
    100% { opacity: 1; transform: scale(1); }
}

    /* Styles pour les badges multiples */
    #taskCounter {
        background-color: #ff0707 !important;
    }


    .badge.bg-warning.blink-notification {
        animation: pulse-alert-strong 1s infinite;
    }

    @keyframes pulse-alert-strong {
        0% {
            transform: scale(1);
            background-color: #ffc107;
            box-shadow: 0 0 0 rgba(255, 193, 7, 0.7);
            opacity: 1;
        }
        25% {
            transform: scale(1.2);
            background-color: #ffc107;
            box-shadow: 0 0 10px rgba(255, 193, 7, 0.9);
            opacity: 0.9;
        }
        50% {
            transform: scale(1);
            background-color: #ffc107;
            box-shadow: 0 0 0 rgba(255, 193, 7, 0.7);
            opacity: 1;
        }
        75% {
            transform: scale(1.2) rotate(1deg);
            background-color: #ffc107;
            box-shadow: 0 0 10px rgba(255, 193, 7, 0.9);
            opacity: 0.9;
        }
        100% {
            transform: scale(1);
            background-color: #ffc107;
            box-shadow: 0 0 0 rgba(255, 193, 7, 0.7);
            opacity: 1;
        }


    }
</style>
