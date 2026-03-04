
<script>
    $(document).ready(function() {
        // Confirmation de suppression d'un élément répété
        $(document).on('click', '[data-repeater-delete]', function(e) {
            e.preventDefault();
            const elementToDelete = $(this).closest('[data-repeater-item]');

            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "La suppression de cette marque sera définitive !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    elementToDelete.slideUp(() => elementToDelete.remove());
                }
            });
        });

        // Supprimer l'erreur dès que l'utilisateur commence à écrire
        $(document).on('input', '#brandForm input', function() {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').text('');
            $(this).closest('.col-md-12').find('.invalid-feedback').text('');
        });

        // Gérer la soumission du formulaire d'ajout
        $('#brandForm').on('submit', function(e) {
            e.preventDefault();
            
            // Afficher le spinner
            $(this).find('button[type="submit"] .spinner-border').css('display', 'inline-block');
            $(this).find('button[type="submit"]').prop('disabled', true);
            
            // Nettoyer les messages d'erreur précédents
            $('.invalid-feedback').text('');
            $('.is-invalid').removeClass('is-invalid');

            var formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Masquer le spinner
                    $('#brandForm button[type="submit"] .spinner-border').css('display', 'none');
                    $('#brandForm button[type="submit"]').prop('disabled', false);
                    
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
                    $('#exLargeModal').modal('hide');
                    
                    // Rediriger après un court délai
                    setTimeout(function() {
                        if (response.redirect_url) {
                            window.location.href = response.redirect_url;
                        } else {
                            location.reload();
                        }
                    }, 1500);
                },
                error: function(xhr) {
                    // Masquer le spinner
                    $('#brandForm button[type="submit"] .spinner-border').css('display', 'none');
                    $('#brandForm button[type="submit"]').prop('disabled', false);
                    
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;

                        // Nettoyer les anciennes erreurs
                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').text('');

                        // Parcourir chaque erreur
                        Object.keys(errors).forEach(function(key) {
                            // Gérer les erreurs pour les champs répétés (group-a)
                            if (key.includes('group-a.')) {
                                const matches = key.match(/group-a\.(\d+)\.(\w+)/);
                                if (matches) {
                                    const index = matches[1];
                                    const fieldName = matches[2];
                                    
                                    // Cibler le champ spécifique
                                    const field = $(`[name="group-a[${index}][${fieldName}]"]`);
                                    field.addClass('is-invalid');
                                    field.next('.invalid-feedback').text(errors[key][0]);
                                    field.closest('.col-md-12').find('.invalid-feedback').text(errors[key][0]);
                                }
                            } else if (key === 'group-a') {
                                // Erreur globale sur group-a
                                $('[data-repeater-item]').first().find('input').addClass('is-invalid');
                                $('[data-repeater-item]').first().find('.invalid-feedback').text(errors[key][0]);
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
                            message: xhr.responseJSON?.message || 'Une erreur est survenue lors de l\'ajout de la marque.',
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

        // Réinitialiser le formulaire à la fermeture du modal
        $('#exLargeModal').on('hidden.bs.modal', function () {
            $('#brandForm')[0].reset();
            $('#brandForm .is-invalid').removeClass('is-invalid');
            $('#brandForm .invalid-feedback').text('');
            $('#brandForm .spinner-border').css('display', 'none');
            $('#brandForm button[type="submit"]').prop('disabled', false);
            
            // Réinitialiser le repeater - garder un seul élément
            const repeaterList = $('#brandForm [data-repeater-list="group-a"]');
            const items = repeaterList.find('[data-repeater-item]');
            if (items.length > 1) {
                items.slice(1).remove();
            }
            // Vider la valeur du premier élément
            items.first().find('input').val('');
        });

        // Réinitialiser les erreurs lors de l'ajout d'un nouvel élément
        $(document).on('click', '[data-repeater-create]', function() {
            setTimeout(function() {
                const newItem = $('[data-repeater-list]').find('[data-repeater-item]').last();
                newItem.find('input').removeClass('is-invalid');
                newItem.find('.invalid-feedback').text('');
            }, 100);
        });
    });

    // Fonction d'alerte pour la rétrocompatibilité
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