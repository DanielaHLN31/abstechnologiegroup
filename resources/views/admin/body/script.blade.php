<script src="{{ asset('backend/vendor/libs/jquery/jquery.js')}}"></script>
<script src="{{ asset('backend/vendor/libs/popper/popper.js')}}"></script>
<script src="{{ asset('backend/vendor/js/bootstrap.js')}}"></script>
<script src="{{ asset('backend/vendor/libs/node-waves/node-waves.js')}}"></script>
<script src="{{ asset('backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
<script src="{{ asset('backend/vendor/libs/hammer/hammer.js')}}"></script>
<script src="{{ asset('backend/vendor/libs/i18n/i18n.js')}}"></script>
<script src="{{ asset('backend/vendor/libs/typeahead-js/typeahead.js')}}"></script>
<script src="{{ asset('backend/vendor/js/menu.js')}}"></script>

<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('backend/vendor/libs/apex-charts/apexcharts.js')}}"></script>
<script src="{{ asset('backend/vendor/libs/swiper/swiper.js')}}"></script>
<script src="{{ asset('backend/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>

<!-- Vendors JS -->
<script src="{{ asset('backend/vendor/libs/toastr/toastr.js')}}"></script>

<!-- Main JS -->
<script src="{{ asset('backend/js/main.js')}}"></script>

<!-- Page JS -->
<script src="{{ asset('backend/js/dashboards-analytics.js')}}"></script>


<script src="{{ asset('backend/js/iziToast.min.js')}}"></script>


