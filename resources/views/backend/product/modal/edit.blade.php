{{-- ================================================================
     MODAL MODIFIER UN PRODUIT — version complète avec couleurs/specs
     ================================================================ --}}
<div class="modal fade" id="Modifierproduct" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier un produit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Loader --}}
            <div id="edit-modal-loader" class="text-center py-5" style="display:none">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-2 text-muted">Chargement...</p>
            </div>

            <div class="modal-body" id="edit-modal-body">
                <form id="productEditForm"
                      action="{{ route('update.products') }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    {{-- <input type="hidden" name="_method" value="PUT"> --}}
                    <input type="hidden" id="edit_product_id" name="product_id">

                    {{-- ── Informations de base ──────────────────── --}}
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Nom du produit</label>
                            <input type="text" name="name" id="edit_name" class="form-control" placeholder="Ex: Smartphone X" />
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Prix</label>
                            <div class="input-group">
                                <span class="input-group-text">FCFA</span>
                                <input type="number" name="price" id="edit_price" class="form-control" min="0" step="0.01" />
                            </div>
                            <div class="invalid-feedback"></div>
                        </div>
                        {{-- <div class="col-md-3 mb-3">
                            <label class="form-label">Prix barré (promo)</label>
                            <div class="input-group">
                                <span class="input-group-text">FCFA</span>
                                <input type="number" name="compare_price" id="edit_compare_price" class="form-control" min="0" step="0.01" />
                            </div>
                            <div class="invalid-feedback"></div>
                        </div> --}}
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Catégorie</label>
                            <select name="category_id" id="edit_category_id" class="form-select" required>
                                <option value="">Sélectionnez une catégorie</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Marque</label>
                            <select name="brand_id" id="edit_brand_id" class="form-select" required>
                                <option value="">Sélectionnez une marque</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    {{-- ── Description ──────────────────────────── --}}
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label required">Description</label>
                            <textarea name="description" id="edit_description" class="form-control" rows="4"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    {{-- ── Images existantes + nouvelles ────────── --}}
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Images actuelles</label>
                            <div id="edit-existing-images" class="row g-2 mb-2"></div>
                            <label class="form-label">Ajouter de nouvelles images</label>
                            <div class="upload-container border rounded p-3">
                                <div class="d-flex align-items-center justify-content-center flex-column">
                                    <i class="ti ti-photo ti-3x text-muted mb-2"></i>
                                    <small class="text-muted mb-2">JPEG, PNG, JPG, GIF, WEBP (Max 2 Mo)</small>
                                    <label class="btn btn-outline-primary btn-sm">
                                        <i class="ti ti-plus"></i> Parcourir
                                        <input type="file" name="new_images[]" class="d-none file-upload-input-edit" accept="image/*" multiple />
                                    </label>
                                </div>
                                <div class="image-preview-container-edit row mt-3"></div>
                            </div>
                        </div>
                    </div>

                    {{-- ── Couleurs ──────────────────────────────── --}}
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="form-label">Couleurs disponibles</label>
                            <div class="border rounded p-3">
                                {{-- Liste des couleurs existantes + nouvelles --}}
                                <div id="edit-colors-list"></div>

                                {{-- Template couleur (caché) --}}
                                <div id="edit-color-template" style="display:none !important">
                                    <div class="edit-color-item mb-3 border rounded p-2">
                                        <div class="row g-2 align-items-end">
                                            <input type="hidden" data-field="color_db_id" value="">
                                            {{-- <div class="col-md-3">
                                                <label class="form-label small">Couleur existante</label>
                                                <select data-field="color_id" class="form-select form-select-sm edit-existing-color-select">
                                                    <option value="">-- Créer nouvelle --</option>
                                                    @foreach($colors ?? [] as $color)
                                                        <option value="{{ $color->id }}" data-code="{{ $color->code }}">{{ $color->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div> --}}
                                            <div class="col-md-6">
                                                <label class="form-label small">Couleur personnalisée</label>
                                                <div class="d-flex gap-2 align-items-center">
                                                    <input type="color" data-field="color_code"
                                                           class="form-control form-control-color edit-color-code"
                                                           style="width:42px;height:31px;padding:2px" value="#3a86ff" />
                                                    <input type="text" data-field="color_name"
                                                           class="form-control form-control-sm edit-color-name"
                                                           placeholder="Nom (ex: Bleu nuit)" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label small">Stock</label>
                                                <input type="number" data-field="color_stock"
                                                       class="form-control form-control-sm edit-color-stock"
                                                       placeholder="0" min="0" value="0" />
                                            </div>
                                            <div class="col-md-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-label-danger btn-sm w-100 remove-edit-color">
                                                    <i class="ti ti-trash me-1"></i>Retirer
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-edit-color">
                                    <i class="ti ti-plus me-1"></i>Ajouter une couleur
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- ── Spécifications ────────────────────────── --}}
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="form-label">Spécifications</label>
                            <div class="border rounded p-3">
                                <div id="edit-specs-list"></div>

                                <div id="edit-spec-template" style="display:none !important">
                                    <div class="edit-spec-item mb-2 border rounded p-2">
                                        <div class="row g-2 align-items-end">
                                            <input type="hidden" data-field="spec_db_id" value="">
                                            <div class="col-md-5">
                                                <label class="form-label small">Caractéristique</label>
                                                <input type="text" data-field="spec_name"
                                                       class="form-control form-control-sm"
                                                       placeholder="Ex: Taille, Matière" />
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label small">Valeur</label>
                                                <input type="text" data-field="spec_value"
                                                       class="form-control form-control-sm"
                                                       placeholder="Ex: XL, Coton" />
                                            </div>
                                            <div class="col-md-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-label-danger btn-sm w-100 remove-edit-spec">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-edit-spec">
                                    <i class="ti ti-plus me-1"></i>Ajouter une spécification
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- ── Stock & Statut ────────────────────────── --}}
                    <div class="row g-3 mt-2">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">
                                Quantité en stock
                                <small class="text-muted ms-1 edit-stock-auto-label" style="display:none">
                                    — <i class="ti ti-calculator ti-xs"></i> auto
                                </small>
                            </label>
                            <input type="number" name="stock_quantity" id="edit_stock_quantity"
                                   class="form-control" min="0" value="0" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Seuil de stock bas</label>
                            <input type="number" name="low_stock_threshold" id="edit_low_stock_threshold"
                                   class="form-control" min="0" value="5" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Statut</label>
                            <select name="status" id="edit_status" class="form-select">
                                <option value="draft">Brouillon</option>
                                <option value="published">Publié</option>
                                <option value="archived">Archivé</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_featured" id="edit_is_featured"
                                       class="form-check-input" value="1" />
                                <label class="form-check-label" for="edit_is_featured">Mettre en avant (produit vedette)</label>
                            </div>
                        </div>
                    </div>

                    {{-- ── SEO ───────────────────────────────────── --}}
                    {{-- <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Meta titre</label>
                            <input type="text" name="meta_title" id="edit_meta_title" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Meta description</label>
                            <textarea name="meta_description" id="edit_meta_description" class="form-control" rows="2"></textarea>
                        </div>
                    </div> --}}

                    {{-- ── Boutons ───────────────────────────────── --}}
                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" id="edit-submit-btn">
                            <span class="spinner-border spinner-border-sm me-1" style="display:none"></span>
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>