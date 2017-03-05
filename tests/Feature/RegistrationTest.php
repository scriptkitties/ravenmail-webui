<?php

namespace Tests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Domain;
use App\NoregLocal;

class RegistrationTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->domain = Domain::findByNameOrFail('test.test')->uuid;
    }

    public function testIncorrectLocal()
    {
        $locals = [
            'A@b@c', // only one @ is allowed outside quotation marks
            'a"b(c)d,e:f;g<h>i[j\k]l', // none of the special characters are allowed outside quotation marks
            'just"not"right', // quoted strings must be dot separated or the only element making up the local-part
            'this is"not\allowed', // spaces, quotes, and backslashes must be contained in quotes
            'this\ still\"not\\allowed', // spaces, quotes, and backslashes must be contained in quotes
            '1234567890123456789012345678901234567890123456789012345678901234+x', // too long
            'john..doe', // double dot before @
        ];

        foreach ($locals as $local) {
            $response = $this->post(route('user.store'), [
                    'local' => $local,
                    'domain' => $this->domain,
                    'password' => 'test',
                    'password-verify' => 'test',
                    'accept-tos' => true,
            ]);

            $response->assertRedirect(route('user.create'));
        }
    }

    public function testNoregLocal()
    {
        $local = NoregLocal::first()->local;
        $response = $this->post(route('user.store'), [
            'local' => $local,
            'domain' => $this->domain,
            'password' => 'test',
            'password-verify' => 'test',
            'accept-tos' => true,
        ]);

        $response->assertRedirect(route('user.create'));
        $response->assertSessionHasErrors(['local']);
    }

    public function testPrivateDomain()
    {
        $domain = Domain::findByNameOrFail('private.test.test')->uuid;
        $response = $this->post(route('user.store'), [
            'local' => 'this.surely.wont.exist.in.the.tests',
            'domain' => $domain,
            'password' => 'test',
            'password-verify' => 'test',
            'accept-tos' => true,
        ]);

        $response->assertRedirect(route('user.create'));
        $response->assertSessionHasErrors(['domain']);
    }

    public function testShowFormAsGuest()
    {
        $response = $this->get(route('user.create'));

        $response->assertStatus(200);
    }

    public function testShowFormAsUser()
    {
        $user = User::findByAddressOrFail('user@test.test');
        $response = $this->actingAs($user)->get(route('user.create'));

        $response->assertRedirect(route('dashboard'));
    }

    /**
     * Tests that fail with PHP's filter_var have been disabled.
     */
    public function testSuccess()
    {
        $locals = [
            'prettyandsimple',
            'very.common',
            'other.email-with-dash',
            'x',
            // '"much.more unusual"',
            '"very.unusual.@.unusual.com"',
            '"very.(),:;<>[]\".VERY.\"very@\\ \"very\".unusual"',
            'example-indeed',
            '#!$%&\'*+-/=?^_`{}|~',
            // '"()<>[]:,;@\\\"!#$%&\'-/=?^_`{}| ~.a"',
            // '" "',
        ];

        foreach ($locals as $local) {
            $response = $this->post(route('user.store'), [
                'local' => $local,
                'domain' => $this->domain,
                'password' => 'test',
                'password-verify' => 'test',
                'accept-tos' => true,
            ]);

            $response->assertRedirect(route('login'));
        }
    }

    public function testUncheckedTos()
    {
        $response = $this->post(route('user.store'), [
            'local' => 'this.surely.wont.exist.in.the.tests',
            'domain' => $this->domain,
            'password' => 'test',
            'password-verify' => 'test',
        ]);

        $response->assertRedirect(route('user.create'));
        $response->assertSessionHasErrors(['accept-tos']);
    }

    public function testUnknownDomain()
    {
        $response = $this->post(route('user.store'), [
            'local' => 'this.surely.wont.exist.in.the.tests',
            'domain' => 'not.in.the.tests.org',
            'password' => 'test',
            'password-verify' => 'test',
            'accept-tos' => true,
        ]);

        $response->assertRedirect(route('user.create'));
        $response->assertSessionHasErrors(['domain']);
    }

    public function testUnmatchedPassword()
    {
        $response = $this->post(route('user.store'), [
            'local' => 'this.surely.wont.exist.in.the.tests',
            'domain' => $this->domain,
            'password' => 'test',
            'password-verify' => 'not test',
            'accept-tos' => true,
        ]);

        $response->assertRedirect(route('user.create'));
        $response->assertSessionHasErrors(['password-verify']);
    }
}
