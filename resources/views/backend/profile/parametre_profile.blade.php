@extends('admin.admin_master')

@push('links')
    <title>Profile-ABS-TECHNOLOGIE</title>
    @section('description','Consultez et mettez à jour vos informations personnelles et professionnelles.')

    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css')}}"/>
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/node-waves/node-waves.css')}}"/>
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}"/>
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/typeahead-js/typeahead.css')}}"/>
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/bootstrap-select/bootstrap-select.css')}}"/>
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/select2/select2.css')}}"/>
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/tagify/tagify.css')}}"/>
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/animate-css/animate.css')}}"/>
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/sweetalert2/sweetalert2.css')}}"/>
    <link rel="stylesheet" href="{{ asset('backend/vendor/libs/@form-validation/form-validation.css')}}"/>

    {{-- Cropper.js CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .my-button-class:hover { color: brown; }

        /* Spinner de chargement */
        .spinner-container { display: flex; flex-direction: column; align-items: center; }
        .spinner { width: 60px; height: 60px; position: relative; margin-bottom: 10px; }
        .spinner-line {
            position: absolute; width: 5px; height: 15px;
            background-color: #0305a2; border-radius: 20px;
            left: 27.5px; top: 0; transform-origin: center 30px;
            animation: spin 1.2s linear infinite;
        }
        .loading-text { color: #555; font-size: 16px; margin-top: 5px; }
        @keyframes spin { 0% { opacity: 0.1; } 100% { opacity: 1; } }

        /* Badges professionnels */
        .professional-badges {
            margin-top: 1rem; padding: 1rem;
            background-color: #f8f9fa; border-radius: 8px;
            border-left: 4px solid #0305a2;
        }
        .badge-professional {
            display: inline-flex; align-items: center; gap: 0.5rem;
            margin: 0.25rem; padding: 0.5rem 0.75rem;
            font-size: 0.875rem; font-weight: 500;
        }
        .badge-role    { background-color: #e3f2fd; color: #1976d2; border: 1px solid #bbdefb; }
        .badge-poste   { background-color: #f3e5f5; color: #7b1fa2; border: 1px solid #e1bee7; }
        .badge-service { background-color: #e8f5e8; color: #388e3c; border: 1px solid #c8e6c9; }
        .badge-parquet { background-color: #f38e3b45; color: #fe7f00; border: 1px solid #fdb14db3; }
        .badge-tribunal{ background-color: #52e0ed38; color: #07eeff; border: 1px solid #04d3f3; }
        .professional-info-title { color: #0305a2; font-weight: 600; margin-bottom: 0.75rem; font-size: 1rem; }
        .badge-icon { width: 16px; height: 16px; }

        /* Modal de recadrage */
        .cropper-container { max-height: 400px; margin: 0 auto; }
        #cropper-image { max-width: 100%; max-height: 350px; display: block; margin: 0 auto; }
        .cropper-preview {
            width: 150px; height: 150px; border-radius: 50%; overflow: hidden;
            border: 2px solid #0305a2; margin: 0 auto;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .cropper-preview img { width: 100%; height: 100%; object-fit: cover; }
        .cropper-actions { display: flex; gap: 10px; justify-content: center; margin-top: 20px; }
        .cropper-actions button { min-width: 100px; }
    </style>
@endpush


@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Paramètres du compte /</span> Profile</h4>

        <div class="row">
            <div class="col-md-12">

                {{-- Onglets --}}
                <ul class="nav nav-pills flex-column flex-md-row mb-4">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('parametre') }}">
                            <i class="ti-xs ti ti-users me-1"></i> Général
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('get.password') }}">
                            <i class="ti-xs ti ti-lock me-1"></i> Modifier Mot de Passe
                        </a>
                    </li>
                </ul>

                <div class="card mb-4">
                    <h5 class="card-header">Profile Details</h5>

                    {{-- ── Formulaire photo de profil ─────────────────────── --}}
                    <div class="card-body">
                        {{--
                            IMPORTANT : PAS de onchange="submitForm()" sur l'input.
                            La sélection du fichier ouvre le modal de recadrage.
                            L'upload n'est déclenché QU'après validation du recadrage.
                        --}}
                        <form id="image-upload-form"
                              action="{{ route('update.profile.image') }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="{{ (!empty($personnel->photo_profil)) ? url('upload/user_images/'.$personnel->photo_profil) : url('upload/profil.png') }}"
                                     alt="Photo de profil"
                                     class="d-block w-px-100 h-px-100 rounded"
                                     id="uploadedAvatar"
                                     onerror="this.src='/default/noimage.jpg'"
                                     style="object-fit: cover"/>

                                <div class="button-wrapper">
                                    <label for="account-upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                        <span class="d-none d-sm-block">Télécharger</span>
                                        <i class="ti ti-upload d-block d-sm-none"></i>
                                        {{-- ✅ Pas de onchange ici — géré par addEventListener dans le JS --}}
                                        <input type="file"
                                               id="account-upload"
                                               class="account-file-input"
                                               hidden
                                               name="photo_profil"
                                               accept="image/jpeg,image/png,image/gif"/>
                                    </label>
                                    <a href="{{ route('delete.image') }}"
                                       class="btn btn-label-secondary account-image-reset mb-3">
                                        <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Réinitialiser</span>
                                    </a>
                                    <div class="text-muted">JPEG, JPG, GIF ou PNG autorisés. Taille maximale de 2Mb</div>
                                    @error('photo_profil')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Badges professionnels --}}
                            <div class="professional-badges">
                                <div class="professional-info-title">
                                    <i class="ti ti-briefcase me-1"></i>
                                    Informations Professionnelles
                                </div>
                                <div class="d-flex flex-wrap">
                                    @if($personnel->role && $personnel->role->name)
                                        <span class="badge badge-professional badge-role rounded-pill">
                                            <i class="ti ti-shield-check badge-icon"></i>
                                            {{ $personnel->role->name }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>

                    <hr class="my-0"/>

                    {{-- ── Formulaire informations personnelles ───────────── --}}
                    <div class="card-body">
                        <form id="profilEditForm" method="POST" action="{{ route('user.parametre.update') }}">
                            @csrf
                            <input type="hidden" name="my_user_id" value="{{ $users->id }}">
                            <input type="hidden" name="my_personnel_id" value="{{ $personnel->id }}">

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="prenoms" class="form-label">Prénom</label>
                                    <input class="form-control" type="text" id="prenoms" name="prenoms"
                                           value="{{ $personnel->prenoms }}" autofocus/>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="nom" class="form-label">Nom</label>
                                    <input class="form-control" type="text" name="nom" id="nom"
                                           value="{{ $personnel->nom }}"/>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Nom d'utilisateur</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{ $users->name }}"/>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input class="form-control" type="text" id="email" name="email"
                                           value="{{ $users->email }}" placeholder="john.doe@example.com"/>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="date_naissance" class="form-label">Date de naissance</label>
                                    <input class="form-control flatpickr-basic" type="text"
                                           id="date_naissance" name="date_naissance"
                                           value="{{ $personnel->date_naissance }}"/>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="genre" class="form-label">Genre</label>
                                    <select id="genre" name="genre" class="select2 form-select">
                                        <option value="Homme" {{ $personnel->genre == 'Homme' ? 'selected' : '' }}>Homme</option>
                                        <option value="Femme"  {{ $personnel->genre == 'Femme'  ? 'selected' : '' }}>Femme</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="telephone">Téléphone</label>
                                    <input type="text" id="telephone" name="telephone"
                                           class="form-control" value="{{ $personnel->telephone }}"/>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="adresse" class="form-label">Adresse</label>
                                    <input type="text" class="form-control" id="adresse" name="adresse"
                                           value="{{ $personnel->adresse }}"/>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="ville_de_residence" class="form-label">Ville de résidence</label>
                                    <input class="form-control" type="text" id="ville_de_residence"
                                           name="ville_de_residence" value="{{ $personnel->ville_de_residence }}"/>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="code_postal" class="form-label">Code Postal</label>
                                    <input type="text" class="form-control" id="code_postal"
                                           name="code_postal" value="{{ $personnel->code_postal }}" maxlength="6"/>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label class="form-label" for="nationalite">Nationalité</label>
                                    <input type="text" class="form-control" id="nationalite"
                                           name="nationalite" value="{{ $personnel->nationalite }}"/>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label class="form-label" for="a_propos">Informations professionnelles</label>
                                    <textarea class="form-control" id="a_propos" name="a_propos" rows="3">{{ $personnel->a_propos }}</textarea>
                                </div>
                            </div>

                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                          aria-hidden="true" style="display: none;"></span>
                                    <span class="ms-1">Enregistrer Modification</span>
                                </button>
                                <button type="reset" class="btn btn-label-secondary">Retour</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════════════════
         Modal de recadrage
    ════════════════════════════════════════════════════════════════════ --}}
    <div class="modal fade" id="cropModal" tabindex="-1" aria-hidden="true"
         data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ti ti-crop me-1"></i>
                        Recadrer votre photo de profil
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="cropper-container border rounded p-2 bg-light">
                                <img id="cropper-image" src="" alt="Image à recadrer">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center mb-3">
                                <label class="form-label fw-semibold">Aperçu</label>
                                <div class="cropper-preview">
                                    <img id="preview-image" src="" alt="Aperçu">
                                </div>
                            </div>
                            <div class="text-muted small">
                                <p class="mb-1"><i class="ti ti-info-circle me-1"></i> Conseils :</p>
                                <ul class="ps-3 mb-0">
                                    <li>Utilisez la molette pour zoomer</li>
                                    <li>Glissez l'image pour la positionner</li>
                                    <li>Le résultat final sera carré</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="cropper-actions">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="ti ti-x me-1"></i>Annuler
                        </button>
                        <button type="button" class="btn btn-primary" id="crop-button">
                            <i class="ti ti-crop me-1"></i>Recadrer & Envoyer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════════════════
         Modal de chargement
    ════════════════════════════════════════════════════════════════════ --}}
    <div class="modal fade" id="loadingModall" data-bs-backdrop="static"
         data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-white bg-opacity-75 border-0 rounded-4 shadow-lg">
                <div class="modal-body text-center p-5">
                    <div class="spinner-container">
                        <div class="spinner" id="spinner"></div>
                        <div class="loading-text">Chargement...</div>
                    </div>
                    <p class="mb-0 mt-3" style="color: #0305a2">
                        Veuillez patienter pendant que nous traitons votre photo de profil.
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('scripts')

    {{-- Vendors JS --}}
    <script src="{{ asset('backend/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
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
    <script src="{{ asset('backend/vendor/libs/jquery-repeater/jquery-repeater.js')}}"></script>
    <script src="{{ asset('backend/js/forms-extras.js')}}"></script>
    <script src="{{ asset('backend/js/form-validation.js')}}"></script>
    <script src="{{ asset('backend/js/form-layouts.js')}}"></script>
    <script src="{{ asset('backend/js/extended-ui-sweetalert2.js')}}"></script>
    <script src="{{ asset('backend/js/pages-account-settings-account.js')}}"></script>
    <script src="{{ asset('backend/js/spinner.js')}}" defer></script>

    {{-- Cropper.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    {{-- CSRF global --}}
    <script>
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
    </script>

    {{-- Spinner animé --}}
    <script>
        const spinner = document.getElementById('spinner');
        for (let i = 0; i < 12; i++) {
            const line = document.createElement('div');
            line.className = 'spinner-line';
            line.style.transform = `rotate(${i * 30}deg)`;
            line.style.animationDelay = `${i * 0.1}s`;
            spinner.appendChild(line);
        }
    </script>

    {{-- Flatpickr FR --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.flatpickr-basic').forEach(function (el) {
                flatpickr(el, {
                    dateFormat: "d-m-Y",
                    locale: {
                        firstDayOfWeek: 1,
                        weekdays: {
                            shorthand: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
                            longhand:  ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi']
                        },
                        months: {
                            shorthand: ['Jan','Fév','Mar','Avr','Mai','Juin','Juil','Aoû','Sep','Oct','Nov','Déc'],
                            longhand:  ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre']
                        },
                        rangeSeparator: " au ",
                    }
                });
            });
        });
    </script>

    {{--
        ✅ JS recadrage + upload — tout est centralisé ici.
           Ce fichier contient :
           - addEventListener 'change' sur #account-upload → ouvre le modal
           - Cropper.js initialisé APRÈS shown.bs.modal
           - Bouton #crop-button → génère le blob → uploadProfileImage()
           - uploadProfileImage() → AJAX vers updateProfileImage()
           - checkPhotoStatus() → polling
           - hidden.bs.modal → nettoyage
           - .account-image-reset → réinitialisation
    --}}
    @include('backend.profile.js.default')

@endpush