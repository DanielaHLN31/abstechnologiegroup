@extends('admin.admin_master')
@php

    $increment = 1;

@endphp

@push('links')

    <title>Utilisateurs-ABS-TECHNOLOGIE</title>
    @section('description','Gérez les utilisateurs du système, leurs profils, leurs rôles et leurs accès aux différentes fonctionnalités.')

    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css')}}" />

    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/tagify/tagify.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/animate-css/animate.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/sweetalert2/sweetalert2.css')}}" />

    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/bs-stepper/bs-stepper.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/@form-validation/form-validation.css')}}" />


    @include('backend.user.css.style');

    <style>

        /* Exemple avec une classe spécifique */
        .my-button-class:hover {

            color: brown; /* Changer la couleur du texte au survol, si nécessaire */
        }


        .required::after {
            content: " *";
            color: red;
            font-weight: bold;
        }



        .modal-xl {
                /* max-width: 60% !important; */
                margin: 1.75rem auto;
            }

            /* Styles pour le stepper responsive */
            .bs-stepper {
                max-width: 100%;
                overflow-x: hidden;
            }

            .bs-stepper-header {
                flex-wrap: wrap;
                padding: 1rem 0;
            }

        /* Point de rupture pour passer en mode vertical */
        @media (max-width: 1200px) {

            .bs-stepper .bs-stepper-header .step .step-trigger {
                padding: 2px 0rem;
                flex-wrap: nowrap;
                gap: 1rem;
                font-weight: 500;
            }
            .bs-stepper-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .step {
                width: auto;
                min-width: 300px;
                max-width: 80%;
                margin-bottom: 1rem;
                display: flex;
                justify-content: center;
            }

            .step .step-trigger {
                width: 100%;
                padding: 1rem;
                display: flex;
                align-items: center;
                justify-content: flex-start;
            }

            .bs-stepper-circle {
                margin-right: 1rem;
                flex-shrink: 0;
            }

            .bs-stepper-label {
                flex-grow: 1;
            }

            .line {
                display: none;
            }

        }

        /* Ajustements pour petits écrans */
        @media (max-width: 768px) {
            .modal-dialog {
                margin: 0.5rem;
            }

            .modal-xl {
                max-width: 100% !important;
                margin: 0.5rem;
            }

            .row.g-6 {
                margin: 0;
            }

            .col-sm-6, .col-sm-12 {
                padding: 0.5rem;
            }

            .step {
                min-width: 250px;
                max-width: 90%;
            }

            .btn-prev, .btn-next {
                width: 100%;
                margin: 0.25rem 0;
            }

            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 0.5rem;
            }
        }

        .form-control, .form-select {
            max-width: 100%;
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .modal-xl {
                max-width: 90% !important;
            }

            .row.g-6 {
                margin: 0 -0.5rem;
            }

            .col-sm-6, .col-sm-12 {
                padding: 0.5rem;
            }
        }

        .form-label {
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .bs-stepper-title {
            font-size: 1rem;
            font-weight: 600;
        }

        .bs-stepper-subtitle {
            font-size: 0.875rem;
            opacity: 0.8;
        }

        .bs-stepper-header {
            transition: all 0.3s ease;
        }

        .step {
            transition: all 0.3s ease;
        }
    </style>


@endpush

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row breadcrumbs-top mb-2">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">Mes Utilisateurs</h2>
            </div>
        </div>

        @can('create user')
        <div class="mt-2 mb-3">
            <button
                type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#exLargeModal">
                Ajouter un utilisateur
            </button>
        </div>
        @endcan

        <div class="content-header-left col-md-9 col-12 mb-2 mt-4">
            <div class="mt-2 mb-5">
                @include('backend.user.modal.default')
            </div>
        </div>

        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title mb-0">Filters</h5>
                <div class="d-flex justify-content-between align-items-center row pt-4 gap-4 gap-md-0">
                    <div class="col-md-4 user_role"></div>
                </div>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-users table" id="declaration-table">
                    <thead>
                        <tr style="background-color: #f3f2f7">
                            <th>N°</th>
                            <th>Nom</th>
                            <th>Rôles</th>
                            <th>Status</th>
                            @canany(['edit user', 'delete user', 'activate user', 'deactivate user', 'assign role to user', 'view users'])
                            <th>Action</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $key => $user)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $user->personnel->nom }} {{ $user->personnel->prenoms }}</td>
                                <td>{{ $user->getRoleNames()->implode(', ') }}</td>
                                <td style="text-transform: none">
                                    @if($user->status == 2)
                                        <span class="badge rounded-pill bg-warning bg-glow">En attente de validation</span>
                                    @elseif($user->status == 1)
                                        <span class="badge rounded-pill bg-success bg-glow">Activer</span>
                                    @else
                                        <span class="badge rounded-pill bg-danger bg-glow">Désactiver</span>
                                    @endif
                                </td>

                                @canany(['edit user', 'delete user', 'activate user', 'deactivate user', 'assign role to user', 'view users'])
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow my-button-class" data-bs-toggle="dropdown">
                                            <div class="icon-group" style="display: inline-flex; align-items: center; cursor: pointer;">
                                                <i class="fa-solid fa-ellipsis-vertical" style="font-size: 27px;"></i>
                                                <i class="fa-solid fa-ellipsis-vertical" style="font-size: 27px; margin-left: 4px;"></i>
                                            </div>
                                        </button>
                                        <div class="dropdown-menu">

                                            {{-- Désactiver --}}
                                            @can('deactivate user')
                                                @if(($user->status == 1 || $user->status == 2) && $user->principal != 1)
                                                    <a class="dropdown-item desactive-user-btn" href="#" data-user-id="{{ $user->id }}">
                                                        <i class="ti ti-ban me-1"></i> Désactiver
                                                    </a>
                                                @endif
                                            @endcan

                                            {{-- Activer --}}
                                            @canany(['activate user', 'assign role to user'])
                                                @if($user->status == 2 && $user->principal != 1)
                                                    @can('assign role to user')
                                                    <a class="dropdown-item active-user-role-btn" href="#" data-user-id="{{ $user->id }}">
                                                        <i class="ti ti-check me-1"></i> Activer
                                                    </a>
                                                    @endcan
                                                @elseif($user->status == 0)
                                                    @if(!empty($user->role_id))
                                                        @can('activate user')
                                                        <a class="dropdown-item active-user-btn" href="#" data-user-id="{{ $user->id }}">
                                                            <i class="ti ti-check me-1"></i> Activer
                                                        </a>
                                                        @endcan
                                                    @else
                                                        @can('assign role to user')
                                                        <a class="dropdown-item active-user-role-btn" href="#" data-user-id="{{ $user->id }}">
                                                            <i class="ti ti-check me-1"></i> Activer
                                                        </a>
                                                        @endcan
                                                    @endif
                                                @endif
                                            @endcanany

                                            {{-- Détail --}}
                                            @can('view users')
                                            <a class="dropdown-item details-user-btn" href="javascript:void(0);" data-user-details-id="{{ $user->id }}">
                                                <i class="ti ti-eye me-1"></i> Détail
                                            </a>
                                            @endcan

                                            {{-- Modifier --}}
                                            @can('edit user')
                                            <a class="dropdown-item" href="{{ route('edit.users', ['user' => $user->id]) }}" data-bs-toggle="modal" data-bs-target="#ModifierUsers">
                                                <i class="ti ti-pencil me-1"></i> Modifier
                                            </a>
                                            @endcan

                                            {{-- Supprimer --}}
                                            @can('delete user')
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-danger delete-user-btn" href="#" data-user-id="{{ $user->id }}">
                                                <i class="ti ti-trash me-1"></i> Supprimer
                                            </a>
                                            @endcan

                                        </div>
                                    </div>
                                </td>
                                @endcanany

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal sélection rôle --}}
        @can('assign role to user')
        <div class="modal fade" id="roleModal" tabindex="-1" aria-labelledby="roleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="roleModalLabel">Sélectionner un rôle pour l'utilisateur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="roleForm">
                            <div class="mb-3">
                                <label for="roleSelect" class="form-label">Choisir un rôle</label>
                                <select class="form-select" id="roleSelect" required>
                                    <option value="">Sélectionner un rôle</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="chefService" name="chefService" value="1">
                                    <label class="form-check-label" for="chefService">Chef de service ?</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Activer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endcan

    </div>

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


    <!-- Vendors JS -->
    <script src="{{ asset('backend/vendor/libs/jquery-repeater/jquery-repeater.js')}}"></script>

    <!-- Page JS -->
    <script src="{{ asset('backend/js/forms-extras.js')}}"></script>

    <!-- Page JS -->
    <script src="{{ asset('backend/js/form-validation.js')}}"></script>

    <!-- Vendors JS -->
    <script src="{{ asset('backend/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>

    <!-- Page JS -->
    <script src="{{ asset('backend/js/extended-ui-sweetalert2.js')}}"></script>

    <!-- Vendors JS -->
    <script src="{{ asset('backend/vendor/libs/bs-stepper/bs-stepper.js')}}"></script>

    <!-- Main JS -->
    <script src="{{ asset('backend/js/form-layouts.js')}}"></script>


    <!-- Page JS -->

    <script src="{{ asset('backend/js/form-wizard-numbered.js')}}"></script>



    @include('backend.user.js.default')


    <script>
        $(document).ready(function() {
            // Utiliser la classe au lieu de l'ID
            $('.active-user-role-btn').on('click', function(e) {
                e.preventDefault();
                const userId = $(this).data('user-id');
                $('#roleModal').modal('show');
                $('#roleForm').data('user-id', userId);
            });

            $('#roleForm').on('submit', function(e) {
                e.preventDefault();
                const roleId = $('#roleSelect').val();
                const userId = $(this).data('user-id');
                const chefService = $('#chefService').is(':checked') ? 1 : 0;

                if (!roleId) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'Veuillez sélectionner un rôle',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                $.ajax({
                    url: `/users/role/activate/${userId}`,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        role_id: roleId,
                        chefService: chefService
                    },
                    success: function(response) {
                        $('#roleModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Succès',
                            text: response.message,
                            confirmButtonText: 'OK',
                            showCancelButton: false,
                            showConfirmButton: true,
                            allowOutsideClick: false,
                            customClass: {
                                confirmButton: 'swal2-confirm',
                                confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: 'Une erreur est survenue lors de l\'activation de l\'utilisateur',
                            confirmButtonText: 'OK',
                            showCancelButton: false,
                            showConfirmButton: true,
                            allowOutsideClick: false,
                            customClass: {
                                confirmButton: 'swal2-confirm',
                                confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                            }
                        });
                    }
                });
            });
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function initFlatpickr(element) {
                flatpickr(element, {
                    dateFormat: "d-m-Y",
                    placeholder: "Sélectionner une date",
                    locale: {
                        firstDayOfWeek: 1, // Lundi comme premier jour de la semaine
                        // rangeSeparator: " au ",
                        weekdays: {
                            shorthand: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
                            longhand: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi']
                        },
                        months: {
                            shorthand: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
                            longhand: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre']
                        },
                        rangeSeparator: " au ",
                        weekAbbreviation: "Sem",
                        scrollTitle: "Défiler pour augmenter",
                        toggleTitle: "Cliquer pour basculer",
                        today: "Aujourd'hui",
                        clear: "Effacer",
                        close: "Fermer",
                        yearAriaLabel: "Année",
                        monthAriaLabel: "Mois",
                        hourAriaLabel: "Heure",
                        minuteAriaLabel: "Minute",
                        time_24hr: true
                    },
                });
            }


            document.querySelectorAll('.dob-picker').forEach(function(element) {
                initFlatpickr(element);
            });

        });
    </script>

@endpush
