// ==================== Variables globales ====================
let lastScrollY = window.scrollY;


// ==================== Smooth Scroll avec offset ====================
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            const offsetTop = target.offsetTop - 80;
            window.scrollTo({
                top: offsetTop,
                behavior: 'smooth'
            });
        }
    });
});

// ==================== Animations au scroll (AOS-like) ====================
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const delay = entry.target.dataset.delay || 0;
            setTimeout(() => {
                entry.target.classList.add('aos-animate');
            }, delay);
        }
    });
}, observerOptions);

// Observer tous les éléments avec data-aos
document.querySelectorAll('[data-aos]').forEach(element => {
    observer.observe(element);
});

// ==================== Compteurs animés ====================
function animateCounter(element, target, duration = 2000) {
    const start = 0;
    const increment = target / (duration / 16); // 60 FPS
    let current = start;

    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            element.textContent = Math.floor(target);
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current);
        }
    }, 16);
}

// Observer pour les statistiques
const statsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const counters = entry.target.querySelectorAll('.stat-number[data-count]');
            counters.forEach(counter => {
                const target = parseInt(counter.dataset.count);
                animateCounter(counter, target);
                counter.removeAttribute('data-count'); // Empêcher la réanimation
            });
            statsObserver.unobserve(entry.target);
        }
    });
}, {
    threshold: 0.5
});

// Observer les conteneurs de stats
const statsContainers = document.querySelectorAll('.stats-container, .about-visual');
statsContainers.forEach(container => {
    statsObserver.observe(container);
});

// ==================== Parallax subtil pour les backgrounds ====================
const heroBackground = document.querySelector('.hero-bg');

window.addEventListener('scroll', () => {
    if (heroBackground) {
        const scrolled = window.scrollY;
        heroBackground.style.transform = `translateY(${scrolled * 0.5}px)`;
    }
});


// ==================== Validation du formulaire ====================
const formInputs = document.querySelectorAll('.contact-form input, .contact-form textarea, .contact-form select');

formInputs.forEach(input => {
    input.addEventListener('blur', () => {
        validateField(input);
    });
    
    input.addEventListener('input', () => {
        if (input.classList.contains('error')) {
            validateField(input);
        }
    });
});

function validateField(field) {
    const value = field.value.trim();
    
    if (field.hasAttribute('required') && value === '') {
        showError(field, 'Ce champ est obligatoire');
        return false;
    }
    
    if (field.type === 'email' && value !== '') {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            showError(field, 'Veuillez entrer une adresse email valide');
            return false;
        }
    }
    
    if (field.type === 'tel' && value !== '') {
        const phoneRegex = /^[\d\s\+\-\(\)]+$/;
        if (!phoneRegex.test(value)) {
            showError(field, 'Veuillez entrer un numéro valide');
            return false;
        }
    }
    
    clearError(field);
    return true;
}

function showError(field, message) {
    field.classList.add('error');
    field.style.borderColor = '#ef4444';
    
    let errorMsg = field.parentElement.querySelector('.error-message');
    if (!errorMsg) {
        errorMsg = document.createElement('span');
        errorMsg.className = 'error-message';
        errorMsg.style.cssText = 'color: #ef4444; font-size: 12px; margin-top: 4px; display: block;';
        field.parentElement.appendChild(errorMsg);
    }
    errorMsg.textContent = message;
}

function clearError(field) {
    field.classList.remove('error');
    field.style.borderColor = '';
    
    const errorMsg = field.parentElement.querySelector('.error-message');
    if (errorMsg) {
        errorMsg.remove();
    }
}

// ==================== Effet de parallax sur les cartes flottantes ====================
const floatingCards = document.querySelectorAll('.floating-card');

document.addEventListener('mousemove', (e) => {
    const mouseX = e.clientX / window.innerWidth;
    const mouseY = e.clientY / window.innerHeight;
    
    floatingCards.forEach((card, index) => {
        const speed = (index + 1) * 10;
        const x = (mouseX - 0.5) * speed;
        const y = (mouseY - 0.5) * speed;
        
        card.style.transform = `translate(${x}px, ${y}px)`;
    });
});

// ==================== Animation des service cards au hover ====================
const serviceCards = document.querySelectorAll('.service-card');

serviceCards.forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
    });
});

