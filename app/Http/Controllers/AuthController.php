<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\Frontend\CartController;
use App\Mail\ClientWelcomeMail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    
    public function Clientlogin()
    {
        return view('client.auth.login');
    }

    // Vérifier si l'email correspond à un utilisateur
    public function checkUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->input('email');
        $user = User::where('email', $email)->first();

        if ($user) {
            $cleanPassword = !$user->password || Hash::check('CLEAN', $user->password);

            return response()->json([
                'exists' => true,
                'cleanPassword' => $cleanPassword,
                'has_2fa' => !is_null($user->two_factor_secret)
            ]);
        }

        return response()->json(['exists' => false]);
    }

    // Login
    public function LoginFormStore(Request $request)
    {
        // Validation de base
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => "Veuillez insérer votre email",
            'email.email' => "Format d'email invalide",
            'password.required' => "Veuillez insérer votre mot de passe",
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->has('remember');

        // Recherche de l'utilisateur
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['message' => 'Email ou mot de passe incorrect']);
        }

        // Vérification du statut de l'utilisateur
        if ($user->status == 2) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['message' => 'Votre compte est en attente de validation.']);
        }

        if ($user->status == 0) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['message' => 'Votre compte a été désactivé.']);
        }

        // Cas du premier login avec mot de passe par défaut
        $isFirstLogin = !$user->password || Hash::check('CLEAN', $user->password);

        if ($isFirstLogin) {
            // Validation de la confirmation du mot de passe
            $request->validate([
                'password' => 'required|string|min:8',
                'password_confirmation' => 'required|same:password'
            ], [
                'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
                'password_confirmation.required' => 'Veuillez confirmer votre mot de passe.',
                'password_confirmation.same' => 'Les mots de passe ne correspondent pas.'
            ]);

            // Mise à jour du mot de passe
            $user->password = Hash::make($password);
            $user->save();

            Log::info('Premier login - Mot de passe défini', ['user_id' => $user->id]);
        }


        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            $oldSessionId = session()->getId();
            
            // 🔍 DIAGNOSTIC
            $cartCount = \App\Models\CartItem::where('session_id', $oldSessionId)->count();
            Log::info('CART MERGE DEBUG', [
                'old_session_id'   => $oldSessionId,
                'cart_items_found' => $cartCount,
                'all_session_items'=> \App\Models\CartItem::whereNotNull('session_id')->get(['session_id','product_id','quantity'])->toArray(),
            ]);

            $request->session()->regenerate();
            CartController::mergeSessionCart($oldSessionId);

            Log::info('Connexion réussie', [
                        'user_id' => Auth::id(),
                        'session_id' => session()->getId(),
                        'remember' => $remember
                    ]);
            return redirect()->intended(route('dashboardVendors'));
        }

        Log::warning('Échec d\'authentification', ['email' => $email]);

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['message' => 'Email ou mot de passe incorrect']);
    }


    public function registerFormStore(Request $request)
    {
        // Log de début de processus
        Log::info('=== DÉBUT INSCRIPTION CLIENT ===', [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'request_data' => [
                'username' => $request->username,
                'email' => $request->email,
            ]
        ]);

        // Validation des données
        $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        Log::info('Validation réussie pour l\'inscription', [
            'email' => $request->email,
            'username' => $request->username
        ]);

        DB::beginTransaction();

        try {
            Log::info('Début de la transaction d\'inscription', [
                'email' => $request->email
            ]);

            // 📝 Garder une trace du mot de passe original pour l'email (optionnel)
            $originalPassword = $request->password;

            // 🆕 Création de l'utilisateur
            $user = User::create([
                'name'     => $request->username,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'status'   => 1,
            ]);

            Log::info('Utilisateur créé avec succès', [
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'status' => $user->status
            ]);

            // 🆕 Création du profil client
            $client = Client::create([
                'user_id' => $user->id,
                'email'   => $user->email,
            ]);

            Log::info('Profil client créé avec succès', [
                'client_id' => $client->id,
                'user_id' => $client->user_id,
                'email' => $client->email,
                'created_at' => $client->created_at->format('Y-m-d H:i:s')
            ]);

            // ✅ Envoi de l'email de bienvenue
            try {
                Log::info('Tentative d\'envoi d\'email de bienvenue', [
                    'email' => $user->email,
                    'user_id' => $user->id
                ]);

                // Option 1: Envoyer le mot de passe en clair (moins sécurisé)
                // Mail::to($user->email)->send(new ClientWelcomeMail($user, $originalPassword));
                Mail::to($user->email)->queue(new ClientWelcomeMail($user, $originalPassword));
                
                // Option 2: Ne pas envoyer le mot de passe (plus sécurisé)
                // Mail::to($user->email)->send(new ClientWelcomeMail($user));
                
                Log::info('Email de bienvenue envoyé avec succès', [
                    'email' => $user->email,
                    'user_id' => $user->id
                ]);

            } catch (\Exception $e) {
                // On ne bloque pas la transaction si l'email échoue
                Log::error('Erreur lors de l\'envoi de l\'email de bienvenue', [
                    'email' => $user->email,
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                // Vous pouvez ajouter une notification flash pour informer l'utilisateur
                session()->flash('warning', 'Votre compte a été créé mais l\'email de confirmation n\'a pas pu être envoyé.');
            }

            DB::commit();
            
            Log::info('=== INSCRIPTION CLIENT RÉUSSIE ===', [
                'user_id' => $user->id,
                'email' => $user->email,
                'email_sent' => true,
                'timestamp' => now()->format('Y-m-d H:i:s')
            ]);

            return redirect('/connexion')->with('success', 'Compte client créé avec succès. Un email de confirmation vous a été envoyé.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('=== ERREUR INSCRIPTION CLIENT ===', [
                'email' => $request->email,
                'username' => $request->username,
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'error_trace' => $e->getTraceAsString(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return back()->with('error', 'Une erreur est survenue lors de la création de votre compte. Veuillez réessayer.')->withInput();
        }
    }

    public function ClientLoginFormStore(Request $request)
    {
        // Capturer le session ID AVANT toute opération
        // (celui passé depuis le formulaire, qui correspond à la session de navigation)
        $cartSessionId = $request->input('cart_session_id') ?? session()->getId();
        
        \Log::info('CART::SESSION-IDS', [
            'cart_session_id_from_form'    => $cartSessionId,
            'current_session_id'           => session()->getId(),
            'items_with_form_session'      => \App\Models\CartItem::where('session_id', $cartSessionId)->count(),
        ]);

        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => "Veuillez insérer votre email",
            'email.email'       => "Format d'email invalide",
            'password.required' => "Veuillez insérer votre mot de passe",
        ]);

        $email    = $request->input('email');
        $password = $request->input('password');
        $remember = $request->has('remember');

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withInput($request->only('email'))
                ->withErrors(['message' => 'Email ou mot de passe incorrect']);
        }

        if ($user->status == 2) {
            return back()->withInput($request->only('email'))
                ->withErrors(['message' => 'Votre compte est en attente de validation.']);
        }

        if ($user->status == 0) {
            return back()->withInput($request->only('email'))
                ->withErrors(['message' => 'Votre compte a été désactivé.']);
        }

        $client    = Client::where('user_id', $user->id)->first();
        $personnel = Personnel::where('id', $user->personnel_id)->first();

        $isFirstLogin = !$user->password || Hash::check('CLEAN', $user->password);

        if ($isFirstLogin) {
            $request->validate([
                'password'              => 'required|string|min:8',
                'password_confirmation' => 'required|same:password',
            ], [
                'password.min'                  => 'Le mot de passe doit contenir au moins 8 caractères.',
                'password_confirmation.required'=> 'Veuillez confirmer votre mot de passe.',
                'password_confirmation.same'    => 'Les mots de passe ne correspondent pas.',
            ]);

            $user->password = Hash::make($password);
            $user->save();
        }

        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {

            $request->session()->regenerate();

            // ✅ Utiliser le session ID du formulaire (pas celui post-regenerate)
            \Log::info('CART::MERGE-ATTEMPT', [
                'cart_session_id' => $cartSessionId,
                'user_id'         => Auth::id(),
                'items_found'     => \App\Models\CartItem::where('session_id', $cartSessionId)->count(),
            ]);

            CartController::mergeSessionCart($cartSessionId);

            // Recharger après connexion
            $user      = Auth::user();
            $client    = Client::where('user_id', $user->id)->first();
            $personnel = Personnel::where('id', $user->personnel_id)->first();

            // Création automatique du profil client pour admin
            if ($personnel && !$client) {
                DB::beginTransaction();
                try {
                    $client = Client::create([
                        'user_id' => $user->id,
                        'phone'   => $personnel->telephone ?? null,
                        'address' => $personnel->adresse ?? null,
                        'city'    => $personnel->ville_de_residence ?? null,
                        'country' => 'Bénin',
                    ]);
                    DB::commit();
                    session()->flash('success', 'Votre compte client a été créé automatiquement. Bienvenue !');
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Erreur création auto profil client', [
                        'user_id' => $user->id,
                        'error'   => $e->getMessage(),
                    ]);
                }
            }

            Log::info('Connexion réussie', [
                'user_id'       => $user->id,
                'email'         => $user->email,
                'has_client'    => (bool) $client,
                'has_personnel' => (bool) $personnel,
            ]);

            // Redirection intelligente
            if ($personnel && $client) {
                if ($request->has('as_admin') && $request->as_admin == '1') {
                    return redirect()->intended(route('dashboardVendors'));
                }
                session()->flash('info', 'Vous êtes connecté en tant que client.');
                return redirect()->intended(route('client.index'));
            }

            if ($personnel && !$client) {
                return redirect()->intended(route('dashboardVendors'));
            }

            if ($client && !$personnel) {
                return redirect()->intended(route('client.index'));
            }

            Auth::logout();
            return redirect()->route('client.register')
                ->with('error', 'Une erreur est survenue. Veuillez contacter le support.');
        }

        Log::warning('Échec d\'authentification', ['email' => $email]);

        return back()->withInput($request->only('email'))
            ->withErrors(['message' => 'Email ou mot de passe incorrect']);
    }
}
