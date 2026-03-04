<!DOCTYPE html>
<html lang="fr">
    
<head>
    
    <title>Actualités ABS-TECHNOLOGIE</title>
    @include('client.body.head')
    <link rel="icon" type="image/x-icon" href="{{ asset('frontend/images/favicon/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<!--===============================================================================================-->
    <style> 
		.wrap-menu-desktop {
			background-color: white !important;
		}
	</style>
    <style>
        :root {
            --primary-blue: #0033A0;
            --secondary-blue: #0056D6;
            --orange-gradient: linear-gradient(135deg, #FF7900 0%, #FFB300 100%);
            --purple-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --green-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --red-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --dark-bg: #0A0F2B;
            --light-bg: #F8FAFF;
            --card-shadow: 0 20px 40px rgba(0, 51, 160, 0.1);
            --transition-smooth: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
            --transition-bounce: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            --section-padding: 120px;
        }

        [data-theme="dark"] {
            --light-bg: #0f1419;
            --dark-bg: #ffffff;
            --card-bg: #1a1f2e;
            --text-primary: #ffffff;
            --text-secondary: #b0b8c5;
            --border-color: rgba(255, 255, 255, 0.1);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 32px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 12px;
            cursor: pointer;
            transition: var(--transition-smooth);
            border: none;
            white-space: nowrap;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-primary, #333);
            line-height: 1.6;
            overflow-x: hidden;
            transition: background-color 0.3s ease;
        }

        body.menu-open {
            overflow: hidden;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }


        .theme-toggle {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(0, 51, 160, 0.1);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition-smooth);
            color: var(--primary-blue);
            font-size: 1.2rem;
        }

        .theme-toggle:hover {
            background: rgba(0, 51, 160, 0.2);
            transform: rotate(180deg);
        }

        [data-theme="dark"] .theme-toggle {
            background: rgba(255, 255, 255, 0.1);
            color: #FFB300;
        }

        .back-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition-smooth);
            padding: 10px 25px;
            border-radius: 50px;
            background: rgba(0, 51, 160, 0.08);
        }

        .back-btn:hover {
            background: rgba(0, 51, 160, 0.15);
            transform: translateX(-5px);
        }


        /* Hero Section - reste identique */
        .news-hero {
            padding: 180px 0 80px;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, var(--dark-bg) 0%, #1a237e 100%);
            height: 400px;
        }

        [data-theme="dark"] .news-hero {
            background: linear-gradient(135deg, #0f1419 0%, #1a237e 100%);
        }

        .hero-bg-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(255, 121, 0, 0.15) 0%, transparent 20%),
                radial-gradient(circle at 90% 80%, rgba(0, 86, 214, 0.15) 0%, transparent 20%);
            animation: pulse 10s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        .hero-content {
            text-align: center;
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
            animation: fadeInUp 1s ease-out;
            bottom: 4rem;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-title {
            font-size: 4.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: 20px;
            line-height: 1.1;
            text-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 40px;
        }

        .gradient-text {
            background: var(--orange-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline-block;
        }

        /* Main Carousel Section */
        .main-carousel-section {
            padding: 80px 0;
            position: relative;
            background: var(--light-bg);
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
            animation: fadeInUp 0.8s ease-out;
        }

        .section-label {
            display: inline-block;
            padding: 10px 25px;
            background: var(--orange-gradient);
            color: white;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 1px;
            margin-bottom: 20px;
            box-shadow: 0 10px 20px rgba(255, 121, 0, 0.2);
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .section-title {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--text-primary, var(--dark-bg));
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            height: 5px;
            background: var(--orange-gradient);
            border-radius: 3px;
        }

        .section-description {
            color: var(--text-secondary, #666);
            max-width: 600px;
            margin: 30px auto 0;
            font-size: 1.1rem;
        }

        /* Main Carousel */
        .main-carousel-container {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
            overflow: hidden;
            border-radius: 25px;
            box-shadow: 0 30px 60px rgba(0, 51, 160, 0.2);
            background: #1a1a1a;
        }

        [data-theme="dark"] .main-carousel-container {
            background: #000;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.5);
        }

        .main-carousel {
            display: flex;
            transition: transform 0.8s cubic-bezier(0.25, 0.8, 0.25, 1);
            height: 800px;
        }

        .carousel-slide {
            min-width: 100%;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .slide-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            filter: brightness(0.85);
            transition: transform 0.8s ease, filter 0.5s ease;
        }

        .carousel-slide:hover .slide-image {
            transform: scale(1.05);
            filter: brightness(0.75);
        }

        .slide-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 60px;
            background: linear-gradient(to top, rgba(10, 15, 43, 0.95), transparent);
            color: white;
            transform: translateY(20px);
            opacity: 0;
            transition: var(--transition-smooth);
        }

        .carousel-slide.active .slide-content {
            transform: translateY(0);
            opacity: 1;
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                transform: translateY(40px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .slide-badge {
            display: inline-block;
            padding: 8px 20px;
            background: var(--orange-gradient);
            color: white;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 20px;
            letter-spacing: 1px;
            animation: fadeIn 1s ease-out 0.3s both;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .slide-title {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 10px;
            line-height: 1.2;
            animation: fadeIn 1s ease-out 0.5s both;
        }

        .slide-description {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 20px;
            max-width: 600px;
            animation: fadeIn 1s ease-out 0.7s both;
        }

        .slide-date {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            opacity: 0.8;
            animation: fadeIn 1s ease-out 0.9s both;
        }

        .slide-cta {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 30px;
            background: white;
            color: var(--primary-blue);
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            margin-top: 20px;
            transition: var(--transition-smooth);
            animation: fadeIn 1s ease-out 1.1s both;
        }

        .slide-cta:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(255, 255, 255, 0.3);
        }

        /* Carousel Controls */
        .carousel-controls {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            transform: translateY(-50%);
            display: flex;
            justify-content: space-between;
            padding: 0 30px;
            z-index: 10;
        }

        .carousel-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition-smooth);
            font-size: 1.2rem;
        }

        .carousel-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.15);
            border-color: white;
        }

        .carousel-btn:active {
            transform: scale(1.05);
        }

        .carousel-dots {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 15px;
            z-index: 10;
        }

        .carousel-dot {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: var(--transition-smooth);
            border: 2px solid transparent;
            position: relative;
        }

        .carousel-dot::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 25px;
            height: 25px;
            border: 2px solid white;
            border-radius: 50%;
            opacity: 0;
            transition: var(--transition-smooth);
        }

        .carousel-dot.active {
            background: white;
            transform: scale(1.2);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
        }

        .carousel-dot.active::before {
            opacity: 1;
            animation: ripple 2s ease-out infinite;
        }

        @keyframes ripple {
            0% {
                transform: translate(-50%, -50%) scale(1);
                opacity: 1;
            }
            100% {
                transform: translate(-50%, -50%) scale(1.5);
                opacity: 0;
            }
        }

        .carousel-dot:hover {
            background: white;
            transform: scale(1.1);
        }

        /* Progress Bar */
        .carousel-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 4px;
            background: var(--orange-gradient);
            z-index: 11;
            transition: width 0.1s linear;
        }


        /* Floating Elements */
        .floating-element {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(255, 121, 0, 0.1), rgba(0, 86, 214, 0.1));
            backdrop-filter: blur(5px);
            animation: float 8s ease-in-out infinite;
            z-index: 1;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }

        .floating-1 {
            width: 120px;
            height: 120px;
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .floating-2 {
            width: 80px;
            height: 80px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .floating-3 {
            width: 100px;
            height: 100px;
            bottom: 20%;
            left: 15%;
            animation-delay: 4s;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .main-carousel {
                height: 550px;
            }
        }


        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.8rem;
            }
            
            .section-title {
                font-size: 2.3rem;
            }
            
            .main-carousel {
                height: 450px;
            }
            
            .slide-content {
                padding: 30px;
            }
            
            .slide-title {
                font-size: 1.6rem;
            }
            
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 2.1rem;
            }

            .hero-subtitle{
                font-size: 1.1rem;
            }
            
            .section-title {
                font-size: 1.8rem;
            }
            
            .main-carousel {
                height: 400px;
            }
            
            .slide-title {
                font-size: 1.4rem;
            }
            
            .carousel-controls {
                padding: 0 15px;
            }
            
            .carousel-btn {
                width: 50px;
                height: 50px;
            }

            .scroll-top {
                bottom: 20px;
                right: 20px;
            }

        }
    </style>
