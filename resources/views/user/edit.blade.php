@extends('main')

@section('content')
<h2>Edit {{ $user->getAddress() }}</h2>
<form method="post" action="{{ route('users.update', ['name' => $user->domain, 'address' => $user->getAddress()]) }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <h2>Account details</h2>
    <fieldset>
        <div class="pure-control-group">
            <label for="password">Password</label>
            <input id="password" name="password" type="password">
            <p>
                Leave this blank if you do not wish to update the password.
            </p>
        </div>
    </fieldset>
    <h2>Privileges</h2>
    <fieldset>
        <div class="pure-control-group">
            <label class="pure-checkbox" for="active">
                <input
                    id="active"
                    type="checkbox"
                    name="active"
                    @if($user->active)
                        checked="checked"
                    @endif
                >
                Active
            </label>
        </div>
        <div class="pure-control-group">
            <label class="pure-checkbox" for="admin">
                <input
                    id="admin"
                    type="checkbox"
                    name="admin"
                    @if($user->admin)
                        checked="checked"
                    @endif
                >
                Admin
            </label>
        </div>
    </fieldset>
    <div class="pure-control-group">
        <button class="pure-button" type="submit">
            <i class="fa fa-fw fa-save"></i>
            Save
        </button>
    </div>
</form>
@endsection

