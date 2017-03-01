<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Domain;
use App\User;

/**
 * Test authorization checks for submitting the domain creation form.
 */
class DomainAuthorizationStoreTest extends TestCase
{
    use DatabaseTransactions;

    public function testAsGuest()
    {
        $response = $this->post(route('domain.store'), [
            'domain' => 'test.tld',
            'contact' => 'test@test.test',
        ]);

        $response->assertRedirect(route('login'));
    }

    public function testAsUser()
    {
        $user = User::findByAddressOrFail('user@test.test');
        $response = $this->actingAs($user)->post(route('domain.store'), [
            'domain' => 'test.tld',
            'contact' => 'test@test.test',
        ]);

        $response->assertStatus(403);
    }

    public function testAsModerator()
    {
        $user = User::findByAddressOrFail('mod@test.test');
        $response = $this->actingAs($user)->post(route('domain.store'), [
            'domain' => 'test.tld',
            'contact' => 'test@test.test',
        ]);

        $response->assertStatus(403);
    }

    public function testAsAdmin()
    {
        $user = User::findByAddressOrFail('admin@test.test');
        $response = $this->actingAs($user)->post(route('domain.store'), [
            'domain' => 'test.tld',
            'contact' => 'test@test.test',
        ]);

        $response->assertStatus(403);
    }

    public function testAsRoot()
    {
        $user = User::findByAddressOrFail('test@test.test');
        $response = $this->actingAs($user)->post(route('domain.store'), [
            'domain' => 'test.tld',
            'contact' => 'test@test.test',
        ]);

        $response->assertStatus(302);
    }
}
