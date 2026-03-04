<script>
$(document).ready(function () {

    // ================================================================
    // UTILITAIRE — index du produit parent (ex: "0" pour group-a[0])
    // ================================================================
    function getProductIndex($productItem) {
        const nameAttr = $productItem.find('[name^="group-a["]').first().attr('name');
        if (!nameAttr) return '0';
        const match = nameAttr.match(/group-a\[(\d+)\]/);
        return match ? match[1] : '0';
    }

    // ================================================================
    // NESTED REPEATER — ajouter un item
    //
    // FIX CRITIQUE : le name est maintenant construit comme :
    //   group-a[0][colors][1770982732135][id]
    //   ^^^^^^^^^^^^^^^^^ ^^^^^^^^^^^^^^ ^^^^
    //   préfixe produit   index unique   champ
    //
    // data-nested-name contient UNIQUEMENT la partie après le listSelector :
    //   "[__IDX__][id]"  (PAS "colors[__IDX__][id]" qui cassait le parsing PHP)
    // ================================================================
    function addNestedItem($btn, listSelector) {
        const $container = $btn.closest('[data-nested-list="' + listSelector + '"]');
        if (!$container.length) {
            console.warn('[nested] Conteneur introuvable:', listSelector);
            return;
        }

        const $template = $container.find('.nested-template').first();
        if (!$template.length) {
            console.warn('[nested] Template introuvable:', listSelector);
            return;
        }

        // Zone d'insertion
        let $list = $container.find('#' + listSelector + '-list-container');
        if (!$list.length) $list = $container;

        const $productItem  = $btn.closest('[data-repeater-item]');
        const productIndex  = getProductIndex($productItem);   // "0", "1"...
        const nestedIndex   = Date.now();                       // timestamp unique

        const $clone = $template.clone(true);
        $clone.removeClass('nested-template').addClass('nested-item');
        $clone.removeAttr('style');

        // Construire le name final :
        //   data-nested-name="[__IDX__][id]"
        //   → name="group-a[0][colors][1770982732135][id]"
        $clone.find('[data-nested-name]').each(function () {
            const suffix   = $(this).data('nested-name');   // ex: "[__IDX__][id]"
            const withIdx  = suffix.replace(/__IDX__/g, nestedIndex);
            //                                      ↑ "[1770982732135][id]"
            const realName = 'group-a[' + productIndex + '][' + listSelector + ']' + withIdx;
            //               "group-a[0][colors][1770982732135][id]"  ← CORRECT

            $(this).attr('name', realName);
            $(this).removeAttr('data-nested-name');
        });

        $list.append($clone);
        $clone.hide().slideDown(200);
    }

    // ================================================================
    // NESTED REPEATER — supprimer un item
    // ================================================================
    function removeNestedItem($btn) {
        const $item = $btn.closest('.nested-item');
        if (!$item.length) return;

        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: 'La suppression sera définitive !',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Oui, Supprimer !',
            cancelButtonText: 'Annuler',
            customClass: { confirmButton: 'btn btn-primary me-3', cancelButton: 'btn btn-label-secondary' },
            buttonsStyling: false
        }).then(result => {
            if (result.isConfirmed) {
                $item.slideUp(200, function () {
                    $item.remove();
                    recalcTotalStock($btn);
                });
            }
        });
    }

    // ================================================================
    // STOCK TOTAL AUTO
    // ================================================================
    function recalcTotalStock($source) {
        const $productItem = $source.closest('[data-repeater-item]');
        if (!$productItem.length) return;

        let total = 0, hasAny = false;
        $productItem.find('.color-stock-input').each(function () {
            if (!$(this).closest('.nested-template').length) {
                total += parseInt($(this).val()) || 0;
                hasAny = true;
            }
        });

        const $stockInput = $productItem.find('.total-stock-input');
        const $label      = $productItem.find('.stock-auto-label');

        if (hasAny) {
            $stockInput.val(total).prop('readonly', true).addClass('stock-auto-mode');
            $label.show();
        } else {
            $stockInput.val('').prop('readonly', false).removeClass('stock-auto-mode');
            $label.hide();
        }
    }

    $(document).on('input', '.color-stock-input', function () {
        recalcTotalStock($(this));
    });

    // ================================================================
    // BOUTONS NESTED
    // ================================================================
    $(document).on('click', '[data-nested-create]', function (e) {
        e.preventDefault();
        e.stopPropagation();
        const listSelector = $(this).data('nested-create');
        addNestedItem($(this), listSelector);
        if (listSelector === 'colors') setTimeout(() => recalcTotalStock($(this)), 50);
    });

    $(document).on('click', '[data-nested-delete]', function (e) {
        e.preventDefault();
        e.stopPropagation();
        removeNestedItem($(this));
    });

    // ================================================================
    // REPEATER PRINCIPAL (group-a)
    // ================================================================
    $('[data-repeater-list="group-a"]').repeater({
        initEmpty: false,
        show: function () {
            $(this).slideDown(200);
            $(this).find('.select2').select2({ dropdownParent: $('#exLargeModal'), width: '100%' });
            $(this).find('.file-upload-input').each(function () { this._storedFiles = []; });
        },
        hide: function (deleteElement) {
            const $item = $(this);
            Swal.fire({
                title: 'Êtes-vous sûr ?', text: 'Ce produit sera retiré du formulaire.',
                icon: 'warning', showCancelButton: true,
                confirmButtonText: 'Oui, Supprimer !', cancelButtonText: 'Annuler',
                customClass: { confirmButton: 'btn btn-primary me-3', cancelButton: 'btn btn-label-secondary' },
                buttonsStyling: false
            }).then(result => { if (result.isConfirmed) $item.slideUp(200, deleteElement); });
        }
    });

    // ================================================================
    // SELECT2
    // ================================================================
    $('.select2').select2({ dropdownParent: $('#exLargeModal'), width: '100%' });

    // ================================================================
    // COULEURS — palette & sélection existante
    // ================================================================
    $(document).on('change', '.existing-color-select', function () {
        const $row = $(this).closest('.color-fields-row');
        const $opt = $(this).find('option:selected');
        if ($(this).val()) {
            $row.find('.color-name-input').val($opt.text()).prop('readonly', true);
            $row.find('.color-code-input').val($opt.data('code') || '#000000').prop('readonly', true);
        } else {
            $row.find('.color-name-input').val('').prop('readonly', false);
            $row.find('.color-code-input').val('#3a86ff').prop('readonly', false);
        }
    });

    $(document).on('input', '.color-code-input', function () {
        const $row  = $(this).closest('.color-fields-row');
        const $name = $row.find('.color-name-input');
        const $sel  = $row.find('.existing-color-select');
        if ($sel.val()) { $sel.val('').trigger('change.select2'); $name.prop('readonly', false); }
        if (!$name.val() || /^#[0-9A-Fa-f]{6}$/.test($name.val())) $name.val($(this).val());
    });

    // ================================================================
    // IMAGES CUMULATIVES
    // ================================================================
    $(document).on('change', '.file-upload-input', function () {
        const inputEl = this, $uc = $(this).closest('.upload-container');
        const merged  = [...(inputEl._storedFiles || [])];
        Array.from(inputEl.files).forEach(f => {
            if (!merged.some(e => e.name === f.name && e.size === f.size)) merged.push(f);
        });
        inputEl._storedFiles = merged;
        const dt = new DataTransfer();
        merged.forEach(f => dt.items.add(f));
        inputEl.files = dt.files;
        rebuildPreviews(inputEl, $uc.find('.image-preview-container'));
    });

    function rebuildPreviews(inputEl, $preview) {
        $preview.empty();
        (inputEl._storedFiles || []).forEach(function (file, idx) {
            const reader = new FileReader();
            reader.onload = e => {
                $preview.append(`
                    <div class="col-md-3 col-sm-4 col-6 mb-2">
                        <div class="image-preview-item position-relative">
                            <img src="${e.target.result}" class="img-fluid rounded border" style="height:100px;width:100%;object-fit:cover">
                            <span class="position-absolute top-0 start-0 badge bg-primary">${idx + 1}</span>
                            <button type="button" class="btn btn-xs btn-label-danger position-absolute top-0 end-0 m-1 remove-image" data-index="${idx}">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>
                    </div>`);
            };
            reader.readAsDataURL(file);
        });
    }

    $(document).on('click', '.remove-image', function () {
        const idx = parseInt($(this).data('index'));
        const $uc = $(this).closest('.upload-container');
        const inputEl = $uc.find('.file-upload-input')[0];
        inputEl._storedFiles.splice(idx, 1);
        const dt = new DataTransfer();
        inputEl._storedFiles.forEach(f => dt.items.add(f));
        inputEl.files = dt.files;
        rebuildPreviews(inputEl, $uc.find('.image-preview-container'));
    });

    // ================================================================
    // QUILL (éditeur de description)
    // ================================================================
    var quill = null;
    if (document.querySelector('#ecommerce-category-description')) {
        quill = new Quill('#ecommerce-category-description', {
            modules: { toolbar: '.comment-toolbar' },
            placeholder: 'Description détaillée du produit...',
            theme: 'snow'
        });
    }

    // ================================================================
    // SOUMISSION AJAX
    // ================================================================
    $('#productForm').on('submit', function (e) {
        e.preventDefault();
        const $form = $(this);

        // Vérifier description Quill
        if (quill) {
            const content = quill.root.innerHTML;
            if (!content || content === '<p><br></p>') {
                iziToast.error({ title: 'Erreur', message: 'La description est obligatoire.', position: 'topRight', timeout: 3000 });
                return;
            }
            // Injecter dans le bon champ group-a[0][description]
            const productIndex = getProductIndex($('[data-repeater-item]').first());
            const $hidden = $form.find('[name="group-a[' + productIndex + '][description]"]');
            if ($hidden.length) {
                $hidden.val(content);
            } else {
                $form.append('<input type="hidden" name="group-a[' + productIndex + '][description]" value="">');
                $form.find('[name="group-a[' + productIndex + '][description]"]').val(content);
            }
        }

        $form.find('button[type="submit"] .spinner-border').show();
        $form.find('button[type="submit"]').prop('disabled', true);
        clearErrors();

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: new FormData($form[0]),
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (response) {
                $form.find('button[type="submit"] .spinner-border').hide();
                $form.find('button[type="submit"]').prop('disabled', false);
                iziToast.success({ title: 'Succès', message: response.message, position: 'topRight', timeout: 3000 });
                $('#exLargeModal').modal('hide');
                setTimeout(() => { window.location.href = response.redirect_url; }, 1500);
            },
            error: function (xhr) {
                $form.find('button[type="submit"] .spinner-border').hide();
                $form.find('button[type="submit"]').prop('disabled', false);
                if (xhr.status === 422) {
                    displayErrors(xhr.responseJSON.errors);
                    const $first = $('.is-invalid').first();
                    if ($first.length) $first[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    iziToast.error({ title: 'Erreur', message: xhr.responseJSON?.message || 'Une erreur est survenue.', position: 'topRight', timeout: 5000 });
                }
            }
        });
    });

    // ================================================================
    // ERREURS DE VALIDATION
    // ================================================================
    function clearErrors() {
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').hide().text('');
    }

    function showFieldError($field, message) {
        if (!$field.length) return;
        $field.addClass('is-invalid');
        let $fb = $field.next('.invalid-feedback');
        if (!$fb.length) $fb = $field.closest('.mb-3, .col-md-6, .col-md-12').find('.invalid-feedback').first();
        if ($fb.length) $fb.text(message).show();
        else $field.after(`<div class="invalid-feedback" style="display:block">${message}</div>`);
    }

    function displayErrors(errors) {
        clearErrors();
        Object.keys(errors).forEach(function (key) {
            const message = errors[key][0];
            const m = key.match(/^group-a\.(\d+)\.(.+)$/);
            if (!m) return;
            const $item = $('[data-repeater-list="group-a"] > [data-repeater-item]').eq(parseInt(m[1]));
            if (!$item.length) return;
            const fieldPath = m[2];
            if (fieldPath === 'description') {
                iziToast.error({ title: 'Erreur', message, position: 'topRight', timeout: 3000 });
            } else if (fieldPath.startsWith('images')) {
                $item.find('.file-upload-input').addClass('is-invalid');
                const $uc = $item.find('.upload-container');
                let $fb = $uc.siblings('.invalid-feedback');
                if (!$fb.length) $uc.after(`<div class="invalid-feedback" style="display:block">${message}</div>`);
                else $fb.text(message).show();
            } else {
                let $field = $item.find('[name="' + fieldPath + '"]');
                if (!$field.length) $field = $item.find('[name$="[' + fieldPath + ']"]').first();
                showFieldError($field, message);
            }
        });
    }

    $(document).on('input change', '.form-control, .form-select', function () {
        if ($(this).hasClass('is-invalid')) {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').hide().text('');
            $(this).closest('.mb-3, .col-md-6, .col-md-12').find('.invalid-feedback').first().hide().text('');
        }
    });

});
</script>

