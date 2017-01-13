<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $domains = Domain::orderBy('name')->get();

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

        if ($domain === null) {
            return App::abort(404);
        }

        if (!$request->has('confirm-destroy')) {
            return view('domain.show', ['domain' => $domain])->withErrors(
                ['You must confirm this action']
            );
        }

        $domain->delete();

        return redirect(route('domain.index'));
    }
}

