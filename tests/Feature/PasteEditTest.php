<?php

namespace Tests\Feature;

use App\Models\Paste;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PasteEditTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testCannotEditPasteIfNotLoggedIn()
    {
        $user = User::factory()->create();
        $paste = Paste::factory()->for($user)->create();

        $response = $this->get(route('pastes.edit', $paste));
        $response->assertRedirect(route('login'));
    }

    public function testCannotViewNotExistingPaste()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/paste/999/edit');

        $response->assertNotFound();
    }

}
