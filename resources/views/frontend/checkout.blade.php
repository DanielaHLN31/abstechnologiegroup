<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Validation Commande - ABS-TECHNOLOGIE</title>
    @include('client.body.head')
    <style>
        /* Variables de couleur */
        :root {
            --primary: #717fe0;
            --primary-dark: #5a67d8;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --gray-light: #f8f9fa;
            --gray-border: #e9ecef;
            --text-dark: #212529;
            --text-muted: #6c757d;
        }

        /* Styles généraux */
        .checkout-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        /* Étapes */
        .checkout-steps {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            margin-bottom: 50px;
            padding: 20px 0;
        }
        .step {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
        }
        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            transition: all 0.3s;
        }
        .step.completed .step-number {
            background: var(--success);
            color: white;
        }
        .step.active .step-number {
            background: var(--primary);
            color: white;
            box-shadow: 0 0 0 4px rgba(113, 127, 224, 0.2);
        }
        .step.pending .step-number {
            background: #e9ecef;
            color: #adb5bd;
        }
        .step-line {
            width: 60px;
            height: 2px;
            background: var(--gray-border);
            margin: 0 15px;
        }
        .step.completed + .step-line {
            background: var(--success);
        }

        /* Cartes */
        .checkout-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            padding: 30px;
            margin-bottom: 30px;
        }
        .checkout-card-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--gray-border);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .checkout-card-title i {
            color: var(--primary);
            font-size: 24px;
        }

        /* Champs de formulaire */
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }
        .form-label .required {
            color: var(--danger);
            margin-left: 3px;
        }
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--gray-border);
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.2s;
            background: white;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(113, 127, 224, 0.1);
        }
        .form-control.is-invalid {
            border-color: var(--danger);
        }
        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        /* Options de paiement */
        .payment-options {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .payment-option {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px;
            border: 2px solid var(--gray-border);
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .payment-option:hover {
            border-color: var(--primary);
            background: rgba(113, 127, 224, 0.05);
        }
        .payment-option.selected {
            border-color: var(--primary);
            background: rgba(113, 127, 224, 0.05);
        }
        .payment-radio {
            width: 20px;
            height: 20px;
            accent-color: var(--primary);
            flex-shrink: 0;
        }
        .payment-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            flex-shrink: 0;
        }
        .payment-icon.mtn {
            background: #FFCC00;
            color: #000;
        }
        .payment-icon.moov {
            background: #0057A8;
            color: #fff;
        }
        .payment-icon.celtiis {
            background: #E30613;
            color: #fff;
            font-size: 12px;
        }
        .payment-icon.cash {
            background: var(--gray-light);
            color: var(--text-muted);
        }
        .payment-info {
            flex: 1;
        }
        .payment-title {
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
        }
        .payment-desc {
            font-size: 12px;
            color: var(--text-muted);
        }

        /* Info FedaPay */
        .fedapay-info {
            margin-top: 20px;
            padding: 15px;
            background: linear-gradient(135deg, #f0f6ff 0%, #e8f0fe 100%);
            border-radius: 12px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 13px;
            color: var(--primary-dark);
        }
        .fedapay-info i {
            font-size: 20px;
            flex-shrink: 0;
        }

        /* Résumé commande */
        .order-summary {
            background: white;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            padding: 30px;
            position: sticky;
            top: 100px;
        }
        .order-summary h3 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--gray-border);
        }
        .order-items {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 20px;
        }
        .order-item {
            display: flex;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid var(--gray-border);
        }
        .order-item-img {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            object-fit: cover;
            background: var(--gray-light);
            position: relative;
        }
        .order-item-qty {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--primary);
            color: white;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
        }
        .order-item-info {
            flex: 1;
        }
        .order-item-name {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 5px;
        }
        .order-item-color {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: var(--text-muted);
        }
        .order-item-price {
            font-weight: 700;
            color: var(--primary);
            flex-shrink: 0;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            font-size: 14px;
        }
        .summary-row.total {
            border-top: 2px solid var(--gray-border);
            margin-top: 10px;
            padding-top: 20px;
            font-size: 18px;
            font-weight: 700;
        }
        .summary-row.total .summary-value {
            color: var(--primary);
            font-size: 22px;
        }

        /* Bouton de confirmation */
        .confirm-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            border-radius: 40px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .confirm-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(113, 127, 224, 0.3);
        }
        .confirm-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Alertes */
        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        .alert-danger {
            background: #fef2f0;
            border: 1px solid #ffcdc7;
            color: var(--danger);
        }
        .alert-warning {
            background: #fff8e7;
            border: 1px solid #ffe6b3;
            color: #856404;
        }
        .alert i {
            font-size: 20px;
            flex-shrink: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .checkout-steps {
                flex-wrap: wrap;
            }
            .step-line {
                display: none;
            }
            .checkout-card {
                padding: 20px;
            }
            .order-summary {
                margin-top: 30px;
                position: static;
            }
        }
    </style>

    <style>
        /* ── Hero Checkout ─────────────────────────────────────── */
        .co-hero {
            background: linear-gradient(135deg, #f4f7fc 0%, #e8f0fb 100%);
            padding: 36px 0 0;
            position: relative;
            overflow: hidden;
            margin-top: 97px;
        }

        .co-hero::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: rgba(0,102,204,0.05);
            pointer-events: none;
        }

        .co-hero__inner {
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 24px 32px;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
            flex-wrap: wrap;
        }

        /* Titre */
        .co-hero__title-wrap {}
        .co-hero__pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #b80505;
            background: #fbe6e6;
            border: 1px solid rgba(204, 0, 0, 0.22);
            border-radius: 100px;
            padding: 4px 14px;
            margin-bottom: 12px;
        }
        .co-hero__pill-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #b80505;
            animation: co-pulse 1.8s ease-in-out infinite;
        }
        @keyframes co-pulse {
            0%,100%{transform:scale(1);opacity:1}
            50%{transform:scale(1.5);opacity:.5}
        }
        .co-hero__h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(22px, 3vw, 32px);
            font-weight: 800;
            color: #0a1628;
            line-height: 1.2;
            letter-spacing: -0.02em;
            margin: 0 0 6px;
        }
        .co-hero__h1 span { color: #0066CC; }
        .co-hero__sub {
            font-size: 13px;
            color: #6b7a99;
            margin: 0;
        }

        /* Étapes (stepper) */
        .co-stepper {
            display: flex;
            align-items: center;
            gap: 0;
        }
        .co-step {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #aab4c0;
            white-space: nowrap;
        }
        .co-step.done  { color: #22a05e; }
        .co-step.active{ color: #0066CC; }

        .co-step__num {
            width: 30px; height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
            background: #e0e6ee;
            color: #aab4c0;
            transition: background .25s, color .25s;
        }
        .co-step.done .co-step__num {
            background: #22a05e;
            color: #fff;
        }
        .co-step.active .co-step__num {
            background: #0066CC;
            color: #fff;
            box-shadow: 0 0 0 4px rgba(0,102,204,0.15);
        }

        .co-step__check {
            display: none;
        }
        .co-step.done .co-step__check { display: block; }
        .co-step.done .co-step__num-inner { display: none; }

        .co-sep {
            width: 48px;
            height: 2px;
            background: #e0e6ee;
            margin: 0 4px;
            flex-shrink: 0;
        }
        .co-sep.done { background: #22a05e; }

        /* Barre de confiance */
        .co-trust {
            background: #fff;
            border-top: 1px solid rgba(0,102,204,0.08);
            padding: 12px 24px;
        }
        .co-trust__inner {
            max-width: 1140px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 32px;
            flex-wrap: wrap;
        }
        .co-trust__item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #6b7a99;
            font-weight: 500;
        }
        .co-trust__item svg {
            width: 16px; height: 16px;
            stroke: #0066CC;
            fill: none;
            stroke-width: 1.8;
            flex-shrink: 0;
        }

        @media (max-width: 640px) {
            .co-hero__inner { flex-direction: column; align-items: flex-start; gap: 20px; }
            .co-sep { width: 28px; }
            .co-trust__inner { gap: 16px; }
            .co-trust__item span { display: none; }
        }
    </style>

    <style>
        /* ══════════════════════════════════════════════
        CHECKOUT — Design System
        ══════════════════════════════════════════════ */
        :root {
            --ck-blue:      #0066CC;
            --ck-blue-d:    #004FA3;
            --ck-blue-xl:   #E6F1FB;
            --ck-red:       #CC1E1E;
            --ck-green:     #16a34a;
            --ck-surface:   #f4f7fd;
            --ck-white:     #ffffff;
            --ck-border:    rgba(0,102,204,0.12);
            --ck-border2:   #eef2fb;
            --ck-dark:      #0a1628;
            --ck-muted:     #6b7a99;
            --ck-muted2:    #b0bcd4;
            --ck-radius:    16px;
            --ck-radius-sm: 10px;
        }

        /* ── Wrapper global ── */
        .checkout-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 24px 80px;
            font-family: 'DM Sans', sans-serif;
        }

        /* ══ ALERTES ══ */
        .ck-alert {
            display: flex; align-items: flex-start; gap: 12px;
            padding: 14px 18px;
            border-radius: var(--ck-radius-sm);
            margin-bottom: 24px;
            font-size: 13px; line-height: 1.6;
        }
        .ck-alert--warn {
            background: #fffbeb;
            border: 1px solid #fde68a;
            color: #92400e;
        }
        .ck-alert--error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }
        .ck-alert i { font-size: 18px; flex-shrink: 0; margin-top: 1px; }
        .ck-alert ul { margin: 6px 0 0 16px; padding: 0; }
        .ck-alert a { color: inherit; font-weight: 600; text-decoration: underline; }

        /* ══ LAYOUT : 2 colonnes ══ */
        .ck-grid {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 24px;
            align-items: start;
        }
        @media (max-width: 960px) {
            .ck-grid { grid-template-columns: 1fr; }
            .ck-summary { order: -1; }
        }

        /* ══ CARD de section ══ */
        .ck-card {
            background: var(--ck-white);
            border: 1.5px solid var(--ck-border);
            border-radius: var(--ck-radius);
            padding: 28px 28px 24px;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
            transition: box-shadow .3s;
        }
        .ck-card:hover { box-shadow: 0 8px 32px rgba(0,102,204,.08); }

        /* Accent bar top */
        .ck-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--ck-blue), #4da6ff);
            opacity: 0;
            transition: opacity .3s;
        }
        .ck-card:focus-within::before { opacity: 1; }

        /* ── Titre de section ── */
        .ck-card-head {
            display: flex; align-items: center; gap: 12px;
            margin-bottom: 24px; padding-bottom: 18px;
            border-bottom: 1px solid var(--ck-border2);
        }
        .ck-card-head-icon {
            width: 38px; height: 38px; border-radius: 10px;
            background: #b8050559;
            border: 1px solid rgba(204, 0, 0, 0.18);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: #b80505; flex-shrink: 0;
        }
        .ck-card-head-text {}
        .ck-card-head-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 16px; font-weight: 700;
            color: var(--ck-dark); line-height: 1.2;
        }
        .ck-card-head-sub {
            font-size: 12px; color: var(--ck-muted);
            margin-top: 2px;
        }

        /* ══ FORMULAIRE ══ */
        .ck-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .ck-row.full { grid-template-columns: 1fr; }
        @media (max-width: 600px) { .ck-row { grid-template-columns: 1fr; } }

        .ck-field { display: flex; flex-direction: column; gap: 6px; }

        .ck-label {
            font-size: 12px; font-weight: 600;
            color: var(--ck-dark); letter-spacing: .04em;
            text-transform: uppercase;
        }
        .ck-label .req { color: var(--ck-red); margin-left: 2px; }

        .ck-input,
        .ck-select,
        .ck-textarea {
            width: 100%; padding: 11px 14px;
            background: var(--ck-surface);
            border: 1.5px solid var(--ck-border2);
            border-radius: var(--ck-radius-sm);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px; color: var(--ck-dark);
            transition: border-color .2s, box-shadow .2s, background .2s;
            outline: none;
        }
        .ck-input:focus,
        .ck-select:focus,
        .ck-textarea:focus {
            border-color: var(--ck-blue);
            background: var(--ck-white);
            box-shadow: 0 0 0 3px rgba(0,102,204,.1);
        }
        .ck-input.is-invalid,
        .ck-select.is-invalid { border-color: var(--ck-red); }
        .ck-input::placeholder { color: var(--ck-muted2); }
        .ck-textarea { resize: vertical; min-height: 80px; }
        .ck-select { appearance: none; cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7a99' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 14px center;
            padding-right: 36px;
        }
        .ck-error { font-size: 11px; color: var(--ck-red); margin-top: 2px; }

        /* Input avec icon */
        .ck-input-wrap {
            position: relative;
        }
        .ck-input-wrap .ck-input-icon {
            position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
            font-size: 16px; color: var(--ck-muted); pointer-events: none;
        }
        .ck-input-wrap .ck-input { padding-left: 38px; }

        /* ══ PAIEMENT ══ */
        .ck-payments { display: flex; flex-direction: column; gap: 10px; }

        .ck-pay-opt {
            position: relative;
            display: flex; align-items: center; gap: 14px;
            padding: 16px 18px;
            background: var(--ck-surface);
            border: 1.5px solid var(--ck-border2);
            border-radius: var(--ck-radius-sm);
            cursor: pointer;
            transition: all .2s;
            user-select: none;
        }
        .ck-pay-opt:hover {
            border-color: rgba(0,102,204,.35);
            background: #eef5ff;
        }
        .ck-pay-opt--active {
            border-color: var(--ck-blue) !important;
            background: #eef5ff !important;
            box-shadow: 0 4px 16px rgba(0,102,204,.12);
        }

        /* Radio custom */
        .ck-pay-opt input[type="radio"] { display: none; }
        .ck-radio-custom {
            width: 20px; height: 20px; border-radius: 50%;
            border: 2px solid var(--ck-border2);
            background: var(--ck-white);
            flex-shrink: 0; position: relative;
            transition: border-color .2s;
        }
        .ck-pay-opt--active .ck-radio-custom {
            border-color: var(--ck-blue);
        }
        .ck-radio-custom::after {
            content: '';
            position: absolute; top: 50%; left: 50%;
            transform: translate(-50%,-50%) scale(0);
            width: 10px; height: 10px; border-radius: 50%;
            background: var(--ck-blue);
            transition: transform .2s cubic-bezier(.34,1.56,.64,1);
        }
        .ck-pay-opt--active .ck-radio-custom::after { transform: translate(-50%,-50%) scale(1); }

        /* Icon paiement */
        .ck-pay-icon {
            width: 44px; height: 44px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 800; flex-shrink: 0;
            letter-spacing: .04em;
        }
        .ck-pay-icon--cash    { background: #f0fdf4; color: var(--ck-green); font-size: 22px; }
        .ck-pay-icon--mtn     { background: #FFCC00; color: #000; }
        .ck-pay-icon--moov    { background: #0057A8; color: #fff; }
        .ck-pay-icon--celtiis { background: #E30613; color: #fff; }

        .ck-pay-info {}
        .ck-pay-name {
            font-family: 'Montserrat', sans-serif;
            font-size: 14px; font-weight: 700; color: var(--ck-dark);
        }
        .ck-pay-desc { font-size: 12px; color: var(--ck-muted); margin-top: 2px; }

        /* Badge "Recommandé" */
        .ck-pay-badge {
            position: absolute; top: 12px; right: 14px;
            font-size: 10px; font-weight: 700; letter-spacing: .06em;
            text-transform: uppercase;
            padding: 3px 10px; border-radius: 100px;
            background: #d1fae5; color: #065f46;
        }

        /* FedaPay info box */
        .ck-fedapay-note {
            display: flex; align-items: flex-start; gap: 10px;
            background: #eff6ff; border: 1px solid #bfdbfe;
            border-radius: var(--ck-radius-sm);
            padding: 12px 14px; margin-top: 14px;
            font-size: 12px; color: #1e40af;
            line-height: 1.6; display: none;
        }
        .ck-fedapay-note i { font-size: 16px; flex-shrink: 0; margin-top: 1px; }

        /* ══ BOUTON CONFIRMER ══ */
        .ck-submit-wrap { margin-top: 4px; }
        .ck-submit-btn {
            width: 100%; height: 54px;
            background: var(--ck-blue);
            color: #fff; border: none;
            border-radius: 14px;
            font-family: 'Montserrat', sans-serif;
            font-size: 15px; font-weight: 700; letter-spacing: .04em;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            transition: background .25s, transform .2s, box-shadow .3s;
            position: relative; overflow: hidden;
        }
        .ck-submit-btn::after {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,.18) 50%, transparent 100%);
            transform: translateX(-100%);
            transition: transform .55s ease;
        }
        .ck-submit-btn:hover::after { transform: translateX(100%); }
        .ck-submit-btn:hover:not(:disabled) {
            background: var(--ck-blue-d);
            transform: translateY(-2px);
            box-shadow: 0 14px 32px rgba(0,102,204,.38);
        }
        .ck-submit-btn:disabled { opacity: .6; cursor: not-allowed; transform: none; box-shadow: none; }

        .ck-submit-trust {
            display: flex; align-items: center; justify-content: center; gap: 16px;
            margin-top: 12px; flex-wrap: wrap;
        }
        .ck-submit-trust span {
            display: flex; align-items: center; gap: 5px;
            font-size: 11px; color: var(--ck-muted);
        }
        .ck-submit-trust i { font-size: 13px; color: var(--ck-blue); }

        /* ══ RÉSUMÉ COMMANDE ══ */
        .ck-summary {
            background: var(--ck-white);
            border: 1.5px solid var(--ck-border);
            border-radius: var(--ck-radius);
            overflow: hidden;
            /* position: sticky; */
            top: 100px;
            box-shadow: 0 8px 32px rgba(0,102,204,.06);
        }

        .ck-summary-head {
            background: var(--ck-blue);
            padding: 20px 24px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .ck-summary-head-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 15px; font-weight: 700; color: #fff;
            display: flex; align-items: center; gap: 8px;
        }
        .ck-summary-head-count {
            background: rgba(255,255,255,.2);
            color: #fff; font-size: 12px; font-weight: 600;
            padding: 3px 10px; border-radius: 100px;
        }

        /* Items liste */
        .ck-items { max-height: 340px; overflow-y: auto; padding: 0 24px; }
        .ck-items::-webkit-scrollbar { width: 3px; }
        .ck-items::-webkit-scrollbar-thumb { background: #dde6f5; border-radius: 4px; }

        .ck-item {
            display: flex; align-items: center; gap: 12px;
            padding: 14px 0;
            border-bottom: 1px solid var(--ck-border2);
        }
        .ck-item:last-child { border-bottom: none; }

        .ck-item-img-wrap {
            position: relative; flex-shrink: 0;
        }
        .ck-item-img {
            width: 56px; height: 56px;
            border-radius: 10px; object-fit: cover;
            background: var(--ck-surface);
            border: 1px solid var(--ck-border2);
        }
        .ck-item-qty {
            position: absolute; top: -6px; right: -6px;
            width: 20px; height: 20px; border-radius: 50%;
            background: var(--ck-blue); color: #fff;
            font-size: 10px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            border: 2px solid #fff;
        }

        .ck-item-body { flex: 1; min-width: 0; }
        .ck-item-name {
            font-size: 13px; font-weight: 600; color: var(--ck-dark);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
            margin-bottom: 4px;
        }
        .ck-item-color {
            display: flex; align-items: center; gap: 5px;
            font-size: 11px; color: var(--ck-muted);
        }
        .ck-item-color-dot {
            width: 10px; height: 10px; border-radius: 50%;
            border: 1px solid rgba(0,0,0,.1); flex-shrink: 0;
        }

        .ck-item-price {
            font-family: 'Montserrat', sans-serif;
            font-size: 13px; font-weight: 700;
            color: var(--ck-blue); flex-shrink: 0;
        }

        /* Totaux */
        .ck-totals { padding: 16px 24px 0; }

        .ck-total-row {
            display: flex; align-items: center; justify-content: space-between;
            padding: 9px 0; font-size: 13px; color: var(--ck-muted);
            border-bottom: 1px solid var(--ck-border2);
        }
        .ck-total-row:last-of-type { border-bottom: none; }
        .ck-total-row--grand {
            padding: 14px 0 0; margin-top: 4px;
            font-size: 16px; font-weight: 700; color: var(--ck-dark);
            border-bottom: none !important;
        }
        .ck-total-row--grand .ck-total-val {
            font-family: 'Montserrat', sans-serif;
            font-size: 22px; font-weight: 800; color: var(--ck-blue);
        }
        .ck-delivery-tag {
            font-size: 11px; font-weight: 600;
            color: var(--ck-green);
            background: #f0fdf4; border-radius: 100px;
            padding: 3px 10px;
        }

        /* Promo code */
        .ck-promo { padding: 16px 24px; border-top: 1px solid var(--ck-border2); }
        .ck-promo-row {
            display: flex; gap: 8px;
        }
        .ck-promo-input {
            flex: 1; padding: 10px 14px;
            background: var(--ck-surface);
            border: 1.5px solid var(--ck-border2);
            border-radius: var(--ck-radius-sm);
            font-size: 13px; color: var(--ck-dark); outline: none;
            transition: border-color .2s;
        }
        .ck-promo-input:focus { border-color: var(--ck-blue); }
        .ck-promo-input::placeholder { color: var(--ck-muted2); }
        .ck-promo-btn {
            padding: 10px 16px;
            background: var(--ck-surface);
            border: 1.5px solid var(--ck-border2);
            border-radius: var(--ck-radius-sm);
            font-size: 12px; font-weight: 600; color: var(--ck-blue);
            cursor: pointer; white-space: nowrap;
            transition: background .2s, border-color .2s;
        }
        .ck-promo-btn:hover { background: var(--ck-blue-xl); border-color: rgba(0,102,204,.3); }

        /* CTA dans summary */
        .ck-summary-cta { padding: 16px 24px 24px; }
        .ck-summary-cta-btn {
            width: 100%; height: 50px;
            background: var(--ck-blue); color: #fff;
            border: none; border-radius: 12px;
            font-family: 'Montserrat', sans-serif;
            font-size: 14px; font-weight: 700; letter-spacing: .04em;
            cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;
            transition: background .25s, box-shadow .25s, transform .2s;
        }
        .ck-summary-cta-btn:hover {
            background: var(--ck-blue-d);
            box-shadow: 0 10px 28px rgba(0,102,204,.3);
            transform: translateY(-1px);
        }

        /* ── Error global ── */
        .ck-error-global {
            display: flex; align-items: flex-start; gap: 10px;
            background: #fef2f2; border: 1px solid #fecaca;
            border-radius: var(--ck-radius-sm);
            padding: 12px 16px; margin-top: 16px;
            font-size: 13px; color: #991b1b; line-height: 1.6;
        }
        .ck-error-global i { font-size: 17px; flex-shrink: 0; margin-top: 1px; }

        /* ── Animations ── */
        @keyframes ck-fadein {
            from { opacity:0; transform:translateY(12px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .ck-card, .ck-summary { animation: ck-fadein .5s both; }
        .ck-card:nth-child(2) { animation-delay: .1s; }
        .ck-card:nth-child(3) { animation-delay: .2s; }
    </style>

</head>
<body class="animsition">

@include('client.body.header')
@include('frontend.modal')


<div class="co-hero">
    <div class="co-hero__inner">

        {{-- Titre --}}
        <div class="co-hero__title-wrap">
            <div class="co-hero__pill">
                <span class="co-hero__pill-dot"></span>
                Commande sécurisée
            </div>
            <h1 class="co-hero__h1">Finaliser ma <span>commande</span></h1>
            <p class="co-hero__sub">Livraison rapide au cœur de Cotonou &amp; paiement sécurisé</p>
        </div>

        {{-- Stepper --}}
        <div class="co-stepper">

            {{-- Étape 1 : Panier (toujours done) --}}
            <div class="co-step done">
                <div class="co-step__num">
                    <svg class="co-step__check" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <span class="co-step__num-inner">1</span>
                </div>
                <span>Panier</span>
            </div>

            <div class="co-sep done"></div>

            {{-- Étape 2 : Livraison & Paiement (active) --}}
            <div class="co-step active">
                <div class="co-step__num">
                    <span class="co-step__num-inner">2</span>
                </div>
                <span>Livraison &amp; Paiement</span>
            </div>

            <div class="co-sep"></div>

            {{-- Étape 3 : Confirmation --}}
            <div class="co-step">
                <div class="co-step__num">
                    <span class="co-step__num-inner">3</span>
                </div>
                <span>Confirmation</span>
            </div>

        </div>

    </div>

    {{-- Barre de confiance --}}
    <div class="co-trust">
        <div class="co-trust__inner">
            <div class="co-trust__item">
                <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                <span>Paiement sécurisé FedaPay</span>
            </div>
            <div class="co-trust__item">
                <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                <span>Livraison 24h à Cotonou</span>
            </div>
            <div class="co-trust__item">
                <svg viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                <span>Données chiffrées SSL</span>
            </div>
            <div class="co-trust__item">
                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span>Retour sous 7 jours</span>
            </div>
        </div>
    </div>
</div>

<div class="checkout-container">

    {{-- ── Alertes dynamiques ── --}}
    @if(!empty($stockErrors))
    <div class="ck-alert ck-alert--warn">
        <i class="zmdi zmdi-alert-triangle"></i>
        <div>
            <strong>Problème de stock :</strong>
            <ul>
                @foreach($stockErrors as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <a href="{{ route('client.cart') }}">← Modifier mon panier</a>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="ck-alert ck-alert--error">
        <i class="zmdi zmdi-close-circle"></i>
        <div>{{ session('error') }}</div>
    </div>
    @endif

    <form id="checkout-form" action="{{ route('client.checkout.store') }}" method="POST">
        @csrf

        <div class="ck-grid">

            {{-- ════════════════════════════
                 COLONNE GAUCHE
                 ════════════════════════════ --}}
            <div>

                {{-- ── Adresse de livraison ── --}}
                <div class="ck-card">
                    <div class="ck-card-head">
                        <div class="ck-card-head-icon">
                            <i class="zmdi zmdi-pin"></i>
                        </div>
                        <div class="ck-card-head-text">
                            <div class="ck-card-head-title">Adresse de livraison</div>
                            <div class="ck-card-head-sub">Où souhaitez-vous recevoir votre commande ?</div>
                        </div>
                    </div>

                    <div class="ck-row">
                        <div class="ck-field">
                            <label class="ck-label">Nom complet <span class="req">*</span></label>
                            <div class="ck-input-wrap">
                                <i class="zmdi zmdi-account ck-input-icon"></i>
                                <input type="text" name="fullname"
                                       value="{{ old('fullname', $prefill['fullname']) }}"
                                       class="ck-input form-control @error('fullname') is-invalid @enderror"
                                       placeholder="Jean Dupont" required>
                            </div>
                            @error('fullname')<span class="ck-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="ck-field">
                            <label class="ck-label">Email <span class="req">*</span></label>
                            <div class="ck-input-wrap">
                                <i class="zmdi zmdi-email ck-input-icon"></i>
                                <input type="email" name="email"
                                       value="{{ old('email', $prefill['email']) }}"
                                       class="ck-input form-control @error('email') is-invalid @enderror"
                                       placeholder="email@exemple.com" required>
                            </div>
                            @error('email')<span class="ck-error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="ck-row" style="margin-top:16px">
                        <div class="ck-field">
                            <label class="ck-label">Téléphone <span class="req">*</span></label>
                            <div class="ck-input-wrap">
                                <i class="zmdi zmdi-phone ck-input-icon"></i>
                                <input type="tel" name="phone"
                                       value="{{ old('phone', $prefill['phone']) }}"
                                       class="ck-input form-control @error('phone') is-invalid @enderror"
                                       placeholder="+229 97 00 00 00" required>
                            </div>
                            @error('phone')<span class="ck-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="ck-field">
                            <label class="ck-label">Ville <span class="req">*</span></label>
                            <div class="ck-input-wrap">
                                <i class="zmdi zmdi-city ck-input-icon"></i>
                                <input type="text" name="city"
                                       value="{{ old('city', $prefill['city']) }}"
                                       class="ck-input form-control @error('city') is-invalid @enderror"
                                       placeholder="Cotonou" required>
                            </div>
                            @error('city')<span class="ck-error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="ck-row" style="margin-top:16px">
                        <div class="ck-field">
                            <label class="ck-label">Adresse complète <span class="req">*</span></label>
                            <div class="ck-input-wrap">
                                <i class="zmdi zmdi-home ck-input-icon"></i>
                                <input type="text" name="address"
                                       value="{{ old('address', $prefill['address']) }}"
                                       class="ck-input form-control @error('address') is-invalid @enderror"
                                       placeholder="Quartier, Rue, N°..." required>
                            </div>
                            @error('address')<span class="ck-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="ck-field">
                            <label class="ck-label">Pays</label>
                            <select name="country" class="ck-select form-control">
                                @foreach(['Bénin','Togo','Nigeria','Côte d\'Ivoire','Sénégal','Mali','Burkina Faso','Ghana','Cameroun','Autre'] as $c)
                                    <option value="{{ $c }}" {{ old('country', $prefill['country']) === $c ? 'selected' : '' }}>{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="ck-row full" style="margin-top:16px">
                        <div class="ck-field">
                            <label class="ck-label">Instructions (optionnel)</label>
                            <textarea name="notes" class="ck-textarea form-control"
                                      placeholder="Point de repère, instructions particulières…">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- ── Mode de paiement ── --}}
                <div class="ck-card">
                    <div class="ck-card-head">
                        <div class="ck-card-head-icon">
                            <i class="zmdi zmdi-card"></i>
                        </div>
                        <div class="ck-card-head-text">
                            <div class="ck-card-head-title">Mode de paiement</div>
                            <div class="ck-card-head-sub">Choisissez votre méthode préférée</div>
                        </div>
                    </div>

                    <div class="ck-payments">

                        {{-- Paiement à la livraison --}}
                        <label class="ck-pay-opt {{ old('payment_method','cash_on_delivery') === 'cash_on_delivery' ? 'ck-pay-opt--active' : '' }}">
                            <input type="radio" name="payment_method" value="cash_on_delivery"
                                   {{ old('payment_method','cash_on_delivery') === 'cash_on_delivery' ? 'checked' : '' }}
                                   class="payment-radio">
                            <div class="ck-radio-custom"></div>
                            <div class="ck-pay-icon ck-pay-icon--cash">💵</div>
                            <div class="ck-pay-info">
                                <div class="ck-pay-name">Paiement à la livraison</div>
                                <div class="ck-pay-desc">Payez en espèces à la réception</div>
                            </div>
                            <div class="ck-pay-badge">Populaire</div>
                        </label>

                        {{-- MTN --}}
                        <label class="ck-pay-opt {{ old('payment_method') === 'mtn_benin' ? 'ck-pay-opt--active' : '' }}">
                            <input type="radio" name="payment_method" value="mtn_benin"
                                   {{ old('payment_method') === 'mtn_benin' ? 'checked' : '' }}
                                   class="payment-radio">
                            <div class="ck-radio-custom"></div>
                            <div class="ck-pay-icon ck-pay-icon--mtn">MTN</div>
                            <div class="ck-pay-info">
                                <div class="ck-pay-name">MTN MoMo</div>
                                <div class="ck-pay-desc">Paiement sécurisé via FedaPay</div>
                            </div>
                        </label>

                        {{-- Moov --}}
                        <label class="ck-pay-opt {{ old('payment_method') === 'moov_benin' ? 'ck-pay-opt--active' : '' }}">
                            <input type="radio" name="payment_method" value="moov_benin"
                                   {{ old('payment_method') === 'moov_benin' ? 'checked' : '' }}
                                   class="payment-radio">
                            <div class="ck-radio-custom"></div>
                            <div class="ck-pay-icon ck-pay-icon--moov">MOOV</div>
                            <div class="ck-pay-info">
                                <div class="ck-pay-name">Moov Money</div>
                                <div class="ck-pay-desc">Paiement sécurisé via FedaPay</div>
                            </div>
                        </label>

                        {{-- Celtiis --}}
                        <label class="ck-pay-opt {{ old('payment_method') === 'celtiis_bj' ? 'ck-pay-opt--active' : '' }}">
                            <input type="radio" name="payment_method" value="celtiis_bj"
                                   {{ old('payment_method') === 'celtiis_bj' ? 'checked' : '' }}
                                   class="payment-radio">
                            <div class="ck-radio-custom"></div>
                            <div class="ck-pay-icon ck-pay-icon--celtiis">CELTIIS</div>
                            <div class="ck-pay-info">
                                <div class="ck-pay-name">Celtiis Cash</div>
                                <div class="ck-pay-desc">Paiement sécurisé via FedaPay</div>
                            </div>
                        </label>

                    </div>

                    {{-- Note FedaPay --}}
                    <div id="fedapay-info" class="ck-fedapay-note">
                        <i class="zmdi zmdi-info-outline"></i>
                        <span>Vous serez redirigé vers la page de paiement sécurisée <strong>FedaPay</strong> pour finaliser votre transaction.</span>
                    </div>
                </div>

                {{-- ── Bouton confirmer ── --}}
                <div class="ck-submit-wrap">
                    <button type="button" id="btn-place-order" class="ck-submit-btn">
                        <span id="btn-label">
                            <i class="zmdi zmdi-lock"></i>
                            Confirmer la commande
                        </span>
                    </button>
                    <div class="ck-submit-trust">
                        <span><i class="zmdi zmdi-shield-check"></i> Paiement sécurisé</span>
                        <span><i class="zmdi zmdi-lock-outline"></i> Données chiffrées SSL</span>
                        <span><i class="zmdi zmdi-star"></i> Satisfait ou remboursé</span>
                    </div>
                </div>

            </div>{{-- /col gauche --}}

            {{-- ════════════════════════════
                 COLONNE DROITE — Résumé
                 ════════════════════════════ --}}
            <div class="ck-summary">

                {{-- Header bleu --}}
                <div class="ck-summary-head">
                    <div class="ck-summary-head-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>
                        Récapitulatif
                    </div>
                    <div class="ck-summary-head-count">
                        {{ $cartItems->count() }} article{{ $cartItems->count() > 1 ? 's' : '' }}
                    </div>
                </div>

                {{-- Liste articles --}}
                <div class="ck-items">
                    @foreach($cartItems as $item)
                    <div class="ck-item">
                        <div class="ck-item-img-wrap">
                            <img class="ck-item-img"
                                 src="{{ $item->product->images->isNotEmpty() ? asset('storage/'.$item->product->images->first()->image_path) : asset('frontend/images/no-image.jpg') }}"
                                 alt="{{ $item->product->name }}">
                            <div class="ck-item-qty">{{ $item->quantity }}</div>
                        </div>
                        <div class="ck-item-body">
                            <div class="ck-item-name">{{ $item->product->name }}</div>
                            @if($item->color)
                            <div class="ck-item-color">
                                <span class="ck-item-color-dot" style="background:{{ $item->color->code }}"></span>
                                {{ $item->color->name }}
                            </div>
                            @endif
                        </div>
                        <div class="ck-item-price">
                            {{ number_format($item->product->price * $item->quantity, 0, ',', ' ') }} F
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Totaux --}}
                <div class="ck-totals">
                    <div class="ck-total-row">
                        <span>Sous-total</span>
                        <span>{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="ck-total-row">
                        <span>Livraison</span>
                        <span class="ck-delivery-tag">À régler au livreur</span>
                    </div>
                    <div class="ck-total-row ck-total-row--grand">
                        <span>Total TTC</span>
                        <span class="ck-total-val">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>

                {{-- Code promo --}}
                {{-- <div class="ck-promo">
                    <div class="ck-promo-row">
                        <input type="text" name="promo_code" class="ck-promo-input"
                               placeholder="Code promo" value="{{ old('promo_code') }}">
                        <button type="button" class="ck-promo-btn">Appliquer</button>
                    </div>
                </div> --}}

                {{-- CTA mobile --}}
                <div class="ck-summary-cta">
                    <button type="button" class="ck-summary-cta-btn" onclick="document.getElementById('btn-place-order').click()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Valider ma commande
                    </button>
                </div>

            </div>{{-- /ck-summary --}}

        </div>{{-- /ck-grid --}}

    </form>
</div>


@include('client.body.footer')

<!-- Scripts -->
<script src="{{ asset('frontend/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/animsition/js/animsition.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/bootstrap/js/popper.js') }}"></script>
<script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/select2/select2.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('frontend/vendor/slick/slick.min.js') }}"></script>
<script src="{{ asset('frontend/js/slick-custom.js') }}"></script>
<script src="{{ asset('frontend/vendor/parallax100/parallax100.js') }}"></script>
<script src="{{ asset('frontend/vendor/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/isotope/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('frontend/js/main.js') }}"></script>
@include('frontend.global_js')

<script>
$(document).ready(function () {

    var TOKEN  = '{{ csrf_token() }}';
    var MOBILE = ['mtn_benin', 'moov_benin', 'celtiis_bj'];

    /* ── Sélection visuelle des options de paiement ── */
    function updatePayOpt(val) {
        $('.ck-pay-opt').removeClass('ck-pay-opt--active');
        $('.ck-pay-opt input[value="'+val+'"]').closest('.ck-pay-opt').addClass('ck-pay-opt--active');
        if (MOBILE.indexOf(val) !== -1) {
            $('#fedapay-info').slideDown(200);
        } else {
            $('#fedapay-info').slideUp(200);
        }
    }

    $(document).on('change', 'input[name="payment_method"]', function () {
        updatePayOpt($(this).val());
    });
    $(document).on('click', '.ck-pay-opt', function () {
        $(this).find('input[type="radio"]').prop('checked', true).trigger('change');
    });

    /* Init */
    var checkedVal = $('input[name="payment_method"]:checked').val();
    if (checkedVal) updatePayOpt(checkedVal);

    /* ── Soumettre ── */
    $('#btn-place-order').on('click', function () {
        var method = $('input[name="payment_method"]:checked').val();
        if (!method) { showError('Veuillez choisir un mode de paiement.'); return; }
        if (!validateForm()) return;
        setBtnLoading('Traitement en cours…');

        $.ajax({
            url    : '{{ route("client.checkout.store") }}',
            method : 'POST',
            data   : $('#checkout-form').serialize(),
            success: function (res) {
                if (!res.success) { resetBtn(); showError(res.message || 'Une erreur est survenue.'); return; }
                if (res.checkout_url) { setBtnLoading('Redirection vers FedaPay…'); window.location.href = res.checkout_url; }
                else if (res.redirect_url) { window.location.href = res.redirect_url; }
            },
            error: function (xhr) {
                resetBtn();
                var msg = 'Erreur serveur. Veuillez réessayer.';
                if (xhr.status === 422 && xhr.responseJSON) msg = xhr.responseJSON.message || 'Veuillez vérifier les champs.';
                showError(msg);
            }
        });
    });

    function setBtnLoading(txt) {
        $('#btn-place-order').prop('disabled', true);
        $('#btn-label').html('<i class="zmdi zmdi-rotate-right zmdi-hc-spin"></i> ' + txt);
    }
    function resetBtn() {
        $('#btn-place-order').prop('disabled', false);
        $('#btn-label').html('<i class="zmdi zmdi-lock"></i> Confirmer la commande');
    }
    function showError(msg) {
        $('.ck-error-global').remove();
        var el = $('<div class="ck-error-global"><i class="zmdi zmdi-close-circle"></i><span>'+msg+'</span></div>');
        $('#btn-place-order').after(el);
        el[0].scrollIntoView({ behavior:'smooth', block:'nearest' });
        setTimeout(function () { el.fadeOut(400, function () { $(this).remove(); }); }, 5000);
    }
    function validateForm() {
        var ok = true, first = null;
        $('#checkout-form [required]').each(function () {
            if (!$(this).val().trim()) {
                $(this).addClass('is-invalid');
                if (!first) first = $(this);
                ok = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        if (!ok) { showError('Veuillez remplir tous les champs obligatoires.'); if (first) first.focus(); }
        return ok;
    }

    /* Reset is-invalid à la saisie */
    $(document).on('input change', '.ck-input, .ck-select, .ck-textarea', function () {
        $(this).removeClass('is-invalid');
    });
});
</script>
</body>
</html>