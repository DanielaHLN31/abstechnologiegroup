<!-- Pied de page -->
<tr>
    <td align="center" style="background-color: #f8f9fc; border-radius: 0 0 16px 16px; padding: 30px 40px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <!-- Réseaux sociaux -->
            <tr>
                <td align="center" style="padding-bottom: 25px;">
                    <a href="{{ $facebook_url ?? 'https://www.facebook.com' }}" target="_blank"><img alt="Facebook" class="social-icon" src="{!! asset('backend/images/logo/facebook2x.png') !!}" /></a>
                    <a href="{{ $twitter_url ?? 'https://www.twitter.com' }}" target="_blank"><img alt="Twitter" class="social-icon" src="{!! asset('backend/images/logo/twitter2x.png') !!}" /></a>
                    <a href="{{ $instagram_url ?? 'https://www.instagram.com' }}" target="_blank"><img alt="Instagram" class="social-icon" src="{!! asset('backend/images/logo/instagram2x.png') !!}" /></a>
                    <a href="{{ $site_url ?? 'https://grpcaseco.com/' }}" target="_blank"><img alt="grpcaseco" class="social-icon" src="{!! asset('backend/img/logo/logo_case.png') !!}" /></a>
                </td>
            </tr>
            
            <!-- Adresse -->
            <tr>
                <td align="center" style="padding-bottom: 20px;">
                    <p style="font-size: 14px; color: #555; line-height: 1.5;">
                        <strong style="color: #0305a2;">{{ $company_name ?? 'DIBA.PAQUET' }}</strong><br>
                        {{ $company_address ?? '06BP 2687. Akpakpa, Cotonou. Rep. du Bénin' }}
                    </p>
                </td>
            </tr>
            
            <tr>
                <td align="center">
                    <div class="divider"></div>
                </td>
            </tr>
            
            <!-- Support -->
            <tr>
                <td align="center">
                    <p style="font-size: 14px; color: #555; line-height: 1.5;">
                        <a href="https://grpcaseco.com/" style="color: #0305a2; font-weight: 600; text-decoration: none;" target="_blank">Consultez notre site pour vos questions</a> | 
                        <span style="color: #0305a2; font-weight: 600;">{{ $phone_number ?? 'CASE&CO BENIN : (+229) 21 33 42 86 / 96 96 18 96 · CASE&CO EUROPE : (+33) 487 94 75 75 / 7 51 41 81 63 · MAIL : casecoadministration@grpcaseco.' }}</span>
                    </p>
                </td>
            </tr>
        </table>
    </td>
</tr>