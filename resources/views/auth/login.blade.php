@extends('main')

@section('content')
<form method="post" action="{{ route('login.post') }}">
    {{ csrf_field() }}
    <p class="text-center">
        <input type="text" name="email">
    </p>
    <p class="text-center">
        <input type="password" name="password">
    </p>
    <p class="text-center">
        <input type="checkbox" name="remember">
        Remember me
    </p>
    <p class="text-center">
        <button type="submit">Log in</button>
    </p>
</form>
@endsection

