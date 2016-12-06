@extends('main')

@section('content')
<form method="post" action="{{ route('login.post') }}" class="pure-form pure-form-aligned">
    {{ csrf_field() }}
    <fieldset>
        <div class="pure-control-group">
            <label for="email">Email address</label>
            <input id="email" name="email" type="text">
        </div>
        <div class="pure-control-group">
            <label for="password">Password</label>
            <input id="password" name="password" type="password">
        </div>
        <div class="pure-control-group">
            <label for="remember" class="pure-checkbox">
                <input id="remember" name="remember" type="checkbox">
                Remember me
            </label>
        </div>
        <div class="pure-control-group">
            <button class="pure-button" type="submit">
                <i class="fa fa-fw fa-sign-in"></i>
                Log in
            </button>
        </div>
    </fieldset>
</form>
@endsection

