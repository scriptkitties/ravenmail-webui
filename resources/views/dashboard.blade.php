@extends('main')

@section('content')
<h2>Dashboard</h2>
<p>
    You are curently logged in as <strong>{{ $user->getAddress() }}</strong>.
</p>
<h3>Account actions</h3>
<ul class="pure-menu-list">
    <li class="pure-menu-item">
        <a class="pure-menu-link" href="{{ route('user.edit', ['user' => $user->getAddress()]) }}">
            <i class="fa fa-fw fa-lock"></i> Change password
        </a>
    </li>
    <li class="pure-menu-item">
        <a class="pure-menu-link" href="{{ route('user.alias.index', ['user' => $user->getAddress()]) }}">
            <i class="fa fa-fw fa-mail-forward"></i> Manage aliases
        </a>
    </li>
</ul>
<h3>Account stats</h3>
<ul>
    @if($user->admin)
        <li>
            Your account holds <strong>admin</strong> status. Congratulations!
        </li>
    @endif
    @if($user->domainsModerating->count() > 0)
        <li>
            Your account holds moderator status over
            {{ str_plural('domain', $user->domainsModerating->count()) }}
        </li>
    @endif
    <li>
        Account created on <strong>{{ $user->created_at }}</strong>.
    </li>
</ul>
@if($user->admin)
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

