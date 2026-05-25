<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Gère une requête entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Liste des rôles autorisés (ex: admin, magasinier)
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Vérifier si l'utilisateur est connecté (via Sanctum)
        // 2. Vérifier si son rôle est présent dans la liste des rôles autorisés
        if (!$request->user() || !in_array($request->user()->role, $roles)) {
            return response()->json([
                "message" => "Accès interdit. Vous n'avez pas les droits nécessaires pour effectuer cette action."
            ], 403);
        }

        return $next($request);
    }
}
