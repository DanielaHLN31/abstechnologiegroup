<script>
    $(document).ready(function() {
        const selectedPermissions_edit = new Set(); // Ensemble global pour gérer les cases cochées

        const table = $("#permission-tableEdit").DataTable({
            responsive: true,
            autoWidth: false,
            paging: true,
            searching: true,
            info: false,
            language: {
                url: '{!!asset("backend/plugins/dataTable.french.lang")!!}'
            },
            lengthChange: false,
            lengthMenu: [10, 25, 50, 75, 100],
            // Ajout de cette option pour conserver l'état des cases à cocher
            stateSave: true
        });

        // Modification du modal pour préserver les sélections
        // Modification du gestionnaire de clic sur le bouton modifier
        $(document).on('click', 'a[data-bs-target="#ModifierRole"]', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');

            // Réinitialiser complètement l'état
            selectedPermissions_edit.clear();

            // Décocher toutes les cases
            $('input[name="permissions_edit[]"]').prop('checked', false);

            // Décocher le "Select All"
            $('#selectAllEdit').prop('checked', false);

            // Retourner à la première page
            table.page(0).draw('page');

            // Charger les nouvelles données
            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    if (response.role) {
                        $('#nameRoleEdit').val(response.role.name);
                        $('#idRole').val(response.role.id);

                        // Réinitialiser toutes les cases d'abord
                        $('input[name="permissions_edit[]"]').prop('checked', false);

                        // Cocher les permissions du rôle
                        response.rolePermissions.forEach(permissionName => {
                            selectedPermissions_edit.add(permissionName);
                            $(`input[name="permissions_edit[]"][value="${permissionName}"]`).prop('checked', true);
                        });

                        // Mettre à jour l'état de "Select All"
                        updateSelectAllState();
                    }
                },
                error: function (err) {
                    console.log(err);
                }
            });
        });

        // Gestion du bouton "Select All"
        $('#selectAllEdit').on('change', function() {
            const isChecked = $(this).is(':checked');
            table.rows({ search: 'applied' }).every(function() {
                const row = $(this.node());
                const checkbox = row.find('input[name="permissions_edit[]"]');
                const permissionId = checkbox.val();

                if (isChecked) {
                    selectedPermissions_edit.add(permissionId);
                } else {
                    selectedPermissions_edit.delete(permissionId);
                }

                //checkbox.prop('checked', isChecked); // Coche/décoche visuellement

                // Mettre à jour l'affichage des cases visibles
                $('input[name="permissions_edit[]"]').prop('checked', isChecked);
            });
        });

        // Fonction pour mettre à jour l'état du "Select All"
        function updateSelectAllState() {
            const visibleCheckboxes = table.rows({ search: 'applied' })
                .nodes()
                .find('input[name="permissions_edit[]"]');

            const allChecked = visibleCheckboxes.length > 0 &&
                visibleCheckboxes.filter(':checked').length === visibleCheckboxes.length;

            $('#selectAllEdit').prop('checked', allChecked);
        }


        // Gestion des cases à cocher individuelles
        $('#permission-tableEdit').on('change', 'input[name="permissions_edit[]"]', function() {
            const permissionName = $(this).val();
            if ($(this).is(':checked')) {
                selectedPermissions_edit.add(permissionName);
            } else {
                selectedPermissions_edit.delete(permissionName);
            }
        });

        // Synchronisation des cases cochées à chaque changement de page
        table.on('draw', function() {
            // Mettre à jour l'état des cases à cocher selon selectedPermissionsEdit
            $('input[name="permissions_edit[]"]').each(function() {
                const permissionName = $(this).val();
                $(this).prop('checked', selectedPermissions_edit.has(permissionName));
            });
        });

        $('#roleFormEdit').on('submit', function(e) {
            e.preventDefault(); // Empêche le rechargement de la page

            // var formData = form.serialize();

            // Créer un formulaire temporaire avec toutes les permissions sélectionnées
            const formData = new FormData(this);

            // Supprimer les anciennes permissions du FormData
            formData.delete('permissions_edit[]');

            // Ajouter toutes les permissions de selectedPermissionsEdit
            selectedPermissions_edit.forEach(permissionName => {
                formData.append('permissions_edit[]', permissionName);
            });

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: new URLSearchParams(formData),
                processData: false,
                dataType: 'json',
                success: function(response) {
                    console.log(response)
                    // Stocker les informations de notification dans la session côté client
                    sessionStorage.setItem('toastMessage', response.message);
                    sessionStorage.setItem('toastType', response['alert-type']);

                    // Rediriger vers l'URL fournie par le serveur
                    window.location.href = response.redirect_url;
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(function(key) {
                            errors[key].forEach(function(message) {
                                iziToast.error({
                                    title: 'Erreur',
                                    message: message,
                                    position: 'topRight',
                                    timeout: 5000,
                                    progressBar: true,
                                    closeOnClick: true,
                                    transitionIn: 'bounceInLeft',
                                });
                            });
                        });
                    } else {
                        iziToast.error({
                            title: 'Erreur',
                            message: 'Une erreur est survenue. Veuillez réessayer.',
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







    });
</script>
