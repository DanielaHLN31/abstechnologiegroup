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
        $(document).on('input', '#categoryForm input, #categoryForm textarea', function() {
            // Supprimer la classe d'erreur
            $(this).removeClass('is-invalid');

            // Supprimer le message d'erreur
            $(this).next('.error-message').remove();
        });

        // Gérer la soumission du formulaire
        $('#categoryForm').on('submit', function(e) {
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
                            // Gérer les erreurs pour les champs répétés (group-a)
                            if (key.includes('group-a.')) {
                                // Extraire l'index et le nom du champ
                                const matches = key.match(/group-a\.(\d+)\.(\w+)/);
                                if (matches) {
                                    const index = matches[1];
                                    const fieldName = matches[2];

                                    if (fieldName === 'langue_parlee') {
                                    // Gestion spécifique pour le champ langue_parlee
                                    const field = $(`[name="group-a[${index}][langue_parlee][]"]`);
                                    field.addClass('is-invalid');
                                    field.after(`<div class="invalid-feedback error-message">${errors[key][0]}</div>`);
                                    } else {
                                        // Gérer les autres champs
                                        const field = $(`[name="group-a[${index}][${fieldName}]"]`);
                                        field.addClass('is-invalid');
                                        field.after(`<div class="invalid-feedback error-message">${errors[key][0]}</div>`);
                                    }
                                }
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

        // Effacer les erreurs lors du changement du select
        $(document).on('change', '[name$="[langue_parlee][]"]', function() {
            $(this).closest('.col').find('.error-message').remove();
            $(this).removeClass('is-invalid');
            $(this).closest('.col').find('.select2-container').removeClass('is-invalid');
        });

        // Re-initialiser les erreurs lors de l'ajout d'un nouvel élément
        $(document).on('click', '[data-repeater-create]', function() {
            formSubmitting = false;
            setTimeout(function() {
                $('[data-repeater-list]').find('[data-repeater-item]').last().find('input, textarea, select').each(function() {
                    // Pour les inputs et textareas
                    if ($(this).is('input, textarea')) {
                        $(this).removeClass('is-invalid');
                        $(this).next('.error-message').remove();
                    }
                    
                    // Pour les selects (y compris langue parlée)
                    if ($(this).is('select')) {
                        $(this).removeClass('is-invalid');
                        $(this).closest('.col').find('.error-message').remove();
                        $(this).closest('.col').find('.select2-container').removeClass('is-invalid');
                    }
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

    $('.form-control, .form-select').on('input change', function() {
        var fieldElement = $(this);
        var errorMessage = fieldElement.next('.text-danger');

        if (fieldElement.hasClass('is-invalid')) {
            fieldElement.removeClass('is-invalid');
            errorMessage.text('');
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
