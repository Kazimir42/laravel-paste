<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PasteCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    public function testCannotCreatePasteIfNotLoggedIn()
    {
        $response = $this->get(route('pastes.create'));
        $response->assertRedirect(route('login'));
    }

    public function testCanViewCreatePage()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('pastes.create'));
        $response->assertSuccessful();
        $response->assertSee(route('pastes.store'));
    }

    public function testCannotCreateWithoutData()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('pastes.store'));
        $response->assertSessionHasErrors('content');
    }

    public function testCannotCreateWithEmptyContent()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('pastes.store'), [
            'content' => ''
        ]);
        $response->assertSessionHasErrors('content');
    }

    public function testCanCreateWithEmptyTitle()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('pastes.store'), [
            'title' => '',
            'content' => $this->faker->text
        ]);
        $response->assertRedirect(route('pastes.index'));
    }

    public function testCanCreate()
    {
        $user = User::factory()->create();
        $this->assertDatabaseCount('pastes', 0);

        $response = $this->actingAs($user)->post(route('pastes.store'), [
            'content' => $this->faker->text
        ]);
        $response->assertRedirect(route('pastes.index'));

        $this->assertDatabaseCount('pastes', 1);
    }
}
