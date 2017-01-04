<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

use App\Http\Requests;
use App\Domain;
use App\User;

class RegistrationController extends Controller
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
            return view('registration.closed');
        }

        return view('registration.form', [
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
            'local' => 'required|max:64',
            'domain' => 'required|exists:domains,name',
            'password' => 'required',
            'password-verify' => 'required|same:password',
            'accept-tos' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
            ;
        }

        $domain = Domain::findByNameOrFail($request->input('domain'));

        // disallow non-public domains
        if (!$domain->public) {
            $validator->errors()->add('domain', trans('validation.not_in', [
                'attribute' => 'domain'
            ]));

            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
            ;
        }

        // disallow duplicate addresses
        $count = User::where('local', $request->input('local'))
            ->where('domain', $request->input('domain'))
            ->count()
        ;

        if ($count > 0) {
            $validator->errors()->add('local', trans('registration.dupe'));

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
        $request->session()->flash('success', trans('registration.success', [
            'account' => $user->getAddress()
        ]));

        // return to the login page
        return redirect()->route('login');
    }
}

