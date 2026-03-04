@extends('admin.admin_master')

@push('links')
    <title>Marques-ABS-TECHNOLOGIE</title>
    @section('description','Retrouvez la liste des brands inscrits et gérez leurs informations, spécialisations.')
    <!-- Row Group CSS -->
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css')}}" />

    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/tagify/tagify.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/animate-css/animate.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/sweetalert2/sweetalert2.css')}}" />
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

        
        .description-cell {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }

    </style>

@endpush


@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Mes marques</h2>
                    <div class="breadcrumb-wrapper">
                        <x-breadcrumb :links="[
                            ['title' => 'Tableau de bord', 'url' => route('dashboardVendors')],
                            ['title' => 'Paramètres'],
                            ['title' => 'Mes marques', 'url' => route('all.brand')]
                        ]" />
                    </div>
                </div>
            </div>

            @can('create brand')
            <div class="mt-2 mb-5">
                <button
                    type="button"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#exLargeModal">
                    Ajouter une marque
                </button>
            </div>
            @endcan
        </div>

        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic table" id="declaration-table">
                    <thead>
                        <tr style="background-color: #f3f2f7">
                            <th>N°</th>
                            <th>Nom</th>
                            <th>Status</th>
                            @canany(['edit brand', 'delete brand', 'activate brand', 'deactivate brand'])
                            <th>Action</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($brands as $key => $brand)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $brand->name }}</td>
                            <td style="text-transform: none">
                                @if($brand->status == 1)
                                    <span class="badge rounded-pill bg-success bg-glow">Activer</span>
                                @else
                                    <span class="badge rounded-pill bg-danger bg-glow">Désactiver</span>
                                @endif
                            </td>

                            @canany(['edit brand', 'delete brand', 'activate brand', 'deactivate brand'])
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow my-button-class" data-bs-toggle="dropdown">
                                        <div class="icon-group" style="display: inline-flex; align-items: center; cursor: pointer;">
                                            <i class="fa-solid fa-ellipsis-vertical" style="font-size: 27px;"></i>
                                            <i class="fa-solid fa-ellipsis-vertical" style="font-size: 27px; margin-left: 4px;"></i>
                                        </div>
                                    </button>
                                    <div class="dropdown-menu">

                                        @can('deactivate brand')
                                            @if($brand->status == 1)
                                                <a class="dropdown-item desactive-brand-btn" href="#" data-brand-id="{{ $brand->id }}">
                                                    <i class="ti ti-ban me-1"></i> Désactiver
                                                </a>
                                            @endif
                                        @endcan

                                        @can('activate brand')
                                            @if($brand->status == 0)
                                                <a class="dropdown-item active-brand-btn" href="#" data-brand-id="{{ $brand->id }}">
                                                    <i class="ti ti-check me-1"></i> Activer
                                                </a>
                                            @endif
                                        @endcan

                                        @can('view brands')
                                        <a class="dropdown-item details-brand-btn" href="javascript:void(0);" data-brand-details-id="{{ $brand->id }}">
                                            <i class="ti ti-eye me-1"></i> Détail
                                        </a>
                                        @endcan

                                        @can('edit brand')
                                        <a class="dropdown-item" href="{{ route('edit.brand', ['id' => $brand->id]) }}" data-bs-toggle="modal" data-bs-target="#Modifierbrand">
                                            <i class="ti ti-pencil me-1"></i> Modifier
                                        </a>
                                        @endcan

                                        @can('delete brand')
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger delete-brand-btn" href="#" data-brand-id="{{ $brand->id }}">
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

    </div>

    @include('backend.brand.modal.default')
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
    <script src="{{asset('backend/js/spinner.js')}}" defer></script>

    <script src="{{ asset('backend/js/forms-selects.js')}}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fonction pour initialiser flatpickr sur un élément
            function initFlatpickr(element) {
                flatpickr('.flatpickr-basic', {
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

            // Initialiser flatpickr sur tous les champs existants
            document.querySelectorAll('.flatpickr-basic').forEach(function(element) {
                initFlatpickr(element);
            });

            // Observer les nouveaux champs ajoutés
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    mutation.addedNodes.forEach(function(node) {
                        if (node.nodeType === 1) { // ELEMENT_NODE
                            const newDateFields = node.querySelectorAll('.flatpickr-basic');
                            newDateFields.forEach(function(field) {
                                initFlatpickr(field);
                            });
                        }
                    });
                });
            });

            const container = document.querySelector('.form-repeater');
            if (container) {
                observer.observe(container, {
                    childList: true,
                    subtree: true
                });
            }
        });
    </script>



    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Sélectionnez une ou plusieurs langues",
                allowClear: true,
                dropdownParent: $('body')
            });

            // Pour le repeater
            $('[data-repeater-create]').click(function() {
                $('.select2').each(function() {
                    if ($(this).hasClass('select2-hidden-accessible')) {
                        $(this).select2('destroy');
                    }
                });

                setTimeout(function() {
                    $('.select2').select2({
                        placeholder: "Sélectionnez une ou plusieurs langues",
                        allowClear: true,
                        dropdownParent: $('body'),
                        width: '100%'
                    });
                }, 100);
            });

            $('<style>')
                .text(`
                    .select2-container {
                        z-dashboardVendors: 9999;
                    }
                    .select2-dropdown {
                        z-dashboardVendors: 9999;
                    }
                    .select2-search {
                        z-dashboardVendors: 9999;
                    }
                `)
                .appendTo('head');
        });
    </script>


    @include('backend.brand.js.default')

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("roleForm");
            const inputs = form.querySelectorAll("input, textarea");

            inputs.forEach(input => {
                let timeout = null;

                input.addEventListener("input", function () {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        validateField(input);
                    }, 1000); // 1 seconde d'inactivité
                });
            });

            function validateField(input) {
                const value = input.value.trim();
                const errorElement = document.createElement("small");
                errorElement.classList.add("text-danger");

                // Supprimer les anciens messages d'erreur
                const oldError = input.parentElement.querySelector(".text-danger");
                if (oldError) oldError.remove();

                if (input.name === "nom" && value.length < 3) {
                    errorElement.textContent = "Le nom doit contenir au moins 3 caractères.";
                    input.parentElement.appendChild(errorElement);
                }

                // Ajoute d'autres validations si nécessaire
            }
        });
    </script>

@endpush
