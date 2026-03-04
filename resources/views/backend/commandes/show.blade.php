@extends('admin.admin_master')
@push('links')
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Détails-Commande-ABS-TECHNOLOGIE</title>
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

    <div class="content-header-left col-md-9 col-12 mb-3">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">{{ $order->order_number }}</h2>
                <div class="breadcrumb-wrapper">
                    <x-breadcrumb :links="[
                        ['title' => 'Tableau de bord', 'url' => route('dashboardVendors')],
                        ['title' => 'Commandes', 'url' => route('commandes.index')],
                        ['title' => $order->order_number],
                    ]" />
                </div>
            </div>
        </div>
    </div>

    {{-- ── En-tête actions ─────────────────────────────────────────────── --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div class="d-flex align-items-center gap-3">
            <span class="badge fs-6 px-3 py-2"
                  style="background:{{ $order->status_color }}22;color:{{ $order->status_color }};border:1px solid {{ $order->status_color }}44"
                  id="header-status-badge">
                {{ $order->status_label }}
            </span>
            <span class="text-muted small">Créée le {{ $order->created_at->format('d/m/Y à H:i') }}</span>
        </div>
        <div class="d-flex gap-2 flex-wrap">

            @can('update order status')
            <button class="btn btn-primary btn-sm"
                    onclick="openStatusModal('{{ $order->order_number }}', '{{ $order->status }}')">
                <i data-feather="edit-2" style="width:14px;height:14px;margin-right:4px"></i>
                Changer le statut
            </button>
            @endcan

            @can('mark order paid')
                @if($order->payment_status !== 'paid')
                <button class="btn btn-success btn-sm"
                        onclick="markPaid('{{ $order->order_number }}')">
                    <i data-feather="dollar-sign" style="width:14px;height:14px;margin-right:4px"></i>
                    Marquer payée
                </button>
                @endif
            @endcan

            @can('view orders')
            <a href="{{ route('commandes.index') }}" class="btn btn-outline-secondary btn-sm">
                <i data-feather="arrow-left" style="width:14px;height:14px;margin-right:4px"></i>
                Retour
            </a>
            @endcan

        </div>
    </div>

    {{-- ── Suivi de statut visuel ──────────────────────────────────────── --}}
    @php
        $steps = [
            ['key' => 'pending',    'label' => 'En attente',    'icon' => 'clock'],
            ['key' => 'confirmed',  'label' => 'Confirmée',     'icon' => 'check-circle'],
            ['key' => 'processing', 'label' => 'En traitement', 'icon' => 'settings'],
            ['key' => 'shipped',    'label' => 'Expédiée',      'icon' => 'truck'],
            ['key' => 'delivered',  'label' => 'Livrée',        'icon' => 'home'],
        ];
        $stepKeys     = array_column($steps, 'key');
        $currentIndex = array_search($order->status, $stepKeys);
        $isCancelled  = in_array($order->status, ['cancelled', 'refunded']);
    @endphp

    @if(!$isCancelled)
    <div class="card mb-4">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center position-relative">
                <div style="position:absolute;top:20px;left:10%;right:10%;height:3px;background:#e6e6e6;z-index:0">
                    <div style="height:100%;background:#717fe0;transition:width .5s;
                                width:{{ $currentIndex !== false ? ($currentIndex / (count($steps)-1)) * 100 : 0 }}%">
                    </div>
                </div>
                @foreach($steps as $i => $step)
                @php $done = $currentIndex !== false && $i <= $currentIndex; @endphp
                <div class="d-flex flex-column align-items-center flex-grow-1" style="z-index:1">
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                         style="
                            width:40px;height:40px;
                            background:{{ $done ? '#717fe0' : '#e6e6e6' }};
                            color:{{ $done ? '#fff' : '#aaa' }};
                            box-shadow:{{ $i === $currentIndex ? '0 0 0 4px rgba(113,127,224,.2)' : 'none' }};
                         ">
                        <i data-feather="{{ $step['icon'] }}" style="width:18px;height:18px"></i>
                    </div>
                    <div style="font-size:11px;margin-top:8px;font-weight:{{ $i === $currentIndex ? '700' : '400' }};
                                color:{{ $done ? '#717fe0' : '#aaa' }};text-align:center;max-width:80px;">
                        {{ $step['label'] }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-{{ $order->status === 'cancelled' ? 'danger' : 'secondary' }} mb-4">
        <i data-feather="{{ $order->status === 'cancelled' ? 'x-circle' : 'refresh-cw' }}"
           style="width:16px;height:16px;margin-right:6px"></i>
        <strong>Commande {{ $order->status_label }}.</strong>
        @if($order->status === 'cancelled')
            Le stock des produits a été remis en place.
        @endif
    </div>
    @endif

    <div class="row">

        {{-- ── Colonne gauche : articles ────────────────────────────────── --}}
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i data-feather="shopping-cart" style="width:16px;height:16px;margin-right:6px"></i>
                        Articles commandés ({{ $order->items->sum('quantity') }})
                    </h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Produit</th>
                                <th class="text-center">Qté</th>
                                <th class="text-end">Prix unit.</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        @if($item->product_image)
                                            <img src="{{ asset('storage/'.$item->product_image) }}"
                                                 alt="{{ $item->product_name }}"
                                                 style="width:52px;height:52px;object-fit:cover;border-radius:6px;border:1px solid #eee;flex-shrink:0">
                                        @else
                                            <div style="width:52px;height:52px;background:#f5f5f5;border-radius:6px;flex-shrink:0;display:flex;align-items:center;justify-content:center">
                                                <i data-feather="image" style="width:20px;height:20px;color:#ddd"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-semibold">{{ $item->product_name }}</div>
                                            @if($item->color_name)
                                                <div class="text-muted small mt-1">Couleur : {{ $item->color_name }}</div>
                                            @endif
                                            @if($item->product_id && $item->product)
                                            <div class="small mt-1">
                                                Stock actuel :
                                                <span class="badge bg-label-{{ $item->product->stock_quantity > 5 ? 'success' : ($item->product->stock_quantity > 0 ? 'warning' : 'danger') }}">
                                                    {{ $item->product->stock_quantity }}
                                                </span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center fw-bold">{{ $item->quantity }}</td>
                                <td class="text-end">{{ number_format($item->unit_price, 0, ',', ' ') }} FCFA</td>
                                <td class="text-end fw-bold">{{ number_format($item->total_price, 0, ',', ' ') }} FCFA</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="text-end">Sous-total</td>
                                <td class="text-end">{{ number_format($order->subtotal, 0, ',', ' ') }} FCFA</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end">Livraison</td>
                                <td class="text-end">
                                    @if($order->shipping_cost == 0)
                                        <span class="text-success fw-semibold">Gratuite</span>
                                    @else
                                        {{ number_format($order->shipping_cost, 0, ',', ' ') }} FCFA
                                    @endif
                                </td>
                            </tr>
                            <tr class="fw-bold fs-6">
                                <td colspan="3" class="text-end">Total</td>
                                <td class="text-end text-primary">{{ number_format($order->total, 0, ',', ' ') }} FCFA</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- ── Colonne droite : infos ───────────────────────────────────── --}}
        <div class="col-lg-4 mb-4">

            {{-- Client --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i data-feather="user" style="width:15px;height:15px;margin-right:5px"></i>
                        Client
                    </h6>
                </div>
                <div class="card-body">
                    <div class="fw-semibold fs-6 mb-1">{{ $order->user->name ?? $order->shipping_fullname }}</div>
                    <div class="text-muted small">
                        <i data-feather="mail" style="width:13px;height:13px;margin-right:4px"></i>
                        <a href="mailto:{{ $order->user->email ?? $order->shipping_email }}" class="text-muted">
                            {{ $order->user->email ?? $order->shipping_email }}
                        </a>
                    </div>
                    <div class="text-muted small mt-1">
                        <i data-feather="phone" style="width:13px;height:13px;margin-right:4px"></i>
                        <a href="tel:{{ $order->shipping_phone }}" class="text-muted">{{ $order->shipping_phone }}</a>
                    </div>
                </div>
            </div>

            {{-- Livraison --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i data-feather="map-pin" style="width:15px;height:15px;margin-right:5px"></i>
                        Adresse de livraison
                    </h6>
                </div>
                <div class="card-body" style="font-size:14px;line-height:1.8">
                    <strong>{{ $order->shipping_fullname }}</strong><br>
                    {{ $order->shipping_address }}<br>
                    {{ $order->shipping_city }}, {{ $order->shipping_country }}
                    @if($order->shipping_notes)
                        <div class="alert alert-light mt-2 mb-0 py-2 px-3" style="font-size:12px">
                            <strong>Note :</strong> {{ $order->shipping_notes }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Paiement --}}
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i data-feather="credit-card" style="width:15px;height:15px;margin-right:5px"></i>
                        Paiement
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Méthode</span>
                        <span class="fw-semibold small">{{ $order->payment_label }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Statut</span>
                        <span class="badge bg-label-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                            {{ $order->payment_status === 'paid' ? '✓ Payée' : '⏳ Non payée' }}
                        </span>
                    </div>
                    @if($order->payment_reference)
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Référence</span>
                        <code class="small">{{ $order->payment_reference }}</code>
                    </div>
                    @endif

                    {{-- Preuve de paiement --}}
                    @if($order->payment_proof && \Illuminate\Support\Facades\Storage::disk('public')->exists($order->payment_proof))
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label class="form-label fw-semibold mb-0">Preuve de paiement :</label>
                        <div class="d-flex gap-2">
                            <a href="{{ asset('storage/' . $order->payment_proof) }}"
                               target="_blank"
                               class="btn btn-sm btn-outline-primary">
                                <i data-feather="image" style="width:13px;height:13px"></i> Voir
                            </a>
                            <a href="{{ route('admin.download.proof', ['file' => basename($order->payment_proof), 'type' => 'payment_proofs']) }}"
                               class="btn btn-sm btn-primary">
                                <i data-feather="download" style="width:13px;height:13px"></i> Télécharger
                            </a>
                        </div>
                    </div>
                    @endif

                    {{-- Preuve de remboursement --}}
                    @if($order->refund_proof)
                    <div class="card mt-3">
                        <div class="card-header py-2">
                            <h6 class="mb-0">Preuve de remboursement</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ asset('storage/' . $order->refund_proof) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $order->refund_proof) }}"
                                             alt="Preuve de remboursement"
                                             class="img-fluid img-thumbnail"
                                             style="max-height: 200px;">
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong>Date :</strong>
                                        {{ $order->refunded_at ? $order->refunded_at->format('d/m/Y H:i') : 'N/A' }}
                                    </p>
                                    <a href="{{ route('admin.download.proof', ['file' => basename($order->refund_proof), 'type' => 'refund_proofs']) }}"
                                       class="btn btn-sm btn-primary">
                                        <i data-feather="download" style="width:13px;height:13px"></i> Télécharger
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Bouton confirmer paiement --}}
                    @can('mark order paid')
                        @if($order->payment_status !== 'paid')
                        <button class="btn btn-success btn-sm w-100 mt-3"
                                onclick="markPaid('{{ $order->order_number }}')">
                            <i data-feather="check" style="width:13px;height:13px;margin-right:4px"></i>
                            Confirmer le paiement
                        </button>
                        @endif
                    @endcan

                </div>
            </div>

        </div>
    </div>

</div>
@include('backend.commandes.modal')
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

    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace();
    </script>

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
    @include('backend.commandes.js')
    <style>@keyframes slideIn{from{transform:translateX(100%);opacity:0}to{transform:translateX(0);opacity:1}}</style>

@endpush
@stack('scripts')