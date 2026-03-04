<script>
    $(document).ready(function() {
        const selectedPermissions = new Set(); // Ensemble global pour gérer les cases cochées

        const table = $("#permission-table").DataTable({
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
            stateSave: true // Ajout de cette option comme dans le script de modification
        });

        // Gestion du bouton "Select All"
        $('#selectAll').on('change', function() {
            const isChecked = $(this).is(':checked');
            table.rows({ search: 'applied' }).every(function() {
                const row = $(this.node());
                const checkbox = row.find('input[name="permissions[]"]');
                const permissionId = checkbox.val();

                if (isChecked) {
                    selectedPermissions.add(permissionId);
                } else {
                    selectedPermissions.delete(permissionId);
                }

                checkbox.prop('checked', isChecked);
            });
        });

        // Synchronisation des cases cochées à chaque changement de page
        table.on('draw', function() {
            $('input[name="permissions[]"]').each(function() {
                const permissionId = $(this).val();
                $(this).prop('checked', selectedPermissions.has(permissionId));
            });
        });

        // Gestion manuelle des cases individuelles
        $('#permission-table').on('change', 'input[name="permissions[]"]', function() {
            const permissionId = $(this).val();
            if ($(this).is(':checked')) {
                selectedPermissions.add(permissionId);
            } else {
                selectedPermissions.delete(permissionId);
            }
        });

        // Modification du gestionnaire de soumission du formulaire
        $('#roleForm').on('submit', function(e) {
            e.preventDefault();

            // Créer un nouveau FormData
            const formData = new FormData(this);

            // Supprimer les anciennes permissions du FormData
            formData.delete('permissions[]');

            // Ajouter toutes les permissions sélectionnées du Set
            selectedPermissions.forEach(permission => {
                formData.append('permissions[]', permission);
            });

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: new URLSearchParams(formData),
                processData: false,
                dataType: 'json',
                success: function(response) {
                    show_alert(response['alert-type'], response.message);
                    window.location.href = response.redirect_url;
                },
                error: function(xhr) {
                    show_error(xhr);
                }
            });
        });
    });
</script>
