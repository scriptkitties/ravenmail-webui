<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class LegalController extends Controller
{
    public function tos()
    {
        return view('legal.tos');
    }
}
