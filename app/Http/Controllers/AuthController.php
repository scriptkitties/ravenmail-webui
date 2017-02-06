<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests;
use App\User;

class AuthController extends Controller
{
    public function getLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function getLogout()
    {
        Auth::logout();

        return redirect()->route('login');
    }

    public function postLogin(Request $request)
    {
        if (Auth::check()) {
            return redirect()->intended(route('dashboard'));
        }

        try {
            $user = User::findByAddressOrFail($request->input('email'));

            if (!Hash::check($request->input('password'), $user->password)) {
                throw new \Exception('Invalid email address or password');
            }

            if ($user->trashed()) {
                throw new \Exception('Account has been disabled');
            }
        } catch(\Exception $e) {
            return redirect()
                ->route('login')
                ->withErrors([$e->getMessage()])
                ;
        }

        Auth::login($user, $request->has('remember'));

        return redirect()->intended(route('dashboard'));
    }
}

