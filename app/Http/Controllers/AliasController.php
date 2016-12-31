<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Domain;
use App\Alias;

class AliasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(string $name)
    {
        $aliases = Alias::where('domain', $name)
            ->get()
        ;

        return view('alias.index', [
            'domain' => $name,
            'aliases' => $aliases
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(string $name)
    {
        return view('alias.create', [
            'domain' => $name
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, string $name)
    {
        $domain = Domain::findByNameOrFail($name);

        $alias = new Alias();
        $alias->domain = $domain->name;
        $alias->local = $request->input('local');
        $alias->destination = $request->input('destination');
        $alias->save();

        return redirect()->route('domains.show', [
            'domain' => $domain->name
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $domain, string $address)
    {
        $alias = Alias::findByAddressOrFail($address);
        $alias->delete();

        return redirect()->route('aliases.index', [
            'domain' => $domain
        ]);
    }
}
