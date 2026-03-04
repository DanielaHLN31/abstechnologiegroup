<!-- Modal pour Modifier  -->
<div class="modal fade" id="Modifierbrand" tabindex="-1" aria-hidden="true" >
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel4">Modifier une marque</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-repeater " id="roleFormEdit" action="{{ route('update.brand') }}" method="POST" >
                    @csrf

                    <input type="hidden" id="brand_id" name="brand_id" >

                    <div class="row g-2">
                        <div class="col mb-0">
                            <label class="form-label" for=" form-repeater-1-1">Nom </label>
                            <input
                                type="text"
                                name="nom"
                                class="form-control"
                                id="nom"
                                {{-- placeholder="John" --}}
                            />
                            <span class="text-danger"></span>
                        </div>
                    <div style="display: flex; justify-content: space-between;">
                        <div></div>
                        <div >
                            <button type="button" class="btn btn-label-secondary " data-bs-dismiss="modal">
                                Annuler
                            </button>
                            
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                            <span class="ms-1">Modifier</span>
                        </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Fin du Modal  -->
