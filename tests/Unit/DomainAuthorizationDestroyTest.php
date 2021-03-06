<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Domain;
use App\User;

/**
 * Test authorization checks for deleting a domain.
 */
class DomainAuthorizationDestroyTest extends TestCase
{
    use DatabaseTransactions;

    public function testAsGuestRegularDomain()
    {
        $domain = Domain::where('name', '<>', 'test.test')->first()->name;
        $response = $this->delete(route('domain.destroy', [
            'domain' => $domain,
        ]), [
            'confirm-destroy' => true,
        ]);

        $response->assertRedirect(route('login'));
    }

    public function testAsUserRegularDomain()
    {
        $domain = Domain::where('name', '<>', 'test.test')->first()->name;
        $user = User::findByAddressOrFail('user@test.test');
        $response = $this->actingAs($user)->delete(route('domain.destroy', [
            'domain' => $domain,
        ]), [
            'confirm-destroy' => true,
        ]);

        $response->assertStatus(403);
    }

    public function testAsModeratorRegularDomain()
    {
        $domain = Domain::where('name', '<>', 'test.test')->first()->name;
        $user = User::findByAddressOrFail('mod@test.test');
        $response = $this->actingAs($user)->delete(route('domain.destroy', [
            'domain' => $domain,
        ]), [
            'confirm-destroy' => true,
        ]);

        $response->assertStatus(403);
    }

    public function testAsAdminRegularDomain()
    {
        $domain = Domain::where('name', '<>', 'test.test')->first()->name;
        $user = User::findByAddressOrFail('admin@test.test');
        $response = $this->actingAs($user)->delete(route('domain.destroy', [
            'domain' => $domain,
        ]), [
            'confirm-destroy' => true,
        ]);

        $response->assertStatus(403);
    }

    public function testAsRootRegularDomain()
    {
        $domain = Domain::where('name', '<>', 'test.test')->first()->name;
        $user = User::findByAddressOrFail('test@test.test');
        $response = $this->actingAs($user)->delete(route('domain.destroy', [
            'domain' => $domain,
        ]), [
            'confirm-destroy' => true,
        ]);

        $response->assertStatus(302);
    }

    public function testAsModeratorModeratingDomain()
    {
        $domain = Domain::findByNameOrFail('test.test')->name;
        $user = User::findByAddressOrFail('mod@test.test');
        $response = $this->actingAs($user)->delete(route('domain.destroy', [
            'domain' => $domain,
        ]), [
            'confirm-destroy' => true,
        ]);

        $response->assertStatus(403);
    }

    public function testAsAdminModeratingDomain()
    {
        $domain = Domain::findByNameOrFail('test.test')->name;
        $user = User::findByAddressOrFail('admin@test.test');
        $response = $this->actingAs($user)->delete(route('domain.destroy', [
            'domain' => $domain,
        ]), [
            'confirm-destroy' => true,
        ]);

        $response->assertStatus(403);
    }

    public function testAsRootModeratingDomain()
    {
        $domain = Domain::findByNameOrFail('test.test')->name;
        $user = User::findByAddressOrFail('test@test.test');
        $response = $this->actingAs($user)->delete(route('domain.destroy', [
            'domain' => $domain,
        ]), [
            'confirm-destroy' => true,
        ]);

        $response->assertStatus(302);
    }
}
