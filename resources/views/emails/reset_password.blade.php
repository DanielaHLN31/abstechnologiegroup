@extends('emails.template.layout')

@section('content')
<!-- Contenu du message dans une section colorée -->
<tr>
    <td align="center">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="content-section" style="padding: 30px; margin-bottom: 30px;">
            <tr>
                <td>
                    <p style="font-size: 16px; line-height: 1.6; margin-bottom: 20px;">Bonjour {{ $data['user']->name }},</p>
                    
                    <p style="font-size: 16px; line-height: 1.6; margin-bottom: 20px;">Vous recevez cet email car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte sur DIBA PAQUET.</p>
                    
                    <p style="font-size: 16px; line-height: 1.6; margin-bottom: 20px;">Ce lien de réinitialisation expirera dans <span style="color: #0305a2; font-weight: 600;">60 minutes</span>. Si vous n'avez pas demandé de réinitialisation de mot de passe, aucune action n'est requise de votre part.</p>
                    
                    <p style="font-size: 16px; line-height: 1.6; margin-bottom: 20px;">Si vous rencontrez des difficultés ou avez besoin d'assistance supplémentaire, n'hésitez pas à contacter notre équipe de support.</p>
                    
                    <p style="font-size: 16px; line-height: 1.6;">Merci d'utiliser DIBA PAQUET.</p>
                </td>
            </tr>
        </table>
    </td>
</tr>

<!-- Bouton d'action -->
<tr>
    <td align="center" style="padding: 10px 0 30px 0;">
        <a href="{{ url('password/reset/'.$data['token'].'?email='.$data['email']) }}" class="button-primary" target="_blank" style="color: #ffffff">RÉINITIALISER MOT DE PASSE</a>
    </td>
</tr>

<!-- Message de sécurité -->
<tr>
    <td align="center" style="padding-bottom: 20px;">
        <p style="font-size: 13px; color: #666; background-color: #f7f7f7; padding: 12px; border-radius: 6px; border-left: 4px solid #0305a2;">
            Pour votre sécurité, ne partagez jamais ce lien avec quiconque.
        </p>
    </td>
</tr>
@endsection