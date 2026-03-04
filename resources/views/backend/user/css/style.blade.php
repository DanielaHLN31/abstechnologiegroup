
<style>
        :root {
            --primary-color: #0066CC;
            --primary-hover: #0066CC;
            --secondary-color: #e5e7eb;
            --success-color: #10b981;
            --danger-color: #ef4444;
            /* --warning-color: #f59e0b; */
            --info-color: #3b82f6;
            --dark-color: #1f2937;
            --light-color: #f9fafb;
            --border-radius: 12px;
            --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }


        /* .info-row.full-width {
            flex-direction: column;
            align-items: flex-start;
        } */

        /* #modal-dialog {
            max-width: 900px;
            margin: 0 auto;
        } */

        .modal-content {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            background: white;
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            padding: 2rem;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .modal-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="white" opacity="0.1"/><circle cx="80" cy="40" r="3" fill="white" opacity="0.1"/><circle cx="40" cy="80" r="1" fill="white" opacity="0.1"/></svg>');
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        .modal-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
            position: relative;
            z-index: 1;
            color: white !important;
        }

        .modal-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            margin-top: 0.5rem;
            position: relative;
            z-index: 1;
        }

        /* .btn-close {
            top: 1rem !important;
            right: 1rem !important;
            position: fixed !important; 

        } */

        /* .btn-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            color: white;
            font-size: 1.2rem;
            transition: var(--transition);
            z-index: 2;
        } */

        /* .btn-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        } */

        .modal-body {
            padding: 2rem;
            max-height: 70vh;
            overflow-y: auto;
        }

        .section-header {
            display: flex;
            align-items: center;
            margin: 2rem 0 1.5rem 0;
            padding: 1rem;
            background: linear-gradient(135deg, var(--light-color), #ffffff);
            border-radius: var(--border-radius);
            border-left: 4px solid var(--primary-color);
        }

        .section-header:first-child {
            margin-top: 0;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 1rem;
            font-size: 1.2rem;
        }

        .section-content h4 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark-color);
        }

        .section-content p {
            margin: 0.25rem 0 0 0;
            color: #6b7280;
            font-size: 0.9rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .form-label i {
            margin-right: 0.5rem;
            color: var(--primary-color);
        }

        .form-control, .form-select {
            border: 2px solid var(--secondary-color);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: var(--transition);
            background: white;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            outline: none;
        }

        .input-group {
            position: relative;
        }

        .input-group-text {
            background: var(--primary-color);
            color: white;
            border: 2px solid var(--primary-color);
            border-right: none;
            border-radius: 8px 0 0 8px;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 8px 8px 0;
        }

        .form-check {
            padding: 1rem;
            background: var(--light-color);
            border-radius: 8px;
            border: 2px solid var(--secondary-color);
            transition: var(--transition);
        }

        .form-check:hover {
            border-color: var(--primary-color);
            background: rgba(99, 102, 241, 0.05);
        }

        .form-check-input {
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 0.75rem;
            border: 2px solid var(--secondary-color);
            border-radius: 4px;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            font-weight: 500;
            color: var(--dark-color);
        }

        .text-danger {
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
        }

        .btn {
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 8px;
            transition: var(--transition);
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-hover), #3730a3);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
        }

        .btn-secondary {
            background: var(--secondary-color);
            /* color: var(--dark-color); */
        }

        .btn-secondary:hover {
            background: #d1d5db;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        .modal-footer {
            padding: 1.5rem 2rem;
            background: var(--light-color);
            border-top: 1px solid var(--secondary-color);
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .modal-dialog {
                margin: 0;
                max-width: 100%;
                height: 100vh;
            }
            
            .modal-content {
                height: 100vh;
                border-radius: 0;
            }
            
            .modal-body {
                max-height: calc(100vh - 200px);
            }
        }

        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .field-group {
            margin-bottom: 1.5rem;
        }

        .progress-bar {
            height: 4px;
            background: var(--secondary-color);
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-hover));
            width: 33.33%;
            transition: width 0.3s ease;
        }

