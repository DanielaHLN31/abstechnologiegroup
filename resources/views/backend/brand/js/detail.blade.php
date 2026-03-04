<script>
    $(document).on('click', '.details-brand-btn', function(e) {
    e.preventDefault();
    let brandId = $(this).data('brand-details-id');
    
    $.ajax({
        url: `/brands/show/brands/${brandId}`,
        method: 'GET',
        success: function(response) {
            if (response.brand) {
                let brand = response.brand;
                
                // Formater la date
                let datePrestation = new Date(brand.date_prestation_serment).toLocaleDateString('fr-FR');
                
                // Créer le HTML pour le contenu
                let content = `
                <div class="text-left">
                    <div class="card border-0">
                        <div class="card-body p-0">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold text-primary" width="40%">Nom complet</td>
                                        <td>${brand.name}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>`;

                // Afficher la boîte de dialogue SweetAlert2
                Swal.fire({
                    title: '<h3 class="text-primary">Détails de l\'brand</h3>',
                    html: content,
                    width: '700px',
                    showClass: {
                        popup: 'animate__animated animate__bounceIn'
                    },
                    customClass: {
                        title: 'text-end',  
                        confirmButton: 'btn btn-primary waves-effect waves-light'
                    },
                    buttonsStyling: false,
                    confirmButtonText: 'Fermer'
                });

            }
        },
        error: function(xhr, status, error) {
        console.error('Status:', status);
        console.error('Error:', error);
        console.error('Response:', xhr.responseText);
        
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: `Erreur: ${status} - ${error}\nDétails: ${xhr.responseText}`,
            customClass: {
                confirmButton: 'btn btn-primary waves-effect waves-light'
            },
            buttonsStyling: false
        });
    }
    });
});
</script>