@extends('main')

@section('content')
<h2>{{ $user->getAddress() }}</h2>
<h3>User stats</h3>
<ul>
    <li>
        User has
        @if ($user->admin)
            <strong>admin</strong>
        @else
            <strong>no</strong> admin
        @endif
        privileges
    </li>
    <li>
        User's account is
        @if ($user->active)
            <strong>active</strong>
        @else
            <strong>not</strong> active
        @endif
    </li>
</ul>
<h3>Remove user</h3>
@endsection

