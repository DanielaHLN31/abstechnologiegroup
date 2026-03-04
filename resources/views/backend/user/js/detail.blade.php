<script>
    $(document).on('click', '.details-user-btn', function(e) {
            e.preventDefault();
            let userId = $(this).data('user-details-id');
            
            $.ajax({
                url: `/users/show/user/${userId}`,
                method: 'GET',
                success: function(response) {
                    if (response.success && response.data) {
                        renderUserModal(response.data);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Status:', status);
                    console.error('Error:', error);
                    console.error('Response:', xhr.responseText);
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'Une erreur est survenue lors de la récupération des données.',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    });
                }
            });
        });

        // Fonction principale de rendu du modal utilisateur
        function renderUserModal(userData) {
            const user = userData.user;
            const personnel = userData.personnel;
            const affectation = userData.affectation;
            console.log("Données complètes reçues:", userData); // Vérifiez dans la console du navigateur
    console.log("Données d'affectation:", userData.affectation);

            if (affectation) {
                if (affectation.type === 'tribunal') {
                    console.log('Tribunal:', affectation.nom, affectation.ville);
                } else if (affectation.type === 'parquet') {
                    console.log('Parquet:', affectation.nom, affectation.ville);
                }
            }
            
            const content = `
            <div class="user-profile-container">
                ${createSidebarLayout(userData)}
            </div>`;

            Swal.fire({
                title: '',
                html: content,
                width: '1115',
                padding: '0',
                showClass: {
                    popup: 'animate__animated animate__fadeIn animate__faster'
                },
                customClass: {
                    container: 'user-details-modal',
                    popup: 'border-0 rounded-lg overflow-hidden p-0',
                    title: 'd-none',
                    confirmButton: 'btn btn-soft-primary px-4'
                },
                buttonsStyling: false,
                confirmButtonText: '<i class="fas fa-times me-2"></i>Fermer',
                showCloseButton: false,
                background: '#ffffff',
            });

            // Initialiser les fonctionnalités interactives après le rendu
            initializeTabs();
        }

        // Crée la mise en page avec sidebar
        function createSidebarLayout(userData) {
            const user = userData.user;
            const personnel = userData.personnel;
            const affectation = userData.affectation;
            
            return `
            <div class="user-layout">
                <!-- Sidebar -->
                <div class="user-sidebar">
                    ${createUserProfileCard(user, personnel)}
                    ${createQuickInfoSection(user, personnel, affectation)}
                </div>
                
                <!-- Main Content -->
                <div class="user-main-content">
                    <!-- Tabs de navigation -->
                    <div class="user-tabs-wrapper sticky-top bg-white shadow-sm">
                        <ul class="nav nav-pills" id="userDetailsTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="personal-tab" data-bs-toggle="pill" 
                                    data-bs-target="#personal" type="button" role="tab" aria-selected="true">
                                    <i class="fas fa-user-circle me-2"></i>Personnel
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="pill" 
                                    data-bs-target="#contact" type="button" role="tab" aria-selected="false">
                                    <i class="fas fa-address-card me-2"></i>Contact
                                </button>
                            </li>
                            ${hasValue(personnel.a_propos) ? `
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="bio-tab" data-bs-toggle="pill" 
                                    data-bs-target="#bio" type="button" role="tab" aria-selected="false">
                                    <i class="fas fa-book-open me-2"></i>Biographie
                                </button>
                            </li>` : ''}
                            ${userData.juge ? `
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="juge-tab" data-bs-toggle="pill" 
                                    data-bs-target="#juge" type="button" role="tab" aria-selected="false">
                                    <i class="fas fa-gavel me-2"></i>Info Juge
                                </button>
                            </li>` : ''}
                            ${userData.avocat ? `
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="avocat-tab" data-bs-toggle="pill" 
                                    data-bs-target="#avocat" type="button" role="tab" aria-selected="false">
                                    <i class="fas fa-balance-scale me-2"></i>Info Avocat
                                </button>
                            </li>` : ''}
                        </ul>
                    </div>

                    <!-- Contenu des tabs -->
                    <div class="tab-content p-4" id="userDetailsTabsContent">
                        <!-- Tab Personnel -->
                        <div class="tab-pane fade show active" id="personal" role="tabpanel">
                            ${createPersonalInfoCards(user, personnel)}
                        </div>

                        <!-- Tab Contact -->
                        <div class="tab-pane fade" id="contact" role="tabpanel">
                            ${createContactInfoCards(personnel)}
                        </div>

                        ${hasValue(personnel.a_propos) ? `
                        <!-- Tab Biographie -->
                        <div class="tab-pane fade" id="bio" role="tabpanel">
                            ${createBiographyCard(personnel)}
                        </div>` : ''}
                        
                    </div>
                </div>
            </div>`;
        }

        // Crée la carte de profil utilisateur pour la sidebar
        function createUserProfileCard(user, personnel) {
            const roleClass = getRoleClass(user.role?.name);
            const roleBadge = user.role?.name ? 
                `<span class="badge ${roleClass} position-absolute top-0 end-0 mt-3 me-5">
                    ${user.role.name}
                </span>` : '';

            const modifierButton = user.principal !== 1 ? `
                <button class="btn btn-sm btn-outline-primary w-100 mt-2" data-user-id="${user.id}" data-bs-toggle="modal" data-bs-target="#ModifierUsers">
                    <i class="fas fa-edit me-2"></i>Modifier
                </button>` : '';

            return `
                <div class="profile-card text-center position-relative">
                    ${roleBadge}
                    <div class="profile-image-wrapper">
                        <img src="${personnel.photo_profil_url}" 
                            alt="Photo de profil" 
                            class="profile-image"
                            onerror="this.src='/default/noimage.jpg'"
                        />
                    </div>
                    <h4 class="fw-bold mt-3 mb-1">${personnel.prenoms} ${personnel.nom}</h4>
                    <p class="text-muted mb-2">
                        <i class="fas fa-user-tie me-1"></i>${user.poste?.nom || 'Non spécifié'}
                    </p>
                    ${hasValue(user.service?.nom) ? `
                        <p class="text-muted small mb-3">
                            <i class="fas fa-building me-1"></i>${user.service.nom}
                        </p>` : ''}
                    ${modifierButton}
                </div>`;
        }


        // Crée la section d'information rapide pour la sidebar
        function createQuickInfoSection(user, personnel, affectation) {
    return `
    <div class="quick-info-section">
        <h6 class="section-title"><i class="fas fa-info-circle me-2"></i>Informations rapides</h6>
        
        ${createQuickInfoItem("fas fa-envelope", "Email", personnel.email)}
        ${createQuickInfoItem("fas fa-phone", "Téléphone", personnel.telephone)}
        ${hasValue(personnel.nationalite) ? createQuickInfoItem("fas fa-flag", "Nationalité", personnel.nationalite) : ''}
        ${createQuickInfoItem("fas fa-calendar", "Date de naissance", personnel.date_naissance)}
        ${hasValue(user.name) ? createQuickInfoItem("fas fa-id-badge", "Nom d'utilisateur", user.name) : ''}
        ${affectation ? `
            <div class="quick-info-item">
                <i class="fas fa-map-marker-alt info-icon"></i>
                <div class="info-content">
                    <span class="info-label">Affectation</span>
                    <span class="info-value">
                        ${affectation.nom} (${affectation.ville})
                        <small class="d-block text-muted">${affectation.type === 'tribunal' ? 'Tribunal' : 'Parquet'}</small>
                    </span>
                </div>
            </div>
        ` : ''}
    </div>`;
}

        // Crée un élément d'information rapide
        function createQuickInfoItem(icon, label, value) {
            if (!hasValue(value)) return '';
            
            return `
            <div class="quick-info-item">
                <i class="${icon} info-icon"></i>
                <div class="info-content">
                    <span class="info-label">${label}</span>
                    <span class="info-value">${value}</span>
                </div>
            </div>`;
        }

        // Crée le contenu de l'onglet Informations personnelles
        function createPersonalInfoCards(user, personnel) {
            return `
            <div class="tab-header">
                <h4><i class="fas fa-user-circle text-primary me-2"></i>Informations personnelles</h4>
                <p class="text-muted">Détails personnels et professionnels de l'utilisateur</p>
            </div>
            
            <div>
                ${createInfoCard("Identité", [
                    createInfoRow("fas fa-user", "Nom complet", `${personnel.prenoms} ${personnel.nom}`),
                    createInfoRow("fas fa-venus-mars", "Genre", personnel.genre),
                    createInfoRow("fas fa-flag", "Nationalité", personnel.nationalite),
                    createInfoRow("fas fa-calendar", "Date de naissance", personnel.date_naissance)
                ])}
                
            </div>
            <div >
                
                ${createInfoCard("Compte", [
                    createInfoRow("fas fa-id-badge", "Nom d'utilisateur", user.name),
                    createInfoRow("fas fa-user-shield", "Rôle", user.role?.name, getRoleBadgeClass(user.role?.name)),
                    createInfoRow("fas fa-building", "Service", user.service?.nom),
                    createInfoRow("fas fa-user-tie", "Poste", user.poste?.nom)
                ])}
            </div>`;
        }

        // Crée le contenu de l'onglet Contact
        function createContactInfoCards(personnel) {
            return `
            <div class="tab-header">
                <h4><i class="fas fa-address-card text-info me-2"></i>Coordonnées</h4>
                <p class="text-muted">Informations de contact et coordonnées</p>
            </div>
            
            <div>
                ${createInfoCard("Contact", [
                    createInfoRow("fas fa-envelope", "Email", personnel.email),
                    createInfoRow("fas fa-phone", "Téléphone", personnel.telephone)
                ])}
                
            </div>
            <div >
                ${createInfoCard("Adresse", [
                    createInfoRow("fas fa-map-marker-alt", "Ville", personnel.ville_de_residence),
                    createInfoRow("fas fa-map-pin", "Code postal", personnel.code_postal),
                    createInfoRow("fas fa-home", "Adresse complète", personnel.adresse, null, true)
                ])}
            </div>`;
        }

        // Crée le contenu de l'onglet Biographie
        function createBiographyCard(personnel) {
            return `
            <div class="tab-header">
                <h4><i class="fas fa-book-open text-success me-2"></i>Informations Professionnelles</h4>
                <p class="text-muted">À propos de la personne</p>
            </div>
            
            <div class="bio-card">
                <div class="bio-quote">
                    <i class="fas fa-quote-left bio-quote-icon"></i>
                    <div class="bio-content">
                        ${personnel.a_propos}
                    </div>
                    <i class="fas fa-quote-right bio-quote-icon-right"></i>
                </div>
            </div>`;
        }

        // Crée une carte d'information
        function createInfoCard(title, rows) {
            // Filtrer les lignes vides
            const validRows = rows.filter(row => row !== '');
            
            if (validRows.length === 0) return '';
            
            return `
            <div class="info-card">
                <h6 class="info-card-title">${title}</h6>
                <div class="info-card-content">
                    ${validRows.join('')}
                </div>
            </div>`;
        }

        // Crée une ligne d'information
        function createInfoRow(icon, label, value, badgeClass = null, isFullWidth = false) {
            if (!hasValue(value)) return '';
            
            const valueDisplay = badgeClass ? 
                `<span class="badge ${badgeClass}">${value}</span>` : 
                `<span class="info-row-value">${value}</span>`;
            
            return `
            <div class="info-row ${isFullWidth ? 'full-width' : ''}">
                <div class="info-row-label">
                    <i class="${icon}"></i>
                    <span>${label}</span>
                </div>
                ${valueDisplay}
            </div>`;
        }

        // Obtenir la classe pour le badge de rôle
        function getRoleBadgeClass(role) {
            switch(role) {
                case 'Admin': return 'bg-danger';
                case 'Juge': return 'bg-primary';
                case 'Avocat': return 'bg-success';
                default: return 'bg-secondary';
            }
        }

        // Obtenir la classe pour la carte de rôle
        function getRoleClass(role) {
            switch(role) {
                case 'Admin': return 'bg-danger text-white';
                case 'Juge': return 'bg-primary text-white';
                case 'Avocat': return 'bg-success text-white';
                default: return 'bg-secondary text-white';
            }
        }

        // Vérifie si une valeur existe
        function hasValue(value) {
            return value !== null && value !== undefined && value !== '';
        }

        // Initialise les interactions des onglets
        function initializeTabs() {
            const userDetailsTabs = document.querySelectorAll('#userDetailsTabs .nav-link');
            userDetailsTabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('data-bs-target'));
                    if (target) {
                        document.querySelectorAll('#userDetailsTabsContent .tab-pane').forEach(pane => {
                            pane.classList.remove('show', 'active');
                        });
                        target.classList.add('show', 'active');
                        
                        userDetailsTabs.forEach(t => t.classList.remove('active'));
                        this.classList.add('active');
                    }
                });
            });
        }


    // Gestionnaire pour le bouton modifier dans la vue détails
    $(document).on('click', 'button[data-bs-target="#ModifierUsers"]', function(e) {
        e.preventDefault();
        
        // Récupérer l'ID de l'utilisateur directement depuis le bouton
        var userId = $(this).data('user-id');
        var url = `/users/${userId}/edit`;

        // Mettre à jour l'attribut data-user-details-id immédiatement
        $('.details-user-btn').attr('data-user-details-id', userId);
        
        // Montrer d'abord le modal d'édition
        $('#ModifierUsers').modal('show');
        
        // Puis fermer le SweetAlert
        Swal.close();
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                // Remplir les selects avec les options
                if (response.postes) {
                    $('#poste1').empty().append('<option value="">Sélectionnez un poste</option>');
                    response.postes.forEach(function(poste) {
                        $('#poste1').append(new Option(poste.nom, poste.id));
                    });
                }

                if (response.services) {
                    $('#service1').empty().append('<option value="">Sélectionnez un service</option>');
                    response.services.forEach(function(service) {
                        $('#service1').append(new Option(service.nom, service.id));
                    });
                }

                if (response.roles) {
                    $('#role1').empty().append('<option value="">Sélectionnez un rôle</option>');
                    response.roles.forEach(function(role) {
                        $('#role1').append(new Option(role.name, role.id));
                    });
                }

                
                if (response.user) {
                    $('#user_id').val(response.user.id);
                    $('#my_user_id').val(response.user.id);
                    $('#name1').val(response.user.name);
                    $('#email1').val(response.user.email);
                }

                
                if (response.personnel) {
                    $('#personnel_id').val(response.personnel.id);
                    $('#my_personnel_id').val(response.personnel.id);
                    $('#prenoms1').val(response.personnel.prenoms);
                    $('#nom1').val(response.personnel.nom);
                    $('#telephone1').val(response.personnel.telephone);
                    $('#code_postal1').val(response.personnel.code_postal);
                    $('#date_naissance1').val(response.personnel.date_naissance);
                    $('#nationalite1').val(response.personnel.nationalite);
                    $('#ville_de_residence1').val(response.personnel.ville_de_residence);
                    $('#adresse1').val(response.personnel.adresse);
                    $('#a_propos1').val(response.personnel.a_propos);
                    $('select[name="genre"]').val(response.personnel.genre).trigger('change');
                }

                // Sélectionner le poste, service et rôle
                if (response.poste) {
                    $('#poste1').val(response.poste.id).trigger('change');
                }

                if (response.service) {
                    $('#service1').val(response.service.id).trigger('change');
                }

                if (response.role) {
                    $('#role1').val(response.role.id).trigger('change');
                }
            },
            error: function(xhr) {
                toastr.error('Erreur lors du chargement des données');
            }
        });
    });
    
</script>