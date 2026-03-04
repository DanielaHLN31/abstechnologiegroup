@extends('admin.admin_master')

@push('links')
    <title>Produits-ABS-TECHNOLOGIE</title>
    @section('description','Retrouvez la liste des products inscrits et gérez leurs informations, spécialisations.')

    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Row Group CSS -->
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css')}}" />

    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/tagify/tagify.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/animate-css/animate.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/sweetalert2/sweetalert2.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/@form-validation/form-validation.css')}}" />

    
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/node-waves/node-waves.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/typeahead-js/typeahead.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/quill/typography.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/quill/katex.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/quill/editor.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/dropzone/dropzone.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/flatpickr/flatpickr.css')}}" />


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

    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Mes produits</h2>
                    <div class="breadcrumb-wrapper">
                        <x-breadcrumb :links="[
                            ['title' => 'Tableau de bord', 'url' => route('dashboardVendors')],
                            ['title' => 'Gestion des articles'],
                            ['title' => 'Mes produits', 'url' => route('all.products')]
                        ]" />
                    </div>
                </div>
            </div>

            {{-- Bouton Ajouter — visible uniquement si permission create product --}}
            @can('create product')
            <div class="mt-2 mb-5">
                <button
                    type="button"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#exLargeModal">
                    Ajouter un produit
                </button>

                @include('backend.product.modal.default')
            </div>
            @endcan
        </div>

        <!-- DataTable with Buttons -->
        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic table" id="products-table">
                    <thead>
                        <tr style="background-color: #f3f2f7">
                            <th>N°</th>
                            <th>Image</th>
                            <th>Nom du produit</th>
                            <th>Catégorie</th>
                            <th>Marque</th>
                            <th>Prix</th>
                            <th>Stock</th>
                            <th>Statut</th>
                            {{-- Colonne Action uniquement si au moins une permission d'action --}}
                            @canany(['edit product', 'delete product', 'publish product', 'view products'])
                            <th>Action</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                {{-- Image principale --}}
                                <td>
                                    @php
                                        $primaryImage = $product->images->where('is_primary', true)->first()
                                                     ?? $product->images->first();
                                    @endphp
                                    @if($primaryImage)
                                        <img src="{{ asset('storage/' . $primaryImage->image_path) }}"
                                            alt="{{ $product->name }}"
                                            class="rounded"
                                            style="width:50px;height:50px;object-fit:cover;">
                                    @else
                                        <div class="rounded bg-label-secondary d-flex align-items-center justify-content-center"
                                            style="width:50px;height:50px;">
                                            <i class="ti ti-photo text-muted"></i>
                                        </div>
                                    @endif
                                </td>

                                {{-- Nom --}}
                                <td>
                                    <span class="fw-medium">{{ $product->name }}</span>
                                </td>

                                {{-- Catégorie --}}
                                <td>{{ $product->category->name ?? '—' }}</td>

                                {{-- Marque --}}
                                <td>{{ $product->brand->name ?? '—' }}</td>

                                {{-- Prix --}}
                                <td>{{ number_format($product->price, 0, ',', ' ') }} FCFA</td>

                                {{-- Stock --}}
                                <td>
                                    @if($product->stock_quantity <= 0)
                                        <span class="badge bg-label-danger">Rupture</span>
                                    @elseif($product->stock_quantity <= $product->low_stock_threshold)
                                        <span class="badge bg-label-warning">{{ $product->stock_quantity }} (bas)</span>
                                    @else
                                        <span class="badge bg-label-success">{{ $product->stock_quantity }}</span>
                                    @endif
                                </td>

                                {{-- Statut --}}
                                <td>
                                    @if($product->status === 'published')
                                        <span class="badge rounded-pill bg-success bg-glow">Publié</span>
                                    @elseif($product->status === 'draft')
                                        <span class="badge rounded-pill bg-warning bg-glow">Brouillon</span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary bg-glow">Archivé</span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                @canany(['edit product', 'delete product', 'publish product', 'view products'])
                                <td>
                                    <div class="dropdown">
                                        <button type="button"
                                                class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                            <div class="icon-group" style="display:inline-flex;align-items:center;cursor:pointer;">
                                                <i class="fa-solid fa-ellipsis-vertical" style="font-size:22px;"></i>
                                                <i class="fa-solid fa-ellipsis-vertical" style="font-size:22px;margin-left:3px;"></i>
                                            </div>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">

                                            {{-- Voir le détail --}}
                                            @can('view products')
                                            <a class="dropdown-item details-product-btn"
                                               href="#"
                                               data-product-details-id="{{ $product->id }}">
                                                <i class="ti ti-eye me-1"></i> Détail
                                            </a>
                                            @endcan

                                            {{-- Modifier --}}
                                            @can('edit product')
                                            <a class="dropdown-item"
                                               href="{{ route('edit.products', $product->id) }}"
                                               data-bs-toggle="modal"
                                               data-bs-target="#Modifierproduct">
                                                <i class="ti ti-pencil me-1"></i> Modifier
                                            </a>
                                            @endcan

                                            {{-- Publier / Archiver --}}
                                            @can('publish product')
                                                @if($product->status === 'published')
                                                    <a class="dropdown-item text-warning toggle-status-btn"
                                                       href="#"
                                                       data-product-id="{{ $product->id }}"
                                                       data-action="archive">
                                                        <i class="ti ti-archive me-1"></i> Archiver
                                                    </a>
                                                @else
                                                    <a class="dropdown-item text-success toggle-status-btn"
                                                       href="#"
                                                       data-product-id="{{ $product->id }}"
                                                       data-action="publish">
                                                        <i class="ti ti-check me-1"></i> Publier
                                                    </a>
                                                @endif
                                            @endcan

                                            {{-- Séparateur uniquement si Supprimer est visible --}}
                                            @can('delete product')
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-danger delete-product-btn"
                                               href="#"
                                               data-product-id="{{ $product->id }}">
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
    <!-- / Content -->

@endsection

@push('scripts')

    <!-- Vendors JS -->
    <script src="{{ asset('backend/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <!-- Flat Picker -->
    <script src="{{ asset('backend/vendor/libs/moment/moment.js')}}"></script>

    
    
    <script src="{{ asset('backend/vendor/libs/quill/katex.js')}}"></script>
    <script src="{{ asset('backend/vendor/libs/quill/quill.js')}}"></script>
    <script src="{{ asset('backend/vendor/libs/dropzone/dropzone.js')}}"></script>
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
    <script src="{{ asset('backend/js/app-ecommerce-product-add.js')}}"></script>


    
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





    @include('backend.product.js.default')

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

    
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Sélectionnez ",
                allowClear: true,
                dropdownParent: $('body')
            });


            $('[data-repeater-create]').click(function() {

                $('.select2').each(function() {
                    if ($(this).hasClass('select2-hidden-accessible')) {
                        $(this).select2('destroy');
                    }
                });

                setTimeout(function() {

                    $('.select2').select2({
                        placeholder: "Sélectionnez ",
                        allowClear: true,
                        dropdownParent: $('body'),

                        width: '100%'
                    });
                }, 100);
            });

            $('<style>')
            .text(`
                .select2-container {
                    z-index: 9999;
                }
                .select2-dropdown {
                    z-index: 9999;
                }
                .select2-search {
                    z-index: 9999;
                }
            `)
            .appendTo('head');
        });
    </script>


@endpush