</head>
<body>
    @include('client.body.header')
    <!-- Hero Section -->
    <section class="news-hero">
        <div class="hero-bg-pattern"></div>
        <div class="floating-element floating-1"></div>
        <div class="floating-element floating-2"></div>
        <div class="floating-element floating-3"></div>
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">
                    <span class="gradient-text">Actualités</span> & Événements
                </h1>
                <p class="hero-subtitle">
                    Restez informé des dernières nouveautés, promotions exclusives et événements spéciaux 
                    de ABS Technologie Group. L'innovation n'attend pas !
                </p>
            </div>
        </div>
    </section>

    <!-- Main Carousel Section -->
    <section class="main-carousel-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Dernières Actualités</h2>
                <p class="section-description">
                    Découvrez nos principales annonces et événements en vedette
                </p>
            </div>
            
            <div class="main-carousel-container">
                <div class="carousel-progress" id="carouselProgress"></div>
                <div class="main-carousel" id="mainCarousel">
                    <!-- Slide 1 -->
                    <div class="carousel-slide active">
                        <img src="{{ asset('frontend/images/news/1.png') }}" 
                            alt="Nouvelle gamme Samsung S24" class="slide-image">
                        <div class="slide-content">
                            <h3 class="slide-title">Spécial Saint-Valentin chez ABS</h3>
                            <p class="slide-description">
                                Découvrez en exclusivité au Bénin la nouvelle gamme Galaxy S24 avec 
                                son intelligence artificielle intégrée et ses performances exceptionnelles.
                            </p>
                            <a href="#" class="slide-cta">
                                En savoir plus
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Slide 2 -->
                    <div class="carousel-slide">
                        <img src="{{ asset('frontend/images/news/2.png') }}" 
                            alt="Promotion Orange" class="slide-image">
                        <div class="slide-content">
                            <h3 class="slide-title">Profitez des offres spéciales Saint-Valentin</h3>
                            <p class="slide-description">
                                Bénéficiez de -50% sur les forfaits Orange avec l'achat d'un smartphone Samsung. 
                                Offre valable jusqu'au 28 février 2026.
                            </p>
                            <a href="#" class="slide-cta">
                                Profiter de l'offre
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Slide 3 -->
                    <div class="carousel-slide">
                        <img src="{{ asset('frontend/images/news/111.png') }}" 
                            alt="Showroom rénové" class="slide-image">
                        <div class="slide-content">
                            <h3 class="slide-title">Visitez notre nouveau showroom</h3>
                            <p class="slide-description">
                                Découvrez notre espace entièrement repensé avec des zones d'expérience 
                                interactives et toute la gamme des dernières technologies Samsung.
                            </p>
                            <a href="#" class="slide-cta">
                                Réserver ma visite
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Slide 4 -->
                    <div class="carousel-slide">
                        <img src="{{ asset('frontend/images/news/5.png') }}" 
                            alt="Formation entreprise" class="slide-image">
                        <div class="slide-content">
                            <h3 class="slide-title">Faites confiance à ABS pour vos projets technologiques</h3>
                            <p class="slide-description">
                                Participez à nos ateliers de formation sur les solutions Samsung pour entreprises. 
                                Sessions gratuites sur inscription (limitées à 20 participants).
                            </p>
                            <a href="#" class="slide-cta">
                                S'inscrire
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Carousel Controls -->
                <div class="carousel-controls">
                    <button class="carousel-btn" id="prevBtn" aria-label="Slide précédent">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="carousel-btn" id="nextBtn" aria-label="Slide suivant">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                
                <!-- Carousel Dots -->
                <div class="carousel-dots" id="carouselDots"></div>
            </div>
        </div>
    </section>

