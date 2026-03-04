<!-- Modal pour Ajouter un Produit -->
<div class="modal fade" id="exLargeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un produit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-repeater" id="productForm" action="{{ route('store.products') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div data-repeater-list="group-a">
                        <div data-repeater-item>
                            <!-- Bouton retirer -->
                            <div style="display: flex; justify-content: flex-end;">
                                <div class="d-flex align-items-center mb-0">
                                    <button class="btn btn-label-danger" data-repeater-delete>
                                        <i class="ti ti-x ti-xs me-1"></i>
                                        <span class="align-middle">Retirer</span>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Informations de base -->
                            <div class="row g-2">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Nom du produit</label>
                                    <input
                                        type="text"
                                        name="name"
                                        class="form-control"
                                        placeholder="Ex: Smartphone X, Chaussure de sport..."
                                        required
                                    />
                                    <div class="invalid-feedback error-message"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Prix</label>
                                    <div class="input-group">
                                        <span class="input-group-text">FCFA</span>
                                        <input
                                            type="number"
                                            name="price"
                                            class="form-control"
                                            placeholder="15000"
                                            min="0"
                                            step="0.01"
                                            required
                                        />
                                    </div>
                                    <div class="invalid-feedback error-message"></div>
                                </div>
                            </div>
                            
                            <!-- Catégorie et Marque -->
                            <div class="row g-2">
                                <div class="col-md-6 mb-3">
                          <label
                            class="form-label required mb-1 d-flex justify-content-between align-items-center"
                            for="category-org">
                            <span>Catégorie</span><a href="javascript:void(0);" class="fw-medium">Add new category</a>
                          </label>
                                    {{-- <label class="form-label required">Catégorie</label> --}}
                                    <select name="category_id" class="form-select select2" required>
                                        <option value="">Sélectionnez une catégorie</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback error-message"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Marque</label>
                                    <select name="brand_id" class="form-select select2" required>
                                        <option value="">Sélectionnez une marque</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback error-message"></div>
                                </div>
                            </div>
                            
                            <!-- Description -->
                            {{-- <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label required">Description</label>
                                    <textarea
                                        name="description"
                                        class="form-control"
                                        rows="4"
                                        placeholder="Description détaillée du produit..."
                                        required
                                    ></textarea>
                                    <div class="invalid-feedback error-message"></div>
                                </div>
                            </div> --}}

                            
                        <div>
                          <label class="form-label required">Description</label>
                          <div class="form-control p-0 pt-1">
                            <div class="comment-toolbar border-0 border-bottom">
                              <div class="d-flex justify-content-start">
                                <span class="ql-formats me-0">
                                  <button class="ql-bold"></button>
                                  <button class="ql-italic"></button>
                                  <button class="ql-underline"></button>
                                  <button class="ql-list" value="ordered"></button>
                                  <button class="ql-list" value="bullet"></button>
                                  <button class="ql-link"></button>
                                  <button class="ql-image"></button>
                                </span>
                              </div>
                            </div>
                            <div class="comment-editor border-0 pb-4" id="ecommerce-category-description"></div>
                          </div>
                        </div>
                            
                            <!-- Images (Upload multiple) -->
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label required">Images du produit</label>
                                    <div class="upload-container border rounded p-3">
                                        <div class="d-flex align-items-center justify-content-center flex-column">
                                            <i class="ti ti-photo ti-3x text-muted mb-2"></i>
                                            <p class="mb-1">Glissez-déposez vos images ici ou</p>
                                            <small class="text-muted mt-2 mb-2">Formats: JPEG, PNG, JPG, GIF, WEBP (Max 2 Mo)</small>
                                            <label class="btn btn-outline-primary btn-sm">
                                                <i class="ti ti-plus" style="font-size: xxx-large"></i>
                                                <input
                                                    type="file"
                                                    name="images[]"
                                                    class="d-none file-upload-input"
                                                    accept="image/*"
                                                    multiple
                                                    required
                                                />
                                            </label>
                                        </div>
                                        <div class="image-preview-container row mt-3"></div>
                                    </div>
                                    <div class="invalid-feedback error-message"></div>
                                </div>
                            </div>



                            {{-- ===== SECTION COULEURS ===== --}}
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <label class="form-label">Couleurs disponibles</label>
                                    <div class="colors-repeater-container border rounded p-3">
                                        <div data-nested-list="colors">
                                            <div id="colors-list-container"></div>

                                            <div class="nested-template" style="display:none !important">
                                                <div class="nested-item color-item mb-3 border rounded p-2">
                                                    <div class="row g-2 align-items-end color-fields-row">
                                                        <div class="col-md-3">
                                                            <label class="form-label small">Couleur existante</label>
                                                            <select
                                                                data-nested-name="[__IDX__][id]"
                                                                class="form-select form-select-sm existing-color-select">
                                                                <option value="">-- Créer nouvelle --</option>
                                                                @foreach($colors ?? [] as $color)
                                                                    <option value="{{ $color->id }}" data-code="{{ $color->code }}">
                                                                        {{ $color->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label small">Couleur personnalisée</label>
                                                            <div class="d-flex gap-2 align-items-center">
                                                                <input
                                                                    type="color"
                                                                    data-nested-name="[__IDX__][code]"
                                                                    class="form-control form-control-color color-code-input flex-shrink-0"
                                                                    style="width:42px;height:31px;padding:2px"
                                                                    value="#3a86ff"
                                                                />
                                                                <input
                                                                    type="text"
                                                                    data-nested-name="[__IDX__][name]"
                                                                    class="form-control form-control-sm color-name-input"
                                                                    placeholder="Nom (ex: Bleu nuit)"
                                                                />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label small">Stock pour cette couleur</label>
                                                            <input
                                                                type="number"
                                                                data-nested-name="[__IDX__][stock_quantity]"
                                                                class="form-control form-control-sm color-stock-input"
                                                                placeholder="0" min="0" value="0"
                                                            />
                                                        </div>
                                                        <div class="col-md-2 d-flex align-items-end">
                                                            <button type="button" class="btn btn-label-danger btn-sm w-100" data-nested-delete>
                                                                <i class="ti ti-trash me-1"></i>Retirer
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button"
                                                    class="btn btn-outline-primary btn-sm mt-2"
                                                    data-nested-create="colors">
                                                <i class="ti ti-plus me-1"></i>Ajouter une couleur
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- ===== SECTION SPÉCIFICATIONS ===== --}}
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <label class="form-label">Spécifications et badges</label>
                                    <div class="specifications-repeater-container border rounded p-3">
                                        <div data-nested-list="specifications">
                                            <div id="specifications-list-container"></div>

                                            <div class="nested-template" style="display:none !important">
                                                <div class="nested-item specification-item mb-2 border rounded p-2">
                                                    <div class="row g-2 align-items-end">
                                                        <div class="col-md-5">
                                                            <label class="form-label small">Caractéristique</label>
                                                            <input
                                                                type="text"
                                                                data-nested-name="[__IDX__][name]"
                                                                class="form-control form-control-sm"
                                                                placeholder="Ex: Taille, Matière, Poids"
                                                            />
                                                        </div>
                                                        <div class="col-md-5">
                                                            <label class="form-label small">Valeur</label>
                                                            <input
                                                                type="text"
                                                                data-nested-name="[__IDX__][value]"
                                                                class="form-control form-control-sm"
                                                                placeholder="Ex: XL, Coton, 200g"
                                                            />
                                                        </div>
                                                        <div class="col-md-2 d-flex align-items-end">
                                                            <button type="button" class="btn btn-label-danger btn-sm w-100" data-nested-delete>
                                                                <i class="ti ti-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button"
                                                    class="btn btn-outline-primary btn-sm mt-2"
                                                    data-nested-create="specifications">
                                                <i class="ti ti-plus me-1"></i>Ajouter une spécification
                                            </button>
                                        </div>
                                    </div>
                                    <small class="text-muted">Les badges apparaîtront en évidence sur la fiche produit</small>
                                </div>
                            </div>


                            {{-- ===== SECTION STOCK (remplacer dans l'accordéon) ===== --}}
                            <div class="accordion-body">
                                <div class="row g-2">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            Quantité en stock
                                            <small class="text-muted ms-1 stock-auto-label" style="display:none">
                                                — <i class="ti ti-calculator ti-xs"></i> calculé automatiquement
                                            </small>
                                        </label>
                                        <input
                                            type="number"
                                            name="stock_quantity"
                                            class="form-control total-stock-input"
                                            placeholder="0" min="0" step="1" value="0"
                                        />
                                        <small class="text-muted">Si des couleurs ont un stock, ce champ est mis à jour automatiquement.</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Seuil de stock bas</label>
                                        <input
                                            type="number"
                                            name="low_stock_threshold"
                                            class="form-control"
                                            placeholder="5" min="0" step="1" value="5"
                                        />
                                    </div>
                                </div>
                            </div>



                            <hr />
                        </div>
                    </div>
                    
                    <!-- Bouton pour ajouter un autre produit -->
                    <div style="display: flex; justify-content: space-between; margin-bottom: 20px">
                        <div>
                            <button type="button" class="btn btn-warning" data-repeater-create>
                                <i class="ti ti-plus me-1"></i>
                                Ajouter un autre produit
                            </button>
                        </div>
                    </div>
                    
                    <!-- Boutons d'action -->
                    <div style="display: flex; justify-content: flex-end;">
                        <button type="button" class="btn btn-label-secondary me-2" data-bs-dismiss="modal">
                            Annuler
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span class="spinner-border spinner-border-sm me-1" style="display: none;"></span>
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- ===== CSS À AJOUTER ===== --}}
<style>
    /* Champ stock en mode auto-calculé */
    .total-stock-input[readonly] {
        background-color: #f0f4ff;
        border-color: #696cff;
        color: #696cff;
        font-weight: 600;
        cursor: not-allowed;
    }

    /* Erreurs */
    .is-invalid {
        border-color: #dc3545 !important;
    }
    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }
</style>