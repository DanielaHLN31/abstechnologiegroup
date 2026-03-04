
<!doctype html>

<html lang="en"
    class="light-style layout-wide customizer-hide"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../../assets/"
    data-template="vertical-menu-template">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Réinitialiser Mot de passe - GoodTroc</title>

    <meta name="description" content="Accédez à votre compte en toute sécurité. Saisissez vos identifiants pour utiliser les fonctionnalités de la plateforme." />
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('backend/img/favicon/goodtroc_logo.png')}}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('backend/img/favicon/goodtroc_logo.png')}}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('backend/img/favicon/goodtroc_logo.png')}}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--<link rel="manifest" href="{{ asset('frontend/images/favicons/site.html')}}" />--}}
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://staff-goodtroc.com/">
    <meta name="image" content="{{ asset('backend/img/favicon/goodtroc_logo.png')}}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap" rel="stylesheet" />
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('backend/vendor/fonts/fontawesome.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/fonts/tabler-icons.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/fonts/flag-icons.css')}}" />
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('backend/vendor/css/rtl/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/css/rtl/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('backend/css/demo.css')}}" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/node-waves/node-waves.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/typeahead-js/typeahead.css')}}" />
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/@form-validation/form-validation.css')}}" />
    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('backend/vendor/css/pages/page-auth.css')}}" />

    <!-- Helpers -->
    <script src="{{ asset('backend/vendor/js/helpers.js')}}"></script>
    <script src="{{ asset('backend/vendor/js/template-customizer.js')}}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('backend/js/config.js')}}"></script>
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('backend/vendor/css/rtl/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/css/rtl/theme-default.css')}}" class="template-customizer-theme-css" />
</head>

<body>
    <!-- Content -->
    <div class="container-xxl" style="transform: scale(1.1); ">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Login -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <a href="index.html" class="app-brand-link gap-2">
                                <img alt="ABS Logo" class="w-48 mt-8" src="{{ asset('backend/img/logo/logo_abs.png')}}">
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="card-title mb-1">ABS TECHNOLOGIE: Réinitialisation</h4>
                        <p class="card-text mb-2">Entrez votre email pour réinitialiser votre mot de passe.</p>

                        @error('message')
                            <div class="alert alert-danger show mb-2" role="alert">{{ $message }}</div>
                        @enderror
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif


                        <form method="POST" action="{{ route('password.email.sent') }}">
                            @csrf

                            <div class="form-group"style="margin-top:1rem">
                                <label for="email">Adresse email</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3" style="margin-top:1rem">
                                <button class="btn btn-primary d-grid w-100" type="submit">Envoyer le lien de réinitialisation</button>
                            </div>
                        </form>

                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>
    <!-- / Content -->

    <!-- Core JS -->
    <script src="{{ asset('backend/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{ asset('backend/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{ asset('backend/vendor/js/bootstrap.js')}}"></script>
    <script src="{{ asset('backend/vendor/libs/node-waves/node-waves.js')}}"></script>
    <script src="{{ asset('backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{ asset('backend/vendor/libs/hammer/hammer.js')}}"></script>
    <script src="{{ asset('backend/vendor/libs/i18n/i18n.js')}}"></script>
    <script src="{{ asset('backend/vendor/libs/typeahead-js/typeahead.js')}}"></script>
    <script src="{{ asset('backend/vendor/js/menu.js')}}"></script>
    <!-- Vendors JS -->
    <script src="{{ asset('backend/vendor/libs/@form-validation/popular.js')}}"></script>
    <script src="{{ asset('backend/vendor/libs/@form-validation/bootstrap5.js')}}"></script>
    <script src="{{ asset('backend/vendor/libs/@form-validation/auto-focus.js')}}"></script>
    <!-- Main JS -->
    <script src="{{ asset('backend/js/main.js')}}"></script>
    <!-- Page JS -->
    <script src="{{ asset('backend/js/pages-auth.js')}}"></script>

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>
</body>
</html>