@include('client.body.footer')

    <script>

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
    
    </script>
    <script>
        // Main App Initialization
        document.addEventListener('DOMContentLoaded', function() {
            initCarousel();
            initScrollEffects();
        });


        // Enhanced Carousel
        function initCarousel() {
            const mainCarousel = document.getElementById('mainCarousel');
            const slides = document.querySelectorAll('.carousel-slide');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const carouselDots = document.getElementById('carouselDots');
            const carouselProgress = document.getElementById('carouselProgress');
            
            let currentSlide = 0;
            const totalSlides = slides.length;
            let autoSlideInterval;
            let progressInterval;
            const slideDuration = 2000;
            
            // Create dots
            slides.forEach((_, index) => {
                const dot = document.createElement('div');
                dot.classList.add('carousel-dot');
                if (index === 0) dot.classList.add('active');
                dot.dataset.index = index;
                dot.addEventListener('click', () => goToSlide(index));
                carouselDots.appendChild(dot);
            });
            
            const dots = document.querySelectorAll('.carousel-dot');
            
            function updateCarousel() {
                mainCarousel.style.transform = `translateX(-${currentSlide * 100}%)`;
                
                slides.forEach((slide, index) => {
                    slide.classList.toggle('active', index === currentSlide);
                });
                
                dots.forEach((dot, index) => {
                    dot.classList.toggle('active', index === currentSlide);
                });
                
                startProgress();
            }
            
            function startProgress() {
                clearInterval(progressInterval);
                let progress = 0;
                carouselProgress.style.width = '0%';
                
                progressInterval = setInterval(() => {
                    progress += 100 / (slideDuration / 100);
                    carouselProgress.style.width = progress + '%';
                    
                    if (progress >= 100) {
                        clearInterval(progressInterval);
                    }
                }, 100);
            }
            
            function goToSlide(slideIndex) {
                currentSlide = slideIndex;
                updateCarousel();
                resetAutoSlide();
            }
            
            function nextSlide() {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateCarousel();
            }
            
            function prevSlide() {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                updateCarousel();
            }
            
            function startAutoSlide() {
                autoSlideInterval = setInterval(nextSlide, slideDuration);
            }
            
            function resetAutoSlide() {
                clearInterval(autoSlideInterval);
                clearInterval(progressInterval);
                startAutoSlide();
            }
            
            prevBtn.addEventListener('click', () => {
                prevSlide();
                resetAutoSlide();
            });
            
            nextBtn.addEventListener('click', () => {
                nextSlide();
                resetAutoSlide();
            });
            
            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') {
                    prevSlide();
                    resetAutoSlide();
                } else if (e.key === 'ArrowRight') {
                    nextSlide();
                    resetAutoSlide();
                }
            });
            
            // Touch gestures
            let startX = 0, endX = 0;
            
            mainCarousel.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
            });
            
            mainCarousel.addEventListener('touchend', (e) => {
                endX = e.changedTouches[0].clientX;
                const diff = startX - endX;
                
                if (Math.abs(diff) > 50) {
                    if (diff > 0) nextSlide();
                    else prevSlide();
                    resetAutoSlide();
                }
            });
            
            // Pause on hover
            mainCarousel.addEventListener('mouseenter', () => {
                clearInterval(autoSlideInterval);
                clearInterval(progressInterval);
            });
            
            mainCarousel.addEventListener('mouseleave', () => {
                startAutoSlide();
                startProgress();
            });
            
            // Initialize
            updateCarousel();
            startAutoSlide();
        }


        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href === '#') return;
                
                e.preventDefault();
                const targetElement = document.querySelector(href);
                
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>