<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Models\Order;

class CategoryIntegrationTest extends TestCase
{
    use RefreshDatabase; // RECRÉE LA BASE À CHAQUE TEST (Indispensable !)

   #[Test]
public function un_utilisateur_authentifie_peut_creer_une_categorie()
{
    // MODIFICATION ICI : On force le rôle à 'admin'
    $user = User::factory()->create(['role' => 'admin']);
    Sanctum::actingAs($user);

    $data = [
        'name' => 'BOULANGERIE',
        'slug' => 'boulangerie',
        'description' => 'Produits frais du jour'
    ];

    $response = $this->postJson('/api/categories', $data);

    $response->assertStatus(201);
    // ... reste du code
}

#[Test]
public function la_creation_echoue_si_le_nom_est_manquant()
{
    // MODIFICATION ICI AUSSI : Un admin peut essayer de créer (mais échouera sur la validation)
    $user = User::factory()->create(['role' => 'admin']);
    Sanctum::actingAs($user);

    $response = $this->postJson('/api/categories', []);

    $response->assertStatus(422);
}

}
