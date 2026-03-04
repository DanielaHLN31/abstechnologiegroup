<script>

    // Modification du gestionnaire de soumission du formulaire
    $(document).on('click', '.active-role-btn', function (e) {
        e.preventDefault();

        const roleId = $(this).data('role-id'); // ID du rôle
        const csrfToken = $('meta[name="csrf-token"]').attr('content'); // CSRF Token

        $.ajax({
            url: `/roles/active/${roleId}`, // URL du contrôle de suppression
            type: 'GET', // Méthode DELETE pour respecter les conventions REST
            data: {
                _token: csrfToken // CSRF Token pour la sécurité
            },
            success: function(response) {
                show_alert(response['alert-type'], response.message);
                window.location.href = response.redirect_url;
            },
            error: function(xhr) {
                show_error(xhr);
            }
        });
    });

</script>
