<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Domain;
use App\User;
use App\Http\Requests;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  string $name
     * @return \Illuminate\Http\Response
     */
    public function index(string $name)
    {
        $domain = Domain::where('name', $name)->firstOrFail();

        return view('domain.user.index', [
            'domain' => $domain
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function create(string $name)
    {
        $domain = Domain::where('name', $name)->firstOrFail();

        return view('domain.user.create', [
            'domain' => $domain
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  string  name
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(string $name, Request $request)
    {
        // TODO: form validation

        $domain = Domain::where('name', $name)->firstOrFail();
        $user = new User();
        $user->local = $request->input('local');
        $user->domain = $domain->name;
        $user->password = Hash::make($request->input('password'));
        $user->admin = $request->has('admin');
        $user->active = $request->has('active');
        $user->remember_token = '';
        $user->save();

        // TODO: add a success message
        return view('domain.show', ['domain' => $domain]);
    }

    /**
     * Display the specified resource.
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     *
     * @param  string  $domain_name
     * @param  string  $local
     * @return \Illuminate\Http\Response
     */
    public function show(string $domainName, string $address)
    {
        $user = User::findByAddressOrFail($address);

        return view ('domain.user.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     *
     * @param  string  $name
     * @param  string  $address
     * @return \Illuminate\Http\Response
     */
    public function edit(string $domainName, string $address)
    {
        $user = User::findByAddressOrFail($address);

        return view('domain.user.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $domainName, string $address)
    {
        $user = User::findByAddressOrFail($address);

        // update account details
        if ($request->input('password', '') !== '') {
            $user->password = Hash::make($request->input('password'));
        }

        // update privileges
        $user->admin = $request->input('admin', false);
        $user->active = $request->input('active', false);

        // save the updated user
        $user->save();

        return redirect()->route('domain.users.show', [
            'domain' => $domainName,
            'user' => $address
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, string $domainName, string $address)
    {
        $this->validate($request, [
            'confirm-destroy' => 'required'
        ]);

        $user = User::findByAddressOrFail($address);
        $user->delete();

        return redirect()->route('domain.users.index', [
            'domain' => $user->domain
        ]);
    }
}
