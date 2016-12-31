<?php

namespace App\Http\Controllers;

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
    public function index($name)
    {
        $domain = Domain::where('name', $name)->firstOrFail();

        return view('user.index', [
            'domain' => $domain
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function create($name)
    {
        $domain = Domain::where('name', $name)->firstOrFail();

        return view('user.create', [
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
    public function store($name, Request $request)
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
     * @param  string  $domain_name
     * @param  string  $local
     * @return \Illuminate\Http\Response
     */
    public function show($domain_name, $address)
    {
        $user = User::findByAddressOrFail($address);

        return view ('user.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $name
     * @param  string  $address
     * @return \Illuminate\Http\Response
     */
    public function edit($name, $address)
    {
        $user = User::findByAddressOrFail($address);

        return view('user.edit', [
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
    public function update(Request $request, $domain, $address)
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

        return redirect()->route('users.show', [
            'domain' => $domain,
            'user' => $address
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
