<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    /**
     * Afficher le formulaire de demande de réinitialisation
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgotPassword');
    }

    /**
     * Envoyer le lien de réinitialisation par email
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Veuillez saisir votre adresse email.',
            'email.email' => 'Veuillez saisir une adresse email valide.',
            'email.exists' => 'Aucun compte n\'est associé à cette adresse email.'
        ]);

        $email = $request->email;
        $user = User::where('email', $email)->first();

        // Générer un token unique
        $token = Str::random(64);

        // Supprimer les anciens tokens pour cet email
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        // Créer un nouveau token
        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now()
        ]);

        // Préparer les données pour l'email
        $data = [
            'user' => $user,
            'token' => $token,
            'email' => $email
        ];

        // Variables de configuration pour le template (optionnel, pour surcharger les défauts si besoin)
        $emailData = [
            'data' => $data,
            'main_title' => 'Réinitialisation de mot de passe',
            'login_url' => route('login'),
            'company_name' => 'GoodTroc' // Harmonisation avec le titre de la page
        ];

        // Envoyer l'email
        try {
            Mail::send('emails.password_reset', $emailData, function ($message) use ($email) {
                $message->to($email)
                    ->subject('Réinitialisation de votre mot de passe - GoodTroc');
            });

            return back()->with('success', 'Un lien de réinitialisation a été envoyé à votre adresse email.');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Une erreur est survenue lors de l\'envoi de l\'email. Veuillez réessayer.']);
        }
    }

    /**
     * Afficher le formulaire de réinitialisation avec le token
     */
    public function showResetPasswordForm($token)
    {
        $email = request('email');
        
        // Vérifier si le token existe et n'est pas expiré
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$resetRecord) {
            return redirect()->route('login')->withErrors(['message' => 'Ce lien de réinitialisation est invalide.']);
        }

        // Vérifier l'expiration (60 minutes)
        $createdAt = Carbon::parse($resetRecord->created_at);
        if ($createdAt->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return redirect()->route('login')->withErrors(['message' => 'Ce lien de réinitialisation a expiré.']);
        }

        return view('auth.resetPassword', ['token' => $token]);
    }

    /**
     * Réinitialiser le mot de passe
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed'
        ], [
            'email.required' => 'L\'adresse email est requise.',
            'email.email' => 'Veuillez saisir une adresse email valide.',
            'email.exists' => 'Aucun compte n\'est associé à cette adresse email.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.'
        ]);

        // Vérifier le token
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord) {
            return back()->withErrors(['message' => 'Ce lien de réinitialisation est invalide.']);
        }

        // Vérifier l'expiration
        $createdAt = Carbon::parse($resetRecord->created_at);
        if ($createdAt->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['message' => 'Ce lien de réinitialisation a expiré.']);
        }

        // Mettre à jour le mot de passe
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Supprimer le token utilisé
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter.');
    }
}
