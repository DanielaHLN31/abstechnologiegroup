<script>


    // Fonction pour charger les données dans le modal
    // Modification du gestionnaire de clic sur le bouton modifier
    $(document).on('click', 'a[data-bs-target="#Modifierbrand"]', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {

                if (response.brand) { 
                    $('#brand_id').val(response.brand.id);
                    $('#nom').val(response.brand.name);
                    

                }
            },
            error: function(xhr) {
                toastr.error('Erreur lors du chargement des données');
            }
        });
    });



    // Gestion des erreurs lors de la soumission du formulaire
    $('#roleFormEdit').on('submit', function(e) {
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
                    $('.text-danger').text('');
                    $('.form-control').removeClass('is-invalid');

                    var errors = xhr.responseJSON.errors;

                    $.each(errors, function(field, messages) {
                        if (field === 'edit_langue_parlee') {
                            $('#edit_langue_parlee').addClass('is-invalid');
                            $('#error_edit_langue_parlee').text(messages[0]);
                        } else {
                            var fieldElement = $('#' + field);
                            if (fieldElement.length) {
                                fieldElement.addClass('is-invalid');
                                fieldElement.next('.text-danger').text(messages[0]);
                            }
                        }
                    });

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
                    iziToast.error({
                        title: 'Erreur',
                        message: 'Une erreur est survenue lors de la mise à jour de l\'brand.',
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


    $('#edit_langue_parlee').on('change', function() {
    $(this).removeClass('is-invalid');
    $('#error_edit_langue_parlee').text('');
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
