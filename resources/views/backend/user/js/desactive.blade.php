<script>

    // Modification du gestionnaire de soumission du formulaire
    $(document).on('click', '.desactive-user-btn', function (e) {
        e.preventDefault();

        const userId = $(this).data('user-id'); // ID du rôle
        const csrfToken = $('meta[name="csrf-token"]').attr('content'); // CSRF Token

        $.ajax({
            url: `/users/inactive/${userId}`, // URL du contrôle de suppression
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
