<!DOCTYPE html>
<html lang="fr">
<head>
<title>A propos ABS-TECHNOLOGIE</title>
@include('client.body.head')
    <!-- ========================================
         FONTS & STYLES
         ======================================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    
	<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


	<style>
		.wrap-menu-desktop {
			background-color: white !important;
		}
	</style>
</head>

<body>
    <!-- Navigation -->
    @include('client.body.header')

    <!-- Hero Section -->


    


	@include('frontend.modal')
	<!-- Title page -->
	<section class="bg-img1 txt-center p-lr-15 p-tb-92 m-t-150" style="background-image: url('{{ asset('frontend/images/bg-02.jpg') }}');">
		<h2 class="ltext-105 cl0 txt-center">
			A propos
		</h2>
	</section>	
    <!-- À Propos Section -->
    <section class="about" id="apropos">
        <div class="container">
            <div class="about-grid">
                <div class="about-content" data-aos="fade-right">
                    <span class="section-label">Notre Histoire</span>
                    <h2 class="section-title">ABS Technologie Group</h2>
                    <p class="about-text">
                        <strong>ABS TECHNOLOGIE Group</strong> s'est imposée comme un acteur majeur 
                        de la distribution technologique et électroménagère au Bénin. En tant que distributeur agréé Samsung 
                        et partenaire Meilleures Services Orange, nous offrons à nos clients un accès privilégié aux meilleures 
                        innovations technologiques mondiales.
                    </p>
                    <p class="about-text">
                        Notre engagement envers l'excellence se traduit par un service client irréprochable, 
                        des produits authentiques garantis et une expertise technique reconnue. Nous intervenons 
                        aussi bien auprès des ménages que des entreprises, en proposant la vente, l’installation 
                        et la maintenance d’appareils électroménagers et électroniques, tout en accompagnant nos 
                        clients dans leur transformation digitale.
                    </p>

                    <div class="about-values">
                        <div class="value-item">
                            <div class="value-icon">✓</div>
                            <div class="value-content">
                                <h4>Authenticité Garantie</h4>
                                <p>Produits originaux avec garantie constructeur</p>
                            </div>
                        </div>
                        <div class="value-item">
                            <div class="value-icon">✓</div>
                            <div class="value-content">
                                <h4>Expertise Technique</h4>
                                <p>Équipe certifiée et formée en continu</p>
                            </div>
                        </div>
                        <div class="value-item">
                            <div class="value-icon">✓</div>
                            <div class="value-content">
                                <h4>Service Excellence</h4>
                                <p>Accompagnement personnalisé à chaque étape</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="about-visual" data-aos="fade-left">
                    <div class="stats-container">
                        <div class="stat-box" data-aos="fade-up" data-delay="0">
                            <div class="stat-number" data-count="20">0</div>
                            <div class="stat-unit">+</div>
                            <div class="stat-text">Années d'Expérience</div>
                        </div>
                        <div class="stat-box" data-aos="fade-up" data-delay="100">
                            <div class="stat-number" data-count="10000">0</div>
                            <div class="stat-unit">+</div>
                            <div class="stat-text">Clients Satisfaits</div>
                        </div>
                        <div class="stat-box" data-aos="fade-up" data-delay="200">
                            <div class="stat-number" data-count="100">0</div>
                            <div class="stat-unit">%</div>
                            <div class="stat-text">Produits Authentiques</div>
                        </div>
                        <div class="stat-box" data-aos="fade-up" data-delay="300">
                            <div class="stat-number" data-count="24">0</div>
                            <div class="stat-unit">/7</div>
                            <div class="stat-text">Support Disponible</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


        <!-- Services Section -->
    <section class="services" id="services">
        <div class="container">
            <div class="section-header">
                <span class="section-label">Ce que nous offrons</span>
                <h2 class="section-title">Notre Expertise, Vos Solutions</h2>
                <p class="section-description">
                    Une gamme complète de services pour les particuliers et les professionnels, couvrant tous vos besoins technologiques.
                </p>
            </div>
            <div class="services-grid">
                <!-- Service 1 : Distribution & Commerce -->
                <div class="service-card" data-aos="fade-up" data-delay="0">
                    <div class="service-number">01</div>
                    <div class="service-icon">
                        <span style="font-size: xx-large;">🌍</span>
                    </div>
                    <h3 class="service-title">Distribution & Commerce</h3>
                    <p class="service-description">
                        Import-export, vente en gros, demi-gros et détail de produits électroniques, électroménagers et biens divers. Notre réseau logistique assure une disponibilité optimale.
                    </p>
                    <div class="service-features">
                        <span class="feature-tag">Import/Export</span>
                        <span class="feature-tag">Vente en Gros</span>
                        <span class="feature-tag">Logistique</span>
                    </div>
                </div>

                <!-- Service 2 : Technologies & Électronique -->
                <div class="service-card" data-aos="fade-up" data-delay="100">
                    <div class="service-number">02</div>
                    <div class="service-icon">
                        <span style="font-size: xx-large;">📱</span>
                    </div>
                    <h3 class="service-title">Electronique & Électroménager</h3>
                    <p class="service-description">
                        Distribution exclusive des dernières innovations Samsung (TV QLED, smartphones, électroménagers). Des produits authentiques avec garantie officielle.
                    </p>
                    <div class="service-features">
                        <span class="feature-tag">Smartphones</span>
                        <span class="feature-tag">TV & Audio</span>
                        <span class="feature-tag">Électroménager</span>
                    </div>
                </div>

                <!-- Service 3 : Solutions Entreprises & Assistance Technique (REFONDU) -->
                <div class="service-card" data-aos="fade-up" data-delay="200">
                    <div class="service-number">03</div>
                    <div class="service-icon">
                        <span style="font-size: xx-large;">⚙️</span>
                    </div>
                    <h3 class="service-title">Solutions Entreprises & Assistance</h3>
                    <p class="service-description">
                        Que vous soyez particulier, entreprise, administration ou institution, nous vous accompagnons avec des solutions sur mesure : installation et maintenance de réseaux, équipements domestiques et professionnels, audit technique et support personnalisé.
                    </p>
                    <div class="service-features">
                        <span class="feature-tag">Installation réseau</span>
                        <span class="feature-tag">Maintenance</span>
                        <!-- <span class="feature-tag">Solutions sur-mesure</span> -->
                        <span class="feature-tag">Audit technique</span>
                        <!-- <span class="feature-tag">Support personnalisé</span> -->
                    </div>
                </div>

                <!-- Service 4 : Service Après-Vente (ex Installation & Services) -->
                <div class="service-card" data-aos="fade-up" data-delay="300">
                    <div class="service-number">04</div>
                    <div class="service-icon">
                        <span style="font-size: xx-large;">🔧</span>
                    </div>
                    <h3 class="service-title">Service Après-Vente</h3>
                    <p class="service-description">
                        Centre de réparation avec des techniciens certifiés. Installation de systèmes de vidéo-surveillance, contrôle qualité, magasinage et maintenance de tous vos équipements avec des pièces d'origine.
                    </p>
                    <div class="service-features">
                        <span class="feature-tag">Réparations</span>
                        <span class="feature-tag">Vidéo-surveillance</span>
                        <span class="feature-tag">Installation</span>
                        <span class="feature-tag">Contrôle qualité</span>
                        <span class="feature-tag">Pièces d'origine</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partenaires Section -->
    <section class="partners" id="partenaires">
        <div class="container">
            <div class="section-header">
                <span class="section-label">Nos Alliances</span>
                <h2 class="section-title">Partenaires Officiels</h2>
            </div>
            <div class="partners-showcase">
                <div class="partner-card samsung-card" data-aos="zoom-in" data-delay="0">
                    <div class="partner-badge">Distributeur Agréé</div>
                    <div class="partner-logo">
                        <div class="samsung-logo">SAMSUNG</div>
                    </div>
                    <h3>Samsung Electronics</h3>
                    <p>Partenaire officiel pour la distribution des produits Samsung au Bénin. Accès exclusif aux dernières innovations technologiques.</p>
                    <div class="partner-stats">
                        <div class="stat">
                            <div class="stat-value">100%</div>
                            <div class="stat-label">Produits Originaux</div>
                        </div>
                        <div class="stat">
                            <div class="stat-value">24/7</div>
                            <div class="stat-label">Support</div>
                        </div>
                    </div>
                </div>

                <div class="partner-card orange-card" data-aos="zoom-in" data-delay="200">
                    <div class="partner-badge">Meilleures Services</div>
                    <div class="partner-logo">
                        <div class="orange-logo">Orange</div>
                    </div>
                    <h3>Orange Bénin</h3>
                    <p>Meilleures Services Orange pour les solutions télécoms. Forfaits, services et accompagnement complet pour particuliers et entreprises.</p>
                    <div class="partner-stats">
                        <div class="stat">
                            <div class="stat-value">100%</div>
                            <div class="stat-label">Garantie</div>
                        </div>
                        <div class="stat">
                            <div class="stat-value">∞</div>
                            <div class="stat-label">Possibilités</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    

    <!-- Galerie Section -->
    <section class="gallery" id="galerie">
        <div class="container">
            <div class="section-header">
                <span class="section-label">Notre Showroom</span>
                <h2 class="section-title">Galerie Photos</h2>
                <p class="section-description">
                    Découvrez nos espaces modernes et nos produits Samsung & Orange
                </p>
            </div>
            
            <div class="gallery-grid">
                <!-- Image 1 - Showroom Extérieur -->
                <div class="gallery-item x-large" data-aos="fade-up" data-delay="0">
                    <div class="gallery-image">
                        <img 
                            src="assets/images/3.jpg" 
                            alt="Showroom ABS Technologie - Extérieur"
                            loading="lazy"
                            class="gallery-img"
                        >
                        <div class="gallery-overlay">
                            <div class="gallery-info">
                                <h4>Nos offres</h4>
                                <p>Profitez de nos promotions</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image 3 - Intérieur Showroom -->
                <div class="gallery-item large" data-aos="fade-up" data-delay="200">
                    <div class="gallery-image">
                        <img 
                            src="assets/images/4.jpeg" 
                            alt="Intérieur du showroom ABS Technologie"
                            loading="lazy"
                            class="gallery-img"
                        >
                        <div class="gallery-overlay">
                            <div class="gallery-info">
                                <h4>Notre Équipe</h4>
                                <p>Conseillers certifiés à votre service</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image 2 - Smartphones Samsung -->
                <div class="gallery-item" data-aos="fade-up" data-delay="100">
                    <div class="gallery-image">
                        <img 
                            src="assets/images/2.jpg" 
                            alt="Smartphones Samsung Galaxy"
                            loading="lazy"
                            class="gallery-img"
                        >
                        <div class="gallery-overlay">
                            <div class="gallery-info">
                                <h4>Smartphones Samsung</h4>
                                <p>Découvrez la gamme Galaxy</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image 4 - Téléviseurs Samsung -->
                <div class="gallery-item" data-aos="fade-up" data-delay="300">
                    <div class="gallery-image">
                        <img 
                            src="assets/images/6.png" 
                            alt="Téléviseurs Samsung QLED et OLED"
                            loading="lazy"
                            class="gallery-img"
                        >
                        <div class="gallery-overlay">
                            <div class="gallery-info">
                                <h4>Téléviseurs Premium</h4>
                                <p>QLED 8K, The Frame, et plus</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image 5 - Produits Orange -->
                <div class="gallery-item" data-aos="fade-up" data-delay="400">
                    <div class="gallery-image">
                        <img 
                            src="assets/images/5.png" 
                            alt="Pour faire bon vivre chez vous !"
                            loading="lazy"
                            class="gallery-img"
                        >
                        <div class="gallery-overlay">
                            <div class="gallery-info">
                                <h4>ABS Technologie</h4>
                                <p>Pour faire bon vivre chez vous !</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image 6 - Équipe ABS Technologie -->
                <div class="gallery-item" data-aos="fade-up" data-delay="500">
                    <div class="gallery-image">
                        <img 
                            src="assets/images/111.png" 
                            alt="Équipe ABS Technologie"
                            loading="lazy"
                            class="gallery-img"
                        >
                        <div class="gallery-overlay">
                            <div class="gallery-info">
                                <h4>Samsung & Orange</h4>
                                <p>Les meilleurs services à votre disposition </p>
                            </div>
                        </div>
                    </div>
                </div>

                
                <!-- Image 7 - Équipe ABS Technologie -->
                <div class="gallery-item" data-aos="fade-up" data-delay="500">
                    <div class="gallery-image">
                        <img 
                            src="assets/images/7.png" 
                            alt="Équipe ABS Technologie"
                            loading="lazy"
                            class="gallery-img"
                        >
                        <div class="gallery-overlay">
                            <div class="gallery-info">
                                <h4>Des nouveautés</h4>
                                <p>Passez à notre showroom pour découvrir les nouvelles technologies à votre disposition</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="gallery-note">
                <p><i class="fas fa-info-circle"></i> Visitez notre showroom au CAMP-GUEZO, face à l'Hôpital des Armées (HIA)</p>
            </div>
        </div>
    </section>

    @include('client.body.footer')
