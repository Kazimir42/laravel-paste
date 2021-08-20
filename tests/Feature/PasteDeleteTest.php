<?php

namespace Tests\Feature;

use App\Models\Paste;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PasteDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function testCannotDeletePasteIfNotLoggedIn()
    {
        $user = User::factory()->create();
        $paste = Paste::factory()->for($user)->create();

        $response = $this->delete(route('pastes.destroy', $paste->not_listed_id));
        $response->assertForbidden();
    }

    public function testCannotDeleteNotExistingPaste()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete('/pastes/ExAmPlEe');
        $response->assertNotFound();
    }

    public function testCanDeleteUserExistingPaste()
    {
        $user = User::factory()->create();
        $paste = Paste::factory()->for($user)->create();

        $this->assertDatabaseCount('pastes', 1);

        $response = $this->actingAs($user)->delete(route('pastes.destroy', $paste->not_listed_id));
        $response->assertRedirect(route('pastes.index'));

        $this->assertDatabaseCount('pastes', 0);
    }

    public function testCannotDeleteExistingPasteOfOtherUser()
    {
        $user = User::factory()->create();
        $other_user = User::factory()->create();

        $paste = Paste::factory()->for($user)->create();

        $response = $this->actingAs($other_user)->delete(route('pastes.destroy', $paste->not_listed_id));
        $response->assertForbidden();
    }
}
