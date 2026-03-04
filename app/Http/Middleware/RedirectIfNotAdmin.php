<?php
// app/Http/Middleware/RedirectIfNotAdmin.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Personnel;

class RedirectIfNotAdmin
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
                    'redirect' => route('login')
                ], 401);
            }
            
            return redirect()->route('login')
                ->with('warning', 'Votre session a expiré. Veuillez vous reconnecter.');
        }

        // Vérifier si l'utilisateur est dans personnel (admin)
        $user = Auth::user();
        $personnel = Personnel::where('id', $user->personnel_id)->first();
        
        // Vérifier si l'utilisateur a un profil client
        $client = Client::where('user_id', $user->id)->first();
        
        // Si ce n'est pas un admin (pas dans personnel)
        if (!$personnel) {
            // Si c'est un client, le rediriger vers l'accueil client
            if ($client) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Accès réservé aux administrateurs.',
                        'redirect' => route('client.index')
                    ], 403);
                }
                
                return redirect()->route('client.index')
                    ->with('error', 'Accès réservé aux administrateurs.');
            }
            
            // Sinon, déconnecter et rediriger vers login
            Auth::logout();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous n\'avez pas les droits d\'accès à cette section.',
                    'redirect' => route('login')
                ], 403);
            }
            
            return redirect()->route('login')
                ->with('error', 'Vous n\'avez pas les droits d\'accès à cette section.');
        }

        return $next($request);
    }
}