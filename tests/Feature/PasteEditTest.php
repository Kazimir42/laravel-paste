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

        $response = $this->get(route('pastes.edit', $paste->not_listed_id));
        $response->assertForbidden();
    }

    public function testCannotViewNotExistingPaste()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/pastes/ExAmPlEe/edit');

        $response->assertNotFound();
    }

    public function testCannotUpdateNotExistingPaste()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/pastes/ExAmPlEe', [
            'content' => $this->faker->text,
        ]);
        $response->assertNotFound();
    }

    public function testCannotUpdateWithoutBody()
    {
        $user = User::factory()->create();

        $paste = Paste::factory()->for($user)->create();
        $this->assertDatabaseCount('pastes', 1);

        $response = $this->actingAs($user)->put(route('pastes.update', $paste->not_listed_id));
        $response->assertSessionHasErrors();
    }
    public function testCanUpdateWithEmptyTitle()
    {
        $user = User::factory()->create();

        $paste = Paste::factory()->for($user)->create();
        $this->assertDatabaseCount('pastes', 1);

        $response = $this->actingAs($user)->put(route('pastes.update', $paste->not_listed_id), [
            'title' => '',
            'content' => $this->faker->text,
            'status' => 'public'

        ]);
        $response->assertRedirect(route('pastes.show', $paste->not_listed_id));
    }

    public function testCannotUpdateWithEmptyContent()
    {
        $user = User::factory()->create();

        $paste = Paste::factory()->for($user)->create();
        $this->assertDatabaseCount('pastes', 1);

        $response = $this->actingAs($user)->put(route('pastes.update', $paste->not_listed_id), [
            'title' => $this->faker->title,
            'content' => '',
            'status' => 'public'
        ]);
        $response->assertSessionHasErrors('content');
    }

    public function testCannotUpdateWithEmptyStatus()
    {
        $user = User::factory()->create();

        $paste = Paste::factory()->for($user)->create();
        $this->assertDatabaseCount('pastes', 1);

        $response = $this->actingAs($user)->put(route('pastes.update', $paste->not_listed_id), [
            'title' => $this->faker->title,
            'content' => $this->faker->text,
            'status' => ''
        ]);
        $response->assertSessionHasErrors('status');
    }

    public function testCanUpdateUserExistingPaste()
    {
        $user = User::factory()->create();

        /** @var Paste $paste */
        $paste = Paste::factory()->for($user)->create();

        $this->assertDatabaseCount('pastes', 1);

        $newTitle = $this->faker->title;
        $newContent = $this->faker->text;
        $newStatus = 'private';

        $response = $this->actingAs($user)->put(route('pastes.update', $paste->not_listed_id), [
            'title' => $newTitle,
            'content' => $newContent,
            'status' => $newStatus,
        ]);

        $response->assertRedirect(route('pastes.show', $paste->not_listed_id));

        $paste = $paste->refresh();
        $this->assertEquals($newContent, $paste->content);
    }

    public function testCannotUpdateExistingPasteOfOtherUser()
    {
        $other_user = User::factory()->create();
        $user = User::factory()->create();

        /** @var Paste $paste */
        $paste = Paste::factory()->for($other_user)->create();
        $this->assertDatabaseCount('pastes', 1);

        $newTitle = $this->faker->title;
        $newContent = $this->faker->text;

        $response = $this->actingAs($user)->put(route('pastes.update', $paste->not_listed_id), [
            'title' => $newTitle,
            'content' => $newContent,
        ]);

        $response->assertForbidden();
    }

}
