<script>


    $(document).ready(function() {


        let formSubmitting = false;

        // Supprimer l'erreur dès que l'utilisateur commence à écrire dans un champ invalidé
        $(document).on('input', '#password-form input, #password-form textarea', function() {
            $(this).removeClass('is-invalid');
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
        $('#password-form').on('submit', function(e) {
            e.preventDefault();

            $('button[type="submit"] .spinner-border').css('display', 'inline-block');

            formSubmitting = true;

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
                                const matches = key.match(/group-a\.(\d+)\.(\w+)/);
                                if (matches) {
                                    const index = matches[1];
                                    const fieldName = matches[2];
                                    const field = $(`[name="group-a[${index}][${fieldName}]"]`);
                                    field.addClass('is-invalid');
                                    field.after(`<div class="invalid-feedback error-message">${errors[key][0]}</div>`);
                                }

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

                            } else if (key === 'service_id') {
                                // Gérer les erreurs du select multiple correctement
                                const field = $(`[name="service_id[]"]`);
                                field.addClass('is-invalid');
                                field.parent().append(`<div class="invalid-feedback error-message">${errors[key][0]}</div>`);
                            } else {
                                const field = $(`[name="${key}"]`);
                                field.addClass('is-invalid');
                                field.after(`<div class="invalid-feedback error-message">${errors[key][0]}</div>`);
                            }
                        });
                    }
                    formSubmitting = false;
                }
            });
        });

        // Re-initialiser les erreurs lors de l'ajout d'un nouvel élément
        // Supprimer l'ancien gestionnaire d'événements avant d'en ajouter un nouveau
        $(document).off('click', '[data-repeater-create]').on('click', '[data-repeater-create]', function() {
            formSubmitting = false;
            setTimeout(function() {
                $('[data-repeater-list]').find('[data-repeater-item]').last().find('input, textarea').each(function() {
                    $(this).removeClass('is-invalid');
                    $(this).next('.error-message').remove();
                });
            }, 100);
        });

        // Gestion de la réinitialisation des erreurs
        $(document).on('input', '.form-control', function() {
            var fieldElement = $(this);
            var errorMessage = fieldElement.next('.text-danger');

            if (fieldElement.hasClass('is-invalid')) {
                fieldElement.removeClass('is-invalid');
                errorMessage.text('');
            }
        });
    });

</script>

<style>
    /* Ajout des styles pour éviter les décalages */
    .is-invalid {
        border-color: #dc3545 !important;
    }

    .invalid-feedback {
        display: block; /* Garde le message visible */
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem; /* Ajuste l'espacement */
        position: absolute; /* Position absolue pour ne pas décaler */
        top: 100%; /* Place sous le champ */
        left: 0;
        width: 100%; /* S'aligne avec le champ */
    }

    /* Le conteneur parent doit avoir position: relative */
    .form-group, .input-group, .form-password-toggle {
        position: relative;
    }
</style>

