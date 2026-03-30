<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>Contact ABS TECHNOLOGIE</title>
    @include('client.body.head')
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
<body class="animsition">
	
	<!-- Header -->
	@include('client.body.header')
    @include('frontend.modal')

	<!-- Title page -->
	
<div class="ct-hero">

    {{-- Accent gauche --}}
    <div class="ct-hero__accent"></div>

    {{-- Motif de fond --}}
    <div class="ct-hero__bg">
        <svg viewBox="0 0 560 560" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="280" cy="280" r="260" stroke="#0066CC" stroke-width="1"/>
            <circle cx="280" cy="280" r="210" stroke="#0066CC" stroke-width="1"/>
            <circle cx="280" cy="280" r="160" stroke="#0066CC" stroke-width="1"/>
            <circle cx="280" cy="280" r="110" stroke="#0066CC" stroke-width="1"/>
            <circle cx="280" cy="280" r="60"  stroke="#0066CC" stroke-width="1"/>
            <!-- Points aux intersections -->
            <circle cx="280" cy="20"  r="3" fill="#0066CC"/>
            <circle cx="540" cy="280" r="3" fill="#0066CC"/>
            <circle cx="280" cy="540" r="3" fill="#0066CC"/>
            <circle cx="20"  cy="280" r="3" fill="#0066CC"/>
            <!-- Lignes diagonales légères -->
            <line x1="280" y1="20"  x2="280" y2="540" stroke="#0066CC" stroke-width="0.5" stroke-dasharray="4 8"/>
            <line x1="20"  y1="280" x2="540" y2="280" stroke="#0066CC" stroke-width="0.5" stroke-dasharray="4 8"/>
            <line x1="96"  y1="96"  x2="464" y2="464" stroke="#0066CC" stroke-width="0.5" stroke-dasharray="4 8"/>
            <line x1="464" y1="96"  x2="96"  y2="464" stroke="#0066CC" stroke-width="0.5" stroke-dasharray="4 8"/>
        </svg>
    </div>

    <div class="ct-hero__inner">


        <div class="ct-hero__body">

            {{-- Gauche --}}
            <div class="ct-hero__left">

                <div class="ct-hero__pill">
                    <span class="ct-hero__pill-dot"></span>
                    Nous sommes disponibles
                </div>

                <h1 class="ct-hero__title">
                    Parlons de votre<br><span>projet</span>
                </h1>

                <p class="ct-hero__sub">
                    Notre équipe est à votre écoute du lundi au samedi.
                    Showroom, téléphone ou email — choisissez le canal qui vous convient.
                </p>

                {{-- Infos rapides --}}
                <div class="ct-hero__quick">
                    <div class="ct-hero__quick-item">
                        <div class="ct-hero__quick-icon">
                            <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        CAMP-GUEZO, face à l'Hôpital des Armées (HIA) — Cotonou
                    </div>
                    <div class="ct-hero__quick-item">
                        <div class="ct-hero__quick-icon">
                            <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </div>
                        +229 01 61 06 26 26 &nbsp;·&nbsp; +229 01 96 06 26 26
                    </div>
                    <div class="ct-hero__quick-item">
                        <div class="ct-hero__quick-icon">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        Lundi – Samedi : 9h00 – 18h00
                    </div>
                </div>

            </div>

            {{-- Droite : carte CTA --}}
            <div class="ct-hero__right">
                <div class="ct-hero__card">

                    <div class="ct-hero__card-head">
                        <div class="ct-hero__card-avatar">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                        </div>
                        <div>
                            <div class="ct-hero__card-title">Équipe ABS Technologie</div>
                            <div class="ct-hero__card-online">
                                <span class="ct-hero__card-online-dot"></span>
                                Disponible maintenant
                            </div>
                        </div>
                    </div>

                    <div class="ct-hero__card-links">

                        <a href="#contact" class="ct-hero__card-link">
                            <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            Envoyer un message
                            <svg class="ct-link-arrow" viewBox="0 0 24 24" width="14" height="14"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>

                        <a href="tel:+22901610626 26" class="ct-hero__card-link">
                            <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            Appeler directement
                            <svg class="ct-link-arrow" viewBox="0 0 24 24" width="14" height="14"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>

                        <a href="https://wa.me/2290196062626" target="_blank" class="ct-hero__card-link">
                            <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                            WhatsApp
                            <svg class="ct-link-arrow" viewBox="0 0 24 24" width="14" height="14"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>

                        <a href="#showroom" class="ct-hero__card-link">
                            <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            Voir le showroom
                            <svg class="ct-link-arrow" viewBox="0 0 24 24" width="14" height="14"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>

                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Barre ancres --}}
    <nav class="ct-hero__nav">
        <div class="ct-hero__nav-inner">

            <a href="#showroom" class="ct-hero__nav-link active">
                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Showroom
            </a>

            <a href="#contact" class="ct-hero__nav-link">
                <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                Formulaire de contact
            </a>

        </div>
    </nav>

