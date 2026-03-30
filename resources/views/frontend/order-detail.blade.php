<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Détail Commande - ABS TECHNOLOGIE</title>
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
            margin-bottom: 30px;
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

        /* ==================== ORDER HEADER ==================== */
        .order-header {
            background: linear-gradient(135deg, var(--white) 0%, #F8FAFC 100%);
            border-radius: var(--radius);
            padding: 32px 40px;
            margin-bottom: 32px;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0, 102, 204, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        .order-info h2 {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
            font-family: 'Playfair Display', serif;
        }
        .order-info .order-date {
            font-size: 14px;
            color: var(--gray);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .order-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            border-radius: 40px;
            font-size: 14px;
            font-weight: 600;
            background: var(--gradient-primary);
            color: var(--white);
            box-shadow: var(--shadow-sm);
        }
        .order-status-badge.cancelled {
            background: linear-gradient(135deg, var(--danger) 0%, #c82333 100%);
        }
        .btn-cancel-order {
            background: transparent;
            border: 2px solid var(--danger);
            color: var(--danger);
            padding: 8px 20px;
            border-radius: 40px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-cancel-order:hover {
            background: var(--danger);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }

        /* ==================== STATUS TRACKER ==================== */
        .status-tracker {
            background: var(--white);
            border-radius: var(--radius);
            padding: 32px 40px;
            margin-bottom: 40px;
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(0, 102, 204, 0.1);
        }
        .tracker-steps {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }
        .tracker-line {
            position: absolute;
            top: 20px;
            left: 10%;
            right: 10%;
            height: 3px;
            background: var(--light-gray);
            z-index: 0;
        }
        .tracker-progress {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background: var(--gradient-primary);
            transition: width 0.5s ease;
            border-radius: 3px;
        }
        .tracker-step {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 1;
        }
        .step-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--light-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: var(--gray);
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }
        .step-icon.completed {
            background: var(--gradient-primary);
            color: var(--white);
            box-shadow: 0 4px 12px rgba(0, 102, 204, 0.3);
        }
        .step-icon.active {
            background: var(--gradient-orange);
            color: var(--white);
            transform: scale(1.1);
            box-shadow: 0 4px 20px rgba(255, 102, 0, 0.4);
        }
        .step-label {
            margin-top: 12px;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            color: var(--gray);
        }
        .step-label.completed {
            color: var(--primary);
        }
        .step-label.active {
            color: var(--orange);
            font-weight: 700;
        }
        .cancelled-message {
            background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);
            border-left: 4px solid var(--danger);
            border-radius: 12px;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--danger);
            font-weight: 600;
        }

        /* ==================== ORDER ITEMS ==================== */
        .order-items-card {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            margin-bottom: 30px;
        }
        .card-header-custom {
            background: linear-gradient(135deg, #F8FAFC 0%, var(--white) 100%);
            padding: 20px 28px;
            border-bottom: 1px solid var(--light-gray);
        }
        .card-header-custom h4 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .card-header-custom h4 i {
            color: var(--primary);
        }
        .order-item {
            display: flex;
            gap: 20px;
            padding: 20px 28px;
            border-bottom: 1px solid var(--light-gray);
            transition: background 0.3s ease;
        }
        .order-item:hover {
            background: #F8FAFC;
        }
        .item-image {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            background: #F8FAFC;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
            border: 1px solid var(--light-gray);
        }
        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .item-image i {
            font-size: 32px;
            color: var(--gray);
        }
        .item-details {
            flex: 1;
        }
        .item-name {
            font-size: 16px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 6px;
        }
        .item-variant {
            font-size: 13px;
            color: var(--gray);
            margin-bottom: 8px;
        }
        .item-price {
            font-size: 13px;
            color: var(--gray);
        }
        .item-total {
            text-align: right;
            flex-shrink: 0;
        }
        .item-total .price {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
        }
        .item-total .qty {
            font-size: 12px;
            color: var(--gray);
            margin-top: 4px;
        }
        .order-summary {
            padding: 24px 28px;
            background: #F8FAFC;
            border-top: 2px solid var(--light-gray);
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            font-size: 14px;
        }
        .summary-row.total {
            border-top: 2px solid var(--light-gray);
            margin-top: 10px;
            padding-top: 16px;
            font-size: 18px;
            font-weight: 700;
        }
        .summary-row.total .amount {
            color: var(--primary);
            font-size: 22px;
        }

        /* ==================== INFO CARDS ==================== */
        .info-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(0, 102, 204, 0.1);
        }
        .info-card h5 {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--gray);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .info-card h5 i {
            color: var(--primary);
        }
        .shipping-address {
            line-height: 1.8;
            color: var(--dark);
            font-size: 14px;
        }
        .shipping-address strong {
            color: var(--dark);
        }
        .shipping-address a {
            color: var(--primary);
            text-decoration: none;
        }
        .shipping-address a:hover {
            color: var(--orange);
        }
        .shipping-note {
            background: #FFF8E7;
            border-left: 3px solid var(--orange);
            padding: 12px 16px;
            margin-top: 16px;
            border-radius: 8px;
            font-size: 13px;
            color: #856404;
        }
        .payment-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 16px;
        }
        .payment-status.paid {
            background: #d4edda;
            color: #155724;
        }
        .payment-status.pending {
            background: #fff3cd;
            color: #856404;
        }
        .mobile-payment-info {
            background: linear-gradient(135deg, #FFF8E7 0%, #FFF3D6 100%);
            border: 1px solid var(--orange-light);
            border-radius: 12px;
            padding: 16px;
            margin-top: 16px;
        }
        .mobile-payment-info p {
            margin: 0;
            font-size: 13px;
            color: #856404;
        }
        .mobile-payment-info strong {
            color: var(--orange);
            font-size: 16px;
        }

        /* ==================== BACK BUTTON ==================== */
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: transparent;
            border: 2px solid var(--light-gray);
            border-radius: 40px;
            color: var(--gray);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .back-button:hover {
            border-color: var(--primary);
            color: var(--primary);
            transform: translateX(-5px);
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 992px) {
            .order-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .tracker-steps {
                flex-wrap: wrap;
                gap: 20px;
            }
            .tracker-line {
                display: none;
            }
            .tracker-step {
                min-width: 80px;
            }
        }
        @media (max-width: 768px) {
            .order-item {
                flex-direction: column;
            }
            .item-total {
                text-align: left;
                margin-top: 12px;
            }
            .status-tracker {
                padding: 24px;
            }
            .order-header {
                padding: 24px;
            }
        }
    </style>
</head>
<body class="animsition">
    
    @include('client.body.header')
    @include('frontend.modal')

    <div class="container p-t-80 p-b-80">


        <!-- En-tête commande -->
        <div class="order-header">
            <div class="order-info">
                <h2>Commande #{{ $order->order_number }}</h2>
                <div class="order-date">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Passée le {{ $order->created_at->format('d/m/Y') }} à {{ $order->created_at->format('H:i') }}</span>
                </div>
            </div>
            <div style="display: flex; gap: 12px; align-items: center;">
                <div class="order-status-badge {{ $order->status === 'cancelled' ? 'cancelled' : '' }}">
                    <i class="fas {{ $order->status === 'cancelled' ? 'fa-times-circle' : 'fa-check-circle' }}"></i>
                    <span>{{ $order->status_label }}</span>
                </div>
                @if(in_array($order->status, ['pending', 'confirmed']))
                    <form action="{{ route('client.order.cancel', $order->order_number) }}" 
                          method="POST" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette commande ? Cette action est irréversible.');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-cancel-order">
                            <i class="fas fa-times"></i> Annuler la commande
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Suivi de commande -->
        @php
            $steps = ['pending', 'confirmed', 'processing', 'shipped', 'delivered'];
            $currentIndex = array_search($order->status, $steps);
            $isCancelled = $order->status === 'cancelled';
            $stepsLabels = ['En attente', 'Confirmée', 'En traitement', 'Expédiée', 'Livrée'];
            $stepsIcons = ['fa-clock', 'fa-check-circle', 'fa-cogs', 'fa-truck', 'fa-home'];
        @endphp

        @if(!$isCancelled)
        <div class="status-tracker">
            <div class="tracker-steps">
                <div class="tracker-line">
                    <div class="tracker-progress" style="width: {{ $currentIndex !== false ? ($currentIndex / (count($steps)-1)) * 100 : 0 }}%"></div>
                </div>
                @foreach($steps as $i => $step)
                    @php
                        $completed = $currentIndex !== false && $i <= $currentIndex;
                        $active = $currentIndex !== false && $i === $currentIndex;
                    @endphp
                    <div class="tracker-step">
                        <div class="step-icon {{ $completed ? 'completed' : '' }} {{ $active ? 'active' : '' }}">
                            <i class="fas {{ $stepsIcons[$i] }}"></i>
                        </div>
                        <div class="step-label {{ $completed ? 'completed' : '' }} {{ $active ? 'active' : '' }}">
                            {{ $stepsLabels[$i] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="cancelled-message">
            <i class="fas fa-ban" style="font-size: 20px;"></i>
            <span>Cette commande a été annulée. Pour toute question, contactez notre service client.</span>
        </div>
        @endif

        <div class="row">
            <!-- Colonne gauche : Articles -->
            <div class="col-lg-7">
                <div class="order-items-card">
                    <div class="card-header-custom">
                        <h4>
                            <i class="fas fa-box"></i>
                            Articles commandés
                            <span style="font-size: 14px; font-weight: normal; color: var(--gray);">({{ $order->items->count() }} produit(s))</span>
                        </h4>
                    </div>
                    
                    @foreach($order->items as $item)
                    <div class="order-item">
                        <div class="item-image">
                            @if($item->product_image)
                                <img src="{{ asset('storage/'.$item->product_image) }}" alt="{{ $item->product_name }}">
                            @else
                                <i class="fas fa-image"></i>
                            @endif
                        </div>
                        <div class="item-details">
                            <div class="item-name">{{ $item->product_name }}</div>
                            @if($item->color_name)
                                <div class="item-variant">
                                    <i class="fas fa-palette"></i> Couleur : {{ $item->color_name }}
                                </div>
                            @endif
                            <div class="item-price">
                                {{ number_format($item->unit_price, 0, ',', ' ') }} FCFA × {{ $item->quantity }}
                            </div>
                        </div>
                        <div class="item-total">
                            <div class="price">{{ number_format($item->total_price, 0, ',', ' ') }} FCFA</div>
                            <div class="qty">Quantité : {{ $item->quantity }}</div>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="order-summary">
                        <div class="summary-row">
                            <span>Sous-total</span>
                            <span>{{ number_format($order->subtotal, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="summary-row">
                            <span>Livraison</span>
                            <span style="color: var(--orange);">
                                <i class="fas fa-truck"></i> À régler à la livraison
                            </span>
                        </div>
                        <div class="summary-row total">
                            <span>Total</span>
                            <span class="amount">{{ number_format($order->total, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne droite : Informations -->
            <div class="col-lg-5">
                <!-- Adresse de livraison -->
                <div class="info-card">
                    <h5>
                        <i class="fas fa-map-marker-alt"></i>
                        Adresse de livraison
                    </h5>
                    <div class="shipping-address">
                        <strong>{{ $order->shipping_fullname }}</strong><br>
                        {{ $order->shipping_address }}<br>
                        {{ $order->shipping_city }}, {{ $order->shipping_country }}<br>
                        <i class="fas fa-phone-alt"></i> <a href="tel:{{ $order->shipping_phone }}">{{ $order->shipping_phone }}</a><br>
                        <i class="fas fa-envelope"></i> <a href="mailto:{{ $order->shipping_email }}">{{ $order->shipping_email }}</a>
                    </div>
                    @if($order->shipping_notes)
                        <div class="shipping-note">
                            <i class="fas fa-sticky-note"></i>
                            <strong>Note :</strong> {{ $order->shipping_notes }}
                        </div>
                    @endif
                </div>

                <!-- Paiement -->
                <div class="info-card">
                    <h5>
                        <i class="fas fa-credit-card"></i>
                        Paiement
                    </h5>
                    <div class="payment-status {{ $order->payment_status === 'paid' ? 'paid' : 'pending' }}">
                        <i class="fas {{ $order->payment_status === 'paid' ? 'fa-check-circle' : 'fa-clock' }}"></i>
                        <span>{{ $order->payment_status === 'paid' ? 'Paiement confirmé' : 'En attente de paiement' }}</span>
                    </div>
                    <div style="font-size: 14px; color: var(--dark); margin-bottom: 8px;">
                        <strong>Moyen de paiement :</strong> {{ $order->payment_label }}
                    </div>
                    
                    @if($order->payment_method === 'mobile_money' && $order->payment_status !== 'paid')
                        <div class="mobile-payment-info">
                            <p style="margin-bottom: 8px;">
                                <i class="fas fa-mobile-alt"></i> <strong>Instructions de paiement :</strong>
                            </p>
                            <p>Envoyez <strong>{{ number_format($order->total, 0, ',', ' ') }} FCFA</strong> par Mobile Money au :</p>
                            <p style="font-size: 18px; font-weight: 700; color: var(--orange); margin: 8px 0;">
                                +229 96 71 66 79
                            </p>
                            <p>Référence de paiement : <strong>{{ $order->order_number }}</strong></p>
                            <hr style="margin: 12px 0; border-color: var(--orange-light);">
                            <p style="font-size: 12px;">
                                <i class="fas fa-info-circle"></i> Après paiement, envoyez la preuve de transaction à <strong>dc@abstechnologie.com</strong>
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Informations supplémentaires -->
                <div class="info-card">
                    <h5>
                        <i class="fas fa-info-circle"></i>
                        Informations utiles
                    </h5>
                    <div style="font-size: 13px; color: var(--gray); line-height: 1.8;">
                        <p><i class="fas fa-headset"></i> Besoin d'aide ? Contactez notre service client au <strong>+229 01 61 06 26 26</strong></p>
                        <p><i class="fas fa-undo-alt"></i> Vous disposez de <strong>14 jours</strong> pour retourner un produit.</p>
                        <p><i class="fas fa-shield-alt"></i> Tous nos produits sont garantis par nos partenaires officiels.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Retour -->
        <div class="p-t-30">
            <a href="{{ route('client.my.orders') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Retour à mes commandes
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

    <script>
        $(document).ready(function() {
            // Animation des éléments au scroll
            $('.info-card, .order-items-card, .status-tracker').css('opacity', '0').css('transform', 'translateY(20px)');
            $('.info-card, .order-items-card, .status-tracker').each(function(i) {
                $(this).delay(i * 100).animate({
                    opacity: 1,
                    transform: 'translateY(0)'
                }, 500);
            });
        });
    </script>
</body>
</html>