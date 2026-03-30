<!DOCTYPE html>
<html lang="fr">
<head>
    <title>FAQ - ABS TECHNOLOGIE</title>
    @include('client.body.head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ── Hero FAQ ─────────────────────────────────────────────── */
        .fq-hero {
            background: #fff;
            padding: 80px 0 0;
            margin-top: 35px;
            position: relative;
            overflow: hidden;
        }

        /* Motif de points en arrière-plan */
        .fq-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(0,102,204,0.12) 1.5px, transparent 1.5px);
            background-size: 28px 28px;
            pointer-events: none;
        }

        /* Dégradé pour que les points s'effacent vers le bas */
        .fq-hero::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 120px;
            background: linear-gradient(to bottom, transparent, #fff);
            pointer-events: none;
        }

        .fq-hero__inner {
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 32px 52px;
            position: relative;
            z-index: 1;
        }

        /* Breadcrumb */
        .fq-hero__breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #aab4c0;
            margin-bottom: 28px;
            font-weight: 500;
            letter-spacing: 0.04em;
        }
        .fq-hero__breadcrumb a {
            color: #aab4c0;
            text-decoration: none;
            transition: color .2s;
        }
        .fq-hero__breadcrumb a:hover { color: #0066CC; }
        .fq-hero__breadcrumb-sep { color: #d0d8e4; }
        .fq-hero__breadcrumb-current { color: #0066CC; font-weight: 600; }

        /* Corps : centré */
        .fq-hero__body {
            text-align: center;
            max-width: 680px;
            margin: 0 auto;
        }

        .fq-hero__pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #0066CC;
            background: #E6F1FB;
            border: 1px solid rgba(0,102,204,0.22);
            border-radius: 100px;
            padding: 5px 16px;
            margin-bottom: 20px;
        }
        .fq-hero__pill-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #0066CC;
            animation: fq-pulse 1.8s ease-in-out infinite;
        }
        @keyframes fq-pulse {
            0%,100%{transform:scale(1);opacity:1}
            50%{transform:scale(1.5);opacity:.5}
        }

        .fq-hero__title {
            font-family: 'Syne', 'Montserrat', sans-serif;
            font-size: clamp(28px, 4vw, 48px);
            font-weight: 800;
            color: #0a1628;
            line-height: 1.1;
            letter-spacing: -0.025em;
            margin: 0 0 14px;
        }

        .fq-hero__title span {
            color: #0066CC;
            position: relative;
            display: inline-block;
        }

        .fq-hero__title span::after {
            content: '';
            position: absolute;
            bottom: 3px; left: 0;
            width: 100%; height: 3px;
            background: linear-gradient(90deg, #0066CC, #88C0FF);
            border-radius: 2px;
        }

        .fq-hero__sub {
            font-size: 15px;
            color: #6b7a99;
            line-height: 1.7;
            margin: 0 auto 32px;
            max-width: 520px;
        }

        
        /* Stats rapides */
        .fq-hero__stats {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 32px;
            flex-wrap: wrap;
        }

        .fq-hero__stat {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
        }

        .fq-hero__stat-val {
            font-family: 'Syne', sans-serif;
            font-size: 22px;
            font-weight: 800;
            color: #0a1628;
            line-height: 1;
        }

        .fq-hero__stat-val span { color: #0066CC; }

        .fq-hero__stat-lbl {
            font-size: 11px;
            color: #6b7a99;
            font-weight: 500;
            letter-spacing: 0.03em;
        }

        .fq-hero__stat-divider {
            width: 1px;
            height: 36px;
            background: rgba(0,102,204,0.12);
        }

        /* Barre catégories (remplace l'ancienne .faq-categories) */
        .fq-hero__cats {
            background: #f4f7fc;
            border-top: 1px solid rgba(0,102,204,0.08);
            position: relative;
            z-index: 1;
        }

        .fq-hero__cats-inner {
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 32px;
            display: flex;
            align-items: center;
            gap: 4px;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .fq-hero__cats-inner::-webkit-scrollbar { display: none; }

        .fq-cat-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 13px 18px;
            font-size: 13px;
            font-weight: 600;
            color: #6b7a99;
            background: transparent;
            border: none;
            border-bottom: 2px solid transparent;
            white-space: nowrap;
            cursor: pointer;
            transition: color .2s, border-color .2s;
            font-family: inherit;
        }

        .fq-cat-btn svg {
            width: 14px; height: 14px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            flex-shrink: 0;
        }

        .fq-cat-btn:hover,
        .fq-cat-btn.active {
            color: #0066CC;
            border-bottom-color: #0066CC;
        }

        /* ── Responsive ── */
        @media (max-width: 991px) { .fq-hero { margin-top: 97px; } }

        @media (max-width: 768px) {
            .fq-hero__inner { padding: 0 20px 40px; }
            .fq-hero__stats { gap: 20px; }
            .fq-hero__stat-divider { height: 24px; }
            .fq-hero__cats-inner { padding: 0 16px; }
        }
    </style>
    <style>
        /* ==================== FAQ PAGE STYLES ==================== */
        
        /* FAQ Sections */
        .faq-sections-wrapper {
            max-width: 900px;
            margin: 0 auto;
            margin-top: 5rem;
        }
        
        .faq-section {
            margin-bottom: 60px;
            animation: fadeInUp 0.6s ease;
        }
        
        .faq-section-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid var(--orange-accent);
            display: inline-block;
            font-family: 'Playfair Display', serif;
        }
        
        .faq-section-title i {
            color: #0066cc;
            margin-right: 12px;
        }
        
        /* FAQ Items */
        .faq-item {
            background: var(--white);
            border-radius: 16px;
            margin-bottom: 16px;
            border: 1px solid rgba(0, 102, 204, 0.1);
            overflow: hidden;
            transition: var(--transition-smooth);
        }
        
        .faq-item:hover {
            border-color: #0066cc;
            box-shadow: 0 8px 30px rgba(0, 102, 204, 0.1);
        }
        
        .faq-question {
            padding: 20px 25px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            color: var(--dark);
            font-size: 16px;
            transition: var(--transition-smooth);
        }
        
        .faq-question:hover {
            color: #0066cc;
        }
        
        .faq-question i {
            color: #0066cc;
            font-size: 20px;
            transition: transform 0.3s ease;
        }
        
        .faq-question.active i {
            transform: rotate(180deg);
        }
        
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 0 25px;
            color: var(--gray);
            line-height: 1.8;
            font-size: 15px;
        }
        
        .faq-answer.active {
            max-height: 500px;
            padding: 0 25px 25px;
        }
        
        .faq-answer ul, 
        .faq-answer ol {
            margin-top: 10px;
            padding-left: 20px;
        }
        
        .faq-answer li {
            margin-bottom: 8px;
        }
        
        /* No Results */
        .no-results {
            text-align: center;
            padding: 80px 20px;
            background: linear-gradient(135deg, #F8FAFC 0%, var(--white) 100%);
            border-radius: 24px;
            margin-top: 40px;
        }
        
        .no-results i {
            font-size: 64px;
            color: var(--gray);
            margin-bottom: 20px;
            opacity: 0.5;
        }
        
        .no-results h3 {
            font-size: 24px;
            color: var(--dark);
            margin-bottom: 10px;
            font-family: 'Playfair Display', serif;
        }
        
        .no-results p {
            color: var(--gray);
        }
        
        /* CTA Section */
        .faq-cta {
            background: var(--gradient-mixed);
            padding: 80px 0;
            text-align: center;
            margin-top: 60px;
            position: relative;
            overflow: hidden;
        }
        
        .faq-cta::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            pointer-events: none;
        }
        
        .faq-cta h3 {
            font-size: clamp(28px, 4vw, 36px);
            font-weight: 800;
            margin-bottom: 15px;
            color: var(--white);
            font-family: 'Playfair Display', serif;
            position: relative;
        }
        
        .faq-cta p {
            font-size: 18px;
            margin-bottom: 30px;
            color: rgba(255, 255, 255, 0.9);
            position: relative;
        }
        
        .btn-contact {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 14px 40px;
            background: var(--white);
            color: #0066cc;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            transition: var(--transition-smooth);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }
        
        .btn-contact:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
            background: var(--white);
            color: var(--orange-accent);
        }
        
        .btn-contact i {
            font-size: 18px;
        }
        
        /* Animations */
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
        
        .faq-section {
            animation: fadeInUp 0.6s ease forwards;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .faq-hero {
                padding: 80px 0 60px;
            }
            
            .faq-hero h1 {
                font-size: 32px;
            }
            
            .faq-hero p {
                font-size: 16px;
            }
            
            .faq-search input {
                padding: 14px 50px 14px 20px;
                font-size: 14px;
            }
            
            .faq-categories {
                gap: 10px;
                margin: 40px 0 30px;
            }
            
            .faq-cat-btn {
                padding: 8px 20px;
                font-size: 12px;
            }
            
            .faq-section-title {
                font-size: 24px;
            }
            
            .faq-question {
                padding: 16px 20px;
                font-size: 14px;
            }
            
            .faq-answer {
                font-size: 14px;
            }
            
            .faq-answer.active {
                padding: 0 20px 20px;
            }
            
            .faq-cta {
                padding: 60px 0;
            }
            
            .faq-cta h3 {
                font-size: 24px;
            }
            
            .faq-cta p {
                font-size: 16px;
            }
            
            .btn-contact {
                padding: 12px 30px;
                font-size: 14px;
            }
        }
        
        @media (max-width: 480px) {
            .faq-hero {
                padding: 60px 0 40px;
            }
            
            .faq-hero h1 {
                font-size: 28px;
            }
            
            .faq-categories {
                gap: 8px;
            }
            
            .faq-cat-btn {
                padding: 6px 16px;
                font-size: 11px;
            }
        }
    </style>
</head>
<body class="animsition">
    
    @include('client.body.header')
    @include('frontend.modal')

    <!-- Hero Section -->
    
    <div class="fq-hero">
        <div class="fq-hero__inner">


            <div class="fq-hero__body">

                <div class="fq-hero__pill">
                    <span class="fq-hero__pill-dot"></span>
                    Centre d'aide
                </div>

                <h1 class="fq-hero__title">
                    Questions <span>fréquentes</span>
                </h1>

                <p class="fq-hero__sub">
                    Trouvez rapidement les réponses à toutes vos questions
                    sur nos produits, commandes et services.
                </p>


                {{-- Stats --}}
                <div class="fq-hero__stats">
                    <div class="fq-hero__stat-divider"></div>
                    <div class="fq-hero__stat">
                        <span class="fq-hero__stat-val">15<span>+</span></span>
                        <span class="fq-hero__stat-lbl">Questions répondues</span>
                    </div>
                    <div class="fq-hero__stat-divider"></div>
                    <div class="fq-hero__stat">
                        <span class="fq-hero__stat-val">24<span>/7</span></span>
                        <span class="fq-hero__stat-lbl">Support disponible</span>
                    </div>
                </div>

            </div>
        </div>

        {{-- Barre de catégories (remplace l'ancienne .faq-categories) --}}
        <div class="fq-hero__cats">
            <div class="fq-hero__cats-inner">

                <button class="fq-cat-btn active" data-category="all">
                    <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                    Toutes
                </button>

                <button class="fq-cat-btn" data-category="commande">
                    <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                    Commandes
                </button>

                <button class="fq-cat-btn" data-category="livraison">
                    <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                    Livraison
                </button>

                <button class="fq-cat-btn" data-category="paiement">
                    <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    Paiement
                </button>

                <button class="fq-cat-btn" data-category="retour">
                    <svg viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.42"/></svg>
                    Retours &amp; Échanges
                </button>

                <button class="fq-cat-btn" data-category="compte">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Mon Compte
                </button>

            </div>
        </div>
    </div>


    <!-- FAQ Content -->
    <div class="container">
        <div class="faq-sections-wrapper">
            
            <!-- Commandes -->
            <div class="faq-section" data-category="commande">
                <h2 class="faq-section-title"><i class="fas fa-shopping-cart"></i> Commandes</h2>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>📦 Comment passer une commande ?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Pour passer commande, suivez ces étapes simples :
                        <ul>
                            <li>Ajoutez vos articles au panier en cliquant sur "Ajouter au panier"</li>
                            <li>Cliquez sur l'icône panier en haut à droite pour consulter votre commande</li>
                            <li>Cliquez sur "Commander" et renseignez vos coordonnées</li>
                            <li>Choisissez votre mode de livraison et de paiement</li>
                            <li>Validez votre commande et recevez une confirmation par email</li>
                        </ul>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>✏️ Puis-je modifier ma commande après validation ?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Vous pouvez modifier votre commande dans les <strong>2 heures</strong> suivant sa validation en nous contactant via le formulaire de contact ou par téléphone au <strong>+229 01 61 06 26 26</strong>. Passé ce délai, la commande sera déjà en préparation et ne pourra plus être modifiée.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>📍 Comment suivre ma commande ?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Vous recevrez un email avec un numéro de suivi dès l'expédition de votre commande. Vous pouvez également suivre l'état de votre commande dans votre <strong>espace client</strong>, rubrique "Mes commandes". Le suivi est disponible 24h/24.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>❌ Puis-je annuler ma commande ?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Oui, vous pouvez annuler votre commande gratuitement tant qu'elle n'a pas été expédiée. Contactez rapidement notre service client. Si la commande est déjà expédiée, vous devrez suivre la procédure de retour une fois le colis reçu.
                    </div>
                </div>
            </div>

            <!-- Livraison -->
            <div class="faq-section" data-category="livraison">
                <h2 class="faq-section-title"><i class="fas fa-truck"></i> Livraison</h2>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>⏱️ Quels sont les délais de livraison ?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Les délais varient selon votre zone géographique :
                        <ul>
                            <li><strong>Cotonou et environs</strong> : 24-48h</li>
                            <li><strong>Autres villes du Bénin</strong> : 3-5 jours ouvrés</li>
                            <li><strong>International (Afrique de l'Ouest)</strong> : 5-10 jours ouvrés</li>
                        </ul>
                        Ces délais sont indicatifs et peuvent varier pendant les périodes de forte activité.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>💰 Quels sont les frais de livraison ?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <ul>
                            <li><strong>Livraison gratuite</strong> : pour toute commande supérieure à 100 000 FCFA</li>
                            <li><strong>Cotonou</strong> : 1 500 FCFA</li>
                            <li><strong>Autres villes du Bénin</strong> : 2 500 FCFA</li>
                            <li><strong>International</strong> : calculé selon la destination lors de la commande</li>
                        </ul>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>🌍 Livrez-vous à l'international ?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Oui, nous livrons dans plusieurs pays d'Afrique de l'Ouest : Togo, Nigeria, Ghana, Côte d'Ivoire, Sénégal, Burkina Faso, Niger et Bénin. Les frais et délais sont calculés automatiquement lors de votre commande en fonction de votre adresse.
                    </div>
                </div>
            </div>

            <!-- Paiement -->
            <div class="faq-section" data-category="paiement">
                <h2 class="faq-section-title"><i class="fas fa-credit-card"></i> Paiement</h2>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>💳 Quels modes de paiement acceptez-vous ?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Nous acceptons plusieurs modes de paiement sécurisés :
                        <ul>
                            <li><strong>Cartes bancaires</strong> : Visa, Mastercard</li>
                            <li><strong>Mobile Money</strong> : MTN Money, Moov Money, Celtiis Money</li>
                            <li><strong>Paiement à la livraison</strong> : disponible uniquement à Cotonou</li>
                            <li><strong>Virement bancaire</strong> : sur demande</li>
                        </ul>
                        Tous les paiements sont sécurisés et cryptés.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>🔒 Le paiement en ligne est-il sécurisé ?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Absolument ! Notre site utilise le protocole SSL (certificat de sécurité) pour crypter toutes vos données bancaires. Nous ne conservons aucune information bancaire sur nos serveurs. Les transactions sont traitées par des prestataires certifiés PCI-DSS, la norme internationale de sécurité.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>📅 Puis-je payer en plusieurs fois ?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Le paiement en plusieurs fois est disponible pour les commandes supérieures à <strong>150 000 FCFA</strong>. Cette option vous sera proposée lors de la validation de votre panier. Vous pouvez régler en 2, 3 ou 4 fois sans frais supplémentaires.
                    </div>
                </div>
            </div>

            <!-- Retours -->
            <div class="faq-section" data-category="retour">
                <h2 class="faq-section-title"><i class="fas fa-undo-alt"></i> Retours & Échanges</h2>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>🔄 Quelle est votre politique de retour ?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Vous disposez de <strong>14 jours</strong> à compter de la réception de votre commande pour retourner un article qui ne vous convient pas. Les articles doivent être retournés dans leur emballage d'origine, non utilisés et avec toutes les étiquettes. Les frais de retour sont à votre charge sauf en cas d'erreur de notre part.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>📮 Comment effectuer un retour ?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Procédure de retour simple :
                        <ol>
                            <li>Connectez-vous à votre compte et accédez à "Mes commandes"</li>
                            <li>Sélectionnez la commande concernée et cliquez sur "Retourner un article"</li>
                            <li>Choisissez le(s) article(s) à retourner et indiquez le motif</li>
                            <li>Imprimez le bon de retour et joignez-le au colis</li>
                            <li>Déposez le colis dans un point relais ou demandez un enlèvement</li>
                        </ol>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>💰 Sous quel délai serai-je remboursé ?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Dès réception de votre retour, nous procédons à la vérification sous <strong>48h</strong>. Le remboursement est effectué dans les <strong>5 à 7 jours ouvrés</strong> suivant la validation, sur le moyen de paiement utilisé lors de l'achat. Vous recevrez une confirmation par email.
                    </div>
                </div>
            </div>

            <!-- Compte -->
            <div class="faq-section" data-category="compte">
                <h2 class="faq-section-title"><i class="fas fa-user"></i> Mon Compte</h2>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>👤 Comment créer un compte ?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Cliquez sur "Mon Compte" en haut à droite, puis sur "Créer un compte". Remplissez le formulaire avec vos informations personnelles. Vous recevrez un email de confirmation pour activer votre compte. Un compte vous permet de suivre vos commandes, gérer vos retours et bénéficier d'offres exclusives.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>🔑 J'ai oublié mon mot de passe, que faire ?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Sur la page de connexion, cliquez sur "Mot de passe oublié ?". Entrez votre adresse email et vous recevrez un lien pour réinitialiser votre mot de passe. Si vous ne recevez pas d'email, vérifiez vos spams ou contactez notre service client.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>✏️ Comment modifier mes informations personnelles ?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Connectez-vous à votre compte, puis accédez à la section "Mon profil". Vous pouvez y modifier vos informations (nom, adresse, téléphone, email). N'oubliez pas de cliquer sur "Enregistrer" pour valider vos modifications.
                    </div>
                </div>
            </div>

            <!-- No Results -->
            <div class="no-results" style="display: none;">
                <i class="fas fa-search"></i>
                <h3>Aucun résultat trouvé</h3>
                <p>Essayez avec d'autres mots-clés ou contactez notre service client</p>
                <a href="{{ route('client.contact') }}" style="display: inline-block; margin-top: 20px; color: #0066cc; font-weight: 600;">Contacter le support →</a>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="faq-cta">
        <div class="container">
            <h3>Vous ne trouvez pas votre réponse ?</h3>
            <p>Notre équipe est là pour vous aider 24h/24 et 7j/7</p>
            <a href="{{ route('client.contact') }}" class="btn-contact">
                <i class="fas fa-headset"></i> Contactez-nous
            </a>
        </div>
    </div>

    @include('client.body.footer')

    <div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 99999;"></div>

    <script src="{{ asset('frontend/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/animsition/js/animsition.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    
    @include('frontend.global_js')
    
    <script>
    $(document).ready(function() {
        // Toggle FAQ avec animation fluide
        $('.faq-question').on('click', function() {
            const $answer = $(this).next('.faq-answer');
            const $icon = $(this).find('i');
            
            // Fermer les autres réponses ouvertes
            $('.faq-answer').not($answer).removeClass('active');
            $('.faq-question i').not($icon).removeClass('active');
            
            // Toggle la réponse actuelle
            $answer.toggleClass('active');
            $(this).toggleClass('active');
        });

        // Filtrage par catégorie
        $('.faq-cat-btn').on('click', function() {
            const category = $(this).data('category');
            
            // Mettre à jour l'état actif des boutons
            $('.faq-cat-btn').removeClass('active');
            $(this).addClass('active');
            
            // Réinitialiser la recherche
            $('#faq-search-input').val('');
            
            // Filtrer les sections
            if (category === 'all') {
                $('.faq-section').show();
            } else {
                $('.faq-section').hide();
                $(`.faq-section[data-category="${category}"]`).show();
            }
            
            $('.no-results').hide();
        });

        // Fonction de recherche
        $('#faq-search-input').on('input', function() {
            const searchTerm = $(this).val().toLowerCase().trim();
            let hasResults = false;
            
            if (searchTerm === '') {
                // Réinitialiser l'affichage selon la catégorie active
                const activeCategory = $('.faq-cat-btn.active').data('category');
                if (activeCategory === 'all') {
                    $('.faq-section').show();
                } else {
                    $('.faq-section').hide();
                    $(`.faq-section[data-category="${activeCategory}"]`).show();
                }
                $('.faq-item').show();
                $('.no-results').hide();
                return;
            }
            
            // Filtrer les FAQ items
            $('.faq-item').each(function() {
                const question = $(this).find('.faq-question span').text().toLowerCase();
                const answer = $(this).find('.faq-answer').text().toLowerCase();
                const category = $(this).closest('.faq-section').data('category');
                const activeCategory = $('.faq-cat-btn.active').data('category');
                
                const matchesSearch = question.includes(searchTerm) || answer.includes(searchTerm);
                const matchesCategory = activeCategory === 'all' || category === activeCategory;
                
                if (matchesSearch && matchesCategory) {
                    $(this).show();
                    hasResults = true;
                } else {
                    $(this).hide();
                }
            });
            
            // Masquer les sections vides
            $('.faq-section').each(function() {
                const $section = $(this);
                const category = $section.data('category');
                const activeCategory = $('.faq-cat-btn.active').data('category');
                
                if (activeCategory === 'all' || category === activeCategory) {
                    if ($section.find('.faq-item:visible').length === 0) {
                        $section.hide();
                    } else {
                        $section.show();
                    }
                }
            });
            
            $('.no-results').toggle(!hasResults);
        });
        
        // Ouvrir la première question par défaut (optionnel)
        // $('.faq-item:first .faq-question').click();
    });
    </script>
    
    <script src="{{ asset('frontend/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.fq-cat-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.fq-cat-btn').forEach(function (b) {
                b.classList.remove('active');
            });
            this.classList.add('active');

            var category = this.dataset.category;

            /* Synchronise avec les anciens boutons .faq-cat-btn si présents */
            var oldBtn = document.querySelector('.faq-cat-btn[data-category="' + category + '"]');
            if (oldBtn) oldBtn.click();

            /* Logique inline si les anciens boutons sont absents */
            if (!oldBtn) {
                document.querySelectorAll('.faq-section').forEach(function (s) {
                    s.style.display = (category === 'all' || s.dataset.category === category) ? '' : 'none';
                });
                var noRes = document.querySelector('.no-results');
                if (noRes) noRes.style.display = 'none';
            }
        });
    });
});
</script>
</body>
</html>