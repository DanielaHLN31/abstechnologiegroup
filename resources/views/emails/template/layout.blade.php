<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>{{ $title ?? 'DIBA JUSTICE' }}</title>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet" type="text/css"/>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            margin: 0;
            padding: 0;
            background-color: #f8f9fc;
            font-family: 'Montserrat', sans-serif;
            -webkit-text-size-adjust: none;
            text-size-adjust: none;
            color: #333333;
        }
        .button-primary {
            background-color: #0305a2;
            color: #ffffff;
            text-decoration: none;
            display: inline-block;
            padding: 14px 30px;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            text-transform: uppercase;
            font-size: 15px;
        }
        .button-primary:hover {
            background-color: #010470;
        }
        .button-secondary {
            background-color: #f0f4ff;
            color: #0305a2;
            text-decoration: none;
            display: inline-block;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 14px;
        }
        .social-icon {
            width: 36px;
            height: 36px;
            margin: 0 8px;
            transition: opacity 0.3s;
        }
        .social-icon:hover {
            opacity: 0.8;
        }
        .content-section {
            background: linear-gradient(135deg, #f0f4ff 0%, #e5eaff 100%);
            border-radius: 12px;
        }
        .divider {
            height: 1px;
            background-color: #e0e6ff;
            width: 80%;
            margin: 20px auto;
        }
    </style>
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    <tr>
        <td align="center" style="padding: 40px 0;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="max-width: 600px; background-color: #ffffff; border-radius: 16px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                <tbody>
                <!-- En-tête -->
                @include('emails.template.header')
                
                <!-- Séparateur design -->
                <tr>
                    <td align="center">
                        <div style="height: 5px; background: linear-gradient(90deg, #0305a2, #4f52ff, #0305a2); border-radius: 5px 5px 0 0;"></div>
                    </td>
                </tr>
                
                <!-- Contenu principal -->
                <tr>
                    <td align="center" style="padding: 20px 40px 50px 40px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <!-- Image d'en-tête -->
                            {{-- <tr>
                                <td align="center" style="padding: 20px 0 30px 0;">
                                    <img alt="{{ $header_image_alt ?? $title ?? 'DIBA JUSTICE' }}"  style="display: block; height: auto; max-width: 320px; border-radius: 12px;"/>
                                </td>
                            </tr> --}}
                            
                            <!-- Titre principal -->
                            <tr>
                                <td align="center" style="padding-bottom: 25px;">
                                    <h1 style="color: #0305a2; font-size: 28px; font-weight: 700; margin: 0; line-height: 1.3; text-align:center">{{ $main_title ?? 'Message Important' }}</h1>
                                </td>
                            </tr>
                            
                            <!-- Contenu spécifique à l'email -->
                            @yield('content')
                            
                        </table>
                    </td>
                </tr>
                
                <!-- Pied de page -->
                @include('emails.template.footer')
                </tbody>
            </table>
            
            <!-- Message de copyright -->
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="max-width: 600px;">
                <tr>
                    <td align="center" style="padding-top: 20px;">
                        <p style="font-size: 12px; color: #999;">© {{ date('Y') }} {{ $copyright_name ?? 'DIBA.PAQUET' }}. {{ $copyright_text ?? 'Tous droits réservés.' }}</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>