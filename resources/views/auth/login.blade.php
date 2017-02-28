@extends('main')

@section('content')
<h2>Login</h2>
<form method="post" action="{{ route('login.post') }}">
    {{ csrf_field() }}
    <fieldset>
        <div>
            <label for="email">Email address</label>
            <input id="email" name="email" type="text">
        </div>
        <div>
            <label for="password">Password</label>
            <input id="password" name="password" type="password">
        </div>
        <div>
            <label for="remember">
                <input id="remember" name="remember" type="checkbox">
                Remember me
            </label>
        </div>
        <div class="content-center">
            <button class="button-primary" type="submit">
                <i class="fa fa-fw fa-sign-in"></i>
                Log in
            </button>
        </div>
    </fieldset>
</form>
@endsection

