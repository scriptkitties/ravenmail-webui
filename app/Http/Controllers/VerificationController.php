<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App;
use App\Http\Requests;

use App\Alias;
use App\Verification;

class VerificationController extends Controller
{
    public function getIndex(string $type, string $uuid)
    {
        if (!method_exists($this, $type)) {
            return App::abort(404);
        }

        $verification = Verification::findOrFail($uuid);

        return $this->{$type}($verification);
    }

    public function alias(Verification $verification)
    {
        $alias = Alias::where('verification', $verification->uuid)
            ->firstOrFail()
        ;

        // update the alias
        $alias->active = true;
        $alias->verification = null;
        $alias->save();

        // delete the verification
        $verification->delete();

        return redirect()->route('dashboard')
            ->withSuccess(trans('user.alias.verified'))
        ;
    }
}
