<!DOCTYPE html>
<html lang="en">
<head>
    <title>Détail Commande ABS-TECHNOLOGIE</title>
    @include('client.body.head')
</head>

<body class="animsition">
	<!-- Header -->
    @include('client.body.header')
    @include('frontend.modal')


    <div class="container p-t-80 p-b-80">

        <div class="bread-crumb flex-w p-b-28">
            <a href="{{ route('client.index') }}" class="stext-109 cl8 hov-cl1 trans-04 p-r-5">Accueil</a>
            <span class="stext-109 cl3 p-r-5">/</span>
            <a href="{{ route('client.my.orders') }}" class="stext-109 cl8 hov-cl1 trans-04 p-r-5">Mes Commandes</a>
            <span class="stext-109 cl3 p-r-5">/</span>
            <span class="stext-109 cl3">{{ $order->order_number }}</span>
        </div>

        {{-- En-tête --}}
        <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:16px;margin-bottom:30px">
            <div>
                <h3 class="ltext-103 cl5" style="margin-bottom:6px">{{ $order->order_number }}</h3>
                <p style="font-size:13px;color:#aaa">Passée le {{ $order->created_at->format('d/m/Y à H:i') }}</p>
            </div>
            <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
                <span style="
                    background:{{ $order->status_color }}22;
                    color:{{ $order->status_color }};
                    border:1px solid {{ $order->status_color }}44;
                    padding:6px 16px;border-radius:20px;font-size:13px;font-weight:700
                ">{{ $order->status_label }}</span>

                @if(in_array($order->status, ['pending', 'confirmed']))
                    <form action="{{ route('client.order.cancel', $order->order_number) }}"
                        method="POST" onsubmit="return confirm('Annuler cette commande ?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                style="padding:6px 16px;background:none;border:1px solid #e65540;color:#e65540;border-radius:20px;font-size:13px;font-weight:600;cursor:pointer">
                            Annuler la commande
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Suivi de statut --}}
        @php
            $steps = ['pending','confirmed','processing','shipped','delivered'];
            $currentIndex = array_search($order->status, $steps);
            $isCancelled = $order->status === 'cancelled';
        @endphp

        @if(!$isCancelled)
        <div class="bor10 p-lr-40 p-t-25 p-b-25 p-lr-15-sm m-b-30">
            <div style="display:flex;align-items:center;justify-content:space-between;position:relative;overflow:hidden">
                {{-- Ligne de progression --}}
                <div style="position:absolute;top:20px;left:10%;right:10%;height:3px;background:#e6e6e6;z-index:0">
                    <div style="height:100%;background:#717fe0;transition:width .5s;width:{{ $currentIndex !== false ? ($currentIndex / (count($steps)-1)) * 100 : 0 }}%"></div>
                </div>

                @foreach($steps as $i => $step)
                @php
                    $done    = $currentIndex !== false && $i <= $currentIndex;
                    $active  = $currentIndex !== false && $i === $currentIndex;
                    $labels  = ['En attente','Confirmée','En traitement','Expédiée','Livrée'];
                    $icons   = ['zmdi-time','zmdi-check-circle','zmdi-settings','zmdi-truck','zmdi-home'];
                @endphp
                <div style="display:flex;flex-direction:column;align-items:center;z-index:1;flex:1">
                    <div style="
                        width:40px;height:40px;border-radius:50%;
                        background:{{ $done ? '#717fe0' : '#e6e6e6' }};
                        color:{{ $done ? '#fff' : '#aaa' }};
                        display:flex;align-items:center;justify-content:center;
                        font-size:18px;
                        box-shadow:{{ $active ? '0 0 0 4px rgba(113,127,224,.25)' : 'none' }};
                        transition:all .3s;
                    ">
                        <i class="zmdi {{ $icons[$i] }}"></i>
                    </div>
                    <div style="font-size:11px;margin-top:8px;font-weight:{{ $active ? '700' : '400' }};color:{{ $done ? '#717fe0' : '#aaa' }};text-align:center">
                        {{ $labels[$i] }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div style="background:#f8d7da;border:1px solid #f5c6cb;border-radius:8px;padding:16px 24px;margin-bottom:30px;color:#721c24;font-weight:600">
            ✕ Cette commande a été annulée.
        </div>
        @endif

        <div class="row">

            {{-- Gauche : articles --}}
            <div class="col-lg-7 p-b-30">
                <div class="bor10 p-lr-40 p-t-30 p-b-20 p-lr-15-sm">
                    <h4 class="mtext-109 cl2 p-b-20">Articles commandés</h4>

                    @foreach($order->items as $item)
                    <div style="display:flex;gap:14px;padding:14px 0;border-bottom:1px solid #f5f5f5;align-items:center">
                        @if($item->product_image)
                            <img src="{{ asset('storage/'.$item->product_image) }}"
                                alt="{{ $item->product_name }}"
                                style="width:70px;height:70px;object-fit:cover;border-radius:6px;border:1px solid #eee;flex-shrink:0">
                        @else
                            <div style="width:70px;height:70px;background:#f5f5f5;border-radius:6px;flex-shrink:0;display:flex;align-items:center;justify-content:center">
                                <i class="zmdi zmdi-image-alt" style="color:#ddd;font-size:28px"></i>
                            </div>
                        @endif
                        <div style="flex:1;min-width:0">
                            <div style="font-weight:600;font-size:14px;color:#333">{{ $item->product_name }}</div>
                            @if($item->color_name)
                                <div style="font-size:12px;color:#888;margin-top:3px">Couleur : {{ $item->color_name }}</div>
                            @endif
                            <div style="font-size:13px;color:#aaa;margin-top:4px">
                                {{ $item->quantity }} × {{ number_format($item->unit_price, 0, ',', ' ') }} FCFA
                            </div>
                        </div>
                        <div style="font-weight:700;font-size:14px;color:#333;flex-shrink:0">
                            {{ number_format($item->total_price, 0, ',', ' ') }} FCFA
                        </div>
                    </div>
                    @endforeach

                    {{-- Totaux --}}
                    <div style="padding-top:20px">
                        <div style="display:flex;justify-content:space-between;font-size:14px;color:#666;margin-bottom:8px">
                            <span>Sous-total</span>
                            <span>{{ number_format($order->subtotal, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;font-size:14px;color:#666;margin-bottom:12px">
                            <span>Livraison</span>
                            <span>
                                @if($order->shipping_cost == 0)
                                    <span style="color:#5cb85c;font-weight:600">Gratuite</span>
                                @else
                                    {{ number_format($order->shipping_cost, 0, ',', ' ') }} FCFA
                                @endif
                            </span>
                        </div>
                        <div style="display:flex;justify-content:space-between;font-size:18px;font-weight:700;color:#333;border-top:2px solid #e6e6e6;padding-top:14px">
                            <span>Total</span>
                            <span style="color:#717fe0">{{ number_format($order->total, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Droite : infos --}}
            <div class="col-lg-5 p-b-30">

                {{-- Livraison --}}
                <div class="bor10 p-lr-30 p-t-25 p-b-25 m-b-20">
                    <h5 style="font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#aaa;margin-bottom:14px">
                        Adresse de livraison
                    </h5>
                    <div style="font-size:14px;color:#333;line-height:1.8">
                        <strong>{{ $order->shipping_fullname }}</strong><br>
                        {{ $order->shipping_address }}<br>
                        {{ $order->shipping_city }}, {{ $order->shipping_country }}<br>
                        <a href="tel:{{ $order->shipping_phone }}" style="color:#717fe0">{{ $order->shipping_phone }}</a><br>
                        <a href="mailto:{{ $order->shipping_email }}" style="color:#717fe0">{{ $order->shipping_email }}</a>
                    </div>
                    @if($order->shipping_notes)
                        <div style="margin-top:10px;padding:10px;background:#f9f9f9;border-radius:6px;font-size:12px;color:#666;font-style:italic">
                            <strong>Note :</strong> {{ $order->shipping_notes }}
                        </div>
                    @endif
                </div>

                {{-- Paiement --}}
                <div class="bor10 p-lr-30 p-t-25 p-b-25">
                    <h5 style="font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#aaa;margin-bottom:14px">
                        Paiement
                    </h5>
                    <div style="font-size:14px;color:#333;margin-bottom:10px">
                        {{ $order->payment_label }}
                    </div>
                    <div style="display:inline-block;
                        background:{{ $order->payment_status === 'paid' ? '#d1e7dd' : '#fff3cd' }};
                        color:{{ $order->payment_status === 'paid' ? '#0a3622' : '#856404' }};
                        padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600">
                        {{ $order->payment_status === 'paid' ? '✓ Payé' : '⏳ En attente' }}
                    </div>

                    @if($order->payment_method === 'mobile_money' && $order->payment_status !== 'paid')
                        <div style="background:#fff8e1;border:1px solid #ffc107;border-radius:6px;padding:12px;margin-top:14px;font-size:13px;color:#856404">
                            📱 Envoyez <strong>{{ number_format($order->total, 0, ',', ' ') }} FCFA</strong><br>
                            au numéro : <strong>+229 96 71 66 79</strong><br>
                            Réf. : <strong>{{ $order->order_number }}</strong>
                        </div>
                    @endif
                </div>

            </div>
        </div>

        <div class="p-t-20">
            <a href="{{ route('client.my.orders') }}" class="stext-107 cl6 hov-cl1 trans-04">
                ← Retour à mes commandes
            </a>
        </div>

    </div>

    @include('client.body.footer')


<!--===============================================================================================-->	
	<script src="{{ asset('frontend/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/vendor/animsition/js/animsition.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/vendor/select2/select2.min.js') }}"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/vendor/daterangepicker/moment.min.js') }}"></script>
	<script src="{{ asset('frontend/vendor/daterangepicker/daterangepicker.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/vendor/slick/slick.min.js') }}"></script>
	<script src="{{ asset('frontend/js/slick-custom.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/vendor/parallax100/parallax100.js') }}"></script>
	<script>
        $('.parallax100').parallax100();
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/vendor/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>
	<script>
		$('.gallery-lb').each(function() { // the containers for all your galleries
			$(this).magnificPopup({
		        delegate: 'a', // the selector for gallery item
		        type: 'image',
		        gallery: {
		        	enabled:true
		        },
		        mainClass: 'mfp-fade'
		    });
		});
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/vendor/isotope/isotope.pkgd.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/vendor/sweetalert/sweetalert.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
	<script>
		$('.js-pscroll').each(function(){
			$(this).css('position','relative');
			$(this).css('overflow','hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function(){
				ps.update();
			})
		});
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/js/main.js') }}"></script>

    @include('frontend.global_js')
</body>
</html>