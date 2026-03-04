<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>Mes commandes ABS-TECHNOLOGIE</title>
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
            <a href="{{ route('client.account') }}" class="stext-109 cl8 hov-cl1 trans-04 p-r-5">Mon Compte</a>
            <span class="stext-109 cl3 p-r-5">/</span>
            <span class="stext-109 cl3">Mes Commandes</span>
        </div>

        <h3 class="ltext-103 cl5 p-b-30">Mes Commandes</h3>

        @if(session('success'))
            <div class="p-15 m-b-20" style="background:#d1e7dd;border:1px solid #badbcc;border-radius:6px;color:#0a3622">
                ✓ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="p-15 m-b-20" style="background:#f8d7da;border:1px solid #f5c6cb;border-radius:6px;color:#721c24">
                {{ session('error') }}
            </div>
        @endif

        @if($orders->isEmpty())
            <div class="txt-center p-t-60 p-b-60">
                <i class="zmdi zmdi-receipt" style="font-size:70px;color:#ddd;display:block;margin-bottom:16px"></i>
                <p class="stext-113 cl6 p-b-16">Vous n'avez passé aucune commande.</p>
                <a href="{{ route('client.product') }}"
                class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04"
                style="display:inline-flex">
                    Découvrir nos produits
                </a>
            </div>
        @else

            {{-- Desktop : tableau --}}
            <div class="d-none d-md-block">
                <table style="width:100%;border-collapse:collapse">
                    <thead>
                        <tr style="border-bottom:2px solid #e6e6e6;font-size:12px;text-transform:uppercase;letter-spacing:.06em;color:#aaa">
                            <th style="padding:12px 16px;text-align:left">Commande</th>
                            <th style="padding:12px 16px;text-align:left">Date</th>
                            <th style="padding:12px 16px;text-align:left">Statut</th>
                            <th style="padding:12px 16px;text-align:left">Paiement</th>
                            <th style="padding:12px 16px;text-align:right">Total</th>
                            <th style="padding:12px 16px;text-align:center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr style="border-bottom:1px solid #f0f0f0;transition:background .15s" onmouseenter="this.style.background='#fafafa'" onmouseleave="this.style.background=''">
                            <td style="padding:16px;font-weight:700;color:#717fe0">
                                <a href="{{ route('client.order.show', $order->order_number) }}" style="color:#717fe0;text-decoration:none">
                                    {{ $order->order_number }}
                                </a>
                            </td>
                            <td style="padding:16px;font-size:13px;color:#666">
                                {{ $order->created_at->format('d/m/Y à H:i') }}
                            </td>
                            <td style="padding:16px">
                                <span style="
                                    display:inline-block;
                                    background:{{ $order->status_color }}22;
                                    color:{{ $order->status_color }};
                                    border:1px solid {{ $order->status_color }}44;
                                    padding:3px 10px;border-radius:20px;
                                    font-size:12px;font-weight:600
                                ">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td style="padding:16px;font-size:13px;color:#666">
                                {{ $order->payment_label }}
                                @if($order->payment_status === 'paid')
                                    <span style="color:#5cb85c;margin-left:4px;font-size:11px">✓ Payé</span>
                                @endif
                            </td>
                            <td style="padding:16px;text-align:right;font-weight:700;color:#333">
                                {{ number_format($order->total, 0, ',', ' ') }} FCFA
                            </td>
                            <td style="padding:16px;text-align:center">
                                <div style="display:flex;gap:8px;justify-content:center;align-items:center">
                                    <a href="{{ route('client.order.show', $order->order_number) }}"
                                    style="padding:5px 12px;background:#717fe0;color:#fff;border-radius:4px;font-size:12px;text-decoration:none;white-space:nowrap">
                                        Détails
                                    </a>
                                    @if(in_array($order->status, ['pending', 'confirmed']))
                                        <form action="{{ route('client.order.cancel', $order->order_number) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Annuler cette commande ?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    style="padding:5px 12px;background:none;border:1px solid #e65540;color:#e65540;border-radius:4px;font-size:12px;cursor:pointer;white-space:nowrap">
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

            {{-- Mobile : cartes --}}
            <div class="d-md-none">
                @foreach($orders as $order)
                <div style="border:1px solid #e6e6e6;border-radius:8px;padding:16px;margin-bottom:14px">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px">
                        <div>
                            <div style="font-weight:700;color:#717fe0;font-size:14px">{{ $order->order_number }}</div>
                            <div style="font-size:12px;color:#aaa;margin-top:2px">{{ $order->created_at->format('d/m/Y') }}</div>
                        </div>
                        <span style="
                            background:{{ $order->status_color }}22;
                            color:{{ $order->status_color }};
                            border:1px solid {{ $order->status_color }}44;
                            padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600
                        ">{{ $order->status_label }}</span>
                    </div>
                    <div style="font-size:13px;color:#666;margin-bottom:10px">
                        {{ $order->items->count() }} article(s) · {{ $order->payment_label }}
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center">
                        <div style="font-weight:700;font-size:16px;color:#333">
                            {{ number_format($order->total, 0, ',', ' ') }} FCFA
                        </div>
                        <a href="{{ route('client.order.show', $order->order_number) }}"
                        style="padding:6px 14px;background:#717fe0;color:#fff;border-radius:4px;font-size:12px;text-decoration:none">
                            Voir détails
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="flex-c-m flex-w p-t-30">
                {{ $orders->links() }}
            </div>

        @endif
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