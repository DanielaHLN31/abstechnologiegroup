<!-- Modal pour Ajouter une Catégorie -->
<div class="modal fade" id="exLargeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel4">Ajouter un type de dossier</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-repeater" id="categoryForm" action="{{ route('store.category') }}" method="POST">
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
                                    <label class="form-label required" for="nom">Nom de la category</label>
                                    <input
                                        type="text"
                                        name="nom"
                                        class="form-control"
                                        id="nom"
                                        placeholder="Ex: électroménéger, etc."
                                    />
                                    <span class="text-danger error-message" id="error_nom"></span>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label required" for="description">Description</label>
                                    <textarea
                                        name="description"
                                        class="form-control"
                                        id="description"
                                        rows="4"
                                        placeholder="Description de la catégorie..."
                                    ></textarea>
                                    <span class="text-danger error-message" id="error_description"></span>
                                </div>
                            </div>
                            <hr />
                        </div>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 20px">
                        <div>
                            <button type="button" class="btn btn-warning" data-repeater-create id="addo1">
                                <i class="ti ti-plus me-1" style="font-size: 20px; font-weight: bold"></i>
                                <span class="align-middle">Ajouter un autre type</span>
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
