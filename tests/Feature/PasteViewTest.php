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


    public function testCannotViewPrivatePasteOfOtherUser()
    {
        $user = User::factory()->create();
        $paste = Paste::factory()->for($user)->create([
            'status' => 'private'
        ]);

        $response = $this->get(route('pastes.show', $paste->not_listed_id));
        $response->assertForbidden();
    }

    public function testCanViewPublicPasteOfOtherUser()
    {
        $user = User::factory()->create();
        $paste = Paste::factory()->for($user)->create([
            'status' => 'public'
        ]);

        $response = $this->get(route('pastes.show', $paste->not_listed_id));
        $response->assertSuccessful();
    }

    public function testCanViewNotListedPasteOfOtherUser()
    {
        $user = User::factory()->create();
        $paste = Paste::factory()->for($user)->create([
            'status' => 'not_listed'
        ]);

        $response = $this->get(route('pastes.show', $paste->not_listed_id));
        $response->assertSuccessful();
    }

    public function testCanViewPrivatePasteOfCurrentUser()
    {
        $user = User::factory()->create();
        $paste = Paste::factory()->for($user)->create([
            'status' => 'private'
        ]);

        $response = $this->actingAs($user)->get(route('pastes.show', $paste->not_listed_id));
        $response->assertSuccessful();
    }

    public function testCanViewPublicPasteOfCurrentUser()
    {
        $user = User::factory()->create();
        $paste = Paste::factory()->for($user)->create([
            'status' => 'public'
        ]);

        $response = $this->actingAs($user)->get(route('pastes.show', $paste->not_listed_id));
        $response->assertSuccessful();
    }

    public function testCanViewNotListedPasteOfCurrentUser()
    {
        $user = User::factory()->create();
        $paste = Paste::factory()->for($user)->create([
            'status' => 'not_listed'
        ]);

        $response = $this->actingAs($user)->get(route('pastes.show', $paste->not_listed_id));
        $response->assertSuccessful();
    }

    public function testCannotViewNotExistingPaste()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/pastes/Example');
        $response->assertNotFound();
    }

}
