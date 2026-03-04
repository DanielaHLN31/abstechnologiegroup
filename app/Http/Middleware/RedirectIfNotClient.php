<?php
// app/Http/Middleware/RedirectIfNotClient.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Personnel;

class RedirectIfNotClient
{
    public function handle(Request $request, Closure $next)
    {
        // ✅ Vérifier si l'utilisateur est authentifié (session valide)
        if (!Auth::check()) {
            // Session expirée ou utilisateur non connecté
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Votre session a expiré. Veuillez vous reconnecter.',
                    'redirect' => route('client.login')
                ], 401);
            }
            
            return redirect()->route('client.login')
                ->with('warning', 'Votre session a expiré. Veuillez vous reconnecter.');
        }

        // Vérifier si l'utilisateur a un profil client
        $user = Auth::user();
        $client = Client::where('user_id', $user->id)->first();
        
        // Vérifier si l'utilisateur est dans personnel (admin)
        $personnel = Personnel::where('id', $user->personnel_id)->first();
        
        // Si ce n'est pas un client ET pas un admin
        if (!$client && !$personnel) {
            Auth::logout();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous devez avoir un compte client pour accéder à cette page.',
                    'redirect' => route('client.login')
                ], 403);
            }
            
            return redirect()->route('client.login')
                ->with('error', 'Vous devez avoir un compte client pour accéder à cette page.');
        }

        // Si c'est un admin sans compte client, on le laisse passer
        if ($personnel && !$client) {
            // Optionnel : Ajouter un message pour informer l'admin
            session()->flash('info', 'Vous êtes connecté en tant qu\'administrateur.');
        }

        return $next($request);
    }
}