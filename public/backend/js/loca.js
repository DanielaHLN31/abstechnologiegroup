(function () {
    // Init custom option check
    window.Helpers.initCustomOptionCheck();

    // libs
    const creditCardMask = document.querySelector('.credit-card-mask'),
        expiryDateMask = document.querySelector('.expiry-date-mask'),
        cvvMask = document.querySelector('.cvv-code-mask');

    // Credit Card
    if (creditCardMask) {
        new Cleave(creditCardMask, {
            creditCard: true,
            onCreditCardTypeChanged: function (type) {
                if (type != '' && type != 'unknown') {
                    document.querySelector('.card-type').innerHTML =
                        '<img src="' + assetsPath + 'img/icons/payments/' + type + '-cc.png" height="28"/>';
                } else {
                    document.querySelector('.card-type').innerHTML = '';
                }
            }
        });
    }
    // Expiry Date Mask
    if (expiryDateMask) {
        new Cleave(expiryDateMask, {
            date: true,
            delimiter: '/',
            datePattern: ['m', 'y']
        });
    }

    // CVV
    if (cvvMask) {
        new Cleave(cvvMask, {
            numeral: true,
            numeralPositiveOnly: true
        });
    }

    // Wizard Checkout
    // --------------------------------------------------------------------

    const wizardCheckout = document.querySelector('#wizard-checkout');
    if (typeof wizardCheckout !== undefined && wizardCheckout !== null) {
        // Wizard form
        const wizardCheckoutForm = wizardCheckout.querySelector('#wizard-checkout-form');
        // Wizard steps
        const wizardCheckoutFormStep1 = wizardCheckoutForm.querySelector('#checkout-cart'); // Greffier Divisionnaire
        const wizardCheckoutFormStep2 = wizardCheckoutForm.querySelector('#checkout-address'); // Autres Greffier
        const wizardCheckoutFormStep3 = wizardCheckoutForm.querySelector('#checkout-payment'); // Cabinet de Présidence
        const wizardCheckoutFormStep4 = wizardCheckoutForm.querySelector('#checkout-confirmation'); // Chambre de jugement
        // Wizard next prev button
        const wizardCheckoutNext = [].slice.call(wizardCheckoutForm.querySelectorAll('.btn-next'));
        const wizardCheckoutPrev = [].slice.call(wizardCheckoutForm.querySelectorAll('.btn-prev'));

        let validationStepper = new Stepper(wizardCheckout, {
            linear: false
        });

        // Récupérer les informations de l'utilisateur connecté
        let userPoste = null;
        let userCanEditCurrentStep = true;

        // Fonction pour désactiver une étape
        function disableStep(stepElement) {
            // Griser le contenu
            stepElement.classList.add('disabled-step');
            // Ajouter une couche semi-transparente
            const overlay = document.createElement('div');
            overlay.className = 'step-overlay';
            overlay.style.position = 'absolute';
            overlay.style.top = '0';
            overlay.style.left = '0';
            overlay.style.width = '100%';
            overlay.style.height = '100%';
            overlay.style.backgroundColor = 'rgba(200, 200, 200, 0.6)';
            overlay.style.zIndex = '10';
            overlay.style.pointerEvents = 'all';
            stepElement.style.position = 'relative';
            stepElement.appendChild(overlay);

            // Désactiver tous les inputs et boutons
            const inputs = stepElement.querySelectorAll('input, select, textarea, button');
            inputs.forEach(input => {
                input.disabled = true;
            });
        }

        // Fonction pour activer une étape
        function enableStep(stepElement) {
            // Retirer la classe disabled
            stepElement.classList.remove('disabled-step');
            // Retirer l'overlay s'il existe
            const overlay = stepElement.querySelector('.step-overlay');
            if (overlay) {
                stepElement.removeChild(overlay);
            }

            // Activer tous les inputs et boutons
            const inputs = stepElement.querySelectorAll('input, select, textarea, button');
            inputs.forEach(input => {
                input.disabled = false;
            });
        }

        // Fonction pour rediriger vers l'étape appropriée selon le poste
        function redirectToUserPoste() {
            // Mapping des postes vers les étapes du wizard
            const posteToStepMap = {
                'Greffier Divisionnaire': 0, // Première étape
                'Autres Greffier': 1, // Deuxième étape
                'Cabinet de Présidence': 2, // Troisième étape
                'Chambre de jugement': 3 // Quatrième étape
            };

            // Vérifier si l'utilisateur a un poste valide
            if (userPoste && posteToStepMap.hasOwnProperty(userPoste.nom)) {
                // Obtenir l'index de l'étape correspondante au poste
                const stepIndex = posteToStepMap[userPoste.nom];

                // Accéder directement à l'étape correspondante
                validationStepper.to(stepIndex);

                // Désactiver toutes les étapes
                [wizardCheckoutFormStep1, wizardCheckoutFormStep2, wizardCheckoutFormStep3, wizardCheckoutFormStep4].forEach((step, index) => {
                    if (index !== stepIndex) {
                        disableStep(step);
                    }
                });

                // Vérifier si l'utilisateur peut encore éditer cette étape
                if (userPoste.used === '1' || !userCanEditCurrentStep) {
                    disableStep([wizardCheckoutFormStep1, wizardCheckoutFormStep2, wizardCheckoutFormStep3, wizardCheckoutFormStep4][stepIndex]);
                }
            }
        }

        // Fonction pour vérifier si l'utilisateur peut éditer à l'étape actuelle
        function checkUserAccessibility() {
            fetch('/user/current')
                .then(response => response.json())
                .then(data => {
                    userPoste = data.poste;
                    userCanEditCurrentStep = data.user.used === '0';
                    redirectToUserPoste();
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des informations utilisateur:', error);
                });
        }

        // Appeler la fonction au chargement
        checkUserAccessibility();

        // Valider les formulaires
        const FormValidation1 = FormValidation.formValidation(wizardCheckoutFormStep1, {
            fields: {
                // * Valider les champs selon vos besoins
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: ''
                }),
                autoFocus: new FormValidation.plugins.AutoFocus(),
                submitButton: new FormValidation.plugins.SubmitButton()
            }
        }).on('core.form.valid', function () {
            // Soumettre les données et passer à l'étape suivante
            submitFormData(0);
        });

        const FormValidation2 = FormValidation.formValidation(wizardCheckoutFormStep2, {
            fields: {
                // * Valider les champs selon vos besoins
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: ''
                }),
                autoFocus: new FormValidation.plugins.AutoFocus(),
                submitButton: new FormValidation.plugins.SubmitButton()
            }
        }).on('core.form.valid', function () {
            // Soumettre les données et passer à l'étape suivante
            submitFormData(1);
        });

        const FormValidation3 = FormValidation.formValidation(wizardCheckoutFormStep3, {
            fields: {
                // * Valider les champs selon vos besoins
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: ''
                }),
                autoFocus: new FormValidation.plugins.AutoFocus(),
                submitButton: new FormValidation.plugins.SubmitButton()
            }
        }).on('core.form.valid', function () {
            // Soumettre les données et passer à l'étape suivante
            submitFormData(2);
        });

        const FormValidation4 = FormValidation.formValidation(wizardCheckoutFormStep4, {
            fields: {
                // * Valider les champs selon vos besoins
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: '',
                    rowSelector: '.col-md-12'
                }),
                autoFocus: new FormValidation.plugins.AutoFocus(),
                submitButton: new FormValidation.plugins.SubmitButton()
            }
        }).on('core.form.valid', function () {
            // Soumettre les données et passer à l'étape suivante
            submitFormData(3);
        });

        // Fonction pour soumettre les données du formulaire et passer à la personne suivante
        function submitFormData(stepIndex) {
            // Récupérer les données du formulaire selon l'étape
            const formData = new FormData();

            // Ajouter les données spécifiques à l'étape
            switch(stepIndex) {
                case 0:
                    // Données pour Greffier Divisionnaire
                    formData.append('step', 'greffier_divisionnaire');
                    break;
                case 1:
                    // Données pour Autres Greffier
                    formData.append('step', 'autres_greffier');
                    break;
                case 2:
                    // Données pour Cabinet de Présidence
                    formData.append('step', 'cabinet_presidence');
                    break;
                case 3:
                    // Données pour Chambre de jugement
                    formData.append('step', 'chambre_jugement');
                    break;
            }

            // Soumettre les données via fetch
            fetch('/submit-workflow-step', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Afficher le message de succès
                        Swal.fire({
                            title: 'Succès !',
                            text: 'Votre étape a été validée et transmise à la personne suivante.',
                            icon: 'success',
                            confirmButtonColor: '#0304a2'
                        }).then(() => {
                            // Désactiver l'étape actuelle
                            const currentStep = [wizardCheckoutFormStep1, wizardCheckoutFormStep2, wizardCheckoutFormStep3, wizardCheckoutFormStep4][stepIndex];
                            disableStep(currentStep);

                            // Mettre à jour l'état de l'utilisateur
                            userCanEditCurrentStep = false;
                        });
                    } else {
                        // Afficher le message d'erreur
                        Swal.fire({
                            title: 'Erreur !',
                            text: data.message || 'Une erreur est survenue lors de la validation de votre étape.',
                            icon: 'error',
                            confirmButtonColor: '#0304a2'
                        });
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la soumission des données:', error);
                    Swal.fire({
                        title: 'Erreur !',
                        text: 'Une erreur est survenue lors de la validation de votre étape.',
                        icon: 'error',
                        confirmButtonColor: '#0304a2'
                    });
                });
        }

        // Modifier le comportement des boutons next
        wizardCheckoutNext.forEach(item => {
            item.addEventListener('click', event => {
                // Afficher la confirmation SweetAlert avant validation
                Swal.fire({
                    title: 'Es-tu sûr ?',
                    text: "Tu ne pourras pas revenir en arrière !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0304a2',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, continuer',
                    cancelButtonText: 'Annuler',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Valider selon l'étape actuelle
                        switch (validationStepper._currentIndex) {
                            case 0:
                                FormValidation1.validate();
                                break;
                            case 1:
                                FormValidation2.validate();
                                break;
                            case 2:
                                FormValidation3.validate();
                                break;
                            case 3:
                                FormValidation4.validate();
                                break;
                            default:
                                break;
                        }
                    }
                });
            });
        });

        // Masquer les boutons précédents
        wizardCheckoutPrev.forEach(item => {
            item.style.display = 'none';
        });

        // Vérifier périodiquement si l'état de l'utilisateur a changé
        setInterval(checkUserAccessibility, 30000); // Vérifier toutes les 30 secondes
    }
})();
