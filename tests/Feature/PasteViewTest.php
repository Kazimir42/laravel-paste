<?php

namespace Tests\Feature;

use App\Models\Paste;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PasteViewTest extends TestCase
{
    use RefreshDatabase;


    public function testCannotViewPasteIfNotLoggedIn()
    {
        $user = User::factory()->create();
        $paste = Paste::factory()->for($user)->create();

        $response = $this->get(route('pastes.show', $paste));
        $response->assertRedirect(route('login'));
    }

    public function testCannotViewNotExistingPaste()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/pastes/999');
        $response->assertNotFound();
    }

    public function testCanViewUserExistingPaste()
    {
        $user = User::factory()->create();

        $paste = Paste::factory()->for($user)->create();
        $this->assertDatabaseCount('pastes', 1);

        $response = $this->actingAs($user)->get(route('pastes.show', $paste));
        $response->assertSuccessful();
    }
    public function testCannotViewExistingPasteOfOtherUser()
    {
        $other_user = User::factory()->create();
        $user = User::factory()->create();

        $paste = Paste::factory()->for($other_user)->create();
        $this->assertDatabaseCount('pastes', 1);

        $response = $this->actingAs($user)->get(route('pastes.show', $paste));
        $response->assertForbidden();
    }
}
