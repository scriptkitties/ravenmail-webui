<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class AuthenticationTest extends TestCase
{
    use DatabaseTransactions;

    public function testLoginCorrect()
    {
        $this->assertRedirectedToRoute('dashboard', [], [], $this->call('POST', route('login.post'), [
            'email' => 'test@test.test',
            'password' => 'test',
        ]));

        // TODO: make sure user is authenticated at this point
    }

    public function testLoginIncorrect()
    {
        $this->assertRedirectedToRoute('login', [], [], $this->call('POST', route('login.post'), [
            'email' => 'test@test.test',
            'password' => 'wrong test',
        ]));

        // TODO: make sure the user is still not authenticated at this point
    }

    public function testLoginIncorrectMessage()
    {
        // TODO: make sure the error message appears correctly
    }

    public function testLoginFormAsGuest()
    {
        $this->assertResponseOk($this->call('GET', route('login')));
    }

    public function testLoginFormAsUser()
    {
        $this->assertRedirectedToRoute('dashboard', [], [],
            $this
                ->actingAs(User::findByAddressOrFail('user@test.test'))
                ->call('GET', route('login'))
        );
    }

    public function testLogoutAsGuest()
    {
        $this->assertRedirectedToRoute('login', [], [],
            $this->call('GET', route('logout'))
        );
    }

    public function testLogoutAsUser()
    {
        $this->assertRedirectedToRoute('login', [], [],
            $this
                ->actingAs(User::findByAddressOrFail('user@test.test'))
                ->call('GET', route('logout'))
        );

        // TODO: make sure user is no longer authenticated out at this point
    }
}
