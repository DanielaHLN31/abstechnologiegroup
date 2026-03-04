@extends('admin.admin_master')
@php

    $increment = 1;

@endphp

@push('links')

    <title>Rôle-ABS-TECHNOLOGIE</title>
    @section('description','Attribuez des rôles et des permissions aux utilisateurs. Gérez les accès et les responsabilités au sein du système.')
    <!-- Row Group CSS -->
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css')}}" />

    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/tagify/tagify.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/animate-css/animate.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/sweetalert2/sweetalert2.css')}}" />

    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/@form-validation/form-validation.css')}}" />


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

    </style>

@endpush

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row breadcrumbs-top mb-2">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">Les rôles</h2>
                <div class="breadcrumb-wrapper">
                    <x-breadcrumb :links="[
                        ['title' => 'Tableau de bord', 'url' => route('dashboardVendors')],
                        ['title' => 'Paramètres'],
                        ['title' => 'Les rôles', 'url' => route('all.roles')]
                    ]" />
                </div>
            </div>
        </div>

        <div class="col-12 mt-1">
            <h4 class="mt-6 mb-1">Divers rôles et permissions</h4>
            <p class="mb-0">Consultez les rôles pouvant être attribués à un compte utilisateurs.</p>

            @can('create role')
            <button
                data-bs-target="#addRoleModal"
                data-bs-toggle="modal"
                class="btn btn-primary mb-2 text-nowrap add-new-role mt-4">
                Ajouter nouveau rôle
            </button>
            @endcan
        </div>

        <div class="card mt-5">
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic table" id="declaration-table">
                    <thead>
                        <tr style="background-color: #f3f2f7">
                            <th>N°</th>
                            <th>Rôle</th>
                            <th>Status</th>
                            @canany(['edit role', 'delete role', 'activate role', 'deactivate role'])
                            <th>Action</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $key => $role)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $role->name }}</td>
                            <td style="text-transform: none">
                                @if($role->status == 1)
                                    <span class="badge rounded-pill bg-success bg-glow">Activer</span>
                                @else
                                    <span class="badge rounded-pill bg-danger bg-glow">Désactiver</span>
                                @endif
                            </td>

                            @canany(['edit role', 'delete role', 'activate role', 'deactivate role'])
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow my-button-class" data-bs-toggle="dropdown">
                                        <div class="icon-group" style="display: inline-flex; align-items: center; cursor: pointer;">
                                            <i class="fa-solid fa-ellipsis-vertical" style="font-size: 27px;"></i>
                                            <i class="fa-solid fa-ellipsis-vertical" style="font-size: 27px; margin-left: 4px;"></i>
                                        </div>
                                    </button>
                                    <div class="dropdown-menu">

                                        @can('deactivate role')
                                            @if($role->status == 1)
                                                <a class="dropdown-item desactive-role-btn" href="#" data-role-id="{{ $role->id }}">
                                                    <i class="ti ti-ban me-1"></i> Désactiver
                                                </a>
                                            @endif
                                        @endcan

                                        @can('activate role')
                                            @if($role->status == 0)
                                                <a class="dropdown-item active-role-btn" href="#" data-role-id="{{ $role->id }}">
                                                    <i class="ti ti-check me-1"></i> Activer
                                                </a>
                                            @endif
                                        @endcan

                                        @can('edit role')
                                        <a class="dropdown-item"
                                           href="{{ route('edit.roles', ['role' => $role->id]) }}"
                                           data-bs-toggle="modal"
                                           data-bs-target="#ModifierRole">
                                            <i class="ti ti-pencil me-1"></i> Modifier
                                        </a>
                                        @endcan

                                        @can('delete role')
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger delete-role-btn" data-role-id="{{ $role->id }}" href="#">
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

        @include('backend.role.modal.default')

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

    <!-- Page JS -->
    <script src="{{ asset('backend/js/app-access-roles.js')}}"></script>
    <script src="{{ asset('backend/js/modal-add-role.js')}}"></script>



    @include('backend.role.js.default')


@endpush
