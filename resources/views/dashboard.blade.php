@extends('main')

@section('content')
<h2>Dashboard</h2>
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
@endsection

