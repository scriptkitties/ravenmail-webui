@extends('main')

@section('content')
<form method="post" action="{{ route('login.post') }}">
    {{ csrf_field() }}
    <div class="container">
        <div class="grid">
            <section class="grid__col grid__col--1-of-2 content-right">
                Email address
            </section>
            <section class="grid__col grid__col--1-of-2 content-left">
                <input type="text" name="email">
            </section>
        </div>
    </div>
    <div class="container">
        <div class="grid">
            <section class="grid__col grid__col--1-of-2 content-right">
                Password
            </section>
            <section class="grid__col grid__col--1-of-2 content-left">
                <input type="password" name="password">
            </section>
        </div>
    </div>
    <div class="container">
        <section class="content-center">
            <input type="checkbox" name="remember">
            Remember me
        </section>
    </div>
    <div class="container">
        <section class="content-center">
            <button type="submit">
                <i class="fa fa-fw fa-sign-in"></i>
                Log in
            </button>
        </section>
    </div>
</form>
@endsection

