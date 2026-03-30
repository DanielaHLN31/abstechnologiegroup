{{-- ═══════════════════════════════════════════
    FOOTER — ABS TECHNOLOGIE
    Remplace entièrement ton ancien footer.blade.php
═══════════════════════════════════════════ --}}

<style>
/* ── Variables ── */
:root {
    --ft-bg:        #060e20;
    --ft-bg2:       #0b1628;
    --ft-blue:      #0066CC;
    --ft-blue-lt:   #3389d6;
    --ft-red:       #b80505;
    --ft-border:    rgba(255,255,255,0.07);
    --ft-text:      rgba(255,255,255,0.55);
    --ft-text-hl:   rgba(255,255,255,0.88);
}

/* ── Wrapper principal ── */
.abs-footer {
    background: var(--ft-bg);
    font-family: 'DM Sans', 'Poppins-Regular', sans-serif;
    position: relative;
    overflow: hidden;
}

/* ── Décor top-edge ── */
.abs-footer__topbar {
    height: 3px;
    background: linear-gradient(90deg, var(--ft-blue) 0%, var(--ft-red) 55%, var(--ft-blue) 100%);
}

/* ── Cercles décoratifs (fond) ── */
.abs-footer::before {
    content: '';
    position: absolute;
    top: -120px; right: -120px;
    width: 420px; height: 420px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(0,102,204,0.08) 0%, transparent 70%);
    pointer-events: none;
}
.abs-footer::after {
    content: '';
    position: absolute;
    bottom: 80px; left: -80px;
    width: 280px; height: 280px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(184,5,5,0.06) 0%, transparent 70%);
    pointer-events: none;
}

/* ── Corps principal ── */
.abs-footer__body {
    max-width: 1200px;
    margin: 0 auto;
    padding: 60px 32px 40px;
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1.4fr;
    gap: 40px;
}

@media (max-width: 991px) {
    .abs-footer__body {
        grid-template-columns: 1fr 1fr;
        gap: 36px 32px;
        padding: 48px 24px 36px;
    }
}

@media (max-width: 575px) {
    .abs-footer__body {
        grid-template-columns: 1fr;
        gap: 32px;
        padding: 40px 20px 28px;
    }
}

/* ── Colonne brand ── */
.abs-footer__brand {}

.abs-footer__logo {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    margin-bottom: 18px;
    text-decoration: none;
}

.abs-footer__logo-main {
    font-family: 'Syne', sans-serif;
    font-size: 22px;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.03em;
}

.abs-footer__logo-main span {
    color: var(--ft-blue);
}

.abs-footer__logo-badge {
    display: inline-block;
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--ft-blue);
    background: rgba(0,102,204,0.15);
    border: 1px solid rgba(0,102,204,0.3);
    border-radius: 4px;
    padding: 2px 6px;
    margin-left: 6px;
    vertical-align: middle;
    align-self: center;
}

.abs-footer__tagline {
    font-size: 13px;
    line-height: 1.65;
    color: var(--ft-text);
    max-width: 260px;
    margin-bottom: 24px;
}

/* Réseaux sociaux */
.abs-footer__socials {
    display: flex;
    gap: 10px;
}

.abs-footer__social {
    width: 38px; height: 38px;
    border-radius: 10px;
    border: 1px solid var(--ft-border);
    background: rgba(255,255,255,0.04);
    display: flex; align-items: center; justify-content: center;
    color: var(--ft-text);
    font-size: 16px;
    text-decoration: none;
    transition: all 0.25s ease;
}

.abs-footer__social:hover {
    background: var(--ft-blue);
    border-color: var(--ft-blue);
    color: #fff;
    transform: translateY(-3px);
}

.abs-footer__social.whatsapp:hover {
    background: #25D366;
    border-color: #25D366;
}

/* ── Colonnes liens ── */
.abs-footer__col-title {
    font-family: 'Syne', sans-serif;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #fff;
    margin-bottom: 20px;
    position: relative;
    padding-bottom: 12px;
}

.abs-footer__col-title::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0;
    width: 24px; height: 2px;
    background: var(--ft-blue);
    border-radius: 1px;
}

