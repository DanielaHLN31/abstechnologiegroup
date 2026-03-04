<!-- Modal pour Ajouter  -->
<div class="modal fade" id="exLargeModal" tabindex="-1" aria-hidden="true" >
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 1300px;">
        <div class="modal-content">
            <!-- Validation Wizard -->
            <div class="col-12 mb-6">

                <div id="wizard-validation" class="bs-stepper mt-2">
                    <div class="bs-stepper-header">
                        <div class="step" data-target="#account-details-validation">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle">1</span>
                                <span class="bs-stepper-label mt-1">
                                <span class="bs-stepper-title">Détails du compte</span>
                                <span class="bs-stepper-subtitle">Entrez les détails de votre compte</span>
                                </span>
                            </button>
                        </div>
                        <div class="line">
                            <i class="ti ti-chevron-right"></i>
                        </div>
                        <div class="step" data-target="#personal-info-validation">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle">2</span>
                                <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Informations personnelles</span>
                                <span class="bs-stepper-subtitle">Ajouter des informations personnelles</span>
                                </span>
                            </button>
                        </div>
                        <div class="line">
                            <i class="ti ti-chevron-right"></i>
                        </div>
                        <div class="step" data-target="#social-links-validation">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle">3</span>
                                <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Qualités Professionnelles</span>
                                <span class="bs-stepper-subtitle">Entrez vos compétences</span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="bs-stepper-content">
                        <form id="wizard-validation-form" class="wizard-form" action="{{ route('store.users') }}" method="POST" onSubmit="return false" enctype="multipart/form-data">
                            @csrf
                            <!-- Account Details -->
                            <div id="account-details-validation" class="content">
                                <div class="content-header mb-4">
                                    <h6 class="mb-0">Détails du compte</h6>
                                    <small>Entrez les détails de votre compte</small>
                                </div>
                                <div class="row g-6">
                                    <div class="col-sm-6">
                                        <label class="form-label required" for="username">Nom d'utilisateur</label>
                                        <input type="text" name="username" id="username" class="form-control" placeholder="johndoe" />
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label required" for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="john.doe@email.com" aria-label="john.doe" />
                                    </div>
                                    <div class="col-12 d-flex justify-content-between mt-4">
                                        <button class="btn btn-label-secondary btn-prev" disabled>
                                            <i class="ti ti-arrow-left ti-xs me-sm-2 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Précédent</span>
                                        </button>
                                        <button class="btn btn-primary btn-next">
                                            <span class="align-middle d-sm-inline-block d-none me-sm-2">Suivant</span>
                                            <i class="ti ti-arrow-right ti-xs"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Personal Info -->
                            <div id="personal-info-validation" class="content">
                                <div class="content-header mb-4">
                                    <h6 class="mb-0">Informations personnelles</h6>
                                    <small>Entrez vos informations personnelles.</small>
                                </div>
                                <div class="row g-6">
                                    <div class="col-sm-6">
                                        <label class="form-label required" for="firstname">Prénoms</label>
                                        <input type="text" id="firstname" name="firstname" class="form-control" placeholder="Jean" />
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label required" for="lastname">Nom</label>
                                        <input type="text" id="lastname" name="lastname" class="form-control" placeholder="LEBOIS" />
                                    </div>
                                    <div class="col-sm-6 mt-3">
                                        <label class="form-label required" for="telephone">Numéro de téléphone</label>
                                        <div class="input-group ">
                                            <span id="basic-icon-default-phone2" class="input-group-text"></span>
                                            <input type="text" id="telephone" name="telephone" class="form-control " placeholder="03 77 77 77 77" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-3">
                                        <label class="form-label" for="code_postal">Code Postal</label>
                                        <input type="text" id="code_postal" name="code_postal" class="form-control " placeholder="BP 1087" maxlength="6" />
                                    </div>
                                    <div class="col-sm-6 mt-3">
                                        <label class="form-label" for="date_naissance">Date d'anniversaire</label>
                                        <input type="text" name="date_naissance" id="date_naissance" class="form-control dob-picker" placeholder="AAAA-MM-JJ" />
                                    </div>
                                    <div class="col-sm-6 mt-3">
                                        <label class="form-label required" for="multiStepsState">Genre</label>
                                        <select name="genre" id="multiStepsState" class="select2 form-select" data-allow-clear="true">
                                            <option value="">Sélectionnez</option>
                                            <option value="Homme">Homme</option>
                                            <option value="Femme">Femme</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 mt-3">
                                        <label class="form-label required" for="nationnalite">Nationnalité</label>
                                        <input type="text" name="nationalite"  id="nationalite" class="form-control" placeholder="Français(e)" />
                                    </div>
                                    <div class="col-sm-6 mt-3">
                                        <label class="form-label required" for="ville_de_residence">Ville de résidence</label>
                                        <input type="text" name="ville_de_residence" id="ville_de_residence" class="form-control" placeholder="Lyon" />
                                    </div>
                                    <div class="col-sm-12 mt-3">
                                        <label class="form-label required" for="adresse">Adresse de résidence</label>
                                        <input type="text" id="adresse" name="adresse" class="form-control" placeholder="Addresse"  />
                                    </div>
                                    <div class="col-12 d-flex justify-content-between mt-4">
                                        <button class="btn btn-label-secondary btn-prev">
                                            <i class="ti ti-arrow-left ti-xs me-sm-2 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Précédent</span>
                                        </button>
                                        <button class="btn btn-primary btn-next">
                                            <span class="align-middle d-sm-inline-block d-none me-sm-2">Suivant</span>
                                            <i class="ti ti-arrow-right ti-xs"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Social Links -->
                            <div id="social-links-validation" class="content">
                                <div class="content-header mb-4">
                                    <h6 class="mb-0">Qualités Professionnelles</h6>
                                    <small>Entrez vos compétences</small>
                                </div>
                                <div class="row g-6">
                                    <div class="col-sm-12">
                                        <label class="form-label required" for="multiStepsState">Rôles</label>
                                        <select name="role_id" id="" class="select2 form-select" data-allow-clear="true">
                                            <option value="">Sélectionnez</option>
                                            @foreach($roles as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="form-label" for="photo_profil">Photo de profil</label>
                                        <input type="file" name="photo_profil" class="form-control" id="photo_profil"  />
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="form-label" for="basic-default-bio">Informations Professionnelles</label>
                                        <textarea class="form-control" id="basic-default-bio" name="a_propos" rows="3" ></textarea>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between mt-4">
                                        <button class="btn btn-label-secondary btn-prev">
                                            <i class="ti ti-arrow-left ti-xs me-sm-2 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Précédent</span>
                                        </button>
                                        <button type="submit" class="btn btn-success btn-next btn-submit">
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                                            Enregistrer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Validation Wizard -->

        </div>
    </div>
</div>
<!-- Fin du modal -->