/* ======================= style détail ========================*/
        /* Structure principale */
        .user-layout {
            display: flex;
            min-height: 600px;
        }
        
        .user-sidebar {
            width: 280px;
            background-color: #f8f9fa;
            border-right: 1px solid #e9ecef;
            display: flex;
            flex-direction: column;
        }
        
        .user-main-content {
            flex: 1;
            background-color: #fff;
            display: flex;
            flex-direction: column;
        }
        
        /* Carte de profil */
        .profile-card {
            padding: 2rem 1.5rem;
            background-color: #fff;
            border-bottom: 1px solid #e9ecef;
        }
        
        .profile-image-wrapper {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto;
            margin-top: 2rem;
        }
        
        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        /* Section infos rapides */
        .quick-info-section {
            padding: 1.5rem;
            flex-grow: 1;
            padding-right: 2rem;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            color: #0066CC;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e9ecef;
        }
        
        .quick-info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px dashed #e9ecef;
        }
        
        .quick-info-item:last-child {
            border-bottom: none;
        }
        
        .info-icon {
            width: 28px;
            color: #0066CC;
            font-size: 14px;
        }
        
        .info-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .info-label {
            font-size: 12px;
            color: #0066CC;
        }
        
        .info-value {
            font-weight: 500;
            color: #212529;
            font-size: 16px;
        }
        
        /* Navigation par onglets */
        .user-tabs-wrapper {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e9ecef;
            z-index: 10;
        }
        
        .nav-pills .nav-link {
            padding: 0.6rem 1rem;
            border-radius: -12px;
            font-weight: 500;
            font-size: 14px;
            color: #0066CC;
            margin-right: 0.5rem;
            transition: all 0.2s ease;
        }
        
        .nav-pills .nav-link:hover {
            color: #0066CC;
            background-color: rgba(58, 87, 232, 0.05);
        }
        
        .nav-pills .nav-link.active {
            color: #fff;
            background-color: #0066CC;
        }
        
        /* En-tête des onglets */
        .tab-header {
            margin-bottom: 2rem;
        }
        
        .tab-header h4 {
            margin-bottom: 0.5rem;
        }
        
        .tab-header p {
            margin-bottom: 0;
        }
        
        /* Grille d'informations */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        /* Cartes d'information */
        .info-card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            overflow: hidden;
            transition: all 0.3s ease;
            margin-top: 3rem;
        }
        
        #userDetailsTabs{
            justify-content: center;
        }

        .info-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transform: translateY(-3px);
        }
        
        .info-card-title {
            padding: 1rem;
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            margin: 0;
            font-weight: 600;
            color: #495057;
        }
        
        .info-card-content {
            padding: 1rem;
        }
        
        /* Lignes d'information */
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px dashed #e9ecef;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        
        .info-row.full-width .info-row-value {
            margin-top: 0.5rem;
            padding-left: 1.5rem;
        }
        
        .info-row-label {
            display: flex;
            align-items: center;
            color: #0066CC;
            font-size: 14px;
        }
        
        .info-row-label i {
            width: 20px;
            margin-right: 0.5rem;
            color: #0066CC;
        }
        
        .info-row-value {
            font-weight: 500;
            color: #212529;
        }
        
        /* Carte biographie */
        .bio-card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            overflow: hidden;
            padding: 1.5rem;
        }
        
        .bio-quote {
            position: relative;
            padding: 1.5rem;
            background-color: #f8f9fa;
            border-radius: 12px;
        }
        
        .bio-quote-icon {
            color: #0066CC;
            opacity: 0.2;
            position: absolute;
            top: 15px;
            left: 15px;
            font-size: 1.5rem;
        }
        
        .bio-quote-icon-right {
            color: #0066CC;
            opacity: 0.2;
            position: absolute;
            bottom: 15px;
            right: 15px;
            font-size: 1.5rem;
        }
        
        .bio-content {
            padding: 0.5rem 2rem;
            line-height: 1.7;
            color: #495057;
        }
        
        /* Couleurs */
        .text-indigo {
            color: #6610f2 !important;
        }
        
        .text-purple {
            color: #6f42c1 !important;
        }
        
        /* Animation */
        @keyframes fadeSlideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .tab-pane.show {
            animation: fadeSlideIn 0.3s ease-out forwards;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .user-layout {
                flex-direction: column;
            }
            
            .user-sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #e9ecef;
            }
            
            .profile-card {
                display: flex;
                align-items: center;
                text-align: left;
                padding: 1.5rem;
            }
            
            .profile-image-wrapper {
                margin: 0 1.5rem 0 0;
                width: 80px;
                height: 80px;
            }
            
            .profile-image {
                width: 80px;
                height: 80px;
            }
            
            .quick-info-section {
                padding: 1rem;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .profile-card {
                flex-direction: column;
                text-align: center;
            }
            
            .profile-image-wrapper {
                margin: 0 auto 1rem auto;
            }
            
            .nav-pills .nav-link {
                font-size: 13px;
                padding: 0.5rem 0.8rem;
            }
        }
        
        /* Sweet Alert customization */
        .user-details-modal .swal2-popup {
            padding: 0;
        }
        
        .user-details-modal .swal2-actions {
            padding: 1rem;
            border-top: 1px solid #e9ecef;
            margin-top: 0;
        }
        
        .user-details-modal .swal2-styled.swal2-confirm {
            background-color: #0066CC;
        }
        
        .user-details-modal .swal2-close {
            top: 0.75rem;
            right: 0.75rem;
            color: #0066CC;
        }
        
        .btn-soft-primary {
            background-color: rgba(58, 87, 232, 0.1);
            color: #0066CC;
            border: none;
            transition: all 0.2s ease;
        }
        
        .btn-soft-primary:hover {
            background-color: #0066CC;
            color: #fff;
        }
        
        .btn-outline-primary {
            color: #0066CC ;
            border-color: #0066CC;
        }
        
        .btn-outline-primary:hover {
            background-color: #0066CC !important;
            color: #fff !important;
        }

        .custom-option-icon {
            position: relative;
        }

        .custom-option-content {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            display: block;
            position: relative;
        }

        .custom-option-content:hover {
            border-color: #0066CC;
            box-shadow: 0 2px 8px rgba(var(--bs-primary-rgb), 0.1);
        }

        /* État sélectionné - utilise :has() pour détecter l'input coché */
        .custom-option-icon:has(input[type="radio"]:checked) .custom-option-content {
            border-color: #0066CC;
            background: linear-gradient(135deg, 
                color-mix(in srgb, #0066CC 5%, white) 0%, 
                color-mix(in srgb, #0066CC 15%, white) 100%);
            box-shadow: 0 6px 20px color-mix(in srgb, #0066CC 20%, transparent);
            transform: translateY(-3px);
        }

        /* Icône de validation */
        .custom-option-icon:has(input[type="radio"]:checked) .custom-option-content::before {
            content: '✓';
            position: absolute;
            top: 10px;
            right: 15px;
            background: #0066CC;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
        }

        /* Style du titre quand sélectionné */
        .custom-option-icon:has(input[type="radio"]:checked) .custom-option-content .custom-option-title {
            color: #0066CC;
            font-weight: 600;
        }

        /* Fallback pour les navigateurs qui ne supportent pas :has() */
        @supports not selector(:has(*)) {
            .custom-option-icon input[type="radio"]:checked {
                /* Déclenche un repaint pour forcer la mise à jour */
                opacity: 0.99;
            }
        }
    </style>