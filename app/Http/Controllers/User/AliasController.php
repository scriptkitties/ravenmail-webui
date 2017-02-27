<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Validator;

use App\Alias;
use App\Mail\VerifyAlias;
use App\Verification;

class AliasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aliases = Auth::user()->aliases();

        return view('user.alias.index', [
            'aliases' => $aliases,
            'max' => config('ravenmail.user.alias.max'),
            'user' => Auth::user()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.alias.create', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'destination' => 'required|email'
        ]);

        if (!$user->admin && $user->aliases()->count() > config('ravenmail.user.alias.max')) {
            $validator->errors()->add('destination', trans('user.alias_max'));
        }

        // check if any errors occurred
        if ($validator->errors()->any()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
            ;
        }

        // create a verification
        $verification = Verification::generate();

        // create the alias
        $alias = new Alias();
        $alias->local = $user->local;
        $alias->domain = $user->domain;
        $alias->destination = $request->input('destination');
        $alias->active = false;
        $alias->verification = $verification->uuid;
        $alias->save();

        // send an email to verify the alias
        Mail::to($alias->getAddress())->send(new VerifyAlias($user, $alias, $verification));

        return redirect()
            ->route('user.alias.index', [
                'user' => $user->getAddress()
            ])
            ->with('success', trans('user.alias.success'))
        ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $user, string $aliasUuid)
    {
        if ($user !== Auth::user()->getAddress()) {
            return App::abort(404);
        }

        $alias = Alias::findOrFail($aliasUuid);
        Alias::destroy($alias->uuid);

        return redirect()->route('user.alias.index', [
            'user' => Auth::user()->getAddress()
        ]);
    }
}