.abs-footer__links {
    list-style: none;
    margin: 0; padding: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.abs-footer__links a {
    font-size: 13px;
    color: var(--ft-text);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    transition: color 0.2s ease, gap 0.2s ease;
}

.abs-footer__links a::before {
    content: '';
    display: inline-block;
    width: 4px; height: 4px;
    border-radius: 50%;
    background: var(--ft-blue);
    opacity: 0;
    flex-shrink: 0;
    transition: opacity 0.2s ease;
}

.abs-footer__links a:hover {
    color: var(--ft-text-hl);
    gap: 10px;
}

.abs-footer__links a:hover::before {
    opacity: 1;
}

/* ── Colonne contact ── */
.abs-footer__contact-list {
    list-style: none;
    margin: 0; padding: 0;
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.abs-footer__contact-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.abs-footer__contact-icon {
    width: 32px; height: 32px;
    border-radius: 8px;
    background: rgba(0,102,204,0.12);
    border: 1px solid rgba(0,102,204,0.2);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    font-size: 13px;
    color: var(--ft-blue);
}

.abs-footer__contact-text {
    font-size: 12.5px;
    color: var(--ft-text);
    line-height: 1.55;
}

.abs-footer__contact-text a {
    color: var(--ft-text);
    text-decoration: none;
    transition: color 0.2s;
}

.abs-footer__contact-text a:hover {
    color: var(--ft-text-hl);
}

/* ── Newsletter ── */
.abs-footer__newsletter-text {
    font-size: 13px;
    color: var(--ft-text);
    line-height: 1.6;
    margin-bottom: 16px;
}

.abs-footer__newsletter-form {
    display: flex;
    gap: 0;
    background: rgba(255,255,255,0.05);
    border: 1px solid var(--ft-border);
    border-radius: 10px;
    overflow: hidden;
    transition: border-color 0.2s;
}

.abs-footer__newsletter-form:focus-within {
    border-color: rgba(0,102,204,0.5);
}

.abs-footer__newsletter-form input {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    padding: 11px 14px;
    font-size: 13px;
    color: var(--ft-text-hl);
    min-width: 0;
}

.abs-footer__newsletter-form input::placeholder {
    color: rgba(255,255,255,0.25);
}

.abs-footer__newsletter-btn {
    background: var(--ft-blue);
    border: none;
    padding: 11px 16px;
    color: #fff;
    font-size: 13px;
    cursor: pointer;
    transition: background 0.2s;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    gap: 6px;
    font-family: 'DM Sans', sans-serif;
    font-weight: 500;
}

.abs-footer__newsletter-btn:hover {
    background: #004FA3;
}

/* ── Séparateur ── */
.abs-footer__sep {
    max-width: 1200px;
    margin: 0 auto;
    height: 1px;
    background: var(--ft-border);
    margin-left: 32px;
    margin-right: 32px;
}

@media (max-width: 575px) {
    .abs-footer__sep {
        margin-left: 20px;
        margin-right: 20px;
    }
}

/* ── Bottom bar ── */
.abs-footer__bottom {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px 32px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
}

@media (max-width: 575px) {
    .abs-footer__bottom {
        padding: 16px 20px 20px;
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
}

.abs-footer__copy {
    font-size: 12px;
    color: var(--ft-text);
}

.abs-footer__copy a {
    color: var(--ft-blue-lt);
    text-decoration: none;
    transition: color 0.2s;
}

.abs-footer__copy a:hover {
    color: #fff;
}

.abs-footer__made {
    font-size: 12px;
    color: rgba(255,255,255,0.3);
}

.abs-footer__made a {
    color: rgba(255,255,255,0.45);
    text-decoration: none;
    transition: color 0.2s;
}

.abs-footer__made a:hover {
    color: var(--ft-text-hl);
}
</style>

<!-- ══════════════════════════ FOOTER ══════════════════════════ -->
<footer class="abs-footer">

    <!-- Liseré top -->
    <div class="abs-footer__topbar"></div>

    <!-- Corps -->
    <div class="abs-footer__body">

        <!-- ── Colonne 1 : Brand ── -->
        <div class="abs-footer__brand">
            <a href="{{ route('client.index') }}" class="abs-footer__logo">
                <span class="abs-footer__logo-main"><span>ABS</span> Technologie</span>
                <span class="abs-footer__logo-badge">Group</span>
            </a>
            <p class="abs-footer__tagline">
                Votre partenaire tech au Bénin — smartphones, informatique &amp; électroménager certifiés, livrés à Cotonou.
            </p>
            <div class="abs-footer__socials">
                <a href="https://facebook.com/abstechnologiegroup" target="_blank" 
                   class="abs-footer__social" title="Facebook">
                    <!-- Facebook -->
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://wa.me/2290196062626" target="_blank" 
                   class="abs-footer__social whatsapp" title="WhatsApp">

                    <!-- WhatsApp -->
                    <i class="fab fa-whatsapp"></i>
                </a>
                {{-- <a href="mailto:dc@abstechnologie.com" 
                   class="abs-footer__social" title="Email">
                    <i class="fa fa-envelope"></i>
                </a> --}}
            </div>
        </div>

        <!-- ── Colonne 2 : Catégories ── -->
        <div>
            <h4 class="abs-footer__col-title">Catégories</h4>
            <ul class="abs-footer__links">
                @if(isset($categories) && $categories->count() > 0)
                    @foreach($categories->take(5) as $category)
                    <li>
                        <a href="{{ route('client.product', ['category' => $category->id]) }}">
                            {{ $category->name }}
                        </a>
                    </li>
                    @endforeach
                @else
                    <li><a href="#">Téléphonie</a></li>
                    <li><a href="#">Informatique</a></li>
                    <li><a href="#">Électroménager</a></li>
                    <li><a href="#">Accessoires</a></li>
                @endif
            </ul>
        </div>

        <!-- ── Colonne 3 : Aide ── -->
        <div>
            <h4 class="abs-footer__col-title">Aide</h4>
            <ul class="abs-footer__links">
                <li><a href="{{ route('client.my.orders') }}">Suivre ma commande</a></li>
                <li><a href="{{ route('client.about') }}">À propos</a></li>
                <li><a href="{{ route('client.contact') }}">Livraison</a></li>
                <li><a href="{{ route('client.faqs') }}">FAQs</a></li>
            </ul>
        </div>

        <!-- ── Colonne 4 : Contact + Newsletter ── -->
        <div>
            <h4 class="abs-footer__col-title">Contact</h4>
            <ul class="abs-footer__contact-list" style="margin-bottom: 28px;">
                <li class="abs-footer__contact-item">
                    <div class="abs-footer__contact-icon">
                        <i class="fa fa-map-marker"></i>
                    </div>
                    <span class="abs-footer__contact-text">
                        CAMP-GUEZO, Face HIA<br>Cotonou, Bénin
                    </span>
                </li>
                <li class="abs-footer__contact-item">
                    <div class="abs-footer__contact-icon">
                        <i class="fa fa-phone"></i>
                    </div>
                    <span class="abs-footer__contact-text">
                        <a href="tel:+22901 96 06 06 26">(+229) 01 96 06 06 26</a>
                    </span>
                </li>
                <li class="abs-footer__contact-item">
                    <div class="abs-footer__contact-icon">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <span class="abs-footer__contact-text">
                        <a href="mailto:dc@abstechnologie.com">dc@abstechnologie.com</a>
                    </span>
                </li>
            </ul>

        </div>

    </div>

    <!-- Séparateur -->
    <div class="abs-footer__sep"></div>

    <!-- Bottom bar -->
    <div class="abs-footer__bottom">
        <p class="abs-footer__copy">
            &copy;<script>document.write(new Date().getFullYear());</script>
            <a href="{{ route('client.index') }}">ABS Technologie Group</a>.
            Tous droits réservés.
        </p>
        <p class="abs-footer__made">
            Réalisé par <a href="https://abstechnologie.com" target="_blank">ABS Technologie Group</a>
        </p>
    </div>

</footer>

<!-- Back to top -->
<div class="btn-back-to-top" id="myBtn">
    <span class="symbol-btn-back-to-top">
        <i class="zmdi zmdi-chevron-up"></i>
    </span>
</div>