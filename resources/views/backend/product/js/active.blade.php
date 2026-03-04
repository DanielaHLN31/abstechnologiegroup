<script>
$(document).ready(function() {

    // ================================================================
    // CHANGEMENT DE STATUT (PUBLIER / ARCHIVER)
    // ================================================================
    $(document).on('click', '.toggle-status-btn', function (e) {
        e.preventDefault();

        const productId = $(this).data('product-id');
        const action = $(this).data('action'); // 'publish' ou 'archive'
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Déterminer le message de confirmation
        const actionText = action === 'publish' ? 'publier' : 'archiver';
        const confirmationMessage = `Êtes-vous sûr de vouloir ${actionText} ce produit ?`;

        Swal.fire({
            title: 'Confirmation',
            text: confirmationMessage,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Oui',
            cancelButtonText: 'Annuler',
            customClass: {
                confirmButton: 'btn btn-primary me-3',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                // Afficher le loader
                Swal.fire({
                    title: 'Traitement en cours...',
                    text: 'Veuillez patienter',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: `/products/${productId}/status`,
                    type: 'POST',
                    data: {
                        _token: csrfToken,
                        action: action
                    },
                    success: function(response) {
                        Swal.close();
                        
                        if (response.success) {
                            // Afficher le message de succès
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                // Rafraîchir la page ou mettre à jour l'UI
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.close();
                        
                        let errorMessage = 'Une erreur est survenue.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: errorMessage
                        });
                    }
                });
            }
        });
    });

    // ================================================================
    // SUPPRESSION D'UN PRODUIT (à garder si vous en avez besoin)
    // ================================================================
    $(document).on('click', '.delete-product-btn', function (e) {
        e.preventDefault();

        const productId = $(this).data('product-id');
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Cette action est irréversible !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler',
            customClass: {
                confirmButton: 'btn btn-danger me-3',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/products/delete/${productId}`,
                    type: 'DELETE',
                    data: {
                        _token: csrfToken
                    },
                    success: function(response) {
                        show_alert(response['alert-type'], response.message);
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    },
                    error: function(xhr) {
                        show_error(xhr);
                    }
                });
            }
        });
    });

    // ================================================================
    // FONCTIONS UTILITAIRES (à adapter selon votre configuration)
    // ================================================================
    function show_alert(type, message) {
        if (type === 'success') {
            iziToast.success({
                title: 'Succès',
                message: message,
                position: 'topRight',
                timeout: 3000
            });
        } else {
            iziToast.error({
                title: 'Erreur',
                message: message,
                position: 'topRight',
                timeout: 3000
            });
        }
    }

    function show_error(xhr) {
        let message = 'Une erreur est survenue.';
        if (xhr.responseJSON && xhr.responseJSON.message) {
            message = xhr.responseJSON.message;
        }
        
        iziToast.error({
            title: 'Erreur',
            message: message,
            position: 'topRight',
            timeout: 5000
        });
    }

});
</script>