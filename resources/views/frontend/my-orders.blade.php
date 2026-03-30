<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Mes commandes - ABS TECHNOLOGIE</title>
    @include('client.body.head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ==================== VARIABLES ==================== */
        :root {
            --primary: #0066CC;
            --primary-dark: #004494;
            --primary-light: #4D94FF;
            --orange: #FF6600;
            --orange-light: #FF9944;
            --success: #28a745;
            --danger: #dc3545;
            --warning: #ffc107;
            --info: #17a2b8;
            --dark: #0A0E1A;
            --gray: #64748B;
            --light-gray: #E2E8F0;
            --white: #FFFFFF;
            --bg-light: #F8FAFC;
            --gradient-primary: linear-gradient(135deg, #0066CC 0%, #004494 100%);
            --gradient-orange: linear-gradient(135deg, #FF6600 0%, #FF9944 100%);
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 8px 32px rgba(0, 0, 0, 0.12);
            --radius: 16px;
        }

        /* ==================== BREADCRUMB ==================== */
        .breadcrumb-custom {
            background: transparent;
            padding: 20px 0;
            margin-bottom: 20px;
        }
        .breadcrumb-custom .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
            font-size: 14px;
        }
        .breadcrumb-custom .breadcrumb-item a {
            color: var(--gray);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .breadcrumb-custom .breadcrumb-item a:hover {
            color: var(--primary);
        }
        .breadcrumb-custom .breadcrumb-item.active {
            color: var(--primary);
            font-weight: 600;
        }
        .breadcrumb-custom .breadcrumb-item + .breadcrumb-item::before {
            content: "›";
            color: var(--gray);
            font-size: 18px;
            font-weight: 300;
        }

        /* ==================== PAGE HEADER ==================== */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 40px;
        }
        .page-header h1 {
            font-size: 32px;
            font-weight: 800;
            color: var(--dark);
            font-family: 'Playfair Display', serif;
            margin: 0;
            position: relative;
            display: inline-block;
        }
        .page-header h1::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--gradient-orange);
            border-radius: 3px;
        }
        .order-stats {
            display: flex;
            gap: 20px;
        }
        .stat-badge {
            background: var(--bg-light);
            padding: 8px 16px;
            border-radius: 40px;
            font-size: 13px;
            font-weight: 600;
            color: var(--gray);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .stat-badge i {
            color: var(--primary);
        }
        .stat-badge strong {
            color: var(--dark);
            font-size: 16px;
            margin-right: 4px;
        }

        /* ==================== ALERTS ==================== */
        .alert-custom {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.4s ease;
        }
        .alert-custom.success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-left: 4px solid var(--success);
            color: #155724;
        }
        .alert-custom.error {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            border-left: 4px solid var(--danger);
            color: #721c24;
        }
        .alert-custom i {
            font-size: 20px;
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ==================== EMPTY STATE ==================== */
        .empty-state {
            text-align: center;
            padding: 80px 40px;
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--light-gray);
        }
        .empty-state-icon {
            width: 100px;
            height: 100px;
            background: var(--bg-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }
        .empty-state-icon i {
            font-size: 48px;
            color: var(--gray);
        }
        .empty-state h3 {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 12px;
            font-family: 'Playfair Display', serif;
        }
        .empty-state p {
            color: var(--gray);
            margin-bottom: 24px;
        }
        .btn-primary-custom {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--gradient-primary);
            color: var(--white);
            padding: 12px 32px;
            border-radius: 40px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: var(--white);
        }

        /* ==================== ORDERS TABLE (DESKTOP) ==================== */
        .orders-table-wrapper {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow-md);
            overflow-x: auto;
            border: 1px solid var(--light-gray);
        }
        .orders-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }
        .orders-table th {
            padding: 18px 20px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--gray);
            background: var(--bg-light);
            border-bottom: 2px solid var(--light-gray);
        }
        .orders-table td {
            padding: 20px;
            border-bottom: 1px solid var(--light-gray);
            vertical-align: middle;
            transition: background 0.3s ease;
        }
        .orders-table tr:hover td {
            background: var(--bg-light);
        }
        .order-number-link {
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color 0.3s ease;
        }
        .order-number-link:hover {
            color: var(--orange);
        }
        .order-date {
            font-size: 13px;
            color: var(--gray);
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-badge.pending {
            background: #FFF8E7;
            color: #E6A817;
            border: 1px solid #FFE8B3;
        }
        .status-badge.confirmed {
            background: #E8F0FE;
            color: var(--primary);
            border: 1px solid #CCE0FF;
        }
        .status-badge.processing {
            background: #E3F2FD;
            color: #1976D2;
            border: 1px solid #BBDEFB;
        }
        .status-badge.shipped {
            background: #E8F5E9;
            color: #2E7D32;
            border: 1px solid #C8E6C9;
        }
        .status-badge.delivered {
            background: #E0F2F1;
            color: #00695C;
            border: 1px solid #B2DFDB;
        }
        .status-badge.cancelled {
            background: #FFEBEE;
            color: var(--danger);
            border: 1px solid #FFCDD2;
        }
        .payment-info {
            font-size: 13px;
            color: var(--gray);
        }
        .payment-paid {
            display: inline-block;
            background: #E8F5E9;
            color: #2E7D32;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 12px;
            margin-left: 6px;
            font-weight: 600;
        }
        .order-total {
            font-weight: 700;
            color: var(--dark);
            font-size: 16px;
        }
        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
        }
        .btn-detail {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            background: var(--gradient-primary);
            color: var(--white);
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .btn-detail:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
            color: var(--white);
        }
        .btn-cancel {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            background: transparent;
            border: 1.5px solid var(--danger);
            color: var(--danger);
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-cancel:hover {
            background: var(--danger);
            color: var(--white);
            transform: translateY(-2px);
        }

        /* ==================== MOBILE CARDS ==================== */
        .order-card {
            background: var(--white);
            border-radius: var(--radius);
            margin-bottom: 16px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--light-gray);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .order-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }
        .order-card-header {
            padding: 16px;
            background: var(--bg-light);
            border-bottom: 1px solid var(--light-gray);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        .order-card-number {
            font-weight: 700;
            color: var(--primary);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .order-card-date {
            font-size: 12px;
            color: var(--gray);
        }
        .order-card-body {
            padding: 16px;
        }
        .order-card-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            flex-wrap: wrap;
            gap: 10px;
        }
        .order-card-items {
            font-size: 13px;
            color: var(--gray);
        }
        .order-card-total {
            font-weight: 700;
            font-size: 18px;
            color: var(--primary);
        }
        .order-card-footer {
            padding: 12px 16px;
            border-top: 1px solid var(--light-gray);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 28px;
            }
            .order-stats {
                width: 100%;
                justify-content: space-between;
            }
            .stat-badge {
                font-size: 12px;
                padding: 6px 12px;
            }
        }

        
    </style>
