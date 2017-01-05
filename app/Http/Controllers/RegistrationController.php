<?php

namespace App\Http\Controllers;

use Exception;

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
            'local' => 'required|max:64', // todo: disallow leading and trailing dot
            'domain' => 'required|exists:domains,name',
            'password' => 'required',
            'password-verify' => 'required|same:password',
            'accept-tos' => 'required'
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
            $validator->errors()->add('local', trans('registration.dupe'));
        }

        // disallow illegal addresses
        try {
            if (!User::isValidLocal($request->input('local'))) {
                $validator->errors()->add('local', trans('registration.illegal'));
            }
        } catch (Exception $e) {
            $validator->errors()->add('application', trans('registration.regex_error'));
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
        $request->session()->flash('success', trans('registration.success', [
            'account' => $user->getAddress()
        ]));

        // return to the login page
        return redirect()->route('login');
    }
}

