<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // [READ ALL] L'utilisateur voit SES commandes
    public function index(Request $request)
{
    $user = $request->user();

    // Si c'est un client, il ne voit que ses commandes
    if ($user->role === 'client') {
        return Order::where('user_id', $user->id)->get();
    }

    // Si c'est un manager ou admin, il voit tout
    return Order::all();
}

    // [CREATE] Passer une commande
    public function store(Request $request) {
        $validated = $request->validate([
            'total_price' => 'required|numeric|min:0',
        ]);

        // On crée la commande liée à l'utilisateur connecté
        $order = $request->user()->orders()->create([
            'total_price' => $validated['total_price'],
            'status' => 'pending',
        ]);

        return response()->json($order, 201);
    }

    // [READ ONE] Détails d'une commande
    public function show(Order $order) {
        // Optionnel : vérifier que la commande appartient bien à l'user
        return response()->json($order, 200);
    }

    public function update(Request $request, $id)
{
    $order = Order::findOrFail($id);
    $user = $request->user();

    // 1. Le client ne peut modifier que SA propre commande
    if ($user->role === 'client' && $order->user_id !== $user->id) {
        return response()->json(["message" => "Accès interdit."], 403);
    }

    // 2. Règle métier : Si le client veut modifier, le statut doit être 'en_attente'
    if ($user->role === 'client' && $order->status !== 'en_attente') {
        return response()->json([
            "message" => "Impossible de modifier une commande déjà en cours de préparation."
        ], 422);
    }

    // 3. Le manager, lui, peut modifier le statut à tout moment
    if ($user->role === 'magasinier' || $user->role === 'admin') {
        $order->update($request->only('status'));
    } else {
        // Le client ne peut modifier que les articles ou l'adresse (par exemple)
        $order->update($request->only('shipping_address', 'items'));
    }

    return response()->json(["message" => "Commande mise à jour.", "order" => $order]);
}

    // [DELETE] Annuler une commande
    public function destroy(Order $order) {
        $order->delete();
        return response()->json(['message' => 'Commande annulée'], 200);
    }
}
