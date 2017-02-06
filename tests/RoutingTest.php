<?php

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
        $this->assertResponseOk($this->call('GET', route('legal.tos')));
    }

    public function testDashboard()
    {
        $this->assertRedirectedToRoute('login', [], [], 
            $this->call('GET', route('dashboard'))
        );
    }

    public function testDashboardAsUser()
    {
        $this->assertResponseOk(
            $this
                ->actingAs(User::findByAddressOrFail('user@test.test'))
                ->call('GET', route('dashboard'))
        );
    }
}