</div>


	<!-- Content page -->
	
    
    <!-- Showroom Section -->
    <section id="showroom" class="showroom">
        <div class="container">
            <div class="showroom-content">
                <div class="showroom-info" data-aos="fade-right">
                    <span class="section-label">Visitez-nous</span>
                    <h2 class="section-title">Notre Showroom</h2>
                    <p class="showroom-description">
                        Venez découvrir nos équipements en exclusivité dans notre showroom moderne et entièrement équipé.
                    </p>
                    
                    <div class="showroom-details">
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="detail-content">
                                <h4>Adresse</h4>
                                <p>CAMP-GUEZO, Face Hôpital des Armées (HIA)<br>Cotonou, Bénin</p>
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="detail-content">
                                <h4>Horaires d'ouverture</h4>
                                <p>Lundi - Samedi : 9h00 - 18h00<br>Dimanche : Fermé</p>
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="detail-content">
                                <h4>Téléphone</h4>
                                <p><a href="tel:+22996062626">+229 01 61 06 26 26 - +229 01 96 06 26 26</a></p>
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="detail-content">
                                <h4>Email</h4>
                                <p><a href="mailto:dc@abstechnologie.com ">dc@abstechnologie.com </a></p>
                            </div>
                        </div>
                    </div>
                    
                    <a href="https://www.google.com/maps/place/ABS+TECHNOLOGIE.GROUP+-DISTRIBUTEUR+AGREE+SAMSUNG.ELECTRONIC/@6.356074,2.4129451,17z/data=!3m1!4b1!4m6!3m5!1s0x10235599f7ca61d5:0x296ae994321772a6!8m2!3d6.356074!4d2.4155022!16s%2Fg%2F11h263j1rt?entry=ttu&g_ep=EgoyMDI2MDEyNi4wIKXMDSoKLDEwMDc5MjA2OUgBUAM%3D" target="_blank" class="btn btn-primary">
                        <i class="fas fa-directions"></i> Voir sur Google Maps
                    </a>
                </div>
                
                <div class="showroom-map" data-aos="fade-left">
                    <div class="map-container">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.6477193999836!2d2.4129451!3d6.356074!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x10235599f7ca61d5%3A0x296ae994321772a6!2sABS%20TECHNOLOGIE.GROUP%20-DISTRIBUTEUR%20AGREE%20SAMSUNG.ELECTRONIC!5e0!3m2!1sfr!2sbj!4v1706547800000!5m2!1sfr!2sbj" 
                            width="100%" 
                            height="100%" 
                            style="border:0; border-radius: 20px;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Contact Section -->
    <section class="contact" id="contact">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-info" data-aos="fade-right">
                    <span class="section-label">Restons en Contact</span>
                    <h2 class="section-title">Contactez-Nous</h2>
                    <p class="contact-description">
                        Notre équipe est à votre disposition pour répondre à toutes vos questions 
                        et vous accompagner dans vos projets technologiques.
                    </p>
                    
                    <div class="info-cards">
                        <div class="info-card">
                            <div class="info-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                            </div>
                            <div class="info-content">
                                <h4>Adresse</h4>
                                <p>Cotonou, Bénin</p>
                            </div>
                        </div>

                        <div class="info-card">
                            <div class="info-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                            </div>
                            <div class="info-content">
                                <h4>Téléphone</h4>
                                <p>+229 01 61 06 26 26 - +229 01 96 06 26 26</p>
                            </div>
                        </div>

                        <div class="info-card">
                            <div class="info-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,6"/>
                                </svg>
                            </div>
                            <div class="info-content">
                                <h4>Email</h4>
                                <p>dc@abstechnologie.com </p>
                            </div>
                        </div>

                        <div class="info-card">
                            <div class="info-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                            </div>
                            <div class="info-content">
                                <h4>Horaires</h4>
                                <p>Lun - Sam: 9h - 18h<br>Dim: Fermé</p>
                            </div>
                        </div>
                    </div>

                    <div class="social-links">
                        <a href="https://facebook.com/abstechnologiegroup" target="_blank" class="social-link" aria-label="Facebook">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="https://wa.me/2290196062626" class="social-link" aria-label="WhatsApp">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="contact-form-container" data-aos="fade-left">
                    <form name="contact" action="https://formspree.io/f/mwvnzpld" method="POST" class="contact-form">
                        <!-- Vos champs restent identiques -->
                        <div class="form-group">
                            <label for="name">Nom complet *</label>
                            <input type="text" id="name" name="name" required placeholder="Votre nom">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" required placeholder="votre@email.com">
                            </div>
                            <div class="form-group">
                                <label for="phone">Téléphone</label>
                                <input type="tel" id="phone" name="phone" placeholder="+229 XX XX XX XX">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="subject">Sujet *</label>
                            <select id="subject" name="subject" required>
                                <option value="">Sélectionnez un sujet</option>
                                <option value="information">Demande d'information</option>
                                <option value="samsung">Produits Samsung</option>
                                <option value="orange">Services Orange</option>
                                <option value="sav">Service après-vente</option>
                                <option value="entreprise">Solutions Entreprises</option>
                                <option value="autre">Autre</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="message">Message *</label>
                            <textarea id="message" name="message" required rows="5" placeholder="Décrivez votre besoin..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-full">
                            <span>Envoyer le message</span>
                            
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M19 1L9 11M19 1l-6 18-4-8-8-4 18-6z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
	
	


	@include('client.body.footer')

    <div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 99999;"></div>
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
    
    @include('frontend.global_js')
    <!-- Script pour le formulaire avec Toast -->
    <script>
        // Fonction pour afficher un toast
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toast-container');
            
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.style.cssText = `
                background: ${type === 'success' ? 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)' : '#f44336'};
                color: white;
                padding: 20px 30px;
                border-radius: 12px;
                margin-bottom: 10px;
                box-shadow: 0 10px 40px rgba(0,0,0,0.3);
                display: flex;
                align-items: center;
                gap: 15px;
                min-width: 300px;
                animation: slideIn 0.4s ease-out;
                font-family: 'Montserrat', sans-serif;
            `;
            
            const icon = type === 'success' ? '✓' : '✕';
            toast.innerHTML = `
                <div style="
                    width: 40px;
                    height: 40px;
                    background: rgba(255,255,255,0.2);
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 24px;
                    font-weight: bold;
                ">${icon}</div>
                <div style="flex: 1;">
                    <div style="font-weight: 600; margin-bottom: 4px;">
                        ${type === 'success' ? 'Message envoyé !' : 'Erreur'}
                    </div>
                    <div style="font-size: 14px; opacity: 0.9;">${message}</div>
                </div>
            `;
            
            toastContainer.appendChild(toast);
            
            // Animation de sortie après 5 secondes
            setTimeout(() => {
                toast.style.animation = 'slideOut 0.4s ease-out';
                setTimeout(() => {
                    toastContainer.removeChild(toast);
                }, 400);
            }, 5000);
        }

        // Animation CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(400px);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(400px);
                    opacity: 0;
                }
            }
            
            .toast {
                cursor: pointer;
                transition: transform 0.2s;
            }
            
            .toast:hover {
                transform: translateY(-2px);
            }
        `;
        document.head.appendChild(style);
        
        
        // Gérer la soumission du formulaire
        document.querySelector('.contact-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;
            
            // Désactiver le bouton
            submitButton.disabled = true;
            submitButton.innerHTML = '<span>Envoi en cours...</span>';
            
            // 🔥 CHANGEZ CETTE LIGNE : envoyez à Formspree, pas à '/'
            fetch('https://formspree.io/f/xlgwdqbg', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    showToast('Nous vous répondrons dans les plus brefs délais.', 'success');
                    this.reset();
                } else {
                    return response.json().then(data => {
                        throw new Error(data.error || 'Erreur lors de l\'envoi');
                    });
                }
            })
            .catch((error) => {
                showToast('Une erreur est survenue. Veuillez réessayer.', 'error');
                console.error('Erreur:', error);
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            });
        });
    </script>

</body>
</html>