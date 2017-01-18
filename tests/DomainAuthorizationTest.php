<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Domain;
use App\User;

class DomainAuthorizationTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->root = User::findByAddressOrFail('test@test.test');
        $this->admin = User::findByAddressOrFail('admin@test.test');
        $this->mod = User::findByAddressOrFail('mod@test.test');
        $this->user = User::findByAddressOrFail('user@test.test');

        $this->domainModerating = Domain::findByNameOrFail('test.test')->name;
        $this->domainRegular = Domain::where('name', '<>', 'test.test')->first()->name;
    }

    public function testIndex()
    {
        $route = route('domain.index');

        $this->assertRedirectedToRoute('login', [], [], $this->call('GET', $route));
        $this->assertResponseStatus(403, $this->actingAs($this->user)->call('GET', $route));
        $this->assertResponseStatus(200, $this->actingAs($this->mod)->call('GET', $route));
        $this->assertResponseStatus(200, $this->actingAs($this->admin)->call('GET', $route));
        $this->assertResponseOk(200, $this->actingAs($this->root)->call('GET', $route));
    }

    public function testShowModerating()
    {
        $route = route('domain.show', ['domain' => $this->domainModerating]);

        $this->assertRedirectedToRoute('login', [], [], $this->call('GET', $route));
        $this->assertResponseStatus(403, $this->actingAs($this->user)->call('GET', $route));
        $this->assertResponseStatus(200, $this->actingAs($this->mod)->call('GET', $route));
        $this->assertResponseStatus(200, $this->actingAs($this->admin)->call('GET', $route));
        $this->assertResponseOk(200, $this->actingAs($this->root)->call('GET', $route));
    }

    public function testShowNotModerating()
    {
        $route = route('domain.show', ['domain' => $this->domainRegular]);

        $this->assertRedirectedToRoute('login', [], [], $this->call('GET', $route));
        $this->assertResponseStatus(403, $this->actingAs($this->user)->call('GET', $route));
        $this->assertResponseStatus(403, $this->actingAs($this->mod)->call('GET', $route));
        $this->assertResponseStatus(403, $this->actingAs($this->admin)->call('GET', $route));
        $this->assertResponseOk(200, $this->actingAs($this->root)->call('GET', $route));
    }

    public function testCreate()
    {
        $route = route('domain.create');

        $this->assertRedirectedToRoute('login', [], [], $this->call('GET', $route));
        $this->assertResponseStatus(403, $this->actingAs($this->user)->call('GET', $route));
        $this->assertResponseStatus(403, $this->actingAs($this->mod)->call('GET', $route));
        $this->assertResponseStatus(403, $this->actingAs($this->admin)->call('GET', $route));
        $this->assertResponseOk(200, $this->actingAs($this->root)->call('GET', $route));
    }

    public function testStore()
    {
        $route = route('domain.store');
        $input = [
            'domain' => 'test.tld',
            'contact' => 'test@test.test',
        ];

        $this->assertRedirectedToRoute('login', [], [], $this->call('POST', $route, $input));
        $this->assertResponseStatus(403, $this->actingAs($this->user)->call('POST', $route, $input));
        $this->assertResponseStatus(403, $this->actingAs($this->mod)->call('POST', $route, $input));
        $this->assertResponseStatus(403, $this->actingAs($this->admin)->call('POST', $route, $input));
        $this->assertResponseStatus(302, $this->actingAs($this->root)->call('POST', $route, $input));
    }

    public function testEditModerating()
    {
        $route = route('domain.edit', ['domain' => $this->domainModerating]);

        $this->assertRedirectedToRoute('login', [], [], $this->call('GET', $route));
        $this->assertResponseStatus(403, $this->actingAs($this->user)->call('GET', $route));
        $this->assertResponseStatus(403, $this->actingAs($this->mod)->call('GET', $route));
        $this->assertResponseStatus(200, $this->actingAs($this->admin)->call('GET', $route));
        $this->assertResponseOk(200, $this->actingAs($this->root)->call('GET', $route));
    }

    public function testEditNotModerating()
    {
        $route = route('domain.edit', ['domain' => $this->domainRegular]);

        $this->assertRedirectedToRoute('login', [], [], $this->call('GET', $route));
        $this->assertResponseStatus(302, $this->call('GET', $route));
        $this->assertResponseStatus(403, $this->actingAs($this->user)->call('GET', $route));
        $this->assertResponseStatus(403, $this->actingAs($this->mod)->call('GET', $route));
        $this->assertResponseStatus(403, $this->actingAs($this->admin)->call('GET', $route));
        $this->assertResponseOk($this->actingAs($this->root)->call('GET', $route));
    }

    public function testUpdateModerating()
    {
        $route = route('domain.update', ['domain' => $this->domainModerating]);
        $input = [
            'public' => true
        ];

        $this->assertRedirectedToRoute('login', [], [], $this->call('PUT', $route, $input));
        $this->assertResponseStatus(403, $this->actingAs($this->user)->call('PUT', $route, $input));
        $this->assertResponseStatus(403, $this->actingAs($this->mod)->call('PUT', $route, $input));
        $this->assertResponseStatus(302, $this->actingAs($this->admin)->call('PUT', $route, $input));
        $this->assertResponseStatus(302, $this->actingAs($this->root)->call('PUT', $route, $input));
    }

    public function testUpdateNotModerating()
    {
        $route = route('domain.update', ['domain' => $this->domainRegular]);

        $this->assertRedirectedToRoute('login', [], [], $this->call('PUT', $route));
        $this->assertResponseStatus(403, $this->actingAs($this->user)->call('PUT', $route));
        $this->assertResponseStatus(403, $this->actingAs($this->mod)->call('PUT', $route));
        $this->assertResponseStatus(403, $this->actingAs($this->admin)->call('PUT', $route));
        $this->assertResponseStatus(302, $this->actingAs($this->root)->call('PUT', $route));
    }

    public function testDestroyModerating()
    {
        $route = route('domain.destroy', ['domain' => $this->domainModerating]);
        $input = [
            'confirm-destroy' => true,
        ];

        $this->assertRedirectedToRoute('login', [], [], $this->call('DELETE', $route, $input));
        $this->assertResponseStatus(403, $this->actingAs($this->user)->call('DELETE', $route, $input));
        $this->assertResponseStatus(403, $this->actingAs($this->mod)->call('DELETE', $route, $input));
        $this->assertResponseStatus(403, $this->actingAs($this->admin)->call('DELETE', $route, $input));
        $this->assertResponseStatus(302, $this->actingAs($this->root)->call('DELETE', $route, $input));
    }

    public function testDestroyNotModerating()
    {
        $route = route('domain.destroy', ['domain' => $this->domainRegular]);
        $input = [
            'confirm-destroy' => true,
        ];

        $this->assertRedirectedToRoute('login', [], [], $this->call('DELETE', $route, $input));
        $this->assertResponseStatus(403, $this->actingAs($this->user)->call('DELETE', $route, $input));
        $this->assertResponseStatus(403, $this->actingAs($this->mod)->call('DELETE', $route, $input));
        $this->assertResponseStatus(403, $this->actingAs($this->admin)->call('DELETE', $route, $input));
        $this->assertResponseStatus(302, $this->actingAs($this->root)->call('DELETE', $route, $input));
    }
}
