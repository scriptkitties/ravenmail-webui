<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Domain;
use App\User;

/**
 * Test authorization checks for the domain creation form.
 */
class DomainAuthorizationCreateTest extends TestCase
{
    use DatabaseTransactions;

    public function testAsGuest()
    {
        $response = $this->get(route('domain.create'));

        $response->assertRedirect(route('login'));
    }

    public function testAsUser()
    {
        $user = User::findByAddressOrFail('user@test.test');
        $response = $this->actingAs($user)->get(route('domain.create'));

        $response->assertStatus(403);
    }

    public function testAsModerator()
    {
        $user = User::findByAddressOrFail('mod@test.test');
        $response = $this->actingAs($user)->get(route('domain.create'));

        $response->assertStatus(403);
    }

    public function testAsAdmin()
    {
        $user = User::findByAddressOrFail('admin@test.test');
        $response = $this->actingAs($user)->get(route('domain.create'));

        $response->assertStatus(403);
    }

    public function testAsRoot()
    {
        $user = User::findByAddressOrFail('test@test.test');
        $response = $this->actingAs($user)->get(route('domain.create'));

        $response->assertStatus(200);
    }
}
