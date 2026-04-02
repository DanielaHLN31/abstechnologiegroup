
<!doctype html>

<html lang="en"
    class="light-style layout-wide customizer-hide"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="{{ asset('') }}">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

        <title>Connexion - GoodTroc</title>

        <meta name="description" content="Accédez à votre compte en toute sécurité. Saisissez vos identifiants pour utiliser les fonctionnalités de la plateforme." />

        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('backend/img/favicon/goodtroc_logo.png')}}" />
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('backend/img/favicon/goodtroc_logo.png')}}" />
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('backend/img/favicon/goodtroc_logo.png')}}" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{--<link rel="manifest" href="{{ asset('frontend/images/favicons/site.html')}}" />--}}
        <meta name="robots" content="index, follow">
        <link rel="canonical" href="https://staff-goodtroc.com/">
        <meta name="image" content="{{ asset('backend/img/favicon/goodtroc_logo.png')}}">
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('backend/vendor/fonts/fontawesome.css')}}" />
        <link rel="stylesheet" href="{{ asset('backend/vendor/fonts/tabler-icons.css')}}" />
        <link rel="stylesheet" href="{{ asset('backend/vendor/fonts/flag-icons.css')}}" />
        <link rel="stylesheet" href="{{ asset('backend/vendor/css/rtl/core.css')}}" class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{ asset('backend/vendor/css/rtl/theme-default.css')}}" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="{{ asset('backend/css/demo.css')}}" />
        <link rel="stylesheet" href="{{ asset('backend/vendor/libs/node-waves/node-waves.css')}}" />
        <link rel="stylesheet" href="{{ asset('backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
        <link rel="stylesheet" href="{{ asset('backend/vendor/libs/typeahead-js/typeahead.css')}}" />
        <link rel="stylesheet" href="{{ asset('backend/vendor/libs/@form-validation/form-validation.css')}}" />
        <link rel="stylesheet" href="{{ asset('backend/vendor/css/pages/page-auth.css')}}" />
        <script src="{{ asset('backend/vendor/js/helpers.js')}}"></script>
        <script src="{{ asset('backend/vendor/js/template-customizer.js')}}"></script>
        <script src="{{ asset('backend/js/config.js')}}"></script>
        <link rel="stylesheet" href="{{ asset('backend/vendor/css/rtl/core.css')}}" class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{ asset('backend/vendor/css/rtl/theme-default.css')}}" class="template-customizer-theme-css" />
    </head>

    <body>

        {{-- <div class="container-xxl" style="transform: scale(1.1); ">
            <div class="authentication-wrapper authentication-basic container-p-y">
                <div class="authentication-inner py-4">

                    <div class="card">
                        <div class="card-body">

                            <div class="app-brand justify-content-center mb-4 mt-2">
                                <a href="{{ route('client.login') }}" class="app-brand-link gap-2">
                                    <img alt="ABS Logo" class="w-48 mt-8" src="{{ asset('backend/img/logo/logo_abs.png')}}">
                                </a>
                            </div>
                            <h4 class="card-title mb-1">ABS TECHNOLOGIE</h4>
                            <p class="card-text mb-2">Entrer vos identifiants pour vous connecter</p>

                            @error('message')
                                <div class="alert alert-danger show mb-2" role="alert">{{ $message }}</div>
                            @enderror
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @error('password')
                                <div class="alert alert-danger show mb-2" role="alert">{{ $message }}</div>
                            @enderror
                            @error('password_confirmation')
                                <div class="alert alert-danger show mb-2" role="alert">{{ $message }}</div>
                            @enderror

                            @if(isset($sessionExpired) && $sessionExpired)
                                <div class="alert alert-warning">
                                    Votre session a expiré. Veuillez vous reconnecter.
                                </div>
                            @endif

                        <!-- Reste de votre formulaire de connexion -->
                            <form id="login-form" class="mb-3" action="{{ route('client.login.Store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email"
                                            class="form-control"
                                            id="email"
                                            name="email"
                                            placeholder="caseco@example.com"
                                            value="{{ old('email') }}"
                                            autofocus />
                                </div>
                                <div id="password-fields"></div>

                                <div class="mb-3 d-flex justify-content-between">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember" name="remember" />
                                        <label class="form-check-label" for="remember"> Se souvenir de moi </label>
                                    </div>
                                    <a href="{{ route('password.forgot') }}">
                                        <small>Mot de passe oublié ?</small>
                                    </a>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary d-grid w-100" type="submit">Connectez-vous</button>
                                </div>
                            </form>

                            <p class="text-center">
                                <span>Vous n'avez pas de compte ?</span>
                                <a href="{{ route('client.register') }}">
                                    <span>Créer un compte</span>
                                </a>
                            </p>
                        </div>
                    </div>
                    <!-- /Register -->
                </div>
            </div>
        </div> --}}
        
    <div class="authentication-wrapper authentication-cover authentication-bg">
      <div class="authentication-inner row">
        <!-- /Left Text -->
        <div class="d-none d-lg-flex col-lg-7 p-0">
          <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
            <img
              src="{{ asset('backend/img/illustrations/1.png')}}"
              alt="auth-login-cover"
              class="img-fluid auth-illustration"/>

            <img
              src="{{ asset('backend/img/illustrations/bg-shape-image-light.png')}}"
              alt="auth-login-cover"
              class="platform-bg"/>
          </div>
        </div>
        <!-- /Left Text -->

        <!-- Login -->
        <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
          <div class="w-px-400 mx-auto">
            <!-- Logo -->
            <div class="app-brand mb-4">
                {{-- <a href="index.html" class="app-brand-link gap-2">
                    <span class="app-brand-logo demo">
                    <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                        fill="#7367F0" />
                        <path
                        opacity="0.06"
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
                        fill="#161616" />
                        <path
                        opacity="0.06"
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
                        fill="#161616" />
                        <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                        fill="#7367F0" />
                    </svg>
                    </span>
                </a> --}}
                <a href="{{ route('client.index') }}" class="app-brand-link gap-2">
                    <img alt="ABS Logo" class="w-48 mt-8" src="{{ asset('backend/img/logo/logo_abs.png')}}" style="width: 60px; height:35px">
                </a>
            </div>
            <!-- /Logo -->
            <h3 class="mb-1" style="font-size: 1.25rem">Bienvenue à ABS TECHNOLOGIE! 👋</h3>
            <p class="mb-4">Veuillez vous connecter à votre compte et commencer l'aventure</p>
            @error('message')
                <div class="alert alert-danger show mb-2" role="alert">{{ $message }}</div>
            @enderror
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @error('password')
                <div class="alert alert-danger show mb-2" role="alert">{{ $message }}</div>
            @enderror
            @error('password_confirmation')
                <div class="alert alert-danger show mb-2" role="alert">{{ $message }}</div>
            @enderror

            @if(isset($sessionExpired) && $sessionExpired)
                <div class="alert alert-warning">
                    Votre session a expiré. Veuillez vous reconnecter.
                </div>
            @endif

            <form id="login-form" class="mb-3" action="{{ route('client.login.Store') }}" method="POST">
                @csrf
                <input type="hidden" name="cart_session_id" value="{{ session()->getId() }}">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            placeholder="caseco@example.com"
                            value="{{ old('email') }}"
                            autofocus />
                </div>
                <div id="password-fields"></div>

                <div class="mb-3 d-flex justify-content-between">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember" />
                        <label class="form-check-label" for="remember"> Se souvenir de moi </label>
                    </div>
                    <a href="{{ route('password.forgot') }}">
                        <small>Mot de passe oublié ?</small>
                    </a>
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary d-grid w-100" type="submit">Connectez-vous</button>
                </div>
            </form>

            <p class="text-center">
                <span>Vous n'avez pas de compte ?</span>
                <a href="{{ route('client.register') }}">
                    <span>Créer un compte</span>
                </a>
            </p>

            {{-- <div class="divider my-4">
              <div class="divider-text">ou</div>
            </div>

            <div class="d-flex justify-content-center">
              <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
                <i class="tf-icons fa-brands fa-facebook-f fs-5"></i>
              </a>

              <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
                <i class="tf-icons fa-brands fa-google fs-5"></i>
              </a>

              <a href="javascript:;" class="btn btn-icon btn-label-twitter">
                <i class="tf-icons fa-brands fa-twitter fs-5"></i>
              </a>
            </div> --}}
          </div>
        </div>
        <!-- /Login -->
      </div>
    </div>

        <script src="{{ asset('backend/vendor/libs/jquery/jquery.js')}}"></script>
        <script src="{{ asset('backend/vendor/libs/popper/popper.js')}}"></script>
        <script src="{{ asset('backend/vendor/js/bootstrap.js')}}"></script>
        <script src="{{ asset('backend/vendor/libs/node-waves/node-waves.js')}}"></script>
        <script src="{{ asset('backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
        <script src="{{ asset('backend/vendor/libs/hammer/hammer.js')}}"></script>
        <script src="{{ asset('backend/vendor/libs/i18n/i18n.js')}}"></script>
        <script src="{{ asset('backend/vendor/libs/typeahead-js/typeahead.js')}}"></script>
        <script src="{{ asset('backend/vendor/js/menu.js')}}"></script>
        <script src="{{ asset('backend/vendor/libs/@form-validation/popular.js')}}"></script>
        <script src="{{ asset('backend/vendor/libs/@form-validation/bootstrap5.js')}}"></script>
        <script src="{{ asset('backend/vendor/libs/@form-validation/auto-focus.js')}}"></script>
        <script src="{{ asset('backend/js/main.js')}}"></script>
        <script src="{{ asset('backend/js/pages-auth.js')}}"></script>

        @include('auth.js.login')

    </body>

</html>
