<script>



    $(document).ready(function() {
        $(document).on('click', '[data-repeater-delete]', function(e) {
            e.preventDefault();
            const elementToDelete = $(this).closest('[data-repeater-item]');

            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "La suppression du champ sera définitive !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, Supprimer !',
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
    });

    $(document).ready(function() {
        let formSubmitting = false;

        // Supprimer l'erreur dès que l'utilisateur commence à écrire dans un champ invalidé
        $(document).on('input', '#posteForm input, #posteForm textarea', function() {
            // Supprimer la classe d'erreur
            $(this).removeClass('is-invalid');

            // Supprimer le message d'erreur
            $(this).next('.error-message').remove();
        });

        // Faire disparaître le message d'erreur lors de la sélection d'une valeur
        $(document).on('change', '[name="service_id[]"]', function() {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').remove();
        });

        $('#add-group-a-item').on('click', function () {
            // Supprimer le message d'erreur et la classe d'erreur
            $('#group-a-container .is-invalid').removeClass('is-invalid');
            $('#group-a-container .invalid-feedback').remove();
        });


        // Gérer la soumission du formulaire
        $('#registreForm').on('submit', function(e) {
            e.preventDefault();
            formSubmitting = true;

            $('button[type="submit"] .spinner-border').css('display', 'inline-block');
            // Nettoyer les messages d'erreur précédents
            $('.error-message').remove();
            $('.is-invalid').removeClass('is-invalid');

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
                        const errors = xhr.responseJSON.errors;

                        // Parcourir chaque erreur
                        Object.keys(errors).forEach(function(key) {
                            // Gestion de l'erreur globale du repeater
                            if (key === 'group-a') {
                                // Afficher le message global du repeater
                                $('#group-a-container').append(`<div class="invalid-feedback error-message">${errors[key][0]}</div>`);

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

                                // Gestion des champs individuels dans le repeater
                            } else if (key.includes('group-a.')) {
                                // Extraire l'index et le nom du champ
                                const matches = key.match(/group-a\.(\d+)\.(\w+)/);
                                if (matches) {
                                    const index = matches[1];
                                    const fieldName = matches[2];

                                    // Trouver le champ correspondant dans le DOM
                                    const field = $(`[name="group-a[${index}][${fieldName}]"]`);
                                    field.addClass('is-invalid');  // Ajouter la classe 'is-invalid'

                                    // Ajouter le message d'erreur après le champ
                                    field.after(`<div class="invalid-feedback error-message">${errors[key][0]}</div>`);
                                }

                            }  else if (key === 'service_id') {
                                // Gérer les erreurs du select multiple correctement
                                const field = $(`[name="service_id[]"]`);
                                field.addClass('is-invalid');
                                field.parent().append(`<div class="invalid-feedback error-message">${errors[key][0]}</div>`);

                            } else {
                                // Pour les autres champs, gérer l'erreur normalement
                                const field = $(`[name="${key}"]`);
                                field.addClass('is-invalid');  // Ajouter la classe 'is-invalid'
                                field.after(`<div class="invalid-feedback error-message">${errors[key][0]}</div>`);

                            }
                        });
                    } else {
                        iziToast.error({
                            title: 'Erreur',
                            message: 'Une erreur est survenue. Veuillez réessayer.',
                            position: 'topRight',
                            timeout: 5000
                        });
                    }
                    formSubmitting = false;
                }
            });
        });

        // Re-initialiser les erreurs lors de l'ajout d'un nouvel élément
        $(document).on('click', '[data-repeater-create]', function() {
            formSubmitting = false;  // Ajouter cette ligne
            setTimeout(function() {
                $('[data-repeater-list]').find('[data-repeater-item]').last().find('input, textarea').each(function() {
                    $(this).removeClass('is-invalid');
                    $(this).next('.error-message').remove();
                });
            }, 100);
        });
    });

    // Lorsque l'utilisateur commence à taper dans un champ, on réinitialise l'état d'erreur
    $('.form-control').on('input', '.form-control', function() {
        var fieldElement = $(this); // Le champ actuellement en train d'être modifié
        var errorMessage = fieldElement.next('.text-danger'); // Le message d'erreur associé

        // Si le champ a la classe 'is-invalid' (indiquant une erreur)
        if (fieldElement.hasClass('is-invalid')) {
            fieldElement.removeClass('is-invalid'); // Supprime la classe 'is-invalid'
            errorMessage.text(''); // Efface le message d'erreur
        }
    });

</script>

<style>
    .is-invalid {
        border-color: #dc3545 !important;
    }

    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }
</style>
