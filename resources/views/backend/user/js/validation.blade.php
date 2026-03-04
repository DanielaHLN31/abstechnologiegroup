
<script>
/**
 *  Form Wizard Simplifié (3 étapes seulement)
 */
'use strict';

(function () {
    const select2 = $('.select2'),
        selectPicker = $('.selectpicker');

    // Wizard Validation
    const wizardValidation = document.querySelector('#wizard-validation');
    if (typeof wizardValidation !== undefined && wizardValidation !== null) {
        // Wizard form
        const wizardValidationForm = wizardValidation.querySelector('#wizard-validation-form');
        // Wizard steps
        const wizardValidationFormStep1 = wizardValidationForm.querySelector('#account-details-validation');
        const wizardValidationFormStep2 = wizardValidationForm.querySelector('#personal-info-validation');
        const wizardValidationFormStep3 = wizardValidationForm.querySelector('#social-links-validation');

        // Wizard next prev button
        const wizardValidationNext = [].slice.call(wizardValidationForm.querySelectorAll('.btn-next'));
        const wizardValidationPrev = [].slice.call(wizardValidationForm.querySelectorAll('.btn-prev'));

        const validationStepper = new Stepper(wizardValidation, {
            linear: true
        });

        // Account details (Step 1)
        const FormValidation1 = FormValidation.formValidation(wizardValidationFormStep1, {
            fields: {
                username: {
                    validators: {
                        notEmpty: {
                            message: 'Le nom d\'utilisateur est obligatoire'
                        },
                        stringLength: {
                            min: 2,
                            max: 30,
                            message: 'Le nom doit comporter plus de 2 et moins de 30 caractères.'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9 ]+$/,
                            message: 'Le nom ne peut être composé que de lettres, de chiffres et d\'espaces.'
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: 'L\'e-mail est obligatoire'
                        },
                        emailAddress: {
                            message: 'La valeur n\'est pas une adresse électronique valide'
                        },
                        callback: {
                            message: 'Cette adresse email est déjà utilisée',
                            callback: function(input) {
                                return new Promise((resolve) => {
                                    const email = input.value;
                                    
                                    if (!email) {
                                        resolve({ valid: true });
                                        return;
                                    }

                                    $.ajax({
                                        url: '/users/check-email',
                                        type: 'POST',
                                        data: {
                                            email: email,
                                            _token: $('meta[name="csrf-token"]').attr('content')
                                        }
                                    })
                                    .done(function(response) {
                                        resolve({
                                            valid: !response.exists,
                                            message: response.exists ? 'Cette adresse email est déjà utilisée' : null
                                        });
                                    })
                                    .fail(function() {
                                        resolve({ valid: true });
                                    });
                                });
                            }
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: '',
                    rowSelector: '.col-sm-6'
                }),
                autoFocus: new FormValidation.plugins.AutoFocus(),
                submitButton: new FormValidation.plugins.SubmitButton()
            },
            init: instance => {
                instance.on('plugins.message.placed', function (e) {
                    if (e.element.parentElement.classList.contains('input-group')) {
                        e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
                    }
                });
            }
        }).on('core.form.valid', function () {
            validationStepper.next();
        });

        // Personal info (Step 2)
        const FormValidation2 = FormValidation.formValidation(wizardValidationFormStep2, {
            fields: {
                firstname: {
                    validators: {
                        notEmpty: {
                            message: 'Le prénom est obligatoire'
                        }
                    }
                },
                lastname: {
                    validators: {
                        notEmpty: {
                            message: 'Le nom est obligatoire'
                        }
                    }
                },
                telephone: {
                    validators: {
                        notEmpty: {
                            message: 'Le téléphone est obligatoire'
                        }
                    }
                },
                nationalite: {
                    validators: {
                        notEmpty: {
                            message: 'La nationalité est obligatoire'
                        }
                    }
                },
                ville_de_residence: {
                    validators: {
                        notEmpty: {
                            message: 'La ville de résidence est obligatoire'
                        }
                    }
                },
                adresse: {
                    validators: {
                        notEmpty: {
                            message: 'L\'adresse est obligatoire'
                        }
                    }
                },
                genre: {
                    validators: {
                        notEmpty: {
                            message: 'Le genre est obligatoire'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: '',
                    rowSelector: '.col-sm-6, .col-sm-12'
                }),
                autoFocus: new FormValidation.plugins.AutoFocus(),
                submitButton: new FormValidation.plugins.SubmitButton()
            }
        }).on('core.form.valid', function () {
            validationStepper.next();
        });

        // Professional info (Step 3)
        const FormValidation3 = FormValidation.formValidation(wizardValidationFormStep3, {
            fields: {
                service_id: {
                    validators: {
                        notEmpty: {
                            message: 'Le service est obligatoire'
                        }
                    }
                },
                poste_id: {
                    validators: {
                        notEmpty: {
                            message: 'Le poste est obligatoire'
                        }
                    }
                },
                role_id: {
                    validators: {
                        notEmpty: {
                            message: 'Le rôle est obligatoire'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: '',
                    rowSelector: '.col-sm-6, .col-sm-12'
                }),
                autoFocus: new FormValidation.plugins.AutoFocus(),
                submitButton: new FormValidation.plugins.SubmitButton()
            }
        }).on('core.form.valid', function () {
            // Submit form when step 3 is valid
            $('.wizard-form').submit();
        });

        // Navigation handlers
        wizardValidationNext.forEach(item => {
            item.addEventListener('click', event => {
                event.preventDefault();
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
                    default:
                        break;
                }
            });
        });

        wizardValidationPrev.forEach(item => {
            item.addEventListener('click', event => {
                event.preventDefault();
                switch (validationStepper._currentIndex) {
                    case 2:
                        validationStepper.previous();
                        break;
                    case 1:
                        validationStepper.previous();
                        break;
                    case 0:
                    default:
                        break;
                }
            });
        });

        // Form submission
        $('.wizard-form').on('submit', function(e) {
            e.preventDefault();
            
            $('button[type="submit"] .spinner-border').css('display', 'inline-block');
            $('.error-message').remove();
            $('.is-invalid').removeClass('is-invalid');

            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('button[type="submit"] .spinner-border').css('display', 'none');
                    show_alert(response['alert-type'], response.message);
                    window.location.href = response.redirect_url;
                },
                error: function(xhr) {
                    $('button[type="submit"] .spinner-border').css('display', 'none');
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(function(key) {
                            const field = $(`[name="${key}"]`);
                            field.addClass('is-invalid');
                            field.after(`<div class="invalid-feedback error-message">${errors[key][0]}</div>`);
                        });
                    } else {
                        iziToast.error({
                            title: 'Erreur',
                            message: 'Une erreur est survenue. Veuillez réessayer.',
                            position: 'topRight',
                            timeout: 5000
                        });
                    }
                }
            });
        });

        // Clear errors on input
        $(document).on('input', '.form-control', function() {
            $(this).removeClass('is-invalid');
            $(this).next('.error-message').remove();
        });
    }
})();
</script>