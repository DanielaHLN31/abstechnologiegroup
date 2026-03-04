@extends('admin.admin_master')


@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- ════════════════════════════════════════════════════════════════
         1. CARTES KPI DU HAUT
    ════════════════════════════════════════════════════════════════ --}}
    <div class="row mb-4">

        {{-- Chiffre d'affaires --}}
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <small class="text-muted d-block mb-1">CA ce mois</small>
                            <h4 class="mb-0 fw-bold">{{ number_format($revThisMonth, 0, ',', ' ') }} FCFA</h4>
                        </div>
                        <span class="badge bg-label-success rounded-pill p-2">
                            <i class="ti ti-currency-dollar ti-sm"></i>
                        </span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge {{ $revGrowth >= 0 ? 'bg-label-success' : 'bg-label-danger' }} me-2">
                            <i class="ti ti-trending-{{ $revGrowth >= 0 ? 'up' : 'down' }} ti-xs me-1"></i>
                            {{ abs($revGrowth) }}%
                        </span>
                        <small class="text-muted">vs mois dernier</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Commandes --}}
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <small class="text-muted d-block mb-1">Commandes ce mois</small>
                            <h4 class="mb-0 fw-bold">{{ number_format($ordersThisMonth) }}</h4>
                        </div>
                        <span class="badge bg-label-primary rounded-pill p-2">
                            <i class="ti ti-shopping-cart ti-sm"></i>
                        </span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge {{ $ordersGrowth >= 0 ? 'bg-label-success' : 'bg-label-danger' }} me-2">
                            <i class="ti ti-trending-{{ $ordersGrowth >= 0 ? 'up' : 'down' }} ti-xs me-1"></i>
                            {{ abs($ordersGrowth) }}%
                        </span>
                        <small class="text-muted">vs mois dernier</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Nouveaux clients --}}
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <small class="text-muted d-block mb-1">Nouveaux clients</small>
                            <h4 class="mb-0 fw-bold">{{ number_format($newClientsThisMonth) }}</h4>
                        </div>
                        <span class="badge bg-label-info rounded-pill p-2">
                            <i class="ti ti-users ti-sm"></i>
                        </span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge {{ $clientsGrowth >= 0 ? 'bg-label-success' : 'bg-label-danger' }} me-2">
                            <i class="ti ti-trending-{{ $clientsGrowth >= 0 ? 'up' : 'down' }} ti-xs me-1"></i>
                            {{ abs($clientsGrowth) }}%
                        </span>
                        <small class="text-muted">vs mois dernier</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Alertes stock --}}
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <small class="text-muted d-block mb-1">Alertes stock</small>
                            <h4 class="mb-0 fw-bold">{{ $lowStockCount + $outStockCount }}</h4>
                        </div>
                        <span class="badge bg-label-warning rounded-pill p-2">
                            <i class="ti ti-package ti-sm"></i>
                        </span>
                    </div>
                    <div class="d-flex gap-3">
                        <small class="text-warning"><i class="ti ti-alert-triangle ti-xs me-1"></i>{{ $lowStockCount }} faible</small>
                        <small class="text-danger"><i class="ti ti-box-off ti-xs me-1"></i>{{ $outStockCount }} rupture</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════════════
         2. STATUTS COMMANDES (mini-cards)
    ════════════════════════════════════════════════════════════════ --}}
    <div class="row mb-4">
        @php
            $statusCards = [
                ['label' => 'En attente',    'key' => 'pending',    'color' => 'warning', 'icon' => 'ti-clock',          'route' => route('commandes.index')],
                ['label' => 'En traitement', 'key' => 'processing', 'color' => 'info',    'icon' => 'ti-loader',         'route' => route('commandes.index')],
                ['label' => 'Expédiées',     'key' => 'shipped',    'color' => 'primary', 'icon' => 'ti-truck',          'route' => route('commandes.index')],
                ['label' => 'Livrées',       'key' => 'delivered',  'color' => 'success', 'icon' => 'ti-circle-check',   'route' => route('commandes.historique')],
                ['label' => 'Annulées',      'key' => 'cancelled',  'color' => 'danger',  'icon' => 'ti-circle-x',       'route' => route('commandes.historique')],
                ['label' => 'Total',         'key' => 'total',      'color' => 'secondary','icon' => 'ti-list',          'route' => route('commandes.index')],
            ];
        @endphp
        @foreach($statusCards as $card)
        <div class="col-lg-2 col-sm-4 col-6 mb-3">
            <a href="{{ $card['route'] }}" class="text-decoration-none">
                <div class="card text-center h-100 hover-shadow">
                    <div class="card-body py-3">
                        <span class="badge bg-label-{{ $card['color'] }} rounded-pill p-2 mb-2 d-inline-block">
                            <i class="ti {{ $card['icon'] }} ti-sm"></i>
                        </span>
                        <h4 class="mb-0 fw-bold">{{ number_format($stats[$card['key']]) }}</h4>
                        <small class="text-muted">{{ $card['label'] }}</small>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    {{-- ════════════════════════════════════════════════════════════════
         3. GRAPHIQUES — Revenus 12 mois + Commandes 7 jours
    ════════════════════════════════════════════════════════════════ --}}
    <div class="row mb-4">

        {{-- Revenus sur 12 mois --}}
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Chiffre d'affaires</h5>
                        <small class="text-muted">12 derniers mois — commandes payées</small>
                    </div>
                    <span class="badge bg-label-success">
                        Total : {{ number_format($totalRevenue, 0, ',', ' ') }} FCFA
                    </span>
                </div>
                <div class="card-body">
                    <div id="chart-revenue"></div>
                </div>
            </div>
        </div>

        {{-- Donut statuts --}}
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Répartition des statuts</h5>
                    <small class="text-muted">Toutes les commandes</small>
                </div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <div id="chart-status" style="width:100%"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════════════
         4. COMMANDES / SEMAINE + MÉTHODES DE PAIEMENT
    ════════════════════════════════════════════════════════════════ --}}
    <div class="row mb-4">

        {{-- Commandes 7 derniers jours --}}
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Commandes — 7 derniers jours</h5>
                        <small class="text-muted">Semaine courante vs semaine précédente</small>
                    </div>
                </div>
                <div class="card-body">
                    <div id="chart-weekly"></div>
                </div>
            </div>
        </div>

        {{-- Méthodes de paiement --}}
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Méthodes de paiement</h5>
                    <small class="text-muted">Toutes les commandes</small>
                </div>
                <div class="card-body">
                    <div id="chart-payment"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════════════
         5. TOP PRODUITS + DERNIÈRES COMMANDES
    ════════════════════════════════════════════════════════════════ --}}
    <div class="row mb-4">

        {{-- Top 5 produits --}}
        <div class="col-lg-5 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Top 5 produits vendus</h5>
                    <a href="{{ route('all.products') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                </div>
                <div class="card-body">
                    @forelse($topProducts as $i => $product)
                    <div class="d-flex align-items-center mb-3 {{ !$loop->last ? 'pb-3 border-bottom' : '' }}">
                        <div class="badge bg-label-{{ ['primary','info','success','warning','secondary'][$i] }} rounded me-3 p-2 fs-6 fw-bold" style="min-width:36px">
                            #{{ $i + 1 }}
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-0 fw-semibold text-truncate">{{ $product->name }}</p>
                            <small class="text-muted">{{ number_format($product->total_qty) }} unités vendues</small>
                        </div>
                        <div class="text-end ms-2">
                            <p class="mb-0 fw-bold text-primary text-nowrap">
                                {{ number_format($product->total_revenue, 0, ',', ' ') }}
                            </p>
                            <small class="text-muted">FCFA</small>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="ti ti-package-off ti-lg mb-2 d-block"></i>
                        Aucune vente enregistrée
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Dernières commandes --}}
        <div class="col-lg-7 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Dernières commandes</h5>
                    <a href="{{ route('commandes.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>N° Commande</th>
                                <th>Client</th>
                                <th>Montant</th>
                                <th>Statut</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td>
                                    <a href="{{ route('commandes.show', $order->order_number) }}"
                                       class="text-primary fw-semibold">
                                        {{ $order->order_number }}
                                    </a>
                                </td>
                                <td class="text-truncate" style="max-width:120px">
                                    {{ $order->user->name ?? $order->shipping_fullname }}
                                </td>
                                <td class="text-nowrap fw-semibold">
                                    {{ number_format($order->total, 0, ',', ' ') }} F
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'pending'    => 'warning',
                                            'confirmed'  => 'info',
                                            'processing' => 'info',
                                            'shipped'    => 'primary',
                                            'delivered'  => 'success',
                                            'cancelled'  => 'danger',
                                            'refunded'   => 'secondary',
                                        ];
                                        $statusLabels = [
                                            'pending'    => 'En attente',
                                            'confirmed'  => 'Confirmée',
                                            'processing' => 'En cours',
                                            'shipped'    => 'Expédiée',
                                            'delivered'  => 'Livrée',
                                            'cancelled'  => 'Annulée',
                                            'refunded'   => 'Remboursée',
                                        ];
                                    @endphp
                                    <span class="badge bg-label-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                        {{ $statusLabels[$order->status] ?? $order->status }}
                                    </span>
                                </td>
                                <td class="text-muted text-nowrap">
                                    {{ $order->created_at->format('d/m/Y') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Aucune commande</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════════════
         6. TOP CLIENTS + RÉSUMÉ GLOBAL
    ════════════════════════════════════════════════════════════════ --}}
    <div class="row">

        {{-- Top clients --}}
        <div class="col-lg-7 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Meilleurs clients</h5>
                    <small class="text-muted">Par chiffre d'affaires total</small>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Client</th>
                                <th>Commandes</th>
                                <th>Total dépensé</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topClients as $i => $client)
                            <tr>
                                <td>
                                    <span class="badge bg-label-{{ ['primary','info','success','warning','secondary'][$i] }} rounded">
                                        {{ $i + 1 }}
                                    </span>
                                </td>
                                <td>
                                    <p class="mb-0 fw-semibold">{{ $client->name }}</p>
                                    <small class="text-muted">{{ $client->email }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-label-info">{{ $client->orders_count }} commande(s)</span>
                                </td>
                                <td class="fw-bold text-primary">
                                    {{ number_format($client->total_spent, 0, ',', ' ') }} FCFA
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Aucun client</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Résumé global --}}
        <div class="col-lg-5 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Résumé global</h5>
                    <small class="text-muted">Depuis le début de l'activité</small>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-label-success rounded-pill p-2">
                                <i class="ti ti-currency-dollar ti-sm"></i>
                            </span>
                            <div>
                                <p class="mb-0 fw-semibold">Revenu total</p>
                                <small class="text-muted">Toutes commandes payées</small>
                            </div>
                        </div>
                        <h5 class="mb-0 fw-bold text-success">
                            {{ number_format($totalRevenue, 0, ',', ' ') }}
                            <small class="fw-normal text-muted fs-6">FCFA</small>
                        </h5>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-label-primary rounded-pill p-2">
                                <i class="ti ti-shopping-bag ti-sm"></i>
                            </span>
                            <div>
                                <p class="mb-0 fw-semibold">Total commandes</p>
                                <small class="text-muted">Toutes périodes confondues</small>
                            </div>
                        </div>
                        <h5 class="mb-0 fw-bold">{{ number_format($stats['total']) }}</h5>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-label-info rounded-pill p-2">
                                <i class="ti ti-users ti-sm"></i>
                            </span>
                            <div>
                                <p class="mb-0 fw-semibold">Total clients</p>
                                <small class="text-muted">Comptes enregistrés</small>
                            </div>
                        </div>
                        <h5 class="mb-0 fw-bold">{{ number_format($totalClients) }}</h5>
                    </div>

                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-label-warning rounded-pill p-2">
                                <i class="ti ti-package ti-sm"></i>
                            </span>
                            <div>
                                <p class="mb-0 fw-semibold">Produits publiés</p>
                                <small class="text-muted">Visibles sur la boutique</small>
                            </div>
                        </div>
                        <h5 class="mb-0 fw-bold">{{ number_format($totalProducts) }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@push('scripts')
{{--
    ⚠️  NE PAS charger ApexCharts via CDN ici.
    Votre thème Vuexy charge déjà ApexCharts dans ses assets globaux.
    Charger une 2e fois provoque : "TypeError: t.put is not a function"
    car les deux instances entrent en conflit.

    Si ApexCharts n'est PAS inclus dans vos assets globaux, décommentez la ligne ci-dessous
    ET vérifiez que vous n'avez qu'une seule version chargée.
--}}
{{-- <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.44.0"></script> --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    console.group('%c📊 Dashboard — Initialisation des graphiques', 'color:#696cff;font-weight:bold;font-size:14px');

    // ── Vérification qu'ApexCharts est bien disponible ───────────────────
    if (typeof ApexCharts === 'undefined') {
        console.error('❌ ApexCharts non disponible — vérifiez vos assets');
        console.groupEnd();
        return;
    }
    console.log('✅ ApexCharts disponible — version :', ApexCharts.version || '(inconnue)');

    // ── Données PHP → JS ─────────────────────────────────────────────────
    const revenueLabels = @json($revenueLabels ?? []);
    const revenueData   = @json($revenueData   ?? []);
    const weekDays      = @json($weekDays      ?? []);
    const thisWeekData  = @json($thisWeekData  ?? []);
    const lastWeekData  = @json($lastWeekData  ?? []);
    const statusDist    = @json($statusDistribution ?? []);
    const paymentDist   = @json($paymentMethods     ?? []);

    // ── Log des données reçues depuis PHP ────────────────────────────────
    console.group('%c📦 Données reçues depuis PHP', 'color:#03c3ec;font-weight:bold');
    console.log('revenueLabels  :', revenueLabels);
    console.log('revenueData    :', revenueData);
    console.log('weekDays       :', weekDays);
    console.log('thisWeekData   :', thisWeekData);
    console.log('lastWeekData   :', lastWeekData);
    console.log('statusDist     :', statusDist);
    console.log('paymentDist    :', paymentDist);
    console.groupEnd();

    const statusLabelsMap = {
        pending: 'En attente', confirmed: 'Confirmée', processing: 'En cours',
        shipped: 'Expédiée', delivered: 'Livrée', cancelled: 'Annulée', refunded: 'Remboursée'
    };
    const paymentLabelsMap = {
        cash_on_delivery: 'Paiement livraison',
        card: 'Carte bancaire',
        mobile_money: 'Mobile Money',
        bank_transfer: 'Virement',
    };

    const colors = {
        primary  : '#696cff',
        success  : '#71dd37',
        warning  : '#ffab00',
        danger   : '#ff3e1d',
        info     : '#03c3ec',
        secondary: '#8592a3',
    };

    // ── Helper : message vide ────────────────────────────────────────────
    function showEmpty(id, msg) {
        msg = msg || 'Aucune donnée disponible';
        var el = document.getElementById(id);
        if (el) {
            el.innerHTML = '<p class="text-center text-muted py-4">'
                + '<i class="ti ti-chart-bar-off d-block mb-2" style="font-size:2rem"></i>'
                + msg + '</p>';
            console.warn('⚠️  [' + id + '] → "' + msg + '"');
        } else {
            console.error('❌ [' + id + '] élément DOM introuvable');
        }
    }

    // ── Helper : rendu sécurisé ──────────────────────────────────────────
    function safeRender(id, config) {
        var el = document.getElementById(id);
        if (!el) { console.error('❌ [' + id + '] introuvable'); return; }
        requestAnimationFrame(function () {
            console.log('   [' + id + '] offsetWidth=' + el.offsetWidth);
            try {
                new ApexCharts(el, config).render()
                    .then(function ()  { console.log('✅ [' + id + '] OK'); })
                    .catch(function (e){ console.error('❌ [' + id + '] render() :', e.message); });
            } catch (e) {
                console.error('❌ [' + id + '] instanciation :', e.message);
            }
        });
    }

    // ════════════════════════════════════════════════════════════════════
    // 1. Revenus 12 mois (Area)
    // ════════════════════════════════════════════════════════════════════
    console.group('%c1. chart-revenue (Area)', 'color:#71dd37;font-weight:bold');
    console.log('revenueData :', revenueData);
    if (revenueData.length === 0 || revenueData.every(function(v){ return v === 0; })) {
        showEmpty('chart-revenue', 'Aucun revenu enregistré sur les 12 derniers mois');
    } else {
        safeRender('chart-revenue', {
            chart     : { type: 'area', height: 260, width: '100%', toolbar: { show: false }, animations: { enabled: false } },
            series    : [{ name: 'Revenus (FCFA)', data: revenueData }],
            xaxis     : { categories: revenueLabels, labels: { style: { fontSize: '11px' } } },
            yaxis     : { labels: { formatter: function(v){ return v >= 1000 ? (v/1000).toFixed(0)+'k' : v; } } },
            colors    : [colors.primary],
            fill      : { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.45, opacityTo: 0.05 } },
            stroke    : { curve: 'smooth', width: 3 },
            tooltip   : { y: { formatter: function(v){ return Number(v).toLocaleString('fr-FR') + ' FCFA'; } } },
            grid      : { strokeDashArray: 4 },
            dataLabels: { enabled: false },
        });
    }
    console.groupEnd();

    // ════════════════════════════════════════════════════════════════════
    // 2. Donut répartition statuts
    // ════════════════════════════════════════════════════════════════════
    console.group('%c2. chart-status (Donut)', 'color:#ffab00;font-weight:bold');
    var statusKeys   = Object.keys(statusDist);
    var statusValues = Object.values(statusDist).map(Number);
    console.log('statusKeys :', statusKeys, '| statusValues :', statusValues);
    if (statusKeys.length === 0 || statusValues.every(function(v){ return v === 0; })) {
        showEmpty('chart-status', 'Aucune commande enregistrée');
    } else {
        var statusLabels = statusKeys.map(function(k){ return statusLabelsMap[k] || k; });
        var scMap = { pending: colors.warning, confirmed: colors.info, processing: colors.info,
                      shipped: colors.primary, delivered: colors.success, cancelled: colors.danger, refunded: colors.secondary };
        var statusColors = statusKeys.map(function(k){ return scMap[k] || '#aaa'; });
        safeRender('chart-status', {
            chart      : { type: 'donut', height: 280, width: '100%', animations: { enabled: false } },
            series     : statusValues,
            labels     : statusLabels,
            colors     : statusColors,
            legend     : { position: 'bottom', fontSize: '12px' },
            plotOptions: { pie: { donut: { size: '65%', labels: { show: true, total: { show: true, label: 'Total', fontSize: '14px' } } } } },
            dataLabels : { enabled: false },
            tooltip    : { y: { formatter: function(v){ return v + ' commande(s)'; } } },
        });
    }
    console.groupEnd();

    // ════════════════════════════════════════════════════════════════════
    // 3. Bar semaine courante vs précédente
    // ════════════════════════════════════════════════════════════════════
    console.group('%c3. chart-weekly (Bar)', 'color:#03c3ec;font-weight:bold');
    var allZero = thisWeekData.concat(lastWeekData).every(function(v){ return v === 0; });
    console.log('weekDays :', weekDays, '| thisWeek :', thisWeekData, '| lastWeek :', lastWeekData);
    if (weekDays.length === 0 || allZero) {
        showEmpty('chart-weekly', 'Aucune commande cette semaine');
    } else {
        safeRender('chart-weekly', {
            chart      : { type: 'bar', height: 260, width: '100%', toolbar: { show: false }, animations: { enabled: false } },
            series     : [
                { name: 'Cette semaine (FCFA)',    data: thisWeekData },
                { name: 'Semaine dernière (FCFA)', data: lastWeekData },
            ],
            xaxis      : { categories: weekDays },
            colors     : [colors.primary, colors.secondary],
            plotOptions: { bar: { columnWidth: '50%', borderRadius: 4 } },
            dataLabels : { enabled: false },
            yaxis      : { labels: { formatter: function(v){ return v >= 1000 ? (v/1000).toFixed(0)+'k' : v; } } },
            tooltip    : { y: { formatter: function(v){ return Number(v).toLocaleString('fr-FR') + ' FCFA'; } } },
            grid       : { strokeDashArray: 4 },
            legend     : { position: 'top' },
        });
    }
    console.groupEnd();

    // ════════════════════════════════════════════════════════════════════
    // 4. Pie méthodes de paiement
    // ════════════════════════════════════════════════════════════════════
    console.group('%c4. chart-payment (Pie)', 'color:#ff3e1d;font-weight:bold');
    var payKeys   = Object.keys(paymentDist);
    var payValues = Object.values(paymentDist).map(Number);
    console.log('payKeys :', payKeys, '| payValues :', payValues);
    if (payKeys.length === 0 || payValues.every(function(v){ return v === 0; })) {
        showEmpty('chart-payment', 'Aucune donnée de paiement');
    } else {
        var payLabels = payKeys.map(function(k){ return paymentLabelsMap[k] || k; });
        safeRender('chart-payment', {
            chart      : { type: 'pie', height: 280, width: '100%', animations: { enabled: false } },
            series     : payValues,
            labels     : payLabels,
            colors     : [colors.primary, colors.success, colors.warning, colors.info, colors.secondary],
            legend     : { position: 'bottom', fontSize: '11px' },
            dataLabels : { formatter: function(val, opts){ return opts.w.config.series[opts.seriesIndex] + ' cmd'; } },
            tooltip    : { y: { formatter: function(v){ return v + ' commande(s)'; } } },
        });
    }
    console.groupEnd();

    console.log('%c✅ Initialisation terminée', 'color:#71dd37;font-weight:bold');
    console.groupEnd();

}); // DOMContentLoaded
</script>

<style>
.hover-shadow { transition: box-shadow .2s, transform .2s; }
.hover-shadow:hover { box-shadow: 0 4px 20px rgba(0,0,0,.1); transform: translateY(-2px); }
</style>
@endpush