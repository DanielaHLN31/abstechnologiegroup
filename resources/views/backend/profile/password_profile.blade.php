@extends('admin.admin_master')

@push('links')
    <title>Mot de passe-ABS-TECHNOLOGIE</title>

    <!-- Row Group CSS -->
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css')}}" />

    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/node-waves/node-waves.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/typeahead-js/typeahead.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/tagify/tagify.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/animate-css/animate.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/sweetalert2/sweetalert2.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/@form-validation/form-validation.css')}}" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>

        /* Exemple avec une classe spécifique */
        .my-button-class:hover {

            color: brown; /* Changer la couleur du texte au survol, si nécessaire */
        }

    </style>


@endpush


@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Paramètres du compte /</span> Profile</h4>

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-4">
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('parametre') }}"
                        ><i class="ti-xs ti ti-users me-1"></i> Général</a
                        >
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('get.password') }}"
                        ><i class="ti-xs ti ti-lock me-1"></i> Modifier Mot de Passe</a
                        >
                    </li>
                </ul>
                <!-- Change Password -->
                <div class="card mb-4">
                    <h5 class="card-header">Change Password</h5>
                    <div class="card-body">
                        <form id="password-form" method="POST" action="{{ route("Password.update.profil") }}">
                            @csrf

                            <div class="row">
                                <div class="mb-3 col-md-6 form-password-toggle">
                                    <label class="form-label" for="old_password">Ancien mot de passe</label>
                                    <div class="input-group input-group-merge">
                                        <input
                                            class="form-control"
                                            type="password"
                                            name="old_password"
                                            id="old_password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                        <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6 form-password-toggle">
                                    <label class="form-label" for="new_password">Nouveau mot de passe</label>
                                    <div class="input-group input-group-merge">
                                        <input
                                            class="form-control"
                                            type="password"
                                            id="new_password"
                                            name="new_password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                        <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6 form-password-toggle">
                                    <label class="form-label" for="new_password_confirmation">Confirmation du nouveau mot de passe</label>
                                    <div class="input-group input-group-merge">
                                        <input
                                            class="form-control"
                                            type="password"
                                            name="new_password_confirmation"
                                            id="new_password_confirmation"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                        <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                    </div>
                                </div>
                                <div class="col-12 mb-4 mt-5">
                                    <h6>Exigences relatives au mot de passe:</h6>
                                    <ul class="ps-3 mb-0">
                                        <li class="mb-1">Le nouveau mot de passe doit contenir au moins 8 caractères</li>
                                        <li class="mb-1">Au moins un caractère minuscule</li>
                                        <li>Au moins un chiffre, un symbole ou un caractère d'espacement</li>
                                    </ul>
                                </div>
                                <div>
                                    {{-- <button type="submit" class="btn btn-primary me-2">Enregistrer Modification</button> --}}
                                    <button type="submit" class="btn btn-primary me-2">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                                        <span class="ms-1">Enregistrer Modification</span>
                                    </button>
                                    <a href="{{ route('dashboardVendors') }}" class="btn btn-label-secondary">Retour</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->

@endsection

@push('scripts')

    <!-- Vendors JS -->
    <script src="{{ asset('backend/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <!-- Flat Picker -->
    <script src="{{ asset('backend/vendor/libs/moment/moment.js')}}"></script>

    <!-- Vendors JS -->
    <script src="{{ asset('backend/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{ asset('backend/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
    <script src="{{ asset('backend/vendor/libs/moment/moment.js')}}"></script>
    <script src="{{ asset('backend/vendor/libs/flatpickr/flatpickr.js')}}"></script>
    <script src="{{ asset('backend/vendor/libs/typeahead-js/typeahead.js')}}"></script>
    <script src="{{ asset('backend/vendor/libs/tagify/tagify.js')}}"></script>
    <script src="{{ asset('backend/vendor/libs/@form-validation/popular.js')}}"></script>
    <script src="{{ asset('backend/vendor/libs/@form-validation/bootstrap5.js')}}"></script>
    <script src="{{ asset('backend/vendor/libs/@form-validation/auto-focus.js')}}"></script>
    <script src="{{ asset('backend/vendor/libs/cleavejs/cleave.js')}}"></script>
    <script src="{{ asset('backend/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
    <script src="{{ asset('backend/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>

    <!-- Vendors JS -->
    <script src="{{ asset('backend/vendor/libs/jquery-repeater/jquery-repeater.js')}}"></script>

    <!-- Page JS -->
    <script src="{{ asset('backend/js/forms-extras.js')}}"></script>

    <!-- Page JS -->
    <script src="{{ asset('backend/js/form-validation.js')}}"></script>

    <!-- Vendors JS -->
    <script src="{{ asset('backend/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
    <script src="{{ asset('backend/js/form-layouts.js')}}"></script>


    <!-- Page JS -->
    <script src="{{ asset('backend/js/extended-ui-sweetalert2.js')}}"></script>
    <script src="{{ asset('backend/js/pages-account-settings-account.js')}}"></script>
    <script src="{{asset('backend/js/spinner.js')}}" defer></script>



    {{-- @include('backend.profile.js.default') --}}

    @include('backend.profile.js.password')




@endpush
