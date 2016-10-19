@extends('main')

@section('content')
<h2>Dashboard</h2>
<h3>Server stats</h3>
<ul>
    <li>
        <i class="fa fa-fw fa-globe"></i> {{ $domains }} domains
    </li>
    <li>
        <i class="fa fa-fw fa-envelope"></i> {{ $users }} email accounts
    </li>
    <li>
        <i class="fa fa-fw fa-mail-forward"></i> {{ $aliases }} email forwards
    </li>
</ul>
@endsection