<!--===============================================================================================-->	
	<script src="{{ asset('frontend/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/vendor/animsition/js/animsition.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/vendor/select2/select2.min.js') }}"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/vendor/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
	<script>
		$('.js-pscroll').each(function(){
			$(this).css('position','relative');
			$(this).css('overflow','hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function(){
				ps.update();
			})
		});
	</script>
<!--===============================================================================================-->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKFWBqlKAGCeS1rMVoaNlwyayu0e0YRes"></script>
	<script src="{{ asset('frontend/js/map-custom.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/js/main.js') }}"></script>

	<script src="{{ asset('frontend/js/script.js') }}"></script>
	<script src="{{ asset('frontend/js/script.js') }}"></script>
    
	@include('frontend.global_js')
    
    <script>
        // Optimisation du chargement des images de la galerie
        document.addEventListener('DOMContentLoaded', function() {
            // Lazy loading des images de galerie
            const galleryImages = document.querySelectorAll('.gallery-img');
            
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        const src = img.getAttribute('src');
                        
                        // Charger l'image
                        img.src = src;
                        
                        // Retirer la classe loading une fois chargée
                        img.onload = () => {
                            img.classList.remove('loading');
                        };
                        
                        observer.unobserve(img);
                    }
                });
            }, {
                rootMargin: '50px',
                threshold: 0.1
            });
            
            galleryImages.forEach(img => {
                img.classList.add('loading');
                imageObserver.observe(img);
            });
            
            // Lightbox pour la galerie
            const galleryItems = document.querySelectorAll('.gallery-item');
            
            galleryItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const img = this.querySelector('.gallery-img');
                    if (img) {
                        openLightbox(img.src, img.alt);
                    }
                });
            });
            
            // Fonction lightbox
            function openLightbox(src, alt) {
                // Créer l'overlay lightbox
                const lightbox = document.createElement('div');
                lightbox.className = 'lightbox-overlay';
                lightbox.style.cssText = `
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.9);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 9999;
                    opacity: 0;
                    transition: opacity 0.3s ease;
                `;
                
                // Créer l'image dans la lightbox
                const lightboxImg = document.createElement('img');
                lightboxImg.src = src;
                lightboxImg.alt = alt;
                lightboxImg.style.cssText = `
                    max-width: 90%;
                    max-height: 90%;
                    object-fit: contain;
                    border-radius: 8px;
                    transform: scale(0.9);
                    transition: transform 0.3s ease;
                `;
                
                // Créer le bouton fermer
                const closeBtn = document.createElement('button');
                closeBtn.innerHTML = '×';
                closeBtn.style.cssText = `
                    position: absolute;
                    top: 20px;
                    right: 20px;
                    background: rgba(255, 255, 255, 0.1);
                    border: none;
                    color: white;
                    font-size: 40px;
                    width: 60px;
                    height: 60px;
                    border-radius: 50%;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    transition: background 0.3s ease;
                `;
                
                closeBtn.addEventListener('mouseover', () => {
                    closeBtn.style.background = 'rgba(255, 255, 255, 0.2)';
                });
                
                closeBtn.addEventListener('mouseout', () => {
                    closeBtn.style.background = 'rgba(255, 255, 255, 0.1)';
                });
                
                // Fermer au clic
                function closeLightbox() {
                    lightbox.style.opacity = '0';
                    setTimeout(() => {
                        document.body.removeChild(lightbox);
                        document.body.style.overflow = 'auto';
                    }, 300);
                }
                
                closeBtn.addEventListener('click', closeLightbox);
                lightbox.addEventListener('click', (e) => {
                    if (e.target === lightbox) closeLightbox();
                });
                
                // Ajouter au DOM
                lightbox.appendChild(lightboxImg);
                lightbox.appendChild(closeBtn);
                document.body.appendChild(lightbox);
                
                // Animation d'entrée
                setTimeout(() => {
                    lightbox.style.opacity = '1';
                    lightboxImg.style.transform = 'scale(1)';
                }, 10);
                
                // Empêcher le scroll
                document.body.style.overflow = 'hidden';
                
                // Fermer avec la touche ESC
                document.addEventListener('keydown', function closeOnEsc(e) {
                    if (e.key === 'Escape') {
                        closeLightbox();
                        document.removeEventListener('keydown', closeOnEsc);
                    }
                });
            }
        });
    </script>
</body>
</html>
