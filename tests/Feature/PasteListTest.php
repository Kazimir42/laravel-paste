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

    public function testCannotListPastesIfNotLoggedIn()
    {
        $response = $this->get(route('pastes.index'));
        $response->assertRedirect(route('login'));
    }

    public function testCanListPastes()
    {
        $user = User::factory()->create();

        $pastes = Paste::factory()->for($user)->count(15)->create();

        $response = $this->actingAs($user)->get(route('pastes.index'));
        $response->assertSuccessful();

        /** @var Paste $paste */
        foreach ($pastes as $paste) {
            $response->assertSeeText($paste->title);
            $response->assertSee(route('pastes.destroy', $paste));
        }
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
