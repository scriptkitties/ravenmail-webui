<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class AuthenticationTest extends TestCase
{
    use DatabaseTransactions;

    public function testLoginCorrect()
    {
        $response = $this->post(route('login.post'), [
            'email' => 'test@test.test',
            'password' => 'test',
        ]);

        $response->assertRedirect(route('dashboard'));

        //$this->assertRedirectedToRoute('dashboard', [], [], $this->call('POST', route('login.post'), [

        // TODO: make sure user is authenticated at this point
    }

    public function testLoginIncorrect()
    {
        $response = $this->post(route('login.post'), [
            'email' => 'test@test.test',
            'password' => 'wrong test',
        ]);

        $response->assertRedirect(route('login'));

        // TODO: make sure the user is still not authenticated at this point
    }

    public function testLoginIncorrectMessage()
    {
        // TODO: make sure the error message appears correctly
    }

    public function testLoginFormAsGuest()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
    }

    public function testLoginFormAsUser()
    {
        $user = User::findByAddressOrFail('user@test.test');
        $response = $this->actingAs($user)->get(route('login'));

        $response->assertRedirect(route('dashboard'));
    }

    public function testLogoutAsGuest()
    {
        $response = $this->get(route('logout'));

        $response->assertRedirect(route('login'));
    }

    public function testLogoutAsUser()
    {
        $user = User::findByAddressOrFail('user@test.test');
        $response = $this->actingAs($user)->get(route('logout'));

        $response->assertRedirect(route('login'));

        // TODO: make sure user is no longer authenticated out at this point
    }
}
