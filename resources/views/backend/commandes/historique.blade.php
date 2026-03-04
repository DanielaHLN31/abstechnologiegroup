@extends('admin.admin_master')
@push('links')
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Historique-ABS-TECHNOLOGIE</title>
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

    </style>

@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">Historique des Commandes</h2>
                <div class="breadcrumb-wrapper">
                    <x-breadcrumb :links="[
                        ['title' => 'Tableau de bord', 'url' => route('dashboardVendors')],
                        ['title' => 'Commandes', 'url' => route('commandes.index')],
                        ['title' => 'Historique'],
                    ]" />
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0">Historique des commandes terminées</h5>
            @can('view orders')
            <a href="{{ route('commandes.index') }}" class="btn btn-outline-primary btn-sm">
                <i data-feather="arrow-left" style="width:14px;height:14px;margin-right:4px"></i>
                Retour à la gestion
            </a>
            @endcan
        </div>

        {{-- ── Filtres ─────────────────────────────────────────────────── --}}
        <div class="card-body border-bottom pb-3">
            <form method="GET" action="{{ route('commandes.historique') }}" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small fw-semibold mb-1">Recherche</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="form-control form-control-sm"
                           placeholder="N° commande, client, email...">
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold mb-1">Statut</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Tous</option>
                        <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Livrées</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Annulées</option>
                        <option value="refunded"  {{ request('status') === 'refunded'  ? 'selected' : '' }}>Remboursées</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold mb-1">Du</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control form-control-sm">
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold mb-1">Au</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control form-control-sm">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i data-feather="search" style="width:13px;height:13px;margin-right:3px"></i>
                        Filtrer
                    </button>
                    <a href="{{ route('commandes.historique') }}" class="btn btn-outline-secondary btn-sm">
                        <i data-feather="x" style="width:13px;height:13px;margin-right:3px"></i>
                        Réinitialiser
                    </a>
                </div>
            </form>
        </div>

        {{-- ── Tableau ──────────────────────────────────────────────────── --}}
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>N° Commande</th>
                        <th>Client</th>
                        <th>Statut</th>
                        <th>Paiement</th>
                        <th>Total</th>
                        <th>Articles</th>
                        <th>Date</th>
                        @can('view order detail')
                        <th class="text-center">Actions</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
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
                            <div class="text-muted small">{{ $order->user->email ?? $order->shipping_email }}</div>
                        </td>
                        <td>
                            <span class="badge"
                                  style="background:{{ $order->status_color }}22;color:{{ $order->status_color }};border:1px solid {{ $order->status_color }}44">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-label-{{ $order->payment_status === 'paid' ? 'success' : ($order->payment_status === 'refunded' ? 'secondary' : 'warning') }}">
                                {{ match($order->payment_status) { 'paid' => 'Payée', 'refunded' => 'Remboursée', default => 'Non payée' } }}
                            </span>
                            <div class="text-muted small mt-1">{{ $order->payment_label }}</div>
                        </td>
                        <td class="fw-bold">{{ number_format($order->total, 0, ',', ' ') }} FCFA</td>
                        <td>
                            <span class="badge bg-label-secondary">{{ $order->items->sum('quantity') }} art.</span>
                        </td>
                        <td>
                            <div style="font-size:13px">{{ $order->created_at->format('d/m/Y') }}</div>
                            <div class="text-muted small">{{ $order->created_at->format('H:i') }}</div>
                        </td>

                        @can('view order detail')
                        <td class="text-center">
                            <a href="{{ route('commandes.show', $order->order_number) }}"
                               class="btn btn-sm btn-outline-info" title="Voir détails">
                                <i data-feather="eye" style="width:14px;height:14px"></i>
                                Détails
                            </a>
                        </td>
                        @endcan
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i data-feather="inbox" style="width:40px;height:40px;color:#ddd;display:block;margin:0 auto 10px"></i>
                            Aucune commande dans l'historique.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
        <div class="card-footer">
            {{ $orders->links() }}
        </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')


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
    <script src="{{ asset('backend/js/order-management.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => { if (typeof feather !== 'undefined') feather.replace(); });
</script>
@endpush
@stack('scripts')