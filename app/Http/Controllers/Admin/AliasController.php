<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Alias;
use App\Domain;
use App\Http\Requests;
use App\NoregAddress;

class AliasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(string $domainName)
    {
        $aliases = Alias::where('domain', $domainName)
            ->get()
        ;

        return view('domain.alias.index', [
            'domain' => $domainName,
            'aliases' => $aliases
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(string $domainName)
    {
        return view('domain.alias.create', [
            'domain' => $domainName
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, string $domainName)
    {
        // apply basic form validation
        $this->validate($request, [
            'local' => 'required|max:64',
            'destination' => 'required|min:2|max:255|email'
        ]);

        $domain = Domain::findByNameOrFail($domainName);

        $alias = new Alias();
        $alias->domain = $domain->name;
        $alias->local = $request->input('local');
        $alias->destination = $request->input('destination');
        $alias->save();

        if ($request->has('create-noreg') && $request->input('create-noreg')) {
            $count = NoregAddress::where('local', $request->input('local'))
                ->where('domain', $domain->name)
                ->count()
            ;

            // avoid duplicate noreg entries
            if ($count < 1) {
                $noreg = new NoregAddress();
                $noreg->local = $request->input('local');
                $noreg->domain = $domain->name;
                $noreg->save();
            }
        }

        return redirect()->route('domain.alias.index', [
            'domain' => $domain->name
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $domainName, string $address)
    {
        $alias = Alias::findByAddressOrFail($address);
        $alias->delete();

        return redirect()->route('domain.alias.index', [
            'domain' => $domainName
        ]);
    }
}
