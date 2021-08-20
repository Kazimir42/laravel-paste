<?php

namespace Tests\Feature;

use App\Models\Paste;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PasteListTest extends TestCase
{
    use RefreshDatabase;

    public function testCannotListPastesInIndexIfNotLoggedIn()
    {
        $response = $this->get(route('pastes.index'));
        $response->assertRedirect(route('pastes.public'));
    }

    public function testCanListPastesInIndexIfLogged()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('pastes.index'));
        $response->assertSuccessful();
    }

    public function testCanListPastesInPublicIfNotLogged()
    {
        $response = $this->get(route('pastes.public'));
        $response->assertSuccessful();
    }

    public function testCanListPastesInPublicIfLogged()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('pastes.public'));
        $response->assertSuccessful();
    }

    public function testCanListUserPublicPastesInIndexIfLogged()
    {
        $user = User::factory()->create();

        $pastes = Paste::factory()->for($user)->count(10)->create([
            'status' => 'public'
        ]);

        $response = $this->actingAs($user)->get(route('pastes.index'));
        $response->assertSuccessful();

        /** @var Paste $paste */
        foreach ($pastes as $paste) {
            $response->assertSeeText($paste->title);
            $response->assertSee(route('pastes.destroy', $paste->not_listed_id));
        }
    }

    public function testCanListUserPrivatePastesInIndexIfLogged()
    {
        $user = User::factory()->create();

        $pastes = Paste::factory()->for($user)->count(10)->create([
            'status' => 'private'
        ]);

        $response = $this->actingAs($user)->get(route('pastes.index'));
        $response->assertSuccessful();

        /** @var Paste $paste */
        foreach ($pastes as $paste) {
            $response->assertSeeText($paste->title);
            $response->assertSee(route('pastes.destroy', $paste->not_listed_id));
        }
    }

    public function testCanListUserNotListedPastesInIndexIfLogged()
    {
        $user = User::factory()->create();

        $pastes = Paste::factory()->for($user)->count(10)->create([
            'status' => 'not_listed'
        ]);

        $response = $this->actingAs($user)->get(route('pastes.index'));
        $response->assertSuccessful();

        /** @var Paste $paste */
        foreach ($pastes as $paste) {
            $response->assertSeeText($paste->title);
            $response->assertSee(route('pastes.destroy', $paste->not_listed_id));
        }
    }


    public function testCanListPublicPastesInPublic()
    {
        $user = User::factory()->create();

        $pastes = Paste::factory()->for($user)->count(10)->create();

        $response = $this->get(route('pastes.public'));
        $response->assertSuccessful();

        /** @var Paste $paste */
        foreach ($pastes as $paste) {
            $response->assertSeeText($paste->title);
            $response->assertSee(route('pastes.show', $paste->not_listed_id));
        }
    }

    public function testCannotListPrivatePasteInPublic()
    {
        $user = User::factory()->create();

        $pastes = Paste::factory()->for($user)->count(10)->create([
            'status' => 'private'
        ]);

        $response = $this->get(route('pastes.public'));
        $response->assertSuccessful();

        /** @var Paste $paste */
        foreach ($pastes as $paste) {
            $response->assertSeeText(!$paste->title);
            $response->assertSee(!route('pastes.show', $paste->not_listed_id));
        }
    }

    public function testCannotListNotListedPasteInPublic()
    {
        $user = User::factory()->create();

        $pastes = Paste::factory()->for($user)->count(10)->create([
            'status' => 'not_listed',
        ]);

        $response = $this->get(route('pastes.public'));
        $response->assertSuccessful();

        /** @var Paste $paste */
        foreach ($pastes as $paste) {
            $response->assertSeeText(!$paste->title);
            $response->assertSee(!route('pastes.show', $paste->not_listed_id));
        }
    }

    public function testCanSeeCreateNewInIndex()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('pastes.index'));
        $response->assertSuccessful();
        $response->assertSee(route('pastes.create'));
    }

    public function testCanSeeCreateNewInPublic()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('pastes.public'));
        $response->assertSuccessful();
        $response->assertSee(route('pastes.create'));
    }

}
