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

    public function testCanListUserPastes()
    {
        $user = User::factory()->create();

        $pastes = Paste::factory()->for($user)->count(10)->create();

        $response = $this->actingAs($user)->get(route('pastes.index'));
        $response->assertSuccessful();

        /** @var Paste $paste */
        foreach ($pastes as $paste) {
            $response->assertSeeText($paste->title);
            $response->assertSee(route('pastes.destroy', $paste->not_listed_id));
        }
    }
    public function testCanListPublicPastes()
    {
        /**
         * todo: this test
         */
    }

    public function testCannotListOtherUserPastes()
    {
        /**
         * todo: this test
         */
    }

    public function testCanSeeCreateNew()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('pastes.index'));
        $response->assertSuccessful();
        $response->assertSee(route('pastes.create'));
    }

}
