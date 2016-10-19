@extends('main')

@section('content')
<form method="post" action="{{ route('login.post') }}">
    {{ csrf_field() }}
    <p class="text-center">
        <input type="text" name="email">
        <input type="password" name="password">
        <button type="submit">Log in</button>
    </p>
</form>
@endsection

