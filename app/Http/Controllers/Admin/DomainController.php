<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App;
use App\Domain;
use App\Http\Requests;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->admin) {
           $domains = Domain::orderBy('name')->get();
        } else {
            $domains = $user->domainsModerating()->orderBy('name')->get();

            // someone who's not moderating any domains has no right to be here
            if ($domains->count() < 1) {
                App::abort(403);
            }
        }

        return view('domain.index', [
            'domains' => $domains
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Domain::class);

        return view('domain.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Domain::class);

        $this->validate($request, [
            'domain' => 'required|min:2|max:255',
            'contact' => 'required|max:256',
        ]);

        $name = $request->input('domain');
        $count = Domain::where('name', $name)->count();

        if ($count > 0) {
            // TODO: show this error somehow
            return redirect(route('domain.index'))->withErrors(
                ['Domain already exists']
            );
        }

        $domain = new Domain();
        $domain->name = $request->input('domain');
        $domain->contact = $request->input('contact');
        $domain->public = $request->has('public');
        $domain->save();

        return redirect(route('domain.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        $domain = Domain::where('name', $name)->first();
        $this->authorize('view', $domain);

        if ($domain === null) {
            return App::abort(404);
        }

        return view('domain.show', [
            'domain' => $domain
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function edit($name)
    {
        $domain = Domain::where('name', $name)->first();
        $this->authorize('update', $domain);

        if ($domain === null) {
            return App::abort(404);
        }

        return view('domain.edit', [
            'domain' => $domain
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $name)
    {
        $domain = Domain::where('name', $name)->first();
        $this->authorize('update', $domain);

        if ($domain === null) {
            return App::abort(404);
        }

        $domain->public = $request->has('public');
        $domain->save();

        return redirect(route('domain.show', ['name' => $domain->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $name)
    {
        $domain = Domain::where('name', $name)->first();
        $this->authorize('delete', $domain);

        if ($domain === null) {
            return App::abort(404);
        }

        if (!$request->has('confirm-destroy')) {
            return view('domain.show', ['domain' => $domain])->withErrors(
                ['You must confirm this action']
            );
        }

        foreach ($domain->aliases as $alias) {
            $alias->delete();
        }

        foreach ($domain->noreg_addresses as $noreg) {
            $noreg->delete();
        }

        foreach ($domain->users as $user) {
            $user->delete();
        }

        $domain->delete();

        return redirect(route('domain.index'));
    }
}

