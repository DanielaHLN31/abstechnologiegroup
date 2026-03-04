<script>
$(document).ready(function () {

    // ================================================================
    // SELECT2 dans le modal d'édition
    // ================================================================
    function initEditSelect2() {
        $('#edit_category_id, #edit_brand_id').select2({
            dropdownParent: $('#Modifierproduct'),
            width: '100%'
        });
    }

    // Init au chargement (le modal existe déjà dans le DOM)
    $('#Modifierproduct').on('shown.bs.modal', function () {
        // S'assurer que Select2 est bien initialisé à chaque ouverture
        initEditSelect2();
    });

    // ================================================================
    // OUVERTURE DU MODAL — charger les données
    // ================================================================
    $(document).on('click', 'a[data-bs-target="#Modifierproduct"]', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');

        // Reset visuel
        $('#edit-modal-body').hide();
        $('#edit-modal-loader').show();
        clearEditErrors();
        $('#edit-existing-images').empty();
        $('.image-preview-container-edit').empty();
        $('#edit-colors-list').empty();
        $('#edit-specs-list').empty();
        const editInput = $('.file-upload-input-edit')[0];
        if (editInput) editInput._storedFiles = [];

        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {
                $('#edit-modal-loader').hide();
                $('#edit-modal-body').show();
                if (!response.product) return;

                fillEditForm(response.product);
            },
            error: function () {
                $('#edit-modal-loader').hide();
                $('#edit-modal-body').show();
                iziToast.error({ title: 'Erreur', message: 'Impossible de charger les données.', position: 'topRight' });
            }
        });
    });

    // ================================================================
    // REMPLISSAGE DU FORMULAIRE
    // ================================================================
    function fillEditForm(p) {

        // ── Champs simples ───────────────────────────────────────────
        $('#edit_product_id').val(p.id);
        $('#edit_name').val(p.name);
        $('#edit_price').val(p.price);
        $('#edit_compare_price').val(p.compare_price || '');
        $('#edit_description').val(p.description);
        $('#edit_stock_quantity').val(p.stock_quantity);
        $('#edit_low_stock_threshold').val(p.low_stock_threshold || 5);
        $('#edit_status').val(p.status || 'draft');
        $('#edit_is_featured').prop('checked', p.is_featured == 1);
        $('#edit_meta_title').val(p.meta_title || '');
        $('#edit_meta_description').val(p.meta_description || '');

        // ── Select2 — catégorie & marque ─────────────────────────────
        // IMPORTANT : utiliser .val(...).trigger('change') après init Select2
        // Le timeout garantit que Select2 est initialisé sur le modal ouvert
        setTimeout(function () {
            $('#edit_category_id').val(p.category_id).trigger('change');
            $('#edit_brand_id').val(p.brand_id).trigger('change');
        }, 100);

        // ── Images existantes ────────────────────────────────────────
        if (p.images && p.images.length > 0) {
            p.images.forEach(function (img) {
                const badge = img.is_primary
                    ? '<span class="badge bg-primary position-absolute top-0 start-0 m-1" style="font-size:9px">Principale</span>'
                    : '';
                $('#edit-existing-images').append(`
                    <div class="col-md-2 col-sm-3 col-4" data-image-id="${img.id}">
                        <div class="position-relative">
                            <img src="/storage/${img.image_path}"
                                 class="img-fluid rounded border"
                                 style="height:80px;width:100%;object-fit:cover">
                            ${badge}
                            <button type="button"
                                    class="btn btn-xs btn-danger position-absolute top-0 end-0 m-1 delete-existing-image"
                                    title="Supprimer">
                                <i class="ti ti-x"></i>
                            </button>
                            <input type="hidden" name="existing_images[]" value="${img.id}">
                        </div>
                    </div>`);
            });
        } else {
            $('#edit-existing-images').html('<p class="text-muted small mb-1">Aucune image enregistrée</p>');
        }

        // ── Couleurs existantes ──────────────────────────────────────
        if (p.colors && p.colors.length > 0) {
            p.colors.forEach(function (color) {
                addEditColorItem({
                    db_id:          color.id,        // ID de la couleur dans table colors
                    color_id:       color.id,        // sélectionner dans la liste existante
                    color_name:     color.name,
                    color_code:     color.code || '#3a86ff',
                    stock_quantity: color.pivot ? color.pivot.stock_quantity : 0
                });
            });
        }

        // ── Spécifications existantes ────────────────────────────────
        if (p.specifications && p.specifications.length > 0) {
            p.specifications.forEach(function (spec) {
                addEditSpecItem({
                    db_id: spec.id,
                    name:  spec.name,
                    value: spec.value || ''
                });
            });
        }

        // ── Recalc stock depuis couleurs si besoin ───────────────────
        recalcEditStock();
    }

    // ================================================================
    // COULEURS — ajouter un item (existant ou nouveau)
    // ================================================================
    function addEditColorItem(data) {
        data = data || {};
        const $tpl   = $('#edit-color-template').clone(true);
        const $item  = $tpl.children('.edit-color-item').clone(true);

        $item.find('[data-field="color_db_id"]').val(data.db_id || '');
        $item.find('[data-field="color_stock"]').val(data.stock_quantity || 0);

        if (data.color_id) {
            // Couleur existante → sélectionner dans le select
            $item.find('[data-field="color_id"]').val(data.color_id);
            $item.find('[data-field="color_name"]').val(data.color_name || '').prop('readonly', true);
            $item.find('[data-field="color_code"]').val(data.color_code || '#3a86ff').prop('readonly', true);
        } else {
            $item.find('[data-field="color_name"]').val(data.color_name || '');
            $item.find('[data-field="color_code"]').val(data.color_code || '#3a86ff');
        }

        $('#edit-colors-list').append($item);
    }

    // Bouton "Ajouter une couleur"
    $(document).on('click', '#add-edit-color', function (e) {
        e.preventDefault();
        addEditColorItem();
        recalcEditStock();
    });

    // Bouton "Retirer" une couleur
    $(document).on('click', '.remove-edit-color', function () {
        $(this).closest('.edit-color-item').slideUp(200, function () {
            $(this).remove();
            recalcEditStock();
        });
    });

    // Sélection d'une couleur existante dans le select
    $(document).on('change', '.edit-existing-color-select', function () {
        const $item = $(this).closest('.edit-color-item');
        const $opt  = $(this).find('option:selected');
        if ($(this).val()) {
            $item.find('[data-field="color_name"]').val($opt.text()).prop('readonly', true);
            $item.find('[data-field="color_code"]').val($opt.data('code') || '#000000').prop('readonly', true);
        } else {
            $item.find('[data-field="color_name"]').val('').prop('readonly', false);
            $item.find('[data-field="color_code"]').val('#3a86ff').prop('readonly', false);
        }
    });

    // Palette → nom auto
    $(document).on('input', '.edit-color-code', function () {
        const $item = $(this).closest('.edit-color-item');
        const $name = $item.find('[data-field="color_name"]');
        const $sel  = $item.find('.edit-existing-color-select');
        if ($sel.val()) { $sel.val(''); $name.prop('readonly', false); }
        if (!$name.val() || /^#[0-9A-Fa-f]{6}$/.test($name.val())) $name.val($(this).val());
    });

    // Stock par couleur → recalc total
    $(document).on('input', '.edit-color-stock', function () {
        recalcEditStock();
    });

    function recalcEditStock() {
        let total = 0, hasAny = false;
        $('#edit-colors-list .edit-color-item').each(function () {
            total += parseInt($(this).find('[data-field="color_stock"]').val()) || 0;
            hasAny = true;
        });
        const $stockInput = $('#edit_stock_quantity');
        const $label      = $('.edit-stock-auto-label');
        if (hasAny) {
            $stockInput.val(total).prop('readonly', true).addClass('stock-auto-mode');
            $label.show();
        } else {
            $stockInput.prop('readonly', false).removeClass('stock-auto-mode');
            $label.hide();
        }
    }

    // ================================================================
    // SPÉCIFICATIONS — ajouter un item
    // ================================================================
    function addEditSpecItem(data) {
        data = data || {};
        const $tpl  = $('#edit-spec-template').clone(true);
        const $item = $tpl.children('.edit-spec-item').clone(true);
        $item.find('[data-field="spec_db_id"]').val(data.db_id || '');
        $item.find('[data-field="spec_name"]').val(data.name || '');
        $item.find('[data-field="spec_value"]').val(data.value || '');
        $('#edit-specs-list').append($item);
    }

    $(document).on('click', '#add-edit-spec', function (e) {
        e.preventDefault();
        addEditSpecItem();
    });

    $(document).on('click', '.remove-edit-spec', function () {
        $(this).closest('.edit-spec-item').slideUp(200, function () { $(this).remove(); });
    });

    // ================================================================
    // IMAGES EXISTANTES — supprimer visuellement
    // ================================================================
    $(document).on('click', '.delete-existing-image', function () {
        const $card    = $(this).closest('[data-image-id]');
        const imageId  = $card.data('image-id');

        Swal.fire({
            title: 'Retirer cette image ?', icon: 'warning', showCancelButton: true,
            confirmButtonText: 'Oui', cancelButtonText: 'Annuler',
            customClass: { confirmButton: 'btn btn-danger me-3', cancelButton: 'btn btn-label-secondary' },
            buttonsStyling: false
        }).then(r => {
            if (r.isConfirmed) {
                // Enregistrer l'ID à supprimer côté serveur
                $('#productEditForm').append(
                    `<input type="hidden" name="deleted_images[]" value="${imageId}" class="deleted-image-input">`
                );
                $card.fadeOut(200, () => $card.remove());
            }
        });
    });

    // ================================================================
    // NOUVELLES IMAGES — aperçu cumulatif
    // ================================================================
    $(document).on('change', '.file-upload-input-edit', function () {
        const inputEl = this, $uc = $(this).closest('.upload-container');
        const merged  = [...(inputEl._storedFiles || [])];
        Array.from(inputEl.files).forEach(f => {
            if (!merged.some(e => e.name === f.name && e.size === f.size)) merged.push(f);
        });
        inputEl._storedFiles = merged;
        const dt = new DataTransfer();
        merged.forEach(f => dt.items.add(f));
        inputEl.files = dt.files;
        rebuildEditPreviews(inputEl, $uc.find('.image-preview-container-edit'));
    });

    function rebuildEditPreviews(inputEl, $preview) {
        $preview.empty();
        (inputEl._storedFiles || []).forEach(function (file, idx) {
            const reader = new FileReader();
            reader.onload = e => {
                $preview.append(`
                    <div class="col-md-2 col-sm-3 col-4 mb-2">
                        <div class="position-relative">
                            <img src="${e.target.result}" class="img-fluid rounded border" style="height:80px;width:100%;object-fit:cover">
                            <span class="badge bg-success position-absolute top-0 start-0 m-1" style="font-size:9px">Nouveau</span>
                            <button type="button" class="btn btn-xs btn-danger position-absolute top-0 end-0 m-1 remove-edit-new-image" data-index="${idx}">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>
                    </div>`);
            };
            reader.readAsDataURL(file);
        });
    }

    $(document).on('click', '.remove-edit-new-image', function () {
        const idx = parseInt($(this).data('index'));
        const inputEl = $('.file-upload-input-edit')[0];
        inputEl._storedFiles.splice(idx, 1);
        const dt = new DataTransfer();
        inputEl._storedFiles.forEach(f => dt.items.add(f));
        inputEl.files = dt.files;
        rebuildEditPreviews(inputEl, $('.image-preview-container-edit'));
    });

    // ================================================================
    // SOUMISSION — construire FormData avec couleurs + specs
    // ================================================================
    $('#productEditForm').on('submit', function (e) {
        e.preventDefault();
        const $form = $(this);
        const $btn  = $('#edit-submit-btn');
        $btn.find('.spinner-border').show();
        $btn.prop('disabled', true);
        clearEditErrors();

        const formData = new FormData(this);

        // ── Sérialiser les couleurs manuellement ─────────────────────
        // (car les inputs utilisent data-field et non name)
        formData.delete('colors'); // au cas où
        let colorIdx = 0;
        $('#edit-colors-list .edit-color-item').each(function () {
            const dbId   = $(this).find('[data-field="color_db_id"]').val();
            const colorId= $(this).find('[data-field="color_id"]').val();
            const name   = $(this).find('[data-field="color_name"]').val();
            const code   = $(this).find('[data-field="color_code"]').val();
            const stock  = $(this).find('[data-field="color_stock"]').val() || '0';

            if (dbId)    formData.append('colors[' + colorIdx + '][db_id]',         dbId);
            if (colorId) formData.append('colors[' + colorIdx + '][id]',            colorId);
            if (name)    formData.append('colors[' + colorIdx + '][name]',          name);
            if (code)    formData.append('colors[' + colorIdx + '][code]',          code);
                         formData.append('colors[' + colorIdx + '][stock_quantity]', stock);
            colorIdx++;
        });

        // ── Sérialiser les spécifications ────────────────────────────
        let specIdx = 0;
        $('#edit-specs-list .edit-spec-item').each(function () {
            const dbId  = $(this).find('[data-field="spec_db_id"]').val();
            const name  = $(this).find('[data-field="spec_name"]').val();
            const value = $(this).find('[data-field="spec_value"]').val();

            if (name) {
                if (dbId) formData.append('specifications[' + specIdx + '][db_id]', dbId);
                formData.append('specifications[' + specIdx + '][name]',  name);
                formData.append('specifications[' + specIdx + '][value]', value);
                specIdx++;
            }
        });

        $.ajax({
            url: $form.attr('action'), 
            type: 'POST',
            data: formData, 
            processData: false, 
            contentType: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (response) {
                $btn.find('.spinner-border').hide(); $btn.prop('disabled', false);
                iziToast.success({ title: 'Succès', message: response.message, position: 'topRight', timeout: 3000 });
                $('#Modifierproduct').modal('hide');
                setTimeout(() => { window.location.href = response.redirect_url; }, 1200);
            },
            error: function (xhr) {
                $btn.find('.spinner-border').hide(); $btn.prop('disabled', false);
                if (xhr.status === 422) {
                    displayEditErrors(xhr.responseJSON.errors);
                } else {
                    iziToast.error({ title: 'Erreur', message: xhr.responseJSON?.message || 'Une erreur est survenue.', position: 'topRight', timeout: 5000 });
                }
            }
        });
    });

    // ================================================================
    // ERREURS
    // ================================================================
    function clearEditErrors() {
        $('#productEditForm .is-invalid').removeClass('is-invalid');
        $('#productEditForm .invalid-feedback').hide().text('');
    }

    function displayEditErrors(errors) {
        clearEditErrors();
        const fieldMap = {
            name: 'edit_name', price: 'edit_price', compare_price: 'edit_compare_price',
            description: 'edit_description', category_id: 'edit_category_id', brand_id: 'edit_brand_id',
            stock_quantity: 'edit_stock_quantity', low_stock_threshold: 'edit_low_stock_threshold',
            status: 'edit_status', meta_title: 'edit_meta_title', meta_description: 'edit_meta_description',
        };
        Object.keys(errors).forEach(function (key) {
            const message = errors[key][0];
            const inputId = fieldMap[key];
            if (!inputId) return;
            const $field = $('#' + inputId);
            $field.addClass('is-invalid');
            let $fb = $field.next('.invalid-feedback');
            if (!$fb.length) $fb = $field.closest('.col-md-3, .col-md-4, .col-md-6, .col-md-12, .mb-3').find('.invalid-feedback').first();
            if ($fb.length) $fb.text(message).show();
            else $field.after(`<div class="invalid-feedback" style="display:block">${message}</div>`);
        });
    }

    $(document).on('input change', '#productEditForm .form-control, #productEditForm .form-select', function () {
        if ($(this).hasClass('is-invalid')) {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').hide().text('');
        }
    });

    // ── Reset à la fermeture ─────────────────────────────────────────
    $('#Modifierproduct').on('hidden.bs.modal', function () {
        $('#productEditForm')[0].reset();
        $('#edit-existing-images, #edit-colors-list, #edit-specs-list').empty();
        $('.image-preview-container-edit').empty();
        const inputEl = $('.file-upload-input-edit')[0];
        if (inputEl) inputEl._storedFiles = [];
        clearEditErrors();
        // Détruire et recréer Select2 pour éviter les doublons
        $('#edit_category_id, #edit_brand_id').select2('destroy');
        initEditSelect2();
    });

});
</script>

<style>
    #productEditForm .is-invalid { border-color: #dc3545 !important; }
    #productEditForm .invalid-feedback { display: block; color: #dc3545; font-size: 0.875em; margin-top: 0.25rem; }
    .total-stock-input.stock-auto-mode,
    #edit_stock_quantity.stock-auto-mode {
        background-color: #f0f4ff; border-color: #696cff !important;
        color: #696cff; font-weight: 600; cursor: not-allowed;
    }
</style>