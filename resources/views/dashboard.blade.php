@extends('main')

@section('content')
<h2>Dashboard</h2>
<h3>Account actions</h3>
<ul class="pure-menu-list">
    <li class="pure-menu-item">
        <a class="pure-menu-link" href="{{ route('password.edit') }}">
            <i class="fa fa-fw fa-lock"></i> Change password
        </a>
    </li>
</ul>
<h3>Account stats</h3>
<ul>
    <li>
        Account created on {{ Auth::user()->created_at }}
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