// ==================== Preloader (optionnel) ====================
window.addEventListener('load', () => {
    document.body.classList.add('loaded');
    
    // Animer l'apparition initiale
    const heroElements = document.querySelectorAll('.hero-badge, .hero-title .title-line, .hero-subtitle, .hero-cta');
    heroElements.forEach((el, index) => {
        setTimeout(() => {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, index * 100);
    });
});

// ==================== Effet de typing pour le titre (optionnel) ====================
function typeWriter(element, text, speed = 100) {
    let i = 0;
    element.innerHTML = '';
    
    function type() {
        if (i < text.length) {
            element.innerHTML += text.charAt(i);
            i++;
            setTimeout(type, speed);
        }
    }
    
    type();
}

// ==================== Curseur personnalisé (optionnel - avancé) ====================
const createCustomCursor = () => {
    const cursor = document.createElement('div');
    cursor.className = 'custom-cursor';
    cursor.style.cssText = `
        width: 20px;
        height: 20px;
        border: 2px solid #0066CC;
        border-radius: 50%;
        position: fixed;
        pointer-events: none;
        z-index: 9999;
        transition: transform 0.2s ease, background 0.2s ease;
        mix-blend-mode: difference;
    `;
    document.body.appendChild(cursor);
    
    document.addEventListener('mousemove', (e) => {
        cursor.style.left = e.clientX - 10 + 'px';
        cursor.style.top = e.clientY - 10 + 'px';
    });
    
    // Agrandir le curseur sur les liens et boutons
    document.querySelectorAll('a, button').forEach(el => {
        el.addEventListener('mouseenter', () => {
            cursor.style.transform = 'scale(1.5)';
            cursor.style.background = 'rgba(0, 102, 204, 0.2)';
        });
        
        el.addEventListener('mouseleave', () => {
            cursor.style.transform = 'scale(1)';
            cursor.style.background = 'transparent';
        });
    });
};

// Activer le curseur personnalisé sur desktop uniquement
if (window.innerWidth > 1024) {
    // createCustomCursor(); // Décommenter pour activer
}

// ==================== Performance: Lazy loading des images ====================
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.classList.add('loaded');
                    imageObserver.unobserve(img);
                }
            }
        });
    });
    
    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

// ==================== Détection du mode sombre (optionnel) ====================
const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');

function handleColorScheme(e) {
    if (e.matches) {
        // L'utilisateur préfère le mode sombre
        // On pourrait ajouter une classe au body pour basculer les styles
        // document.body.classList.add('dark-mode');
    } else {
        // document.body.classList.remove('dark-mode');
    }
}

prefersDarkScheme.addEventListener('change', handleColorScheme);

// ==================== Console easter egg ====================
console.log('%c🚀 ABS TECHNOLOGIE GROUP', 'font-size: 24px; font-weight: bold; color: #0066CC;');
console.log('%cSite développé avec passion 💙', 'font-size: 14px; color: #FF6600;');
console.log('%cDistributeur Samsung | Représentant Orange', 'font-size: 12px; color: #64748B;');

// ==================== Analytics ready (à configurer) ====================
// Pour Google Analytics, Facebook Pixel, etc.
function trackEvent(category, action, label) {
    if (typeof gtag !== 'undefined') {
        gtag('event', action, {
            'event_category': category,
            'event_label': label
        });
    }
    console.log('Event tracked:', category, action, label);
}

// Exemples d'utilisation:
// trackEvent('Contact', 'submit', 'Form submitted');
// trackEvent('Navigation', 'click', 'Services link');

    // Typing effect in hero section
    const typingText = document.getElementById('typingText');
    if (typingText) {
        const texts = [
            "ABS Technologie Group",
            "Samsung & Orange",
            "Innovation & Qualité",
            "Votre Partenaire Technologique"
        ];
        
        let textIndex = 0;
        let charIndex = 0;
        let isDeleting = false;
        let typingSpeed = 100;
        
        function type() {
            const currentText = texts[textIndex];
            
            if (isDeleting) {
                typingText.textContent = currentText.substring(0, charIndex - 1);
                charIndex--;
                typingSpeed = 50;
            } else {
                typingText.textContent = currentText.substring(0, charIndex + 1);
                charIndex++;
                typingSpeed = 100;
            }
            
            if (!isDeleting && charIndex === currentText.length) {
                isDeleting = true;
                typingSpeed = 1500; // Pause at end
            } else if (isDeleting && charIndex === 0) {
                isDeleting = false;
                textIndex = (textIndex + 1) % texts.length;
                typingSpeed = 500; // Pause before next text
            }
            
            setTimeout(type, typingSpeed);
        }
        
        setTimeout(type, 1000);
    }