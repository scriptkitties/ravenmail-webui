@extends('main')

@section('content')
<h2>Dashboard</h2>
<p>
    You are curently logged in as <strong>{{ $user->getAddress() }}</strong>.
</p>
<h3>Account actions</h3>
<ul>
    <li>
        <a href="{{ route('user.edit', ['user' => $user->getAddress()]) }}">
            <i class="fa fa-fw fa-lock"></i> Change password
        </a>
    </li>
    <li>
        <a href="{{ route('user.alias.index', ['user' => $user->getAddress()]) }}">
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
    @if($user->domainModerators->count() > 0)
        <li>
            Your account holds <strong>moderator</strong> status over
            <strong>{{ $user->domainModerators->count() }}</strong>
            {{ str_plural('domain', $user->domainModerators->count()) }}.
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

