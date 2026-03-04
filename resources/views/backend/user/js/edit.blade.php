
    <script>
        // Animation de la barre de progression
        document.addEventListener('DOMContentLoaded', function() {
            const progressFill = document.querySelector('.progress-fill');
            const sections = document.querySelectorAll('.section-header');
            
            // Simuler le progrès lors du remplissage du formulaire
            let currentSection = 0;
            const totalSections = sections.length;
            
            function updateProgress() {
                const progress = (currentSection / totalSections) * 100;
                progressFill.style.width = progress + '%';
            }
            
            // Observer les sections pour mettre à jour le progrès
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const sectionIndex = Array.from(sections).indexOf(entry.target);
                        if (sectionIndex !== -1) {
                            currentSection = sectionIndex + 1;
                            updateProgress();
                        }
                    }
                });
            });
            
            sections.forEach(section => {
                observer.observe(section);
            });
            
            // Animation du spinner lors de la soumission
            const form = document.getElementById('userFormEdit');
            const submitBtn = form.querySelector('button[type="submit"]');
            const spinner = submitBtn.querySelector('.spinner-border');
            
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Pour la démo
                
                spinner.style.display = 'inline-block';
                submitBtn.disabled = true;
                
                // Simuler un traitement
                setTimeout(() => {
                    spinner.style.display = 'none';
                    submitBtn.disabled = false;
                    
                    // Afficher un message de succès
                    const toast = document.createElement('div');
                    toast.className = 'alert alert-success position-fixed top-0 end-0 m-3';
                    toast.innerHTML = '<i class="fas fa-check-circle"></i> Profil mis à jour avec succès!';
                    document.body.appendChild(toast);
                    
                    setTimeout(() => {
                        toast.remove();
                    }, 3000);
                }, 2000);
            });
        });

        // Modification du gestionnaire de clic sur le bouton modifier
        $(document).on('click', 'a[data-bs-target="#ModifierUsers"]', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');

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
                        // Remplir le formulaire avec les données
                        $('#user_id').val(response.user.id);
                        $('#name1').val(response.user.name);
                        $('#email1').val(response.user.email);
                        $('#edit_chef_service').prop('checked', response.user.chef_service == 1);
                        $('.details-user-btn').attr('data-user-details-id', response.user.id);
                        console.log('data-user-details-id mis à jour avec :', response.user.id)
                    }

                    if (response.personnel) {
                        $('#personnel_id').val(response.personnel.id);
                        $('#prenoms1').val(response.personnel.prenoms);
                        $('#nom1').val(response.personnel.nom);
                        $('#telephone1').val(response.personnel.telephone);
                        $('#code_postal1').val(response.personnel.code_postal);
                        $('#date_naissance1').val(response.personnel.date_naissance);
                        $('#nationalite1').val(response.personnel.nationalite);
                        $('#ville_de_residence1').val(response.personnel.ville_de_residence);
                        $('#adresse1').val(response.personnel.adresse);
                        $('#a_propos1').val(response.personnel.a_propos);
                        console.log("Genre reçu:", response.personnel.genre);

                        // Pour le genre, on s'assure que la valeur correspond exactement
                        $('select[name="genre"]').val(response.personnel.genre).trigger('change');
                    }

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

        // Gestion de la soumission du formulaire
        $('#userFormEdit').on('submit', function(e) {
            e.preventDefault();

            $('button[type="submit"] .spinner-border').css('display', 'inline-block');
            var formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('button[type="submit"] .spinner-border').css('display', 'none');
                    show_alert(response['alert-type'], response.message);
                    window.location.href = response.redirect_url;
                },
                error: function(xhr) {
                    $('button[type="submit"] .spinner-border').css('display', 'none');
                    if (xhr.status === 422) {
                        // Effacer les messages d'erreur précédents
                        $('.text-danger').text('');
                        $('.form-control').removeClass('is-invalid'); // Réinitialiser la classe is-invalid
                        
                        // Récupérer les erreurs de validation du backend
                        var errors = xhr.responseJSON.errors;

                        // Boucle sur les erreurs et ajout de la classe is-invalid + affichage des messages sous chaque champ
                        $.each(errors, function(field, messages) {
                            
                        if (field === 'role_id') {
                                $('#role1').addClass('is-invalid');
                                $('#error_role1').text(messages[0]);
                            } else if (field === 'service_id') {
                                $('#service1').addClass('is-invalid');
                                $('#error_service1').text(messages[0]);
                            }else if (field === 'poste_id') {
                                $('#poste1').addClass('is-invalid');
                                $('#error_poste1').text(messages[0]);
                            }else if (field === 'genre') {
                                $('#genre1').addClass('is-invalid');
                                $('#error_genre1').text(messages[0]);
                            } else {
                                var fieldElement = $('#' + field + '1'); // Ajout du suffixe '1' pour correspondre aux IDs du formulaire
                                if (fieldElement.length) {
                                    fieldElement.addClass('is-invalid'); // Ajoute la classe is-invalid
                                    fieldElement.next('.text-danger').text(messages[0]); // Affiche le premier message d'erreur
                                }
                            }
                        });

                        // Afficher un message d'erreur global (facultatif)
                        iziToast.error({
                            title: 'Erreur',
                            message: 'Veuillez corriger les erreurs dans le formulaire.',
                            position: 'topRight',
                            timeout: 5000,
                            progressBar: true,
                            closeOnClick: true,
                            transitionIn: 'bounceInLeft',
                        });

                    } else {
                        // En cas d'erreur générale
                        iziToast.error({
                            title: 'Erreur',
                            message: 'Une erreur est survenue lors de la mise à jour du service.',
                            position: 'topRight',
                            timeout: 5000,
                            progressBar: true,
                            closeOnClick: true,
                            transitionIn: 'bounceInLeft',
                        });
                    }
                }
            });
        });

        // Lorsque l'utilisateur commence à taper dans un champ, on réinitialise l'état d'erreur
        $('.form-control').on('input', function() {
            var fieldElement = $(this); // Le champ actuellement en train d'être modifié
            var errorMessage = fieldElement.next('.text-danger'); // Le message d'erreur associé

            // Si le champ a la classe 'is-invalid' (indiquant une erreur)
            if (fieldElement.hasClass('is-invalid')) {
                fieldElement.removeClass('is-invalid'); // Supprime la classe 'is-invalid'
                errorMessage.text(''); // Efface le message d'erreur
            }
        });

        $('#role1').on('change', function() {
        $(this).removeClass('is-invalid');
        $('.text-danger').text('');
        });

        $('#service1').on('change', function() {
        $(this).removeClass('is-invalid');
        $('#error_service1').text('');
        });

        $('#poste1').on('change', function() {
        $(this).removeClass('is-invalid');
        $('#error_poste1').text('');
        });

        $('#genre1').on('change', function() {
        $(this).removeClass('is-invalid');
        $('#error_genre1').text('');
        });
    </script>