<style>
    .total-stock-input.stock-auto-mode {
        background-color: #f0f4ff;
        border-color: #696cff !important;
        color: #696cff;
        font-weight: 600;
        cursor: not-allowed;
    }
    .is-invalid { border-color: #dc3545 !important; }
    .invalid-feedback { display: block; color: #dc3545; font-size: 0.875em; margin-top: 0.25rem; }
    .upload-container.has-files { border-color: #696cff !important; background-color: rgba(105,108,255,0.04); }
</style>

<style>
    .total-stock-input.stock-auto-mode {
        background-color: #f0f4ff;
        border-color: #696cff !important;
        color: #696cff;
        font-weight: 600;
        cursor: not-allowed;
    }
    .is-invalid { border-color: #dc3545 !important; }
    .invalid-feedback { display: block; color: #dc3545; font-size: 0.875em; margin-top: 0.25rem; }
    .upload-container.has-files { border-color: #696cff !important; background-color: rgba(105,108,255,0.04); }
</style>

<style>
    /* Champ stock en mode auto-calculé */
    .total-stock-input.stock-auto-mode {
        background-color: #f0f4ff;
        border-color: #696cff !important;
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

    /* Zone upload avec fichiers chargés */
    .upload-container.has-files {
        border-color: #696cff !important;
        background-color: rgba(105, 108, 255, 0.04);
    }
</style>