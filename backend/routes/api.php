<?php
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// --- 1. ROUTES PUBLIQUES (Consultation libre) ---
// Tout le monde peut voir la liste et le détail sans être connecté
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
//Route::post('/products', [ProductController::class, 'store']);
//Route::put('/products/{product}', [ProductController::class, 'update']);
//Route::delete('/products/{product}', [ProductController::class, 'destroy']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
//Route::post('/categories', [CategoryController::class, 'store']);
//Route::put('/categories/{category}', [CategoryController::class, 'update']);
//Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

// --- ROUTES PROTÉGÉES PAR RÔLE ---
Route::middleware('auth:sanctum')->group(function () {

// --- PROFIL (Tout le monde pour son propre compte) ---
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);

     // --- COMMANDES ---
    // Un client voit SES commandes, un manager voit TOUTES les commandes (logique à mettre dans le contrôleur)
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);

    // 1. Uniquement Admin et Magasinier peuvent créer/modifier
    Route::middleware('role:admin,magasinier')->group(function () {
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{id}', [ProductController::class, 'update']);
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{id}', [CategoryController::class, 'update']);
        Route::put('/orders/{id}', [OrderController::class, 'update']);
    });

    // 2. Uniquement l'Admin peut supprimer définitivement
    Route::middleware('role:admin')->group(function () {
        Route::delete('/products/{id}', [ProductController::class, 'destroy']);
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
    });
});
