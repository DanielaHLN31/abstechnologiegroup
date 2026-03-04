<!-- Modal pour Ajouter une Marque -->
<div class="modal fade" id="exLargeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter une marque</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-repeater" id="brandForm" action="{{ route('store.brand') }}" method="POST">
                    @csrf

                    <div data-repeater-list="group-a">
                        <div data-repeater-item>
                            <div style="display: flex; justify-content: flex-end;">
                                <div class="d-flex align-items-center mb-0">
                                    <button class="btn btn-label-danger" data-repeater-delete>
                                        <i class="ti ti-x ti-xs me-1"></i>
                                        <span class="align-middle">Retirer</span>
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label required" for="nom_brand">Nom de la marque</label>
                                    <input
                                        type="text"
                                        name="nom"
                                        class="form-control"
                                        id="nom_brand"
                                        placeholder="Ex: Nike, Apple, Samsung, etc."
                                    />
                                    <div class="invalid-feedback error-message"></div>
                                </div>
                            </div>
                            <hr />
                        </div>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 20px">
                        <div>
                            <button type="button" class="btn btn-warning" data-repeater-create>
                                <i class="ti ti-plus me-1" style="font-size: 20px; font-weight: bold"></i>
                                <span class="align-middle">Ajouter une autre marque</span>
                            </button>
                        </div>
                    </div>
                    
                    <div style="display: flex; justify-content: flex-end;">
                        <button type="button" class="btn btn-label-secondary me-2" data-bs-dismiss="modal">
                            Annuler
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true" style="display: none;"></span>
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Fin du modal -->


<style>
    .is-invalid {
        border-color: #dc3545 !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }

    .required:after {
        content: " *";
        color: #dc3545;
    }

    /* Style pour le bouton d'ajout */
    .btn-warning {
        color: #fff;
        background-color: #ff9f43;
        border-color: #ff9f43;
    }

    .btn-warning:hover {
        color: #fff;
        background-color: #ff8a1f;
        border-color: #ff8a1f;
    }
</style>