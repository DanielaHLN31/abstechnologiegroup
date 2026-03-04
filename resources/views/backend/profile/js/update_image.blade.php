<script>
    let cropper = null;

    // ════════════════════════════════════════════════════════════════════
    // ÉTAPE 1 — Sélection du fichier → ouvrir le modal de recadrage UNIQUEMENT
    // ════════════════════════════════════════════════════════════════════
    document.getElementById('account-upload').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        // ── Validations côté client ──────────────────────────────────────
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({ title: 'Erreur', text: 'Le fichier est trop volumineux. Maximum 2MB.', icon: 'error' });
            this.value = '';
            return;
        }

        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            Swal.fire({ title: 'Erreur', text: 'Format non autorisé. Utilisez JPEG, PNG ou GIF.', icon: 'error' });
            this.value = '';
            return;
        }

        // ── Lire le fichier et ouvrir le modal de recadrage ─────────────
        const reader = new FileReader();
        reader.onload = function (event) {
            const image = document.getElementById('cropper-image');
            image.src = event.target.result;

            // Ouvrir le modal
            const cropModal = new bootstrap.Modal(document.getElementById('cropModal'));
            cropModal.show();

            // Initialiser Cropper.js après que le modal soit visible
            document.getElementById('cropModal').addEventListener('shown.bs.modal', function initCropper() {
                // Retirer l'écouteur pour éviter la réinitialisation à chaque ouverture
                document.getElementById('cropModal').removeEventListener('shown.bs.modal', initCropper);

                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }

                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 1,
                    dragMode: 'move',
                    autoCropArea: 0.9,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: false,
                    guides: true,
                    center: true,
                    highlight: false,
                    background: true,
                    responsive: true,
                    minContainerWidth: 400,
                    minContainerHeight: 300,
                    ready() {
                        updatePreview();
                    },
                    crop() {
                        updatePreview();
                    }
                });
            });
        };

        reader.readAsDataURL(file);
    });

    // ── Mise à jour de l'aperçu en temps réel ───────────────────────────
    function updatePreview() {
        if (!cropper) return;
        const canvas = cropper.getCroppedCanvas({ width: 150, height: 150 });
        if (canvas) {
            document.getElementById('preview-image').src = canvas.toDataURL('image/jpeg', 0.9);
        }
    }

    // ════════════════════════════════════════════════════════════════════
    // ÉTAPE 2 — Clic sur "Recadrer & Envoyer" → uploader
    // ════════════════════════════════════════════════════════════════════
    document.getElementById('crop-button').addEventListener('click', function () {
        if (!cropper) return;

        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Traitement...';

        // Générer le canvas recadré en haute qualité
        const croppedCanvas = cropper.getCroppedCanvas({
            width: 500,
            height: 500,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });

        croppedCanvas.toBlob(function (blob) {
            // Créer un fichier depuis le blob
            const croppedFile = new File(
                [blob],
                'profile_' + Date.now() + '.jpg',
                { type: 'image/jpeg', lastModified: Date.now() }
            );

            // Injecter le fichier recadré dans l'input
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);
            document.getElementById('account-upload').files = dataTransfer.files;

            // Fermer le modal de recadrage
            bootstrap.Modal.getInstance(document.getElementById('cropModal')).hide();

            // Détruire cropper
            cropper.destroy();
            cropper = null;

            // ── Maintenant seulement on upload ──────────────────────────
            uploadProfileImage();

        }, 'image/jpeg', 0.92);
    });

    // ════════════════════════════════════════════════════════════════════
    // Upload AJAX (appelé uniquement après recadrage confirmé)
    // ════════════════════════════════════════════════════════════════════
    function uploadProfileImage() {
        const form    = document.getElementById('image-upload-form');
        const fileInput = document.getElementById('account-upload');

        if (!fileInput.files[0]) return;

        // Afficher le spinner de chargement
        $('#loadingModall').modal('show');

        const formData = new FormData(form);

        $.ajax({
            url: form.action,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.check_status) {
                    // Vérification en polling jusqu'à ce que le traitement soit terminé
                    checkPhotoStatus(response.personnel_id);
                } else {
                    $('#loadingModall').modal('hide');
                    window.location.href = response.redirect_url;
                }
            },
            error: function (xhr) {
                $('#loadingModall').modal('hide');
                // Réactiver le bouton recadrage si jamais
                const btn = document.getElementById('crop-button');
                btn.disabled = false;
                btn.innerHTML = '<i class="ti ti-crop me-1"></i>Recadrer & Envoyer';

                const response = xhr.responseJSON;
                Swal.fire({
                    title: 'Erreur',
                    text: response?.message || 'Une erreur est survenue lors de l\'upload.',
                    icon: 'error'
                }).then(() => {
                    if (response?.redirect_url) window.location.href = response.redirect_url;
                });
            }
        });
    }

    // ════════════════════════════════════════════════════════════════════
    // Polling : vérification du statut de traitement de la photo
    // ════════════════════════════════════════════════════════════════════
    function checkPhotoStatus(personnelId) {
        $.ajax({
            url: '/check-profile-photo-status',
            type: 'GET',
            data: { personnel_id: personnelId },
            success: function (response) {
                if (response.processed) {
                    $('#loadingModall').modal('hide');
                    window.location.href = response.redirect_url;
                } else {
                    setTimeout(() => checkPhotoStatus(personnelId), 2000);
                }
            },
            error: function () {
                setTimeout(() => checkPhotoStatus(personnelId), 5000);
            }
        });
    }

    // ════════════════════════════════════════════════════════════════════
    // Nettoyage quand le modal de recadrage est fermé (annulation)
    // ════════════════════════════════════════════════════════════════════
    document.getElementById('cropModal').addEventListener('hidden.bs.modal', function () {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        // Réinitialiser l'input pour permettre une nouvelle sélection
        document.getElementById('account-upload').value = '';
        // Réactiver le bouton recadrage
        const btn = document.getElementById('crop-button');
        btn.disabled = false;
        btn.innerHTML = '<i class="ti ti-crop me-1"></i>Recadrer & Envoyer';
    });

    // ════════════════════════════════════════════════════════════════════
    // Réinitialisation de la photo (bouton "Réinitialiser")
    // ════════════════════════════════════════════════════════════════════
    $('.account-image-reset').on('click', function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('href'),
            type: 'GET',
            success: function (response) {
                window.location.href = response.redirect_url;
            },
            error: function (xhr) {
                Swal.fire({ title: 'Erreur', text: 'Impossible de réinitialiser la photo.', icon: 'error' });
            }
        });
    });
</script>