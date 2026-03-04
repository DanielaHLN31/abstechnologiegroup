<!-- En-tête avec logo et bouton -->
<tr>
    <td align="center" style="padding: 30px 40px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="50%" align="left">
                    <img alt="DIBA JUSTICE Logo" src="{!! asset('backend/img/logo/logo_case.png') !!}" style="display: block; height: auto; max-width: 180px;"/>
                </td>
                <td width="50%" align="right">
                    <a href="{{ $login_url ?? url('/') }}" class="button-secondary" target="_blank">{{ $login_button_text ?? 'Se connecter' }}</a>
                </td>
            </tr>
        </table>
    </td>
</tr>