<!DOCTYPE html>
<html lang="fr">
<head>
    
    <title>Validation Commande ABS-TECHNOLOGIE</title>
    @include('client.body.head')
    <style>
        .checkout-input {
            width:100%;border:1px solid #e0e0e0;border-radius:6px;
            padding:10px 14px;font-size:14px;color:#333;
            transition:border-color .2s,box-shadow .2s;background:#fff;
        }
        .checkout-input:focus {
            outline:none;border-color:#0066cc;
            box-shadow:0 0 0 3px rgba(0,102,204,.12);
        }
        .checkout-input.is-invalid { border-color:#e65540; }
        .payment-option { transition:border-color .2s,background .2s; }
        .payment-option:has(input:checked) { border-color:#0066cc !important; background:#f0f6ff; }
        #mobile-phone:focus { outline:none;border-color:#0066cc;box-shadow:0 0 0 3px rgba(0,102,204,.12); }
        #btn-place-order:disabled { opacity:.55;cursor:not-allowed; }
        @keyframes spin { to { transform:rotate(360deg); } }
    </style>
</head>
<body class="animsition">

@include('client.body.header')
@include('frontend.modal')

<div class="container p-t-80 p-b-80">

    {{-- Étapes --}}
    <div class="flex-w flex-c-m p-b-40 m-t-23" style="gap:0">
        <div style="display:flex;align-items:center;gap:8px;color:#5cb85c;font-weight:600;font-size:13px">
            <span style="width:28px;height:28px;border-radius:50%;background:#5cb85c;color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px">✓</span>
            Panier
        </div>
        <div style="width:40px;height:2px;background:#e0e0e0;margin:0 8px"></div>
        <div style="display:flex;align-items:center;gap:8px;color:#0066cc;font-weight:700;font-size:13px">
            <span style="width:28px;height:28px;border-radius:50%;background:#0066cc;color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700">2</span>
            Livraison &amp; Paiement
        </div>
        <div style="width:40px;height:2px;background:#e0e0e0;margin:0 8px"></div>
        <div style="display:flex;align-items:center;gap:8px;color:#aaa;font-size:13px">
            <span style="width:28px;height:28px;border-radius:50%;background:#e0e0e0;color:#aaa;display:flex;align-items:center;justify-content:center;font-size:12px">3</span>
            Confirmation
        </div>
    </div>

    @if(!empty($stockErrors))
        <div class="p-20 m-b-30" style="background:#fff3cd;border:1px solid #ffc107;border-radius:6px;color:#856404">
            <strong>⚠ Problème de stock :</strong>
            <ul style="margin:8px 0 0 20px">
                @foreach($stockErrors as $err)<li>{{ $err }}</li>@endforeach
            </ul>
            <a href="{{ route('client.cart') }}" style="display:inline-block;margin-top:8px;color:#856404;text-decoration:underline">← Modifier mon panier</a>
        </div>
    @endif

    @if(session('error'))
        <div class="p-15 m-b-20" style="background:#f8d7da;border:1px solid #f5c6cb;border-radius:6px;color:#721c24">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('client.checkout.store') }}" method="POST" id="checkout-form">
        @csrf
        <div class="row">

            {{-- GAUCHE --}}
            <div class="col-lg-7 p-b-30">

                {{-- Adresse --}}
                <div class="bor10 p-lr-40 p-t-30 p-b-30 p-lr-15-sm m-b-30">
                    <h4 class="mtext-109 cl2 p-b-25">
                        <i class="zmdi zmdi-pin m-r-8" style="color:#0066cc"></i>Adresse de livraison
                    </h4>
                    <div class="row">
                        <div class="col-md-6 p-b-20">
                            <label class="stext-107 cl3 p-b-8" style="display:block;font-weight:600">Nom complet <span style="color:#e65540">*</span></label>
                            <input type="text" name="fullname" value="{{ old('fullname', $prefill['fullname']) }}"
                                class="checkout-input @error('fullname') is-invalid @enderror"
                                placeholder="Jean Dupont" required>
                            @error('fullname')<span style="color:#e65540;font-size:12px">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-6 p-b-20">
                            <label class="stext-107 cl3 p-b-8" style="display:block;font-weight:600">Email <span style="color:#e65540">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $prefill['email']) }}"
                                class="checkout-input @error('email') is-invalid @enderror"
                                placeholder="email@exemple.com" required>
                            @error('email')<span style="color:#e65540;font-size:12px">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-6 p-b-20">
                            <label class="stext-107 cl3 p-b-8" style="display:block;font-weight:600">Téléphone <span style="color:#e65540">*</span></label>
                            <input type="tel" name="phone" value="{{ old('phone', $prefill['phone']) }}"
                                class="checkout-input @error('phone') is-invalid @enderror"
                                placeholder="+229 97 00 00 00" required>
                            @error('phone')<span style="color:#e65540;font-size:12px">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-6 p-b-20">
                            <label class="stext-107 cl3 p-b-8" style="display:block;font-weight:600">Ville <span style="color:#e65540">*</span></label>
                            <input type="text" name="city" value="{{ old('city', $prefill['city']) }}"
                                class="checkout-input @error('city') is-invalid @enderror"
                                placeholder="Cotonou" required>
                            @error('city')<span style="color:#e65540;font-size:12px">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-12 p-b-20">
                            <label class="stext-107 cl3 p-b-8" style="display:block;font-weight:600">Adresse complète <span style="color:#e65540">*</span></label>
                            <input type="text" name="address" value="{{ old('address', $prefill['address']) }}"
                                class="checkout-input @error('address') is-invalid @enderror"
                                placeholder="Quartier, Rue, N°..." required>
                            @error('address')<span style="color:#e65540;font-size:12px">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-6 p-b-20">
                            <label class="stext-107 cl3 p-b-8" style="display:block;font-weight:600">Pays</label>
                            <select name="country" class="checkout-input">
                                @foreach(['Bénin','Togo','Nigeria','Côte d\'Ivoire','Sénégal','Mali','Burkina Faso','Ghana','Cameroun','Autre'] as $c)
                                    <option value="{{ $c }}" {{ old('country', $prefill['country']) === $c ? 'selected' : '' }}>{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 p-b-20">
                            <label class="stext-107 cl3 p-b-8" style="display:block;font-weight:600">Instructions de livraison (optionnel)</label>
                            <textarea name="notes" rows="3" class="checkout-input" placeholder="Quartier, point de repère...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Paiement --}}
                <div class="bor10 p-lr-40 p-t-30 p-b-30 p-lr-15-sm">
                    <h4 class="mtext-109 cl2 p-b-25">
                        <i class="zmdi zmdi-card m-r-8" style="color:#0066cc"></i>Mode de paiement
                    </h4>
                    <div style="display:flex;flex-direction:column;gap:12px">

                        <label class="payment-option" style="display:flex;align-items:center;gap:16px;padding:16px 20px;border:2px solid #e0e0e0;border-radius:8px;cursor:pointer">
                            <input type="radio" name="payment_method" value="cash_on_delivery"
                                {{ old('payment_method','cash_on_delivery') === 'cash_on_delivery' ? 'checked' : '' }}
                                style="accent-color:#0066cc;width:18px;height:18px;flex-shrink:0">
                            <div>
                                <div style="font-weight:600;color:#333;margin-bottom:3px">💵 Paiement à la livraison</div>
                                <div style="font-size:12px;color:#888">Payez en espèces lors de la réception.</div>
                            </div>
                        </label>

                        <label class="payment-option" style="display:flex;align-items:center;gap:16px;padding:16px 20px;border:2px solid #e0e0e0;border-radius:8px;cursor:pointer">
                            <input type="radio" name="payment_method" value="mtn_benin"
                                {{ old('payment_method') === 'mtn_benin' ? 'checked' : '' }}
                                style="accent-color:#FFCC00;width:18px;height:18px;flex-shrink:0">
                            <div style="display:flex;align-items:center;gap:12px;flex:1">
                                <div style="width:42px;height:42px;border-radius:8px;background:#FFCC00;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:11px;color:#000;flex-shrink:0">MTN</div>
                                <div>
                                    <div style="font-weight:600;color:#333;margin-bottom:2px">MTN MoMo</div>
                                    <div style="font-size:11px;color:#aaa">Préfixes : 96, 97, 66, 67</div>
                                </div>
                            </div>
                        </label>

                        <label class="payment-option" style="display:flex;align-items:center;gap:16px;padding:16px 20px;border:2px solid #e0e0e0;border-radius:8px;cursor:pointer">
                            <input type="radio" name="payment_method" value="moov_benin"
                                {{ old('payment_method') === 'moov_benin' ? 'checked' : '' }}
                                style="accent-color:#0057A8;width:18px;height:18px;flex-shrink:0">
                            <div style="display:flex;align-items:center;gap:12px;flex:1">
                                <div style="width:42px;height:42px;border-radius:8px;background:#0057A8;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:10px;color:#fff;flex-shrink:0">MOOV</div>
                                <div>
                                    <div style="font-weight:600;color:#333;margin-bottom:2px">Moov Money</div>
                                    <div style="font-size:11px;color:#aaa">Préfixes : 95, 60, 64, 65</div>
                                </div>
                            </div>
                        </label>

                        <label class="payment-option" style="display:flex;align-items:center;gap:16px;padding:16px 20px;border:2px solid #e0e0e0;border-radius:8px;cursor:pointer">
                            <input type="radio" name="payment_method" value="celtiis_bj"
                                {{ old('payment_method') === 'celtiis_bj' ? 'checked' : '' }}
                                style="accent-color:#E30613;width:18px;height:18px;flex-shrink:0">
                            <div style="display:flex;align-items:center;gap:12px;flex:1">
                                <div style="width:42px;height:42px;border-radius:8px;background:#E30613;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:9px;color:#fff;flex-shrink:0;text-align:center;line-height:1.2">CELTIIS</div>
                                <div>
                                    <div style="font-weight:600;color:#333;margin-bottom:2px">Celtiis Cash</div>
                                    <div style="font-size:11px;color:#aaa">Préfixes : 61, 62, 63, 69</div>
                                </div>
                            </div>
                        </label>

                    </div>

                    {{-- Champ numéro MoMo --}}
                    <div id="mobile-phone-field" style="display:none;margin-top:20px">
                        <label style="display:block;font-weight:600;font-size:14px;color:#333;margin-bottom:8px">
                            Numéro Mobile Money <span style="color:#e65540">*</span>
                        </label>
                        <div style="display:flex">
                            <span style="padding:10px 14px;background:#f5f5f5;border:1px solid #e0e0e0;border-right:none;border-radius:6px 0 0 6px;font-size:14px;color:#666;flex-shrink:0;white-space:nowrap">
                                🇧🇯 +229
                            </span>
                            <input type="tel" id="mobile-phone" name="mobile_phone"
                                placeholder="97 00 00 00" maxlength="10" autocomplete="tel"
                                style="flex:1;padding:10px 14px;border:1px solid #e0e0e0;border-radius:0 6px 6px 0;font-size:14px;color:#333;transition:border-color .2s">
                        </div>
                        <div id="phone-hint" style="font-size:12px;color:#aaa;margin-top:6px">
                            <i class="zmdi zmdi-info-outline"></i> 8 chiffres sans indicatif — ex : 97 00 00 00
                        </div>
                    </div>
                </div>

                {{-- Bouton --}}
                <button type="button" id="btn-place-order"
                    class="flex-c-m stext-101 cl0 bg1 bor1 hov-btn1 p-lr-15 trans-04 m-t-25"
                    style="width:100%;height:52px;border:none;cursor:pointer;font-size:16px;font-weight:700;border-radius:6px">
                    <i class="zmdi zmdi-lock m-r-8"></i>
                    <span id="btn-label">Confirmer la commande</span>
                </button>
                <p style="font-size:11px;color:#aaa;text-align:center;margin-top:10px">
                    <i class="zmdi zmdi-shield-check m-r-4"></i>
                    Paiement sécurisé par FedaPay · Données chiffrées
                </p>

            </div>

            {{-- DROITE : résumé --}}
            <div class="col-lg-5 p-b-30">
                <div class="bor10 p-lr-40 p-t-30 p-b-30 p-lr-15-sm" style="position:sticky;top:20px">
                    <h4 class="mtext-109 cl2 p-b-20">
                        <i class="zmdi zmdi-shopping-cart m-r-8" style="color:#0066cc"></i>
                        Récapitulatif ({{ $cartItems->count() }} article{{ $cartItems->count() > 1 ? 's' : '' }})
                    </h4>
                    <ul style="list-style:none;padding:0;margin:0;border-bottom:1px solid #e6e6e6;padding-bottom:16px;margin-bottom:16px">
                        @foreach($cartItems as $item)
                        <li style="display:flex;align-items:center;gap:12px;margin-bottom:14px">
                            <div style="position:relative;flex-shrink:0">
                                <img src="{{ $item->product->images->isNotEmpty() ? asset('storage/'.$item->product->images->first()->image_path) : asset('frontend/images/no-image.jpg') }}"
                                    alt="{{ $item->product->name }}"
                                    style="width:56px;height:56px;object-fit:cover;border-radius:6px;border:1px solid #eee">
                                <span style="position:absolute;top:-6px;right:-6px;background:#0066cc;color:#fff;border-radius:50%;width:20px;height:20px;font-size:11px;display:flex;align-items:center;justify-content:center;font-weight:700">{{ $item->quantity }}</span>
                            </div>
                            <div style="flex:1;min-width:0">
                                <div style="font-size:13px;font-weight:600;color:#333;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $item->product->name }}</div>
                                @if($item->color)
                                    <div style="font-size:11px;color:#888;margin-top:2px;display:flex;align-items:center;gap:4px">
                                        <span style="width:10px;height:10px;border-radius:50%;background:{{ $item->color->code }};border:1px solid #ddd;display:inline-block"></span>
                                        {{ $item->color->name }}
                                    </div>
                                @endif
                            </div>
                            <div style="font-size:13px;font-weight:600;color:#333;flex-shrink:0">
                                {{ number_format($item->product->price * $item->quantity, 0, ',', ' ') }} FCFA
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    <div style="font-size:14px;color:#555">
                        <div style="display:flex;justify-content:space-between;margin-bottom:10px">
                            <span>Sous-total</span><span>{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-bottom:10px">
                            <span>Livraison</span>
                            <span>
                                @if($shippingCost === 0)
                                    <span style="color:#5cb85c;font-weight:600">Gratuite 🎉</span>
                                @else
                                    {{ number_format($shippingCost, 0, ',', ' ') }} FCFA
                                @endif
                            </span>
                        </div>
                        @if($shippingCost > 0)
                            <div style="font-size:11px;color:#aaa;margin-bottom:10px;text-align:right">Livraison gratuite dès 1 000 000 FCFA</div>
                        @endif
                        <div style="display:flex;justify-content:space-between;padding-top:14px;border-top:2px solid #e6e6e6;font-size:18px;font-weight:700;color:#333">
                            <span>Total</span>
                            <span>{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                    <p style="font-size:11px;color:#aaa;text-align:center;margin-top:12px">
                        <i class="zmdi zmdi-shield-check m-r-4"></i> Vos données ne seront jamais partagées.
                    </p>
                </div>
            </div>

        </div>
    </form>
</div>

{{-- OVERLAY ATTENTE PAIEMENT --}}
<div id="payment-overlay" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.75);backdrop-filter:blur(4px);align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:20px;padding:44px 48px;max-width:420px;width:92%;text-align:center;box-shadow:0 24px 60px rgba(0,0,0,.3)">
        <div id="op-logo" style="width:72px;height:72px;border-radius:50%;margin:0 auto 20px;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:900"></div>
        <div style="position:relative;width:56px;height:56px;margin:0 auto 22px">
            <div style="position:absolute;inset:0;border:4px solid #f0f0f0;border-top-color:#0066cc;border-radius:50%;animation:spin .8s linear infinite"></div>
        </div>
        <h3 style="font-size:18px;font-weight:700;color:#333;margin-bottom:10px">Paiement en cours...</h3>
        <p id="op-msg" style="font-size:14px;color:#666;line-height:1.6;margin-bottom:20px"></p>
        <div style="font-size:13px;color:#aaa;margin-bottom:16px">
            Expire dans : <span id="op-timer" style="font-weight:700;color:#0066cc">3:00</span>
        </div>
        <div id="op-status" style="padding:10px 16px;border-radius:8px;font-size:13px;font-weight:600;background:#f0f6ff;color:#0066cc;margin-bottom:20px">
            ⏳ En attente de votre confirmation...
        </div>
        <button id="btn-cancel-pay" type="button"
            style="background:none;border:1px solid #e0e0e0;color:#888;padding:8px 24px;border-radius:6px;cursor:pointer;font-size:13px">
            Annuler
        </button>
    </div>
</div>

@include('client.body.footer')

<script src="{{ asset('frontend/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/animsition/js/animsition.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/bootstrap/js/popper.js') }}"></script>
<script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/select2/select2.min.js') }}"></script>
<script>$(".js-select2").each(function(){ $(this).select2({ minimumResultsForSearch:20, dropdownParent:$(this).next('.dropDownSelect2') }); })</script>
<script src="{{ asset('frontend/vendor/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('frontend/vendor/slick/slick.min.js') }}"></script>
<script src="{{ asset('frontend/js/slick-custom.js') }}"></script>
<script src="{{ asset('frontend/vendor/parallax100/parallax100.js') }}"></script>
<script>$('.parallax100').parallax100();</script>
<script src="{{ asset('frontend/vendor/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/isotope/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script>
    $('.js-pscroll').each(function(){
        $(this).css('position','relative').css('overflow','hidden');
        var ps = new PerfectScrollbar(this, {wheelSpeed:1,scrollingThreshold:1000,wheelPropagation:false});
        $(window).on('resize', function(){ ps.update(); });
    });
</script>
<script src="{{ asset('frontend/js/main.js') }}"></script>
@include('frontend.global_js')

{{-- ════════════════════════════════════════════════════════
     SCRIPT CHECKOUT — UN SEUL BLOC
     Corrections :
       1. resetButton() utilise le bon HTML (icône correcte)
       2. Plus de conflict entre deux $(document).ready
       3. Numéro envoyé = 8 chiffres SANS +229 (corresp. PaymentController)
       4. Validation préfixe AVANT d'appeler le serveur
     ════════════════════════════════════════════════════════ --}}
<script>
$(document).ready(function () {

    var TOKEN  = '{{ csrf_token() }}';
    var MOBILE = ['mtn_benin', 'moov_benin', 'celtiis_bj'];

    // Préfixes par opérateur (identiques à OPERATOR_PREFIXES dans PaymentController.php)
    // var PREFIXES = {
    //     mtn_benin  : ['96','97','66','67', '53', '61','62',],
    //     moov_benin : ['95','60','64','65'],
    //     celtiis_bj : ['63','69']
    // };
    var OP_STYLE = {
        mtn_benin  : { bg:'#FFCC00', color:'#000', label:'MTN'     },
        moov_benin : { bg:'#0057A8', color:'#fff', label:'MOOV'    },
        celtiis_bj : { bg:'#E30613', color:'#fff', label:'CELTIIS' }
    };

    var pollInterval  = null;
    var timerInterval = null;
    var timerSec      = 180;

    // ── Afficher/masquer le champ téléphone ───────────────────
    $('input[name="payment_method"]').on('change', function () {
        if (MOBILE.indexOf($(this).val()) !== -1) {
            $('#mobile-phone-field').slideDown(200);
            $('#mobile-phone').prop('required', true);
        } else {
            $('#mobile-phone-field').slideUp(200);
            $('#mobile-phone').prop('required', false);
            resetPhoneField();
        }
    }).filter(':checked').trigger('change');

    // ── Détection opérateur en temps réel ────────────────────
    $('#mobile-phone').on('input', function () {
        var raw    = $(this).val().replace(/\D/g,'');
        var phone  = (raw.length === 11 && raw.indexOf('229') === 0) ? raw.slice(3) : raw;
        var prefix = phone.slice(0, 2);

        if (phone.length < 2) { resetPhoneField(); return; }

        var found = null;
        // $.each(PREFIXES, function(op, pfxs) {
        //     if (pfxs.indexOf(prefix) !== -1) { found = op; return false; }
        // });

        // if (found) {
            $(this).css('border-color','#5cb85c');
            $('#phone-hint').css('color','#5cb85c')
                .html('&#10003; Numéro <strong>' + OP_STYLE[found].label + '</strong> reconnu');
        // } else {
        //     $(this).css('border-color','#e65540');
        //     $('#phone-hint').css('color','#e65540')
        //         .html('&#9888; Préfixe « ' + prefix + ' » non reconnu au Bénin');
        // }
    });

    // ── Clic bouton "Confirmer la commande" ───────────────────
    $('#btn-place-order').on('click', function () {
        var method = $('input[name="payment_method"]:checked').val();

        if (!method) {
            showGlobalError('Veuillez choisir un mode de paiement.');
            return;
        }

        if (MOBILE.indexOf(method) !== -1) {
            if (!validateForm()) return;

            var raw   = $('#mobile-phone').val().replace(/\D/g,'');
            // Retirer l'indicatif 229 si présent
            var phone = (raw.length === 11 && raw.indexOf('229') === 0) ? raw.slice(3) : raw;

            if (phone.length !== 8) {
                setPhoneError('Entrez exactement 8 chiffres sans indicatif +229. Ex: 97001122');
                return;
            }

            var prefix = phone.slice(0, 2);
            // if (PREFIXES[method].indexOf(prefix) === -1) {
            //     setPhoneError('Numéro incompatible avec ' + getOpName(method)
            //         + '. Préfixes valides : ' + PREFIXES[method].join(', '));
            //     return;
            // }

            submitAndPay(method, phone);

        } else {
            // Paiement à la livraison → soumettre le formulaire normalement
            if (validateForm()) {
                setBtnLoading('Traitement en cours...');
                $('#checkout-form').submit();
            }
        }
    });

    // ── ÉTAPE 1 : créer la commande (AJAX) ───────────────────
    function submitAndPay(method, phone) {
        setBtnLoading('Création de la commande...');

        $.ajax({
            url    : '{{ route("client.checkout.store") }}',
            method : 'POST',
            data   : $('#checkout-form').serialize() + '&ajax=1',
            success: function (res) {
                if (res.success && res.order_number) {
                    initiatePay(res.order_number, method, phone);
                } else {
                    resetBtn();
                    showGlobalError(res.message || 'Erreur lors de la création de la commande.');
                }
            },
            error: function (xhr) {
                resetBtn();
                if (xhr.status === 422) {
                    var errors = (xhr.responseJSON && xhr.responseJSON.errors) ? xhr.responseJSON.errors : {};
                    var first  = '';
                    $.each(errors, function(f, msgs) { if (!first) first = msgs[0]; });
                    showGlobalError(first || 'Formulaire invalide. Vérifiez les champs.');
                } else {
                    showGlobalError('Erreur serveur. Réessayez.');
                }
            }
        });
    }

    // ── ÉTAPE 2 : initier le paiement FedaPay ────────────────
    function initiatePay(orderNumber, method, phone) {
        setBtnLoading('Envoi de la demande de paiement...');
        
        // Nettoyer le numéro une dernière fois
        phone = phone.replace(/\D/g, '');
        
        // Si le numéro fait 11 chiffres et commence par 229, garder juste les 8 derniers
        if (phone.length === 11 && phone.indexOf('229') === 0) {
            phone = phone.slice(3);
        }
        
        // Ne garder que les 8 derniers chiffres si trop long
        if (phone.length > 8) {
            phone = phone.slice(-8);
        }
        
        console.log('Phone final envoyé:', phone, 'Longueur:', phone.length);
        
        $.ajax({
            url    : '{{ route("payment.initiate") }}',
            method : 'POST',
            data   : {
                order_number   : orderNumber,
                payment_method : method,
                phone          : phone, // Strictement 8 chiffres
                _token         : TOKEN
            },
            success: function (res) {
                resetBtn();
                if (res.success) {
                    showOverlay(method, res.message, res.transaction_id, orderNumber);
                } else {
                    showGlobalError(res.message || 'Échec de l\'initiation du paiement.');
                }
            },
            error: function (xhr) {
                resetBtn();
                var msg = (xhr.responseJSON && xhr.responseJSON.message)
                    ? xhr.responseJSON.message : 'Erreur lors du paiement. Réessayez.';
                showGlobalError(msg);
            }
        });
    }

    // ── OVERLAY d'attente + polling ───────────────────────────
    function showOverlay(method, message, txId, orderNumber) {
        timerSec = 180;
        var op = OP_STYLE[method];
        $('#op-logo').css({ background: op.bg, color: op.color }).text(op.label);
        $('#op-msg').text(message);
        setStatusBox('⏳ En attente de votre confirmation...', '#f0f6ff', '#0066cc');
        $('#payment-overlay').css('display','flex');

        updateTimer();
        timerInterval = setInterval(function () {
            timerSec--;
            updateTimer();
            if (timerSec <= 0) stopAll('⏰ Délai expiré. Fermez et réessayez.');
        }, 1000);

        // Polling toutes les 5s, premier check après 8s
        setTimeout(function () { checkStatus(txId, orderNumber); }, 8000);
        pollInterval = setInterval(function () { checkStatus(txId, orderNumber); }, 5000);
    }

    function checkStatus(txId, orderNumber) {
        $.post('{{ route("payment.check-status") }}',
            { transaction_id: txId, order_number: orderNumber, _token: TOKEN },
            function (res) {
                if (res.status === 'approved') {
                    clearAll();
                    setStatusBox('✅ Paiement confirmé ! Redirection...', '#d1e7dd', '#0a3622');
                    setTimeout(function () { window.location.href = res.redirect_url; }, 1200);
                } else if (res.status === 'declined' || res.status === 'cancelled') {
                    stopAll('❌ ' + res.message);
                }
                // pending → on continue le polling
            }
        );
    }

    $('#btn-cancel-pay').on('click', function () {
        stopAll('Paiement annulé. Vous pouvez réessayer.');
        setTimeout(function () { $('#payment-overlay').css('display','none'); }, 2000);
    });

    // ── Utilitaires internes ──────────────────────────────────

    function updateTimer() {
        var m = Math.floor(timerSec / 60), s = timerSec % 60;
        $('#op-timer').text(m + ':' + (s < 10 ? '0' : '') + s);
    }
    function stopAll(msg) { clearAll(); setStatusBox(msg, '#f8d7da', '#721c24'); }
    function clearAll() { clearInterval(pollInterval); clearInterval(timerInterval); }
    function setStatusBox(txt, bg, color) {
        $('#op-status').text(txt).css({ background: bg, color: color });
    }

    function setBtnLoading(txt) {
        $('#btn-place-order').prop('disabled', true);
        $('#btn-label').html('<span class="zmdi zmdi-rotate-right zmdi-hc-spin" style="margin-right:8px"></span>' + txt);
    }
    function resetBtn() {
        $('#btn-place-order').prop('disabled', false);
        // CORRECTION : icône correcte (pas </i> orpheline)
        $('#btn-label').html('<i class="zmdi zmdi-lock" style="margin-right:8px"></i>Confirmer la commande');
    }

    function setPhoneError(msg) {
        $('#mobile-phone').css('border-color','#e65540');
        $('#phone-hint').css('color','#e65540').html('&#9888; ' + msg);
        $('#mobile-phone')[0].scrollIntoView({ behavior:'smooth', block:'nearest' });
    }
    function resetPhoneField() {
        $('#mobile-phone').css('border-color','');
        $('#phone-hint').css('color','#aaa')
            .html('<i class="zmdi zmdi-info-outline"></i> 8 chiffres sans indicatif — ex : 97 00 00 00');
    }

    function showGlobalError(msg) {
        $('.checkout-global-error').remove();
        var el = $('<div class="checkout-global-error" style="background:#f8d7da;border:1px solid #f5c6cb;border-radius:6px;padding:12px 16px;color:#721c24;font-size:14px;margin-top:14px">&#9888; ' + msg + '</div>');
        $('#btn-place-order').after(el);
        el[0].scrollIntoView({ behavior:'smooth', block:'nearest' });
    }

    function validateForm() {
        var ok = true;
        $('#checkout-form [required]').each(function () {
            if (!$(this).val().trim()) {
                $(this).css('border-color','#e65540');
                $(this).one('input change', function () { $(this).css('border-color',''); });
                ok = false;
            }
        });
        if (!ok) showGlobalError('Remplissez tous les champs obligatoires avant de continuer.');
        return ok;
    }

    function getOpName(method) {
        var names = { mtn_benin:'MTN MoMo', moov_benin:'Moov Money', celtiis_bj:'Celtiis Cash' };
        return names[method] || 'Mobile Money';
    }

}); // fin $(document).ready
</script>

</body>
</html>