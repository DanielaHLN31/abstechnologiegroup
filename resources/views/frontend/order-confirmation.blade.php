<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>Confirmation ABS-TECHNOLOGIE</title>
    @include('client.body.head')
    <style>
    @keyframes pop-in {
        0%   { transform: scale(0); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
    </style>
</head>

<body class="animsition">
	<!-- Header -->
    @include('client.body.header')
    @include('frontend.modal')

<div class="container p-t-80 p-b-80">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- Bannière succès --}}
            <div class="txt-center p-t-30 p-b-40">
                <div class="success-icon" style="
                    width:90px;height:90px;border-radius:50%;
                    background:linear-gradient(135deg,#5cb85c,#28a745);
                    display:flex;align-items:center;justify-content:center;
                    margin:0 auto 20px;
                    box-shadow:0 8px 24px rgba(92,184,92,.35);
                    animation: pop-in .5s cubic-bezier(.34,1.56,.64,1)
                ">
                    <i class="zmdi zmdi-check" style="font-size:44px;color:#fff"></i>
                </div>

                <h2 class="ltext-103 cl2 p-b-10">Commande confirmée !</h2>
                <p class="stext-113 cl6">
                    Merci pour votre commande. Vous recevrez une confirmation à
                    <strong>{{ $order->shipping_email }}</strong>.
                </p>

                <div style="
                    display:inline-block;
                    background:#f7f8ff;
                    border:2px solid #717fe0;
                    border-radius:8px;
                    padding:10px 28px;
                    margin-top:16px;
                    font-size:18px;
                    font-weight:700;
                    color:#717fe0;
                    letter-spacing:.05em;
                ">
                    {{ $order->order_number }}
                </div>
                <p style="font-size:12px;color:#aaa;margin-top:6px">Numéro de commande — conservez-le pour le suivi</p>
            </div>

            {{-- Détails de la commande --}}
            <div class="bor10 p-lr-40 p-t-30 p-b-30 p-lr-15-sm m-b-30">
                <h4 class="mtext-109 cl2 p-b-20">Détails de la commande</h4>

                <div class="row p-b-20" style="border-bottom:1px solid #f0f0f0;margin-bottom:20px">
                    {{-- Livraison --}}
                    <div class="col-sm-6 p-b-15">
                        <div style="font-size:11px;text-transform:uppercase;letter-spacing:.08em;color:#aaa;font-weight:700;margin-bottom:8px">
                            Adresse de livraison
                        </div>
                        <div style="font-size:14px;color:#333;line-height:1.7">
                            <strong>{{ $order->shipping_fullname }}</strong><br>
                            {{ $order->shipping_address }}<br>
                            {{ $order->shipping_city }}, {{ $order->shipping_country }}<br>
                            <a href="tel:{{ $order->shipping_phone }}" style="color:#717fe0">{{ $order->shipping_phone }}</a>
                        </div>
                        @if($order->shipping_notes)
                            <div style="font-size:12px;color:#888;margin-top:8px;font-style:italic">
                                Note : {{ $order->shipping_notes }}
                            </div>
                        @endif
                    </div>

                    {{-- Paiement --}}
                    <div class="col-sm-6 p-b-15">
                        <div style="font-size:11px;text-transform:uppercase;letter-spacing:.08em;color:#aaa;font-weight:700;margin-bottom:8px">
                            Paiement
                        </div>
                        <div style="font-size:14px;color:#333">
                            <div style="margin-bottom:6px">{{ $order->payment_label }}</div>
                            <span style="
                                display:inline-block;
                                background:{{ $order->status === 'pending' ? '#fff3cd' : '#d1e7dd' }};
                                color:{{ $order->status === 'pending' ? '#856404' : '#0a3622' }};
                                padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600
                            ">
                                {{ $order->status_label }}
                            </span>
                        </div>

                        @if($order->payment_method === 'mobile_money')
                            <div style="background:#fff8e1;border:1px solid #ffc107;border-radius:6px;padding:12px;margin-top:12px;font-size:13px;color:#856404">
                                📱 Envoyez le montant au : <strong>+229 96 71 66 79</strong><br>
                                Référence : <strong>{{ $order->order_number }}</strong>
                            </div>
                        @elseif($order->payment_method === 'bank_transfer')
                            <div style="background:#e8f4fd;border:1px solid #bee5eb;border-radius:6px;padding:12px;margin-top:12px;font-size:13px;color:#0c5460">
                                🏦 Coordonnées bancaires envoyées à <strong>{{ $order->shipping_email }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Articles commandés --}}
                <div>
                    <div style="font-size:11px;text-transform:uppercase;letter-spacing:.08em;color:#aaa;font-weight:700;margin-bottom:16px">
                        Articles ({{ $order->items->count() }})
                    </div>

                    @foreach($order->items as $item)
                    <div style="display:flex;align-items:center;gap:14px;padding:12px 0;border-bottom:1px solid #f5f5f5">
                        @if($item->product_image)
                            <img src="{{ asset('storage/'.$item->product_image) }}"
                                 alt="{{ $item->product_name }}"
                                 style="width:56px;height:56px;object-fit:cover;border-radius:6px;border:1px solid #eee;flex-shrink:0">
                        @else
                            <div style="width:56px;height:56px;background:#f5f5f5;border-radius:6px;flex-shrink:0;display:flex;align-items:center;justify-content:center">
                                <i class="zmdi zmdi-image-alt" style="color:#ddd;font-size:24px"></i>
                            </div>
                        @endif
                        <div style="flex:1;min-width:0">
                            <div style="font-weight:600;color:#333;font-size:14px">{{ $item->product_name }}</div>
                            @if($item->color_name)
                                <div style="font-size:12px;color:#888;margin-top:2px">Couleur : {{ $item->color_name }}</div>
                            @endif
                            <div style="font-size:12px;color:#aaa;margin-top:2px">
                                {{ $item->quantity }} × {{ number_format($item->unit_price, 0, ',', ' ') }} FCFA
                            </div>
                        </div>
                        <div style="font-weight:700;color:#333;font-size:14px;flex-shrink:0">
                            {{ number_format($item->total_price, 0, ',', ' ') }} FCFA
                        </div>
                    </div>
                    @endforeach

                    {{-- Total --}}
                    <div style="padding-top:16px">
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
                        <div style="display:flex;justify-content:space-between;font-size:20px;font-weight:700;color:#333;border-top:2px solid #e6e6e6;padding-top:12px">
                            <span>Total payé</span>
                            <span style="color:#717fe0">{{ number_format($order->total, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex-w flex-c-m" style="gap:16px">
                <a href="{{ route('client.my.orders') }}"
                   class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                    <i class="zmdi zmdi-receipt m-r-8"></i> Mes commandes
                </a>
                <a href="{{ route('client.index') }}"
                   class="flex-c-m stext-101 cl2 size-101 bg6 bor1 hov-btn3 p-lr-15 trans-04">
                    <i class="zmdi zmdi-home m-r-8"></i> Retour à l'accueil
                </a>
            </div>

        </div>
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