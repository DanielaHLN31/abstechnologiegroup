<script>
    // Fonction pour charger les données dans le modal de modification
    $(document).on('click', 'a[data-bs-target="#Modifiercategory"]', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                if (response.category) { 
                    $('#category_id').val(response.category.id);
                    $('#edit_nom').val(response.category.name);
                    $('#edit_description').val(response.category.description);
                    
                    // Réinitialiser les erreurs
                    $('.is-invalid').removeClass('is-invalid');
                    $('.text-danger').text('');
                }
            },
            error: function(xhr) {
                toastr.error('Erreur lors du chargement des données');
                console.error('Erreur:', xhr.responseJSON);
            }
        });
    });

    // Gestion des erreurs lors de la soumission du formulaire de modification
    $('#categoryFormEdit').on('submit', function(e) {
        e.preventDefault();

        // Afficher le spinner
        $(this).find('button[type="submit"] .spinner-border').css('display', 'inline-block');
        
        // Désactiver le bouton pour éviter les doubles soumissions
        $(this).find('button[type="submit"]').prop('disabled', true);
        
        var formData = $(this).serialize();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(response) {
                // Masquer le spinner et réactiver le bouton
                $('#categoryFormEdit button[type="submit"] .spinner-border').css('display', 'none');
                $('#categoryFormEdit button[type="submit"]').prop('disabled', false);
                
                // Afficher le message de succès
                if (response['alert-type'] === 'Succès') {
                    iziToast.success({
                        title: 'Succès',
                        message: response.message,
                        position: 'topRight',
                        timeout: 3000,
                        progressBar: true,
                        closeOnClick: true,
                        transitionIn: 'bounceInLeft',
                    });
                }
                
                // Fermer le modal
                $('#Modifiercategory').modal('hide');
                
                // Rafraîchir la page après un court délai
                setTimeout(function() {
                    window.location.href = response.redirect_url;
                }, 1500);
            },
            error: function(xhr) {
                // Masquer le spinner et réactiver le bouton
                $('#categoryFormEdit button[type="submit"] .spinner-border').css('display', 'none');
                $('#categoryFormEdit button[type="submit"]').prop('disabled', false);
                
                if (xhr.status === 422) {
                    // Nettoyer les anciennes erreurs
                    $('#categoryFormEdit .text-danger').text('');
                    $('#categoryFormEdit .form-control').removeClass('is-invalid');
                    $('#categoryFormEdit textarea').removeClass('is-invalid');

                    var errors = xhr.responseJSON.errors;

                    // Afficher les nouvelles erreurs
                    $.each(errors, function(field, messages) {
                        if (field === 'nom') {
                            $('#edit_nom').addClass('is-invalid');
                            $('#error_edit_nom').text(messages[0]);
                        } else if (field === 'description') {
                            $('#edit_description').addClass('is-invalid');
                            $('#error_edit_description').text(messages[0]);
                        }
                    });

                    iziToast.error({
                        title: 'Erreur de validation',
                        message: 'Veuillez corriger les erreurs dans le formulaire.',
                        position: 'topRight',
                        timeout: 5000,
                        progressBar: true,
                        closeOnClick: true,
                        transitionIn: 'bounceInLeft',
                    });

                } else {
                    iziToast.error({
                        title: 'Erreur',
                        message: 'Une erreur est survenue lors de la mise à jour du type de dossier.',
                        position: 'topRight',
                        timeout: 5000,
                        progressBar: true,
                        closeOnClick: true,
                        transitionIn: 'bounceInLeft',
                    });
                    
                    console.error('Erreur:', xhr.responseJSON);
                }
            }
        });
    });

    // Gestion des erreurs pour le formulaire d'ajout
    // $('#categoryForm').on('submit', function(e) {
    //     e.preventDefault();

    //     // Afficher le spinner
    //     $(this).find('button[type="submit"] .spinner-border').css('display', 'inline-block');
        
    //     // Désactiver le bouton
    //     $(this).find('button[type="submit"]').prop('disabled', true);
        
    //     var formData = $(this).serialize();

    //     $.ajax({
    //         url: $(this).attr('action'),
    //         type: 'POST',
    //         data: formData,
    //         success: function(response) {
    //             // Masquer le spinner et réactiver le bouton
    //             $('#categoryForm button[type="submit"] .spinner-border').css('display', 'none');
    //             $('#categoryForm button[type="submit"]').prop('disabled', false);
                
    //             // Afficher le message de succès
    //             if (response['alert-type'] === 'Succès') {
    //                 iziToast.success({
    //                     title: 'Succès',
    //                     message: response.message,
    //                     position: 'topRight',
    //                     timeout: 3000,
    //                     progressBar: true,
    //                     closeOnClick: true,
    //                     transitionIn: 'bounceInLeft',
    //                 });
    //             }
                
    //             // Fermer le modal
    //             $('#exLargeModal').modal('hide');
                
    //             // Rafraîchir la page après un court délai
    //             setTimeout(function() {
    //                 window.location.href = response.redirect_url;
    //             }, 1500);
    //         },
    //         error: function(xhr) {
    //             // Masquer le spinner et réactiver le bouton
    //             $('#categoryForm button[type="submit"] .spinner-border').css('display', 'none');
    //             $('#categoryForm button[type="submit"]').prop('disabled', false);
                
    //             if (xhr.status === 422) {
    //                 // Nettoyer les anciennes erreurs
    //                 $('#categoryForm .text-danger').text('');
    //                 $('#categoryForm .form-control').removeClass('is-invalid');
    //                 $('#categoryForm textarea').removeClass('is-invalid');

    //                 var errors = xhr.responseJSON.errors;

    //                 // Afficher les nouvelles erreurs pour les champs répétés
    //                 if (errors['group-a']) {
    //                     $('#categoryForm .form-control').first().addClass('is-invalid');
    //                     $('#error_nom').text('Veuillez ajouter au moins un type de dossier');
    //                 }
                    
    //                 $.each(errors, function(field, messages) {
    //                     if (field.includes('group-a')) {
    //                         if (field.includes('nom')) {
    //                             $('#nom').addClass('is-invalid');
    //                             $('#error_nom').text(messages[0]);
    //                         }
    //                         if (field.includes('description')) {
    //                             $('#description').addClass('is-invalid');
    //                             $('#error_description').text(messages[0]);
    //                         }
    //                     }
    //                 });

    //                 iziToast.error({
    //                     title: 'Erreur de validation',
    //                     message: 'Veuillez corriger les erreurs dans le formulaire.',
    //                     position: 'topRight',
    //                     timeout: 5000,
    //                     progressBar: true,
    //                     closeOnClick: true,
    //                     transitionIn: 'bounceInLeft',
    //                 });

    //             } else {
    //                 iziToast.error({
    //                     title: 'Erreur',
    //                     message: 'Une erreur est survenue lors de l\'ajout du type de dossier.',
    //                     position: 'topRight',
    //                     timeout: 5000,
    //                     progressBar: true,
    //                     closeOnClick: true,
    //                     transitionIn: 'bounceInLeft',
    //                 });
                    
    //                 console.error('Erreur:', xhr.responseJSON);
    //             }
    //         }
    //     });
    // });

    // Réinitialisation des erreurs lors de la saisie
    $(document).on('input', '#edit_nom, #edit_description, #categoryForm input[name*="nom"], #categoryForm textarea[name*="description"]', function() {
        $(this).removeClass('is-invalid');
        
        // Effacer le message d'erreur associé
        if ($(this).attr('id') === 'edit_nom') {
            $('#error_edit_nom').text('');
        } else if ($(this).attr('id') === 'edit_description') {
            $('#error_edit_description').text('');
        } else if ($(this).attr('name') && $(this).attr('name').includes('nom')) {
            $('#error_nom').text('');
        } else if ($(this).attr('name') && $(this).attr('name').includes('description')) {
            $('#error_description').text('');
        }
    });

    // Réinitialisation du formulaire d'ajout lors de l'ouverture du modal
    $('#exLargeModal').on('hidden.bs.modal', function () {
        $('#categoryForm')[0].reset();
        $('#categoryForm .is-invalid').removeClass('is-invalid');
        $('#categoryForm .text-danger').text('');
        $('#categoryForm .spinner-border').css('display', 'none');
        $('#categoryForm button[type="submit"]').prop('disabled', false);
    });

    // Réinitialisation du formulaire de modification lors de la fermeture du modal
    $('#Modifiercategory').on('hidden.bs.modal', function () {
        $('#categoryFormEdit')[0].reset();
        $('#categoryFormEdit .is-invalid').removeClass('is-invalid');
        $('#categoryFormEdit .text-danger').text('');
        $('#categoryFormEdit .spinner-border').css('display', 'none');
        $('#categoryFormEdit button[type="submit"]').prop('disabled', false);
    });

    // Fonction d'alerte (si nécessaire pour la rétrocompatibilité)
    function show_alert(type, message) {
        if (type === 'Succès') {
            iziToast.success({
                title: 'Succès',
                message: message,
                position: 'topRight',
                timeout: 3000,
                progressBar: true,
                closeOnClick: true,
                transitionIn: 'bounceInLeft',
            });
        }
    }
</script>

<style>
    .is-invalid {
        border-color: #dc3545 !important;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .text-danger {
        display: block;
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }

    .required:after {
        content: " *";
        color: #dc3545;
    }
</style>