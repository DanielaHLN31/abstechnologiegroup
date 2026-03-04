<!-- Modal d'édition utilisateur -->
    <div class="modal fade" id="ModifierUsers" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content fade-in">
                <div class="modal-header">
                    <div>
                        <h4 class="modal-title">
                            <i class="fas fa-user-edit"></i> Modifier le profil utilisateur
                        </h4>
                        <p class="modal-subtitle">Mettez à jour les informations du compte</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- Barre de progression -->
                    <div class="progress-bar">
                        <div class="progress-fill"></div>
                    </div>

                    <form id="userFormEdit" action="{{ route('update.users') }}" method="POST">
                        @csrf
                        <input type="hidden" id="user_id" name="my_user_id">
                        <input type="hidden" id="personnel_id" name="my_personnel_id">

                        <!-- Section 1: Informations de connexion -->
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-key"></i>
                            </div>
                            <div class="section-content">
                                <h4>Informations de connexion</h4>
                                <p>Gérez les détails de connexion au compte</p>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="field-group">
                                    <label class="form-label" for="name1">
                                        <i class="fas fa-user"></i> Nom d'utilisateur
                                    </label>
                                    <input type="text" name="name" id="name1" class="form-control" placeholder="johndoe" />
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="field-group">
                                    <label class="form-label" for="email1">
                                        <i class="fas fa-envelope"></i> Adresse email
                                    </label>
                                    <input type="email" name="email" id="email1" class="form-control" placeholder="john.doe@email.com" />
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Informations personnelles -->
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <div class="section-content">
                                <h4>Informations personnelles</h4>
                                <p>Détails personnels et coordonnées</p>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="field-group">
                                    <label class="form-label" for="prenoms1">
                                        <i class="fas fa-user-tag"></i> Prénoms
                                    </label>
                                    <input type="text" id="prenoms1" name="prenoms" class="form-control" placeholder="Jean" />
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="field-group">
                                    <label class="form-label" for="nom1">
                                        <i class="fas fa-user-tag"></i> Nom de famille
                                    </label>
                                    <input type="text" id="nom1" name="nom" class="form-control" placeholder="Dupont" />
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="field-group">
                                    <label class="form-label" for="telephone1">
                                        <i class="fas fa-phone"></i> Téléphone
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                        <input type="text" id="telephone1" name="telephone" class="form-control" placeholder="97 68 34 89" />
                                    </div>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="field-group">
                                    <label class="form-label" for="date_naissance1">
                                        <i class="fas fa-calendar"></i> Date de naissance
                                    </label>
                                    <input type="date" name="date_naissance" id="date_naissance1" class="form-control dob-picker" placeholder="JJ-MM-AAAA" />
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="field-group">
                                    <label class="form-label" for="genre1">
                                        <i class="fas fa-venus-mars"></i> Genre
                                    </label>
                                    <select name="genre" id="genre1" class="select2 form-select">
                                        <option value="">Sélectionnez un genre</option>
                                        <option value="Homme">Homme</option>
                                        <option value="Femme">Femme</option>
                                    </select>
                                    <span class="text-danger" id="error_genre1"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="field-group">
                                    <label class="form-label" for="nationalite1">
                                        <i class="fas fa-flag"></i> Nationalité
                                    </label>
                                    <input type="text" name="nationalite" id="nationalite1" class="form-control" placeholder="Béninoise" />
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="field-group">
                                    <label class="form-label" for="ville_de_residence1">
                                        <i class="fas fa-city"></i> Ville de résidence
                                    </label>
                                    <input type="text" name="ville_de_residence" id="ville_de_residence1" class="form-control" placeholder="Cotonou" />
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="field-group">
                                    <label class="form-label" for="code_postal1">
                                        <i class="fas fa-mail-bulk"></i> Code postal
                                    </label>
                                    <input type="text" id="code_postal1" name="code_postal" class="form-control" placeholder="BP 1087" maxlength="6" />
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="field-group">
                                    <label class="form-label" for="adresse1">
                                        <i class="fas fa-map-marker-alt"></i> Adresse complète
                                    </label>
                                    <input type="text" id="adresse1" name="adresse" class="form-control" placeholder="123 Rue de la Paix, Quartier..." />
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Informations professionnelles -->
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div class="section-content">
                                <h4>Informations professionnelles</h4>
                                <p>Poste, service et compétences</p>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <div class="field-group">
                                    <label class="form-label" for="role1">
                                        <i class="fas fa-user-shield"></i> Rôle dans le système
                                    </label>
                                    <select name="role_id" id="role1" class="select2 form-select">
                                        <option value="">Sélectionnez un rôle</option>
                                        <!-- Rempli dynamiquement -->
                                    </select>
                                    <span class="text-danger" id="error_role1"></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="field-group">
                                    <label class="form-label" for="a_propos1">
                                        <i class="fas fa-info-circle"></i> Informations professionnelles
                                    </label>
                                    <textarea class="form-control" id="a_propos1" name="a_propos" rows="4" placeholder="Décrivez les compétences, expériences et responsabilités..."></textarea>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="modal-footer">
                    <button type="submit" form="userFormEdit" class="btn btn-primary">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                        <i class="fas fa-save"></i>
                        <span class="ms-1">Modifier</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

