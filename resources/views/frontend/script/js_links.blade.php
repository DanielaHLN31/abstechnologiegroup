
	<!-- Scripts -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
	
	<script src="{{ asset('frontend/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
	<script src="{{ asset('frontend/vendor/animsition/js/animsition.min.js') }}"></script>
	<script src="{{ asset('frontend/vendor/select2/select2.min.js') }}"></script>
	<script src="{{ asset('frontend/vendor/daterangepicker/moment.min.js') }}"></script>
	<script src="{{ asset('frontend/vendor/daterangepicker/daterangepicker.js') }}"></script>
	<script src="{{ asset('frontend/vendor/slick/slick.min.js') }}"></script>
	<script src="{{ asset('frontend/js/slick-custom.js') }}"></script>
	<script src="{{ asset('frontend/vendor/parallax100/parallax100.js') }}"></script>
	<script src="{{ asset('frontend/vendor/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>
	<script src="{{ asset('frontend/vendor/isotope/isotope.pkgd.min.js') }}"></script>
	<script src="{{ asset('frontend/vendor/sweetalert/sweetalert.min.js') }}"></script>
	<script src="{{ asset('frontend/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
	<script src="{{ asset('frontend/js/main.js') }}"></script>
	
	<!-- Owl Carousel JS -->
	<script src="{{ asset('frontend/lib/owlcarousel/owl.carousel.min.js') }}"></script>
	
	<script src="{{ asset('frontend/lib/easing/easing.min.js') }}" ></script>
	<script src="{{ asset('frontend/lib/waypoints/waypoints.min.js') }}" ></script>
	<script src="{{ asset('frontend/lib/lightbox/js/lightbox.min.js') }}" ></script>

<!--===============================================================================================-->
	<script src="{{ asset('frontend/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
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

    
    @include('frontend.script.global_js')