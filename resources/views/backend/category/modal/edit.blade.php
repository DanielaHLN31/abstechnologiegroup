
<!-- Modal pour Modifier une Catégorie -->
<div class="modal fade" id="Modifiercategory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel4">Modifier le type de dossier</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-repeater" id="categoryFormEdit" action="{{ route('update.category') }}" method="POST">
                    @csrf

                    <input type="hidden" id="category_id" name="category_id">

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label required" for="edit_nom">Nom de la catégorie</label>
                            <input
                                type="text"
                                name="nom"
                                class="form-control"
                                id="edit_nom"
                                placeholder="Ex: électroménager, etc."
                            />
                            <span class="text-danger error-message" id="error_edit_nom"></span>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label required" for="edit_description">Description</label>
                            <textarea
                                name="description"
                                class="form-control"
                                id="edit_description"
                                rows="4"
                                placeholder="Description du type de dossier..."
                            ></textarea>
                            <span class="text-danger error-message" id="error_edit_description"></span>
                        </div>
                    </div>
                    
                    <div style="display: flex; justify-content: flex-end;">
                        <button type="button" class="btn btn-label-secondary me-2" data-bs-dismiss="modal">
                            Annuler
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true" style="display: none;"></span>
                            Modifier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Fin du Modal -->