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
        const wizardCheckoutForm = wizardCheckout.querySelector('#wizard-checkout-form');

        const wizardCheckoutFormStep1 = wizardCheckoutForm.querySelector('#checkout-cart');
        const wizardCheckoutFormStep2 = wizardCheckoutForm.querySelector('#checkout-address');
        const wizardCheckoutFormStep3 = wizardCheckoutForm.querySelector('#checkout-payment');
        const wizardCheckoutFormStep4 = wizardCheckoutForm.querySelector('#checkout-confirmation');

        const wizardCheckoutNext = [].slice.call(wizardCheckoutForm.querySelectorAll('.btn-next'));
        const wizardCheckoutPrev = [].slice.call(wizardCheckoutForm.querySelectorAll('.btn-prev'));

        let validationStepper = new Stepper(wizardCheckout, {
            linear: false
        });

        const navigationSchema = [1, 2, 1, 3, 1, 2, 4, 3, 4, 2];
        let currentSchemaStep = 0;

        // Titres dynamiques
        const stepTitles = {
            1: "Greffier Divisionnaire",
            2: "Autres Greffier",
            3: "Cabinet de Présidence",
            4: "Chambre de Jugement"
        };

        // Récupérer les valeurs passées depuis le contrôleur
        const userEtape = parseInt(wizardCheckout.dataset.userEtape || '0');
        const isEtapeActive = wizardCheckout.dataset.isEtapeActive === "true";

        // Fonction pour désactiver les interfaces non utilisables
        function setupUserInterface() {
            // Aller directement à l'étape correspondant au poste de l'utilisateur
            if (userEtape > 0) {
                validationStepper.to(userEtape);
                updateStepTitle(userEtape);
            }

            // Désactiver les interactions si l'étape n'est pas active
            if (!isEtapeActive) {
                // Griser l'interface
                wizardCheckout.classList.add('disabled-wizard');

                // Désactiver les boutons
                wizardCheckoutNext.forEach(btn => {
                    btn.disabled = true;
                });
            }
        }

        function updateStepTitle(stepNumber) {
            const titleElement = document.getElementById('current-step-title');
            if (titleElement && stepTitles[stepNumber]) {
                titleElement.textContent = stepTitles[stepNumber];
            }
        }

        // Fonction pour envoyer les données au contrôleur
        function sendStepDataToController(stepNumber, stepTitle, isRestart = false) {


            // Récupérer l'ID du dossier (vous pouvez le stocker dans un attribut data de votre HTML)
            const dossierId = document.getElementById('wizard-checkout').dataset.dossierId;


            // Création de l'objet à envoyer
            const data = {
                stepNumber: stepNumber,
                stepTitle: stepTitle,
                dossierId: dossierId,
                isRestart: isRestart // Nouveau paramètre pour indiquer une réinitialisation
            };

            // Envoi de la requête AJAX
            fetch('/my_audience/etape/avancer', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
                .then(response => {
                    // Vérifier si la réponse est OK
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            throw errorData;
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Succès:', data);

                    // Après avoir traité une étape, on vérifie si cette étape n'est plus active
                    if (data.etapeTerminee && data.etapeTerminee === true) {
                        wizardCheckout.classList.add('disabled-wizard');
                        wizardCheckoutNext.forEach(btn => {
                            btn.disabled = true;
                        });
                    }

                    // Mise à jour du titre principal
                    if (data.stepTitle) {
                        const titleElement = document.getElementById('current-step-title');
                        if (titleElement) {
                            titleElement.textContent = data.stepTitle;
                        }
                    }

                    // Afficher les données renvoyées par le contrôleur
                    const messageElement = document.getElementById('response-message');
                    if (messageElement && data.message) {
                        messageElement.textContent = data.message;
                        messageElement.classList.remove('d-none');

                        // Option: faire disparaître le message après quelques secondes
                        setTimeout(() => {
                            messageElement.classList.add('d-none');
                        }, 3000);
                    }

                    // Mettre à jour le numéro d'étape affiché
                    const stepNumberDisplay = document.getElementById('step-number-display');
                    if (stepNumberDisplay && data.stepNumber) {
                        stepNumberDisplay.textContent = data.stepNumber;
                    }

                    // Mettre à jour le titre d'étape affiché
                    const stepTitleDisplay = document.getElementById('step-title-display');
                    if (stepTitleDisplay && data.stepTitle) {
                        stepTitleDisplay.textContent = data.stepTitle;
                    }

                    // Mettre à jour le titre d'étape affiché
                    const dossierIdDisplay = document.getElementById('dossierp-id-display');
                    if (dossierIdDisplay && data.stepTitle) {
                        dossierIdDisplay.textContent = data.stepTitle;
                    }
                })
                .catch((error) => {
                    console.error('Erreur:', error);

                    // Afficher SweetAlert pour les erreurs d'autorisation
                    if (error && error.requireSweetAlert) {
                        Swal.fire({
                            title: 'Erreur d\'autorisation',
                            text: error.message || "Vous n'avez pas les autorisations nécessaires pour cette action.",
                            icon: 'error',
                            confirmButtonColor: '#0304a2',
                            confirmButtonText: 'Compris'
                        });
                    }
                });
        }

        // Mise à jour de la fonction pour inclure l'envoi au contrôleur
        function goToNextStep() {
            currentSchemaStep++;
            if (currentSchemaStep < navigationSchema.length) {
                const nextStepNumber = navigationSchema[currentSchemaStep];
                validationStepper.to(nextStepNumber);
                updateStepTitle(nextStepNumber);

                // Envoi des données au contrôleur
                sendStepDataToController(nextStepNumber, stepTitles[nextStepNumber]);
            } else {
                const restart = confirm("Vous avez terminé le schéma de navigation. Voulez-vous recommencer?");
                if (restart) {
                    currentSchemaStep = 0;
                    validationStepper.to(navigationSchema[0]);
                    updateStepTitle(navigationSchema[0]);

                    // Envoi des données au contrôleur avec un flag de réinitialisation
                    sendStepDataToController(navigationSchema[0], stepTitles[navigationSchema[0]], true);
                }
            }
        }

        // Initialiser l'interface utilisateur
        setupUserInterface();

        // Si l'étape est active, initialiser normalement et envoyer les données initiales
        if (isEtapeActive) {
            updateStepTitle(userEtape || navigationSchema[0]);
            sendStepDataToController(userEtape || navigationSchema[0], stepTitles[userEtape || navigationSchema[0]]);
        }

        // Step 1 - Cart
        const FormValidation1 = FormValidation.formValidation(wizardCheckoutFormStep1, {
            fields: {},
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({ eleValidClass: '' }),
                autoFocus: new FormValidation.plugins.AutoFocus(),
                submitButton: new FormValidation.plugins.SubmitButton()
            }
        }).on('core.form.valid', function () {
            goToNextStep();
        });

        // Step 2 - Address
        const FormValidation2 = FormValidation.formValidation(wizardCheckoutFormStep2, {
            fields: {},
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({ eleValidClass: '' }),
                autoFocus: new FormValidation.plugins.AutoFocus(),
                submitButton: new FormValidation.plugins.SubmitButton()
            }
        }).on('core.form.valid', function () {
            goToNextStep();
        });

        // Step 3 - Payment
        const FormValidation3 = FormValidation.formValidation(wizardCheckoutFormStep3, {
            fields: {},
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({ eleValidClass: '' }),
                autoFocus: new FormValidation.plugins.AutoFocus(),
                submitButton: new FormValidation.plugins.SubmitButton()
            }
        }).on('core.form.valid', function () {
            goToNextStep();
        });

        // Step 4 - Confirmation
        const FormValidation4 = FormValidation.formValidation(wizardCheckoutFormStep4, {
            fields: {},
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
            goToNextStep();
        });

        wizardCheckoutNext.forEach(item => {
            item.addEventListener('click', event => {
                event.preventDefault(); // Empêche le comportement par défaut

                Swal.fire({
                    title: 'Es-tu sûr ?',
                    text: "Tu ne pourras pas revenir en arrière !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0304a2',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, continuer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // On lance la validation uniquement si l'utilisateur confirme
                        switch (validationStepper._currentIndex) {
                            case 0: FormValidation1.validate(); break;
                            case 1: FormValidation2.validate(); break;
                            case 2: FormValidation3.validate(); break;
                            case 3: FormValidation4.validate(); break;
                        }
                    }
                });
            });
        });

        // On désactive les boutons "précédent"
        wizardCheckoutPrev.forEach(item => {
            item.style.display = 'none';
        });
    }
})();