</head>
<body class="animsition">
    
    @include('client.body.header')
    @include('frontend.modal')

    <div class="container p-t-80 p-b-80">


        <!-- Page Header -->
        <div class="page-header">
            <h1>Mes commandes</h1>
            <div class="order-stats">
                <div class="stat-badge">
                    <i class="fas fa-shopping-cart"></i>
                    <span><strong>{{ $orders->total() }}</strong> commande(s)</span>
                </div>
                <div class="stat-badge">
                    <i class="fas fa-clock"></i>
                    <span><strong>{{ $orders->where('status', 'pending')->count() }}</strong> en attente</span>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert-custom success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="alert-custom error">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($orders->isEmpty())
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-receipt"></i>
                </div>
                <h3>Aucune commande</h3>
                <p>Vous n'avez encore passé aucune commande chez ABS TECHNOLOGIE.</p>
                <a href="{{ route('client.product') }}" class="btn-primary-custom">
                    <i class="fas fa-store"></i>
                    Découvrir nos produits
                </a>
            </div>
        @else

            <!-- Desktop Table -->
            <div class="d-none d-md-block orders-table-wrapper">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Commande</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Paiement</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('client.order.show', $order->order_number) }}" class="order-number-link">
                                    <i class="fas fa-hashtag"></i>
                                    {{ $order->order_number }}
                                </a>
                            </td>
                            <td>
                                <div class="order-date">
                                    <i class="far fa-calendar-alt"></i>
                                    {{ $order->created_at->format('d/m/Y') }}
                                </div>
                                <div class="order-date" style="font-size: 11px; margin-top: 2px;">
                                    {{ $order->created_at->format('H:i') }}
                                </div>
                            </td>
                            <td>
                                <span class="status-badge {{ $order->status }}">
                                    <i class="fas {{ $order->status === 'pending' ? 'fa-clock' : ($order->status === 'cancelled' ? 'fa-times-circle' : 'fa-check-circle') }}"></i>
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td>
                                <div class="payment-info">
                                    {{ $order->payment_label }}
                                    @if($order->payment_status === 'paid')
                                        <span class="payment-paid">
                                            <i class="fas fa-check"></i> Payé
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="order-total">
                                    {{ number_format($order->total, 0, ',', ' ') }} FCFA
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('client.order.show', $order->order_number) }}" class="btn-detail">
                                        <i class="fas fa-eye"></i>
                                        Détails
                                    </a>
                                    @if(in_array($order->status, ['pending', 'confirmed']))
                                        <form action="{{ route('client.order.cancel', $order->order_number) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette commande ? Cette action est irréversible.');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn-cancel">
                                                <i class="fas fa-times"></i>
                                                Annuler
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="d-md-none">
                @foreach($orders as $order)
                <div class="order-card">
                    <div class="order-card-header">
                        <div class="order-card-number">
                            <i class="fas fa-hashtag"></i>
                            {{ $order->order_number }}
                        </div>
                        <div class="order-card-date">
                            <i class="far fa-calendar-alt"></i>
                            {{ $order->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                    <div class="order-card-body">
                        <div class="order-card-info">
                            <div>
                                <span class="status-badge {{ $order->status }}" style="font-size: 11px;">
                                    <i class="fas {{ $order->status === 'pending' ? 'fa-clock' : ($order->status === 'cancelled' ? 'fa-times-circle' : 'fa-check-circle') }}"></i>
                                    {{ $order->status_label }}
                                </span>
                            </div>
                            <div class="order-card-total">
                                {{ number_format($order->total, 0, ',', ' ') }} FCFA
                            </div>
                        </div>
                        <div class="order-card-items">
                            <i class="fas fa-box"></i>
                            {{ $order->items->count() }} article(s)
                            <span style="margin: 0 6px">•</span>
                            <i class="fas fa-credit-card"></i>
                            {{ $order->payment_label }}
                            @if($order->payment_status === 'paid')
                                <span class="payment-paid" style="margin-left: 6px;">Payé</span>
                            @endif
                        </div>
                    </div>
                    <div class="order-card-footer">
                        <a href="{{ route('client.order.show', $order->order_number) }}" class="btn-detail" style="padding: 8px 16px;">
                            <i class="fas fa-eye"></i>
                            Voir les détails
                        </a>
                        @if(in_array($order->status, ['pending', 'confirmed']))
                            <form action="{{ route('client.order.cancel', $order->order_number) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Annuler cette commande ?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-cancel" style="padding: 8px 16px;">
                                    <i class="fas fa-times"></i>
                                    Annuler
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pagination-custom">
                {{ $orders->links() }}
            </div>

        @endif
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

    <script>
        $(document).ready(function() {
            // Animation des éléments au chargement
            $('.orders-table-wrapper, .order-card').css('opacity', '0').css('transform', 'translateY(20px)');
            $('.orders-table-wrapper, .order-card').each(function(i) {
                $(this).delay(i * 100).animate({
                    opacity: 1,
                    transform: 'translateY(0)'
                }, 500);
            });
        });
    </script>
</body>
</html>