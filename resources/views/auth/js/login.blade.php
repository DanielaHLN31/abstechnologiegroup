<script>

    $(document).ready(function() {
        afficherChampsMotDePasse()
        // Appel de la fonction afficherChampsMotDePasse lorsque l'utilisateur saisit quelque chose dans le champ d'email
        document.getElementById('email').addEventListener('input', afficherChampsMotDePasse);

        // Gestionnaire d'événements pour afficher ou masquer le mot de passe
        $(document).on('click', '.input-group-text', function() {
            var passwordInput = $(this).closest('.input-group').find('input[type="password"], input[type="text"]');
            var passwordFieldType = passwordInput.attr('type');
            passwordInput.attr('type', passwordFieldType === 'password' ? 'text' : 'password');
            var icon = $(this).find('i');
            if (passwordFieldType === 'password') {
                icon.removeClass('ti-eye-off').addClass('ti-eye'); // Icône "œil ouvert"
            } else {
                icon.removeClass('ti-eye').addClass('ti-eye-off'); // Icône "œil barré"
            }
        });
    });

    // Fonction pour afficher les champs de mot de passe en fonction de l'email saisi
    function afficherChampsMotDePasse() {
        var email = document.getElementById('email').value;

        $.ajax({
            type: 'POST',
            url: '/check-user',
            data: {
                email: email,
                _token: '{{ csrf_token() }}',
            },
            dataType: 'json',
            success: function(response) {
                if (response.exists) {
                    var passwordFields;
                    if (response.cleanPassword) {
                        passwordFields = `
                            <div class="text-danger" style="font-size:11px">
                                <i class="fa fa-exclamation-circle"></i>
                                Il s'agit de votre première connexion. Veuillez définir votre mot de passe de connexion et le confirmé.
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Mot de passe</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input
                                        type="password"
                                        id="password"
                                        class="form-control"
                                        name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Confirmer mot de passe</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input
                                        type="password"
                                        id="password_confirmation"
                                        class="form-control"
                                        name="password_confirmation"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                        `;
                    }
                    else {
                        passwordFields = `<div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Mot de passe</label>
                            </div>
                            <div class="input-group input-group-merge">
                                <input
                                    type="password"
                                    id="password"
                                    class="form-control"
                                    name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                        </div>`;
                    }
                    $('#password-fields').html(passwordFields);
                    // Appel de feather.replace() après avoir modifié le contenu du formulaire
                    feather.replace();
                } else {
                    $('#password-fields').empty();
                    // Appel de feather.replace() après avoir modifié le contenu du formulaire
                    feather.replace();
                }
            }
        });
    }


    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>
