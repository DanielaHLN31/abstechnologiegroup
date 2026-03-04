@extends('admin.admin_master')
@push('links')
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Commandes-ABS-TECHNOLOGIE</title>
    <link rel="apple-touch-icon" href="{{ asset('backend/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('backend/images/ico/3.png')}}">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/css/editors/quill/katex.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/css/editors/quill/monokai-sublime.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/css/editors/quill/quill.snow.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/css/forms/select/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/css/extensions/dragula.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/css/extensions/toastr.min.css')}}">
    <!-- END: Vendor CSS-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/themes/bordered-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/themes/semi-dark-layout.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/plugins/forms/form-quill-editor.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/plugins/forms/pickers/form-flat-pickr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/plugins/extensions/ext-component-toastr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/plugins/forms/form-validation.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/pages/app-todo.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/style.css')}}">
    <!-- END: Custom CSS-->


    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/css/forms/wizard/bs-stepper.min.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/plugins/forms/form-wizard.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .icon {
            vertical-align: middle;
            margin-right: 5px;
        }
        /* button{
            border: none
        } */

        button {
            border: none; /* Supprime la bordure */
            outline: none; /* Supprime l'effet de focus */
            cursor: pointer; /* Curseur de type pointer */
        }

        button:focus {
            outline: none; /* Supprime l'effet de contour focus */
        }

        button:active {
            outline: none; /* Supprime l'effet de contour lors du clic */
            border: none;  /* Supprime la bordure sur clic */
        }


        .badge.bg-warning {
            animation: pulse-warning 1.5s ease-in-out infinite;
        }

        /* Option 3: Effet pulse avec changement de couleur */
        @keyframes pulse-warning {
            0% {
                background-color: #ffc107;
                box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.7);
            }
            50% {
                background-color: #fd7e14;
                box-shadow: 0 0 20px 5px rgba(253, 126, 20, 0.5);
                transform: scale(1.05);
            }
            100% {
                background-color: #ffc107;
                box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.7);
            }
        }

        .badge.bg-warning {
            animation: pulse-warning 1.5s ease-in-out infinite;
        }

        
        .badge.bg-info {
            animation: pulse-info 1.5s ease-in-out infinite;
        }

        @keyframes pulse-info {
            0% {
                background-color: #0dcaf0;
                box-shadow: 0 0 0 0 rgba(13, 202, 240, 0.7);
            }
            50% {
                background-color: #0aa2c0;
                box-shadow: 0 0 20px 5px rgba(10, 162, 192, 0.5);
                transform: scale(1.05);
            }
            100% {
                background-color: #0dcaf0;
                box-shadow: 0 0 0 0 rgba(13, 202, 240, 0.7);
            }
        }
    </style>

    

