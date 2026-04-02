<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
        Log::info('Tentative d\'envoi de lien de réinitialisation', ['email' => $request->email]);
        
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email'
            ], [
                'email.required' => 'Veuillez saisir votre adresse email.',
                'email.email' => 'Veuillez saisir une adresse email valide.',
                'email.exists' => 'Aucun compte n\'est associé à cette adresse email.'
            ]);
            
            Log::info('Validation réussie pour l\'email', ['email' => $request->email]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Échec de validation pour la réinitialisation', [
                'email' => $request->email,
                'erreurs' => $e->errors()
            ]);
            throw $e;
        }

        $email = $request->email;
        $user = User::where('email', $email)->first();

        if (!$user) {
            Log::error('Utilisateur non trouvé après validation', ['email' => $email]);
            return back()->withErrors(['email' => 'Une erreur inattendue est survenue.']);
        }

        Log::info('Utilisateur trouvé', ['user_id' => $user->id, 'email' => $email]);

        try {
            // Générer un token unique
            $token = Str::random(64);
            Log::debug('Token généré', ['email' => $email, 'token_length' => strlen($token)]);

            // Supprimer les anciens tokens pour cet email
            $deleted = DB::table('password_reset_tokens')->where('email', $email)->delete();
            Log::info('Anciens tokens supprimés', ['email' => $email, 'nombre_supprime' => $deleted]);

            // Créer un nouveau token
            $hashedToken = Hash::make($token);
            $inserted = DB::table('password_reset_tokens')->insert([
                'email' => $email,
                'token' => $hashedToken,
                'created_at' => Carbon::now()
            ]);

            if (!$inserted) {
                Log::error('Échec de l\'insertion du token', ['email' => $email]);
                throw new \Exception('Impossible de créer le token de réinitialisation');
            }

            Log::info('Nouveau token créé avec succès', ['email' => $email]);

            // Préparer les données pour l'email
            $data = [
                'user' => $user,
                'token' => $token,
                'email' => $email
            ];

            // Variables de configuration pour le template
            $emailData = [
                'data' => $data,
                'main_title' => 'Réinitialisation de mot de passe',
                'login_url' => route('login'),
                'company_name' => 'ABS TECHNOLOGIE'
            ];

            // Envoyer l'email
            Log::info('Tentative d\'envoi d\'email', ['email' => $email]);

            Mail::send('emails.password_reset', $emailData, function ($message) use ($email) {
                $message->to($email)
                    ->subject('Réinitialisation de votre mot de passe - ABS ²TECHNOLOGIE');
            });

            Log::info('Email envoyé avec succès', ['email' => $email]);
            
            return back()->with('success', 'Un lien de réinitialisation a été envoyé à votre adresse email.');

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi du lien de réinitialisation', [
                'email' => $email,
                'user_id' => $user->id ?? null,
                'erreur' => $e->getMessage(),
                'fichier' => $e->getFile(),
                'ligne' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

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
