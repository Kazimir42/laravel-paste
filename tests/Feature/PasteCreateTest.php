<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PasteCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    public function testCanCreatePublicPasteIfNotLoggingIn()
    {

        $guest = User::factory()->create([
            'name' => 'Guest'
        ]);

        $response = $this->post(route('pastes.store'), [
            'content' => $this->faker->text,
            'status' => 'public'
        ]);
        /**
         * @note don't know how to set parameters of new paste
         */
        //$response->assertRedirect(route('pastes.show'));


        $this->assertDatabaseCount('pastes', 1);
    }

    public function testCannotCreatePrivatePasteIfNotLoggingIn()
    {
        $guest = User::factory()->create([
            'name' => 'Guest'
        ]);

        $response = $this->post(route('pastes.store'), [
            'content' => $this->faker->text,
            'status' => 'private'
        ]);
        /**
         * @note don't know how to set parameters of new paste
         */
        //$response->assertRedirect(route('pastes.show'));
        $response->assertForbidden();
    }

    public function testCanCreateNotListedPasteIfNotLoggingIn()
    {
        $guest = User::factory()->create([
            'name' => 'Guest'
        ]);

        $response = $this->post(route('pastes.store'), [
            'content' => $this->faker->text,
            'status' => 'not_listed'
        ]);
        /**
         * @note don't know how to set parameters of new paste
         */
        //$response->assertRedirect(route('pastes.show'));

        $this->assertDatabaseCount('pastes', 1);
    }

    public function testCanCreatePublicPasteIfLoggingIn()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('pastes.store'), [
            'content' => $this->faker->text,
            'status' => 'public'
        ]);
        /**
         * @note don't know how to set parameters of new paste
         */
        //$response->assertRedirect(route('pastes.show'));

        $this->assertDatabaseCount('pastes', 1);
    }

    public function testCanCreatePrivatePasteIfLoggingIn()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('pastes.store'), [
            'content' => $this->faker->text,
            'status' => 'private'
        ]);
        /**
         * @note don't know how to set parameters of new paste
         */
        //$response->assertRedirect(route('pastes.show'));

        $this->assertDatabaseCount('pastes', 1);
    }

    public function testCanCreateNotListedPasteIfLoggingIn()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('pastes.store'), [
            'content' => $this->faker->text,
            'status' => 'not_listed'
        ]);
        /**
         * @note don't know how to set parameters of new paste
         */
        //$response->assertRedirect(route('pastes.show'));

        $this->assertDatabaseCount('pastes', 1);
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


    public function testCannotCreateWithEmptyStatus()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('pastes.store'), [
            'content' => $this->faker->text,
            'status' => ''
        ]);
        $response->assertSessionHasErrors('status');
    }

    public function testCannotCreateWithEmptyContent()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('pastes.store'), [
            'content' => '',
            'status' => 'public'
        ]);
        $response->assertSessionHasErrors('content');
    }

    public function testCanCreateWithEmptyTitle()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('pastes.store'), [
            'title' => '',
            'content' => $this->faker->text,
            'status' => 'public'
        ]);

        /**
         * @note don't know how to set parameters of new paste
         */
        //$response->assertRedirect(route('pastes.show'));

        $this->assertDatabaseCount('pastes', 1);
    }
}
