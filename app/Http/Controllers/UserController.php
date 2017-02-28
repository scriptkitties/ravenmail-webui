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
        $rules = [
            'local' => 'required|max:64', // todo: disallow leading and trailing dot
            'domain' => 'required|regex:/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i|exists:domains,uuid',
            'password' => 'required',
            'password-verify' => 'required|same:password',
            'accept-tos' => 'required',
        ];

        // @todo: figure out how to properly mock the captcha so it can be tested properly
        if (config('app.env') !== 'testing') {
            $rules['captcha'] = 'required|captcha';
        }

        // apply basic form validation
        $validator = Validator::make($request->all(), $rules);

        try {
            $domain = Domain::find($request->input('domain'));

            if ($domain === null) {
                throw new Exception(trans('domain.unknown'));
            }

            // disallow non-public domains
            if (!$domain->public) {
                $validator->errors()->add('domain', trans('validation.not_in', [
                    'attribute' => 'domain'
                ]));
            }

            // dont allow addresses considered unregisterable
            if (!User::isRegisterable($request->input('local'), $domain->uuid)) {
                $validator->errors()->add('local', trans('user.dupe'));
            }

            // disallow illegal addresses
            if (!User::isValidAddress($request->input('local'), $domain->name)) {
                $validator->errors()->add('local', trans('user.illegal'));
            }
        } catch (Exception $e) {
            $validator->errors()->add('application', $e->getMessage());
        }

        // check if any errors occurred
        if ($validator->errors()->any()) {
            return redirect()
                ->route('user.create')
                ->withErrors($validator)
                ->withInput()
            ;
        }

        // create the new user
        $user = new User();
        $user->local = $request->input('local');
        $user->domain_uuid = $domain->uuid;
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
