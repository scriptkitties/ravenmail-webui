<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

/**
 * This is intended to test all stand-alone routes.
 */
class RoutingTest extends TestCase
{
    use DatabaseTransactions;

    public function testLegalTos()
    {
        $response = $this->get(route('legal.tos'));

        $response->assertStatus(200);
    }

    public function testDashboardAsGuest()
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function testDashboardAsUser()
    {
        $user = User::findByAddressOrFail('user@test.test');
        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
    }
}
