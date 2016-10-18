@extends('main')

@section('content')
<h1>Dashboard</h1>
<div class="container">
    <div class="grid">
        <div class="grid__col grid__col--1-of-3">
            <a href="{{ URL::route('domains.index') }}">
                <div class="text-center">
                    <i class="fa fa-globe"></i>
                </div>
                <p class="text-center">Domains</p>
                <p class="text-center">{{ $domains }}</p>
            </a>
        </div>
        <div class="grid__col grid__col--1-of-3">
            <a href="{{ URL::route('users.index') }}">
                <div class="text-center">
                    <i class="fa fa-envelope"></i>
                </div>
                <p class="text-center">Users</p>
                <p class="text-center">{{ $users }}</p>
            </a>
        </div>
        <div class="grid__col grid__col--1-of-3">
            <a href="{{ URL::route('aliases.index') }}">
                <div class="text-center">
                    <i class="fa fa-mail-forward"></i>
                </div>
                <p class="text-center">Aliases</p>
                <p class="text-center">{{ $aliases }}</p>
            </a>
        </div>
    </div>
</div>
@endsection

