<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Teste que l'utilisateur peut récupérer ses propres infos.
     */
    public function test_un_utilisateur_peut_voir_son_profil(): void
    {
        $user = User::factory()->create(['role' => 'client']);
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/profile');

        $response->assertStatus(200)
                 ->assertJsonPath('email', $user->email);
    }

    /**
     * Teste la mise à jour des informations.
     */
    public function test_les_informations_du_profil_peuvent_etre_mises_a_jour(): void
    {
        $user = User::factory()->create(['role' => 'client']);
        Sanctum::actingAs($user);

        $response = $this->putJson('/api/profile', [
            'name' => 'Nouveau Nom',
            'email' => 'nouveau@example.com',
        ]);

        $response->assertStatus(200);

        $user->refresh();
        $this->assertSame('Nouveau Nom', $user->name);
        $this->assertSame('nouveau@example.com', $user->email);
    }

    /**
     * Teste la sécurité : Un client ne peut pas changer son rôle en Admin.
     */
    public function test_un_utilisateur_ne_peut_pas_changer_son_propre_role(): void
    {
        $user = User::factory()->create(['role' => 'client']);
        Sanctum::actingAs($user);

        // On tente de s'auto-promouvoir admin
        $this->putJson('/api/profile', [
            'name' => 'Pirate',
            'role' => 'admin',
        ]);

        $user->refresh();
        // Le nom change, mais le rôle DOIT rester 'client'
        $this->assertSame('client', $user->role);
    }
}
