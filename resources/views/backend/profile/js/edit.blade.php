<script>


    $(document).ready(function() {

        let formSubmitting = false;


        // Gérer la soumission du formulaire
        $('#image-upload-form').on('submit', function(e) {
            e.preventDefault();


            formSubmitting = true;

            $('.error-message').remove();
            $('.is-invalid').removeClass('is-invalid');

            var formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    show_alert(response['alert-type'], response.message);
                    window.location.href = response.redirect_url;
                },
                error: function(xhr) {
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


        $('#profilEditForm').on('submit', function(e) {
            e.preventDefault();


            formSubmitting = true;
            $('button[type="submit"] .spinner-border').css('display', 'inline-block');

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
