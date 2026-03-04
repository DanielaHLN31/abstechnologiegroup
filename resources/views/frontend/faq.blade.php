<!DOCTYPE html>
<html lang="fr">
<head>
    <title>FAQ-ABS-TECHNOLOGIE</title>
    @include('client.body.head')
    <style>
		.wrap-menu-desktop {
			background-color: white !important;
		}
        .faq-hero {
            background: linear-gradient(135deg, #0066CC 0%, #3e23ad 100%);
            padding: 80px 0 60px;
            color: #fff;
            text-align: center;
        }
        .faq-hero h1 {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 15px;
        }
        .faq-hero p {
            font-size: 18px;
            opacity: 0.95;
            max-width: 600px;
            margin: 0 auto;
        }
        .faq-search {
            max-width: 600px;
            margin: 30px auto 0;
            position: relative;
        }
        .faq-search input {
            width: 100%;
            padding: 15px 50px 15px 20px;
            border-radius: 50px;
            border: none;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .faq-search i {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: ##0066CC;
            font-size: 20px;
        }
        .faq-categories {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
            margin: 50px 0;
        }
        .faq-cat-btn {
            padding: 12px 28px;
            border: 2px solid #e0e0e0;
            border-radius: 25px;
            background: #fff;
            color: #666;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        .faq-cat-btn:hover,
        .faq-cat-btn.active {
            background: ##0066CC;
            color: #fff;
            border-color: ##0066CC;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        .faq-section {
            margin-bottom: 60px;
        }
        .faq-section-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid ##0066CC;
            display: inline-block;
        }
        .faq-item {
            background: #fff;
            border-radius: 12px;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
            transition: all 0.3s;
        }
        .faq-item:hover {
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .faq-question {
            padding: 20px 25px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            color: #333;
            font-size: 16px;
            user-select: none;
        }
        .faq-question:hover {
            color: ##0066CC;
        }
        .faq-question i {
            color: ##0066CC;
            font-size: 20px;
            transition: transform 0.3s;
        }
        .faq-question.active i {
            transform: rotate(180deg);
        }
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease, padding 0.4s ease;
            padding: 0 25px;
            color: #666;
            line-height: 1.8;
        }
        .faq-answer.active {
            max-height: 500px;
            padding: 0 25px 20px;
        }
        .faq-cta {
            background: linear-gradient(135deg, ##0066CC 0%, #764ba2 100%);
            padding: 60px 0;
            text-align: center;
            color: #fff;
            margin-top: 80px;
        }
        .faq-cta h3 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 15px;
        }
        .faq-cta p {
            font-size: 18px;
            margin-bottom: 25px;
            opacity: 0.95;
        }
        .faq-cta .btn-contact {
            padding: 15px 40px;
            background: #fff;
            color: ##0066CC;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .faq-cta .btn-contact:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }
        .no-results {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        .no-results i {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.3;
        }
    </style>
</head>
<body class="animsition">

    
	@include('client.body.header')
    @include('frontend.modal')

    <!-- Hero Section -->
    <div class="faq-hero">
        <div class="container">
            <h1>Questions Fréquentes</h1>
            <p>Trouvez rapidement les réponses à toutes vos questions</p>
            
            <div class="faq-search">
                <input type="text" id="faq-search-input" placeholder="Rechercher une question...">
                <i class="zmdi zmdi-search"></i>
            </div>
        </div>
    </div>

    <!-- Categories -->
    <div class="container">
        <div class="faq-categories">
            <button class="faq-cat-btn active" data-category="all">Toutes</button>
            <button class="faq-cat-btn" data-category="commande">Commandes</button>
            <button class="faq-cat-btn" data-category="livraison">Livraison</button>
            <button class="faq-cat-btn" data-category="paiement">Paiement</button>
            <button class="faq-cat-btn" data-category="retour">Retours & Échanges</button>
            <button class="faq-cat-btn" data-category="compte">Mon Compte</button>
        </div>
    </div>

    <!-- FAQ Content -->
    <div class="container p-b-80">
        
        <!-- Commandes -->
        <div class="faq-section" data-category="commande">
            <h2 class="faq-section-title"><i class="zmdi zmdi-shopping-cart m-r-10"></i>Commandes</h2>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>Comment passer une commande ?</span>
                    <i class="zmdi zmdi-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    Pour passer commande, ajoutez vos articles au panier en cliquant sur "Ajouter au panier". 
                    Une fois vos achats terminés, cliquez sur l'icône panier en haut à droite, vérifiez votre commande 
                    et cliquez sur "Commander". Suivez ensuite les étapes pour renseigner vos coordonnées et finaliser le paiement.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Puis-je modifier ma commande après validation ?</span>
                    <i class="zmdi zmdi-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    Vous pouvez modifier votre commande dans les 2 heures suivant sa validation en nous contactant 
                    via le formulaire de contact ou par téléphone. Passé ce délai, la commande sera déjà en préparation 
                    et ne pourra plus être modifiée.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Comment suivre ma commande ?</span>
                    <i class="zmdi zmdi-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    Vous recevrez un email de confirmation avec un numéro de suivi dès l'expédition de votre commande. 
                    Vous pouvez également suivre l'état de votre commande dans votre espace client, section "Mes commandes".
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Puis-je annuler ma commande ?</span>
                    <i class="zmdi zmdi-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    Oui, vous pouvez annuler votre commande gratuitement tant qu'elle n'a pas été expédiée. 
                    Contactez-nous rapidement via notre service client pour procéder à l'annulation. 
                    Si la commande est déjà expédiée, vous devrez suivre la procédure de retour.
                </div>
            </div>
        </div>

        <!-- Livraison -->
        <div class="faq-section" data-category="livraison">
            <h2 class="faq-section-title"><i class="zmdi zmdi-truck m-r-10"></i>Livraison</h2>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>Quels sont les délais de livraison ?</span>
                    <i class="zmdi zmdi-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    Les délais varient selon votre zone géographique :<br>
                    • Cotonou et environs : 24-48h<br>
                    • Autres villes du Bénin : 3-5 jours ouvrés<br>
                    • International : 7-15 jours ouvrés<br>
                    Ces délais sont donnés à titre indicatif et peuvent varier pendant les périodes de forte activité.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Quels sont les frais de livraison ?</span>
                    <i class="zmdi zmdi-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    • Livraison gratuite pour toute commande supérieure à 50 000 FCFA<br>
                    • Cotonou : 1 500 FCFA<br>
                    • Autres villes du Bénin : 2 500 FCFA<br>
                    • International : calculé selon la destination
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Livrez-vous à l'international ?</span>
                    <i class="zmdi zmdi-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    Oui, nous livrons dans la plupart des pays d'Afrique de l'Ouest et en Europe. 
                    Les frais de livraison et délais sont calculés automatiquement lors de votre commande 
                    en fonction de votre adresse de livraison.
                </div>
            </div>
        </div>

        <!-- Paiement -->
        <div class="faq-section" data-category="paiement">
            <h2 class="faq-section-title"><i class="zmdi zmdi-card m-r-10"></i>Paiement</h2>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>Quels modes de paiement acceptez-vous ?</span>
                    <i class="zmdi zmdi-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    Nous acceptons les modes de paiement suivants :<br>
                    • Cartes bancaires (Visa, Mastercard)<br>
                    • Mobile Money (MTN, Moov, Celtiis)<br>
                    • Paiement à la livraison (disponible uniquement à Cotonou)<br>
                    • Virement bancaire<br>
                    Tous les paiements sont sécurisés et cryptés.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Le paiement en ligne est-il sécurisé ?</span>
                    <i class="zmdi zmdi-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    Absolument ! Notre site utilise le protocole SSL (certificat de sécurité) pour crypter 
                    toutes vos données bancaires. Nous ne conservons aucune information bancaire sur nos serveurs. 
                    Les transactions sont traitées par des prestataires certifiés PCI-DSS.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Puis-je payer en plusieurs fois ?</span>
                    <i class="zmdi zmdi-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    Le paiement en plusieurs fois est disponible pour les commandes supérieures à 100 000 FCFA. 
                    Cette option vous sera proposée lors de la validation de votre panier. 
                    Vous pouvez régler en 2, 3 ou 4 fois sans frais.
                </div>
            </div>
        </div>

        <!-- Retours -->
        <div class="faq-section" data-category="retour">
            <h2 class="faq-section-title"><i class="zmdi zmdi-swap m-r-10"></i>Retours & Échanges</h2>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>Quelle est votre politique de retour ?</span>
                    <i class="zmdi zmdi-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    Vous disposez de 14 jours à compter de la réception de votre commande pour nous retourner 
                    un article qui ne vous convient pas. Les articles doivent être retournés dans leur emballage d'origine, 
                    non portés et avec toutes les étiquettes. Les frais de retour sont à votre charge sauf en cas d'erreur de notre part.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Comment effectuer un retour ?</span>
                    <i class="zmdi zmdi-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    1. Connectez-vous à votre compte et accédez à "Mes commandes"<br>
                    2. Sélectionnez la commande concernée et cliquez sur "Retourner un article"<br>
                    3. Choisissez le(s) article(s) à retourner et indiquez le motif<br>
                    4. Imprimez le bon de retour et joignez-le au colis<br>
                    5. Déposez le colis en point relais ou demandez un enlèvement à domicile
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Sous quel délai serai-je remboursé ?</span>
                    <i class="zmdi zmdi-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    Dès réception de votre retour dans nos entrepôts, nous procédons à la vérification des articles 
                    sous 48h. Le remboursement est effectué dans les 5 à 7 jours ouvrés suivant la validation du retour, 
                    sur le moyen de paiement utilisé lors de l'achat.
                </div>
            </div>
        </div>

        <!-- Compte -->
        <div class="faq-section" data-category="compte">
            <h2 class="faq-section-title"><i class="zmdi zmdi-account m-r-10"></i>Mon Compte</h2>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>Comment créer un compte ?</span>
                    <i class="zmdi zmdi-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    Cliquez sur "Mon Compte" en haut à droite du site, puis sur "Créer un compte". 
                    Remplissez le formulaire avec vos informations personnelles. Vous recevrez un email de confirmation 
                    pour activer votre compte. Avoir un compte vous permet de suivre vos commandes et de bénéficier d'offres exclusives.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>J'ai oublié mon mot de passe, que faire ?</span>
                    <i class="zmdi zmdi-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    Sur la page de connexion, cliquez sur "Mot de passe oublié ?". 
                    Entrez votre adresse email et vous recevrez un lien pour réinitialiser votre mot de passe. 
                    Si vous ne recevez pas d'email, vérifiez vos spams ou contactez notre service client.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Comment modifier mes informations personnelles ?</span>
                    <i class="zmdi zmdi-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    Connectez-vous à votre compte, puis accédez à la section "Mon profil". 
                    Vous pouvez y modifier vos informations (nom, adresse, téléphone, email). 
                    N'oubliez pas de cliquer sur "Enregistrer" pour valider vos modifications.
                </div>
            </div>
        </div>

        <!-- No Results Message -->
        <div class="no-results" style="display:none;">
            <i class="zmdi zmdi-search"></i>
            <h3>Aucun résultat trouvé</h3>
            <p>Essayez avec d'autres mots-clés ou contactez notre service client</p>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="faq-cta">
        <div class="container">
            <h3>Vous ne trouvez pas votre réponse ?</h3>
            <p>Notre équipe est là pour vous aider</p>
            <a href="{{ route('client.contact') }}" class="btn-contact">Contactez-nous</a>
        </div>
    </div>

   

    <script src="{{ asset('frontend/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/animsition/js/animsition.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    
	@include('frontend.global_js')
    <script>
    $(document).ready(function() {
        // Toggle FAQ
        $('.faq-question').click(function() {
            const answer = $(this).next('.faq-answer');
            const icon = $(this).find('i');
            
            // Fermer les autres
            $('.faq-answer').not(answer).removeClass('active');
            $('.faq-question i').not(icon).removeClass('active');
            
            // Toggle actuel
            answer.toggleClass('active');
            $(this).toggleClass('active');
        });

        // Filtre par catégorie
        $('.faq-cat-btn').click(function() {
            const category = $(this).data('category');
            
            $('.faq-cat-btn').removeClass('active');
            $(this).addClass('active');
            
            if (category === 'all') {
                $('.faq-section').fadeIn();
            } else {
                $('.faq-section').hide();
                $(`.faq-section[data-category="${category}"]`).fadeIn();
            }
            
            $('.no-results').hide();
        });

        // Recherche
        $('#faq-search-input').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            let hasResults = false;
            
            if (searchTerm === '') {
                $('.faq-item').show();
                $('.faq-section').show();
                $('.no-results').hide();
                return;
            }
            
            $('.faq-item').each(function() {
                const question = $(this).find('.faq-question span').text().toLowerCase();
                const answer = $(this).find('.faq-answer').text().toLowerCase();
                
                if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                    $(this).show();
                    $(this).closest('.faq-section').show();
                    hasResults = true;
                } else {
                    $(this).hide();
                }
            });
            
            // Masquer les sections vides
            $('.faq-section').each(function() {
                if ($(this).find('.faq-item:visible').length === 0) {
                    $(this).hide();
                }
            });
            
            $('.no-results').toggle(!hasResults);
        });
    });
    </script>
    
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
	<script src="{{ asset('frontend/js/main.js') }}"></script>

</body>
</html>