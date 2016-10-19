<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function getLogin()
    {
        return view('auth.login');
    }

    public function getLogout()
    {
        Auth::logout();

        return redirect(route('login'));
    }

    public function postLogin(Request $request)
    {
        $parts = explode('@', $request->input('email'));
        $count = count($parts);

        if ($count < 2) {
            return view('auth.login')->withErrors(['Invalid emailaddress']);
        }

        if ($count > 2) {
            $domain = array_unshift($parts);
            $local = implode('@', $parts);
        } else {
            $local = $parts[0];
            $domain = $parts[1];
        }

        $password = $request->input('password');
        $remember = false;

        $user = User::where('local', $local)
            ->where('domain', $domain)
            ->where('active', true)
            ->where('admin', true)
            ->first()
        ;

        if ($user === null || !password_verify($password, $user->password)) {
            return view('auth.login')->withErrors(['Invalid emailaddress or password']);
        }

        Auth::login($user, $remember);

        return redirect()->intended('dashboard');
    }
}

