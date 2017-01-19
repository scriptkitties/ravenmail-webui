<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;

use App\Domain;
use App\DomainModerator;
use App\User;

class ModeratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(string $name)
    {
        $domain = Domain::findByNameOrFail($name);

        return view('domain.moderator.index', [
            'domain' => $domain,
            'moderators' => $domain->moderators,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(string $name)
    {
        $domain = Domain::findByNameOrFail($name);

        return view('domain.moderator.create', [
            'domain' => $domain,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, string $name)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required|min:2|max:256'
        ]);

        $domain = Domain::findByNameOrFail($name);
        $user = User::findByAddress($request->input('user'));

        // make sure the user exists
        if ($user === null) {
            $validator->errors()->add('user', trans('validation.user_not_found', [
                'user' => $request->input('user'),
            ]));
        }

        // check if any errors occurred
        if ($validator->errors()->any()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
            ;
        }

        // create new domain_moderators entry
        $dm = new DomainModerator();
        $dm->domain_id = $domain->id;
        $dm->user_id = $user->id;
        $dm->admin = $request->has('admin');
        $dm->save();

        // return to the domain moderator index
        return redirect()->route('domain.moderator.index', [
            'domain' => $domain->name,
        ])->withSuccess(trans('moderator.created', [
            'user' => $user->getAddress(),
            'domain' => $domain->name,
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // NYI
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // NYI
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, string $name, string $address)
    {
        $domain = Domain::findByNameOrFail($name);
        $user = User::findByAddressOrFail($address);
        $dm = DomainModerator::where('domain_id', $domain->id)
            ->where('user_id', $user->id)
            ->firstOrFail()
        ;

        $dm->delete();

        return redirect()->route('domain.moderator.index', [
            'name' => $domain->name,
        ])->withSuccess(trans('moderator.deleted', [
            'domain' => $domain->name,
            'user' => $user->getAddress(),
        ]));
    }
}
