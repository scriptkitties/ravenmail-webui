<?php

namespace App\Http\Controllers;

use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

use App\Http\Requests;
use App\Domain;
use App\User;

class UserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $domains = Domain::where('public', true)->get();

        if (count($domains) < 1) {
            return view('user.closed');
        }

        return view('user.create', [
            'domains' => $domains
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
        // apply basic form validation
        $validator = Validator::make($request->all(), [
            'local' => 'required|max:64', // todo: disallow leading and trailing dot
            'domain' => 'required|exists:domains,name',
            'password' => 'required',
            'password-verify' => 'required|same:password',
            'accept-tos' => 'required',
            'captcha' => 'required|captcha'
        ]);

        $domain = Domain::findByNameOrFail($request->input('domain'));

        // disallow non-public domains
        if (!$domain->public) {
            $validator->errors()->add('domain', trans('validation.not_in', [
                'attribute' => 'domain'
            ]));
        }

        // dont allow addresses considered unregisterable
        if (!User::isRegisterable($request->input('local'), $request->input('domain'))) {
            $validator->errors()->add('local', trans('user.dupe'));
        }

        // disallow illegal addresses
        try {
            if (!User::isValidLocal($request->input('local'))) {
                $validator->errors()->add('local', trans('user.illegal'));
            }
        } catch (Exception $e) {
            $validator->errors()->add('application', trans('user.regex_error'));
        }

        // check if any errors occurred
        if ($validator->errors()->any()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
            ;
        }

        // create the new user
        $user = new User();
        $user->local = $request->input('local');
        $user->domain = $request->input('domain');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        // flash a success message
        $request->session()->flash('success', trans('user.success', [
            'account' => $user->getAddress()
        ]));

        // return to the login page
        return redirect()->route('login');
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
     * @return \Illuminate\Http\Response
     */
    public function edit(string $address)
    {
        if (Auth::user()->getAddress() !== $address) {
            App::abort(404);
        }

        return view('user.edit', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (Auth::user()->getAddress() !== $address) {
            App::abort(404);
        }

        $this->validate($request, [
            'password' => 'required',
            'password-verify' => 'required|same:password'
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // NYI
    }
}
