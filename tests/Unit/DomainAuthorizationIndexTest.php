<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Domain;
use App\User;

class DomainAuthorizationIndexTest extends TestCase
{
    use DatabaseTransactions;

    public function testAsGuest()
    {
        $response = $this->get(route('domain.index'));

        $response->assertRedirect(route('login'));
    }

    public function testAsUser()
    {
        $user = User::findByAddressOrFail('user@test.test');
        $response = $this->actingAs($user)->get(route('domain.index'));

        $response->assertStatus(403);
    }

    public function testAsModerator()
    {
        $user = User::findByAddressOrFail('mod@test.test');
        $response = $this->actingAs($user)->get(route('domain.index'));

        $response->assertStatus(200);
    }

    public function testAsAdmin()
    {
        $user = User::findByAddressOrFail('admin@test.test');
        $response = $this->actingAs($user)->get(route('domain.index'));

        $response->assertStatus(200);
    }

    public function testAsRoot()
    {
        $user = User::findByAddressOrFail('test@test.test');
        $response = $this->actingAs($user)->get(route('domain.index'));

        $response->assertStatus(200);
    }
}
