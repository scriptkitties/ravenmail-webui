<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Domain;
use App\User;
use App\Alias;

class DashboardController extends Controller
{
    public function getIndex()
    {
        $aliases = Alias::count();
        $domains = Domain::count();
        $users = User::count();

        return view('dashboard', [
            'aliases' => $aliases,
            'domains' => $domains,
            'users' => $users,
            'user' => Auth::user(),
        ]);
    }
}

