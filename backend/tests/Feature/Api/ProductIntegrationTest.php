<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductIntegrationTest extends TestCase
{
    use RefreshDatabase;

  #[TEST] // <--- ATTENTION, C'EST UNE ATTRIBUTION, PAS UN COMMENTAIRE
    public function un_manager_peut_ajouter_un_produit()
    {
        $manager = User::factory()->create(['role' => 'magasinier']);
        $categorie = Category::factory()->create();
        Sanctum::actingAs($manager);

        $response = $this->postJson('/api/products', [
            'name' => 'Biscuit Coco',
            'price' => 500,
            'stock' => 100,
            'category_id' => $categorie->id
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('products', ['name' => 'Biscuit Coco']);
    }

        #[TEST]
    public function un_client_ne_peut_pas_supprimer_un_produit()
    {
        $client = User::factory()->create(['role' => 'client']);
        $product = Product::factory()->create();
        Sanctum::actingAs($client);

        $response = $this->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(403);
    }
}