@endpush

    

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">Gestion des Commandes</h2>
                <div class="breadcrumb-wrapper">
                    <x-breadcrumb :links="[
                        ['title' => 'Tableau de bord', 'url' => route('dashboardVendors')],
                        ['title' => 'Gestion des commandes'],
                    ]" />
                </div>
            </div>
        </div>
    </div>

    {{-- ── Cartes statistiques ─────────────────────────────────────────── --}}
    <div class="row mb-4">
        @php
            $statCards = [
                ['label' => 'En attente',    'value' => $stats['pending'],    'color' => 'warning', 'icon' => 'clock'],
                ['label' => 'En traitement', 'value' => $stats['processing'], 'color' => 'info',    'icon' => 'settings'],
                ['label' => 'Expédiées',     'value' => $stats['shipped'],    'color' => 'primary', 'icon' => 'truck'],
                ['label' => 'Livrées',       'value' => $stats['delivered'],  'color' => 'success', 'icon' => 'check-circle'],
                ['label' => 'Annulées',      'value' => $stats['cancelled'],  'color' => 'danger',  'icon' => 'x-circle'],
                ['label' => 'Revenus payés', 'value' => number_format($stats['revenue'], 0, ',', ' ') . ' FCFA', 'color' => 'dark', 'icon' => 'dollar-sign'],
            ];
        @endphp

        @foreach($statCards as $card)
        <div class="col-xl-2 col-sm-4 col-6 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-{{ $card['color'] }}">
                            <i data-feather="{{ $card['icon'] }}" style="width:18px;height:18px"></i>
                        </span>
                    </div>
                    <div>
                        <div class="fw-bold fs-5">{{ $card['value'] }}</div>
                        <div class="text-muted" style="font-size:12px">{{ $card['label'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── Onglets ─────────────────────────────────────────────────────── --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <ul class="nav nav-tabs card-header-tabs" id="orderTabs" role="tablist">

                @can('view orders')
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-pending" type="button">
                        Commandes en Attente
                        @if($stats['pending'] > 0)
                            <span class="badge bg-warning ms-1">{{ $stats['pending'] }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-processing" type="button">
                        En Traitement
                        @if($stats['processing'] + $stats['shipped'] > 0)
                            <span class="badge bg-info ms-1">{{ $stats['processing'] + $stats['shipped'] }}</span>
                        @endif
                    </button>
                </li>
                @endcan

                @can('view order history')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('commandes.historique') }}">
                        <i data-feather="archive" style="width:14px;height:14px;margin-right:4px"></i>
                        Historique
                    </a>
                </li>
                @endcan

            </ul>

            @can('view orders')
            <button class="btn btn-sm btn-outline-secondary" id="btn-refresh" onclick="refreshTables()">
                <i data-feather="refresh-cw" style="width:14px;height:14px;margin-right:4px"></i>
                Actualiser
            </button>
            @endcan
        </div>

        <div class="card-body p-0">
            <div class="tab-content">

                {{-- ════════════════════════════════════════════════════════
                     TAB : EN ATTENTE
                ════════════════════════════════════════════════════════ --}}
                @can('view orders')
                <div class="tab-pane fade show active" id="tab-pending" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>N° Commande</th>
                                    <th>Client</th>
                                    <th>Adresse</th>
                                    <th>Articles</th>
                                    <th>Total</th>
                                    <th>Paiement</th>
                                    <th>Date</th>
                                    @canany(['view order detail', 'update order status', 'start order processing', 'mark order paid'])
                                    <th class="text-center">Actions</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody id="pendingOrdersTableBody">
                                @forelse($pendingOrders as $order)
                                <tr id="row-{{ $order->order_number }}">
                                    <td>
                                        @can('view order detail')
                                        <a href="{{ route('commandes.show', $order->order_number) }}"
                                           class="fw-bold text-primary text-decoration-none">
                                            {{ $order->order_number }}
                                        </a>
                                        @else
                                        <span class="fw-bold">{{ $order->order_number }}</span>
                                        @endcan
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $order->user->name ?? $order->shipping_fullname }}</div>
                                        <div class="text-muted small">{{ $order->shipping_phone }}</div>
                                    </td>
                                    <td>
                                        <div style="max-width:160px;font-size:13px">
                                            {{ $order->shipping_address }}<br>
                                            <span class="text-muted">{{ $order->shipping_city }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-secondary">
                                            {{ $order->items->sum('quantity') }} article(s)
                                        </span>
                                        <div class="text-muted small mt-1" style="max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                                            {{ $order->items->pluck('product_name')->join(', ') }}
                                        </div>
                                    </td>
                                    <td class="fw-bold">{{ number_format($order->total, 0, ',', ' ') }} FCFA</td>
                                    <td>
                                        <span class="badge bg-label-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                            {{ $order->payment_status === 'paid' ? 'Payée' : 'Non payée' }}
                                        </span>
                                        <div class="text-muted small mt-1">{{ $order->payment_label }}</div>
                                    </td>
                                    <td>
                                        <div style="font-size:13px">{{ $order->created_at->format('d/m/Y') }}</div>
                                        <div class="text-muted small">{{ $order->created_at->format('H:i') }}</div>
                                    </td>

                                    @canany(['view order detail', 'update order status', 'start order processing', 'mark order paid'])
                                    <td class="text-center">
                                        {{-- <div class="d-flex gap-1 justify-content-center flex-wrap">

                                            @can('view order detail')
                                            <a href="{{ route('commandes.show', $order->order_number) }}"
                                               class="btn btn-sm btn-outline-info" title="Voir détails">
                                                <i data-feather="eye" style="width:14px;height:14px"></i>
                                            </a>
                                            @endcan

                                            @can('start order processing')
                                            <button class="btn btn-sm btn-outline-success"
                                                    title="Confirmer / Commencer traitement"
                                                    onclick="startProcessing('{{ $order->order_number }}')">
                                                <i data-feather="play" style="width:14px;height:14px"></i>
                                            </button>
                                            @endcan

                                            @can('update order status')
                                            <button class="btn btn-sm btn-outline-primary"
                                                    title="Changer le statut"
                                                    onclick="openStatusModal('{{ $order->order_number }}', '{{ $order->status }}')">
                                                <i data-feather="edit-2" style="width:14px;height:14px"></i>
                                            </button>
                                            @endcan

                                            @can('mark order paid')
                                                @if($order->payment_status !== 'paid')
                                                <button class="btn btn-sm btn-outline-warning"
                                                        title="Marquer comme payée"
                                                        onclick="markPaid('{{ $order->order_number }}')">
                                                    <i data-feather="dollar-sign" style="width:14px;height:14px"></i>
                                                </button>
                                                @endif
                                            @endcan

                                        </div> --}}
                                        
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow my-button-class " data-bs-toggle="dropdown">
                                                <div class="icon-group" style="display: inline-flex; align-items: center; cursor: pointer;" >
                                                    <i class="fa-solid fa-ellipsis-vertical" style="font-size: 27px;"></i>
                                                    <i class="fa-solid fa-ellipsis-vertical" style="font-size: 27px; margin-left: 4px;"></i>
                                                </div>
                                            </button>
                                            <div class="dropdown-menu">

                                                @can('view order detail')
                                                <a class="dropdown-item" href="{{ route('commandes.show', $order->order_number) }}"
                                                 title="Voir détails">
                                                    <i data-feather="eye"  class="me-1"  style="width:18px;height:18px"></i>
                                                    Voir détails
                                                </a>
                                                @endcan

                                                @can('start order processing')
                                                <a class="dropdown-item"  href="#"
                                                        title="Confirmer / Commencer traitement"
                                                        onclick="startProcessing('{{ $order->order_number }}')">
                                                    <i data-feather="play"  class="me-1" style="width:18px;height:18px"></i>
                                                    Commencer traitement
                                                </a>
                                                @endcan

                                                @can('update order status')
                                                <a class="dropdown-item"  href="#"
                                                        title="Changer le statut"
                                                        onclick="openStatusModal('{{ $order->order_number }}', '{{ $order->status }}')">
                                                    <i data-feather="edit-2"  class="me-1" style="width:18px;height:18px"></i>
                                                    Changer le statut
                                                </a>
                                                @endcan

                                                @can('mark order paid')
                                                    @if($order->payment_status !== 'paid')
                                                    <a class="dropdown-item" href="#"
                                                            title="Marquer comme payée"
                                                            onclick="markPaid('{{ $order->order_number }}')">
                                                        <i data-feather="dollar-sign" class="me-1" style="width:18px;height:18px"></i>
                                                        Marquer comme payée
                                                    </a>
                                                    @endif
                                                @endcan

                                            </div>
                                        </div>
                                    </td>
                                    @endcanany
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-5">
                                        <i data-feather="inbox" style="width:40px;height:40px;color:#ddd;display:block;margin:0 auto 10px"></i>
                                        Aucune commande en attente.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ════════════════════════════════════════════════════════
                     TAB : EN TRAITEMENT
                ════════════════════════════════════════════════════════ --}}
                <div class="tab-pane fade" id="tab-processing" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>N° Commande</th>
                                    <th>Client</th>
                                    <th>Articles</th>
                                    <th>Total</th>
                                    <th>Statut</th>
                                    <th>Paiement</th>
                                    <th>Date</th>
                                    @canany(['view order detail', 'update order status', 'mark order paid'])
                                    <th class="text-center">Actions</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody id="processingOrdersTableBody">
                                @forelse($processingOrders as $order)
                                <tr id="row-{{ $order->order_number }}">
                                    <td>
                                        @can('view order detail')
                                        <a href="{{ route('commandes.show', $order->order_number) }}"
                                           class="fw-bold text-primary text-decoration-none">
                                            {{ $order->order_number }}
                                        </a>
                                        @else
                                        <span class="fw-bold">{{ $order->order_number }}</span>
                                        @endcan
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $order->user->name ?? $order->shipping_fullname }}</div>
                                        <div class="text-muted small">{{ $order->shipping_phone }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-secondary">
                                            {{ $order->items->sum('quantity') }} article(s)
                                        </span>
                                    </td>
                                    <td class="fw-bold">{{ number_format($order->total, 0, ',', ' ') }} FCFA</td>
                                    <td>
                                        <span class="badge"
                                              style="background:{{ $order->status_color }}22;color:{{ $order->status_color }};border:1px solid {{ $order->status_color }}44"
                                              id="status-badge-{{ $order->order_number }}">
                                            {{ $order->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                            {{ $order->payment_status === 'paid' ? 'Payée' : 'Non payée' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="font-size:13px">{{ $order->created_at->format('d/m/Y') }}</div>
                                        <div class="text-muted small">{{ $order->created_at->format('H:i') }}</div>
                                    </td>

                                    @canany(['view order detail', 'update order status', 'mark order paid'])
                                    <td class="text-center">
                                        <div class="d-flex gap-1 justify-content-center flex-wrap">

                                            @can('view order detail')
                                            <a href="{{ route('commandes.show', $order->order_number) }}"
                                               class="btn btn-sm btn-outline-info" title="Voir détails">
                                                <i data-feather="eye" style="width:14px;height:14px"></i>
                                            </a>
                                            @endcan

                                            @can('update order status')
                                            <button class="btn btn-sm btn-outline-primary"
                                                    title="Changer le statut"
                                                    onclick="openStatusModal('{{ $order->order_number }}', '{{ $order->status }}')">
                                                <i data-feather="edit-2" style="width:14px;height:14px"></i>
                                            </button>
                                            @endcan

                                            @can('mark order paid')
                                                @if($order->payment_status !== 'paid')
                                                <button class="btn btn-sm btn-outline-warning"
                                                        title="Marquer comme payée"
                                                        onclick="markPaid('{{ $order->order_number }}')">
                                                    <i data-feather="dollar-sign" style="width:14px;height:14px"></i>
                                                </button>
                                                @endif
                                            @endcan

                                        </div>
                                    </td>
                                    @endcanany
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-5">
                                        <i data-feather="inbox" style="width:40px;height:40px;color:#ddd;display:block;margin:0 auto 10px"></i>
                                        Aucune commande en traitement.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @endcan

            </div>
        </div>
    </div>

</div>
@include('backend.commandes.modal')
@endsection


@push('scripts')

    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace();
    </script>

    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('backend/vendors/js/vendors.min.js')}}"></script>
    <!-- BEGIN Vendor JS-->


    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('backend/js/core/app-menu.js')}}"></script>
    <script src="{{ asset('backend/js/core/app.js')}}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('backend/js/scripts/pages/app-todo.js')}}"></script>
    <!-- END: Page JS-->


    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('backend/vendors/js/forms/wizard/bs-stepper.min.js')}}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('backend/js/scripts/forms/form-wizard.js')}}"></script>
    <!-- END: Page JS-->
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
    {{-- <script src="{{ asset('backend/js/order-management.js') }}"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    @include('backend.commandes.js')
    <style>
    @keyframes slideIn { from { transform:translateX(100%);opacity:0; } to { transform:translateX(0);opacity:1; } }
    </style>
@endpush
@stack('scripts')