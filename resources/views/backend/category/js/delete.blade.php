<script type="text/javascript">

    $(document).on('click', '.delete-category-btn', function (e) {
        e.preventDefault(); // Empêche le comportement par défaut du bouton

        const roleId = $(this).data('category-id'); // ID du rôle
        const csrfToken = $('meta[name="csrf-token"]').attr('content'); // CSRF Token

        // SweetAlert pour la confirmation
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "La suppression de l'category sera définitive !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Oui, Supprimer !',
            cancelButtonText: 'Annuler',
            customClass: {
                confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                cancelButton: 'btn btn-label-secondary waves-effect waves-light'
            },
            buttonsStyling: false
        }).then(function (result) {
            if (result.isConfirmed) {
                // Si l'utilisateur confirme, exécuter la requête AJAX
                $.ajax({
                    url: `/category/delete/${roleId}`, // URL du contrôle de suppression
                    type: 'GET', // Méthode DELETE pour respecter les conventions REST
                    data: {
                        _token: csrfToken // CSRF Token pour la sécurité
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Supprimé!',
                                text: response.message || 'L\'category a été supprimé avec succès.',
                                customClass: {
                                    confirmButton: 'btn btn-success waves-effect waves-light'
                                }
                            }).then(() => {
                                // Rafraîchir la page ou mettre à jour l'interface
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur!',
                                text: response.message || 'Une erreur est survenue lors de la suppression.',
                                customClass: {
                                    confirmButton: 'btn btn-danger waves-effect waves-light'
                                }
                            });
                        }
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur!',
                            text: xhr.responseJSON.message || 'Une erreur est survenue.',
                            customClass: {
                                confirmButton: 'btn btn-danger waves-effect waves-light'
                            }
                        });
                    }
                });
            }
        });
    });

</script>
