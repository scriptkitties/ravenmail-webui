<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class DashboardController extends Controller
{
	public function getIndex()
	{
		return view('dashboard');
	}
}

