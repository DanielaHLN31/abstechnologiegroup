<!doctype html>

<html
    lang="en"
    class="light-style layout-wide customizer-hide"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="{{ asset('') }}"
    data-template="vertical-menu-template">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

        <title>Créer un compte - ABS TECHNOLOGIE</title>

        <meta name="description" content="Créez un compte client pour accéder à la plateforme ABS TECHNOLOGIE." />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('backend/img/favicon/abs_logo.png')}}" />
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('backend/img/favicon/abs_logo.png')}}" />
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('backend/img/favicon/abs_logo.png')}}" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="index, follow">
        <link rel="canonical" href="https://abs-technologie.com/">
        <meta name="image" content="{{ asset('backend/img/favicon/abs_logo.png')}}">

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
        <link rel="stylesheet" href="{{ asset('backend/vendor/libs/bs-stepper/bs-stepper.css')}}" />
        <link rel="stylesheet" href="{{ asset('backend/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
        <link rel="stylesheet" href="{{ asset('backend/vendor/libs/select2/select2.css')}}" />
        <link rel="stylesheet" href="{{ asset('backend/vendor/libs/@form-validation/form-validation.css')}}" />
        <!-- Page -->
        <link rel="stylesheet" href="{{ asset('backend/vendor/css/pages/page-auth.css')}}" />
        <!-- Helpers -->
        <!-- Core CSS -->
        <link rel="stylesheet" href="{{ asset('backend/vendor/css/rtl/core.css')}}" class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{ asset('backend/vendor/css/rtl/theme-default.css')}}" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    </head>

    <body>
        <div class="authentication-wrapper authentication-cover authentication-bg">
            <div class="authentication-inner row">
                <!-- Left Text -->
                <div
                    class="d-none d-lg-flex col-lg-5 flex-column align-items-center justify-content-center p-5 auth-cover-bg-color position-relative">
                    <img
                        src="{{ asset('backend/img/illustrations/auth-two-step-illustration-light.png')}}"
                        alt="auth-register"
                        class="img-fluid"
                        width="350" />

                    <div class="text-center mt-4">
                        <h3 class="text-primary mb-2">Bienvenue chez ABS TECHNOLOGIE</h3>
                        <p class="text-muted">Créez votre compte client pour accéder à nos services et solutions innovantes.</p>
                    </div>

                    {{-- <div class="mt-3 text-center">
                        <span class="badge bg-label-info me-2">Sécurisé</span>
                        <span class="badge bg-label-success me-2">Rapide</span>
                        <span class="badge bg-label-primary">Simple</span>
                    </div> --}}
                </div>
                <!-- /Left Text -->

                <!-- Registration Form -->
                <div class="d-flex col-lg-7 align-items-center justify-content-center p-sm-5 p-3">
                    <div class="container-fluid">
                        <div class="card shadow-none bg-transparent border-0">
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    <h3 class="mb-1">Créer un compte client</h3>
                                    <p class="mb-0">Remplissez le formulaire ci-dessous pour vous inscrire</p>
                                </div>

                                <form id="register-form" action="{{ route('register.client.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <!-- Informations de connexion -->
                                    <div class="mb-4">
                                        <h5 class="mb-3">Informations de connexion</h5>
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <label class="form-label required" for="username">Nom d'utilisateur</label>
                                                <input type="text" name="username" id="username" class="form-control" placeholder="johndoe" required />
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label required" for="email">Adresse email</label>
                                                <input type="email" name="email" id="email" class="form-control" placeholder="john.doe@email.com" required />
                                            </div>
                                            <div class="col-md-6 form-password-toggle">
                                                <label class="form-label required" for="password">Mot de passe</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="password" id="password" name="password" class="form-control" placeholder="············" required />
                                                    <span class="input-group-text cursor-pointer toggle-password"><i class="ti ti-eye-off"></i></span>
                                                </div>
                                                <small class="text-muted">Minimum 8 caractères</small>
                                            </div>
                                            <div class="col-md-6 form-password-toggle">
                                                <label class="form-label required" for="password_confirmation">Confirmer le mot de passe</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="············" required />
                                                    <span class="input-group-text cursor-pointer toggle-password"><i class="ti ti-eye-off"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Conditions -->
                                    <div class="mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                            <label class="form-check-label" for="terms">
                                                J'accepte les <a href="/politique-de-confidentialite" target="_blank">conditions d'utilisation</a> et la <a href="/politique-de-confidentialite" target="_blank">politique de confidentialité</a>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Boutons -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('login') }}" class="btn btn-label-secondary">
                                            <i class="ti ti-arrow-left ti-xs me-1"></i>
                                            Retour à la connexion
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti ti-user-plus ti-xs me-1"></i>
                                            Créer mon compte
                                        </button>
                                    </div>
                                </form>

                                <hr class="my-4">

                                <div class="text-center">
                                    <p class="mb-0">Vous avez déjà un compte ? 
                                        <a href="{{ route('client.login') }}" class="fw-semibold">Connectez-vous</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Registration Form -->
            </div>
        </div>

        <!-- Scripts -->
        <script src="{{ asset('backend/vendor/libs/jquery/jquery.js')}}"></script>
        <script src="{{ asset('backend/vendor/libs/popper/popper.js')}}"></script>
        <script src="{{ asset('backend/vendor/js/bootstrap.js')}}"></script>
        <script src="{{ asset('backend/vendor/libs/node-waves/node-waves.js')}}"></script>
        <script src="{{ asset('backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
        <script src="{{ asset('backend/vendor/libs/hammer/hammer.js')}}"></script>
        <script src="{{ asset('backend/vendor/libs/select2/select2.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialisation Select2
                $('.select2').select2({
                    dropdownParent: $('.card-body')
                });

                // Initialisation Flatpickr pour la date
                flatpickr(".date-picker", {
                    dateFormat: "d-m-Y",
                    locale: "fr",
                    allowInput: true
                });

                // Toggle password visibility
                document.querySelectorAll('.toggle-password').forEach(button => {
                    button.addEventListener('click', function() {
                        const input = this.closest('.input-group').querySelector('input');
                        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                        input.setAttribute('type', type);
                        this.querySelector('i').classList.toggle('ti-eye-off');
                        this.querySelector('i').classList.toggle('ti-eye');
                    });
                });

                // Validation du formulaire côté client
                const form = document.getElementById('register-form');
                form.addEventListener('submit', function(e) {
                    const password = document.getElementById('password').value;
                    const confirmPassword = document.getElementById('password_confirmation').value;
                    
                    if (password !== confirmPassword) {
                        e.preventDefault();
                        alert('Les mots de passe ne correspondent pas.');
                    }
                    
                    if (password.length < 8) {
                        e.preventDefault();
                        alert('Le mot de passe doit contenir au moins 8 caractères.');
                    }
                });
            });
        </script>
    </body>
</html>