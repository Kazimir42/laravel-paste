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
        /*$guest = User::factory()->create([
            'name' => 'Guest'
        ]);

        $response = $this->post(route('pastes.store'), [
            'content' => $this->faker->text,
            'status' => 'public'
        ]);
        ;

        $response->assertRedirect(route('pastes.show'));

        $this->assertDatabaseCount('pastes', 1);*/

        /**
         * todo: this
         */
    }

    public function testCanCreatePrivatePasteIfNotLoggingIn()
    {
        /**
         * todo: this
         */
    }

    public function testCanCreateNotListedPasteIfNotLoggingIn()
    {
        /**
         * todo: this
         */
    }

    public function testCanCreatePublicPasteIfLoggingIn()
    {
        /*$user = User::factory()->create();
        $this->assertDatabaseCount('pastes', 0);

        $response = $this->actingAs($user)->post(route('pastes.store'), [
            'content' => $this->faker->text
        ]);
        $response->assertRedirect(route('pastes.show'));

        $this->assertDatabaseCount('pastes', 1);*/
        /**
         * todo: this
         */
    }

    public function testCanCreatePrivatePasteIfLoggingIn()
    {
        /**
         * todo: this
         */
    }

    public function testCanCreateNotListedPasteIfLoggingIn()
    {
        /**
         * todo: this
         */
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
        /*$user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('pastes.store'), [
            'title' => '',
            'content' => $this->faker->text,
            'status' => 'public'
        ]);
        $response->assertRedirect(route('pastes.show'));*/
        /**
         * todo: this
         */
    }
}
