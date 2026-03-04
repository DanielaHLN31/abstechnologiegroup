<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue chez ABS Technologie</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 10px 10px;
            border: 1px solid #e0e0e0;
            border-top: none;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
        h1 {
            margin: 0;
            font-size: 28px;
        }
        .welcome-message {
            font-size: 18px;
            margin: 20px 0;
            color: #555;
        }
        .credentials {
            background: white;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }
        .button {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            font-weight: bold;
        }
        .button:hover {
            background: #5a67d8;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            color: #777;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bienvenue chez ABS Technologie !</h1>
    </div>
    
    <div class="content">
        <p class="welcome-message">Bonjour <strong>{{ $user->name }}</strong>,</p>
        
        <p>Nous sommes ravis de vous accueillir en tant que nouveau client chez <strong>ABS Technologie</strong>. Votre compte a été créé avec succès !</p>
        
        <div class="credentials">
            <h3 style="margin-top: 0; color: #667eea;">Vos informations de connexion :</h3>
            <p><strong>Email :</strong> {{ $user->email }}</p>
            @if($password)
                <p><strong>Mot de passe :</strong> {{ $password }}</p>
                <p style="color: #e53e3e; font-size: 14px; margin-top: 10px;">
                    ⚠️ Pour des raisons de sécurité, nous vous recommandons de changer ce mot de passe après votre première connexion.
                </p>
            @else
                <p><strong>Mot de passe :</strong> (le mot de passe que vous avez choisi lors de l'inscription)</p>
            @endif
        </div>
        
        <p>Vous pouvez dès maintenant :</p>
        <ul>
            <li>Parcourir notre catalogue de produits</li>
            <li>Passer vos premières commandes</li>
            <li>Suivre l'état de vos commandes</li>
            <li>Consulter votre historique d'achats</li>
        </ul>
        
        <div style="text-align: center;">
            <a href="{{ route('client.login') }}" class="button">Se connecter à mon compte</a>
        </div>
        
        <p style="margin-top: 30px;">
            Si vous avez des questions ou besoin d'assistance, n'hésitez pas à contacter notre service client.
        </p>
    </div>
    
    <div class="footer">
        <p>© {{ date('Y') }} ABS Technologie. Tous droits réservés.</p>
        <p>Cet email a été envoyé à {{ $user->email }} suite à votre inscription sur notre site.</p>
    </div>
</body>
</html>