<script>

    document.addEventListener('DOMContentLoaded', function() {
        var message = sessionStorage.getItem('toastMessage');
        var type = sessionStorage.getItem('toastType');

        if (message && type) {
            const toastConfig = {
                title: type.charAt(0).toUpperCase() + type.slice(1),
                message: message,
                position: 'topRight',
                timeout: 5000,
                progressBar: true,
                closeOnClick: true,
                transitionIn: 'bounceInLeft',
            };

            switch(type) {
                case 'info':
                    iziToast.info(toastConfig);
                    break;
                case 'Succès':
                    iziToast.success(toastConfig);
                    break;
                case 'warning':
                    iziToast.warning(toastConfig);
                    break;
                case 'error':
                    iziToast.error(toastConfig);
                    break;
            }

            sessionStorage.removeItem('toastMessage');
            sessionStorage.removeItem('toastType');
        }
    });

    function show_alert(type , message) {

        // Stocker les informations de notification dans la session côté client
        sessionStorage.setItem('toastMessage', message);
        sessionStorage.setItem('toastType', type);

    }

    function show_error(xhr){
        if (xhr.status === 422) {
            const errors = xhr.responseJSON.errors;
            Object.keys(errors).forEach(function(key) {
                errors[key].forEach(function(message) {
                    iziToast.error({
                        title: 'Erreur',
                        message: message,
                        position: 'topRight',
                        timeout: 5000,
                        progressBar: true,
                        closeOnClick: true,
                        transitionIn: 'bounceInLeft',
                    });
                });
            });
        } else {
            iziToast.error({
                title: 'Erreur',
                message: 'Une erreur est survenue. Veuillez réessayer.',
                position: 'topRight',
                timeout: 5000,
                progressBar: true,
                closeOnClick: true,
                transitionIn: 'bounceInLeft',
            });
        }
    }

    // For +/- READER TEXT
    window.toggleReadMore = function (id) {
        const short = document.getElementById(id + '_short');
        const full = document.getElementById(id + '_full');
        const link = document.getElementById(id + '_link');

        const isHidden = full.style.display === 'none';

        short.style.display = isHidden ? 'none' : 'inline';
        full.style.display = isHidden ? 'inline' : 'none';
        link.textContent = isHidden ? 'LIRE MOINS' : 'LIRE PLUS';
    };

    // Fonction global pour afficher la prévisualisation des fichiers dans un modal
    function showFilePreviewGlobal(fileUrl, fileName, fileType) {
        const getDrivePreviewUrl = (url) => {
            const match = url.match(/id=([^&]+)/);
            if (match) {
                return `https://drive.google.com/file/d/${match[1]}/preview`;
            }
            return url;
        };

        // Fonction pour obtenir l'URL réelle (potentiellement pour Google Drive)
        function getProcessedImageUrl(url) {
            if (url.includes('drive.google.com')) {
                const match = url.match(/id=([^&]+)/);
                if (match) {
                    return `https://lh3.googleusercontent.com/d/${match[1]}=w1000`;
                }
            }
            return url;
        }

        // Determine preview content based on file type
        let previewContent = '';
        if (fileType.startsWith('image/')) {
            // Image preview with processed URL
            const processedUrl = getProcessedImageUrl(fileUrl);
            previewContent = `
                <div class="file-preview-container">
                    <img src="${processedUrl}" alt="${fileName}" class="preview-image" style="max-width: 100%; max-height: 70vh; object-fit: contain;">
                </div>`;
        } else if (fileType === 'application/pdf') {
            const previewUrl = getDrivePreviewUrl(fileUrl);
            previewContent = `
                <div class="pdf-preview-container">
                    <iframe src="${previewUrl}"
                            width="100%"
                            height="600px"
                            type="application/pdf"
                            style="border: none;">
                    </iframe>
                </div>`;
        } else if ([
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'text/plain',
            'application/rtf'
        ].includes(fileType)) {
            // Office documents and text files preview
            previewContent = `
                <div class="document-preview-container">
                    <iframe src="https://docs.google.com/viewer?url=${encodeURIComponent(fileUrl)}&embedded=true"
                            width="100%"
                            height="600px"
                            style="border: none;">
                    </iframe>
                </div>`;
        } else {
            // Unsupported file types
            previewContent = `
                <div class="unsupported-file-preview text-center p-4">
                    <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Prévisualisation non disponible pour ce type de fichier.</p>
                    <a href="${fileUrl}" download="${fileName}" class="btn btn-primary mt-3">
                        <i class="fas fa-download mr-2"></i>Télécharger
                    </a>
                </div>`;
        }

        // Show preview modal
        Swal.fire({
            html: `
                <div class="custom-file-preview-modal">
                    <div class="modal-header">
                        <div class="file-info">
                            <span class="file-name">${fileName}</span>
                            <span class="file-type">${fileType}</span>
                        </div>
                        <div class="modal-actions">
                            <a href="${fileUrl}" download="${fileName}" class="btn-download">
                                <i class="fas fa-download mr-2"></i>Télécharger
                            </a>
                        </div>
                    </div>
                    <div class="modal-content">
                        ${previewContent}
                    </div>
                    <div class="modal-footer">
                        <button class="btn-close-preview" onclick="Swal.close()">
                            <i class="fas fa-times mr-2"></i>Fermer
                        </button>
                    </div>
                </div>
            `,
            showConfirmButton: false,
            showCloseButton: false,
            width: '90%',
            padding: '0',
            background: 'transparent',
            customClass: {
                popup: 'file-preview-swal-popup'
            }
        });
    }

    // Script pour prévisualiser les documents directement
    $(document).on('click', '.view-document-btn', function(e) {
        e.preventDefault();

        // Récupérer les données du fichier depuis les attributs data
        const fileUrl = $(this).data('file-url');
        const fileName = $(this).data('file-name');
        const fileType = $(this).data('file-type');

        // Utiliser la fonction existante pour prévisualiser le fichier
        showFilePreviewGlobal(fileUrl, fileName, fileType);
    });

</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        function initAllFlatpickr(element) {
            flatpickr(element, {
                dateFormat: "d-m-Y",
                placeholder: "Sélectionner une date",
                locale: {
                    firstDayOfWeek: 1, // Lundi comme premier jour de la semaine
                    // rangeSeparator: " au ",
                    weekdays: {
                        shorthand: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
                        longhand: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi']
                    },
                    months: {
                        shorthand: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
                        longhand: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre']
                    },
                    rangeSeparator: " au ",
                    weekAbbreviation: "Sem",
                    scrollTitle: "Défiler pour augmenter",
                    toggleTitle: "Cliquer pour basculer",
                    today: "Aujourd'hui",
                    clear: "Effacer",
                    close: "Fermer",
                    yearAriaLabel: "Année",
                    monthAriaLabel: "Mois",
                    hourAriaLabel: "Heure",
                    minuteAriaLabel: "Minute",
                    time_24hr: true
                },
            });
        }
        
    });
</script>
@stack('scripts')
