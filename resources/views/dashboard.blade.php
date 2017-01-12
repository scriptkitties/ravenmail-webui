@extends('main')

@section('content')
<h2>Dashboard</h2>
<p>
    You are curently logged in as <strong>{{ Auth::user()->getAddress() }}</strong>.
</p>
<h3>Account actions</h3>
<ul class="pure-menu-list">
    <li class="pure-menu-item">
        <a class="pure-menu-link" href="{{ route('user.edit', ['user' => Auth::user()->getAddress()]) }}">
            <i class="fa fa-fw fa-lock"></i> Change password
        </a>
    </li>
    <li class="pure-menu-item">
        <a class="pure-menu-link" href="{{ route('user.alias.index', ['user' => Auth::user()->getAddress()]) }}">
            <i class="fa fa-fw fa-mail-forward"></i> Manage aliases
        </a>
    </li>
</ul>
<h3>Account stats</h3>
<ul>
    <li>
        Account created on <strong>{{ Auth::user()->created_at }}</strong>
    </li>
</ul>
@if(Auth::user()->admin)
<h3>Server stats</h3>
<ul>
    <li>
        <i class="fa fa-fw fa-globe"></i> {{ $domains }} {{ str_plural('domain', $domains) }}
    </li>
    <li>
        <i class="fa fa-fw fa-envelope"></i> {{ $users }} email {{ str_plural('account', $users) }}
    </li>
    <li>
        <i class="fa fa-fw fa-mail-forward"></i> {{ $aliases }} email {{ str_plural('forward', $aliases) }}
    </li>
</ul>
@endif
@endsection

