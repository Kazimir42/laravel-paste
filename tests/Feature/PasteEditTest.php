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

        $response = $this->actingAs($user)->get('/pastes/999/edit');

        $response->assertNotFound();
    }

    public function testCannotUpdateNotExistingPaste()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/pastes/999', [
            'content' => $this->faker->text,
        ]);
        $response->assertNotFound();
    }

    public function testCannotUpdateWithoutBody()
    {
        $user = User::factory()->create();

        $paste = Paste::factory()->for($user)->create();
        $this->assertDatabaseCount('pastes', 1);

        $response = $this->actingAs($user)->put(route('pastes.update', $paste));
        $response->assertSessionHasErrors();
    }
    public function testCanUpdateWithEmptyTitle()
    {
        $user = User::factory()->create();

        $paste = Paste::factory()->for($user)->create();
        $this->assertDatabaseCount('pastes', 1);

        $response = $this->actingAs($user)->put(route('pastes.update', $paste), [
            'title' => '',
            'content' => $this->faker->text,
        ]);
        $response->assertRedirect(route('pastes.show', $paste));
    }

    public function testCannotUpdateWithEmptyContent()
    {
        $user = User::factory()->create();

        $paste = Paste::factory()->for($user)->create();
        $this->assertDatabaseCount('pastes', 1);

        $response = $this->actingAs($user)->put(route('pastes.update', $paste), [
            'title' => $this->faker->title,
            'content' => ''
        ]);
        $response->assertSessionHasErrors('content');
    }

    public function testCanUpdateUserExistingPaste()
    {
        $user = User::factory()->create();

        /** @var Paste $paste */
        $paste = Paste::factory()->for($user)->create();

        $this->assertDatabaseCount('pastes', 1);

        $newTitle = $this->faker->title;
        $newContent = $this->faker->text;

        $response = $this->actingAs($user)->put(route('pastes.update', $paste), [
            'title' => $newTitle,
            'content' => $newContent,
        ]);

        $response->assertRedirect(route('pastes.show', $paste));

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

        $response = $this->actingAs($user)->put(route('pastes.update', $paste), [
            'title' => $newTitle,
            'content' => $newContent,
        ]);

        $response->assertForbidden();
    }

}
