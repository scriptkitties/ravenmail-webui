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
<p>
    <a href="{{ route('users.edit', ['name' => $user->domain, 'address' => $user->getAddress()]) }}">
        <i class="fa fa-fw fa-pencil"></i> Edit user
    </a>
</p>
<h2>Destination for</h2>
<ul>
@forelse($user->getDestinationAliases() as $alias)
    <li>
        <a href="{{ route('aliases.show', ['name' => $user->domain, 'address' => $alias->getAddress()]) }}">
            {{ $alias->getAddress() }}
        </a>
    </li>
@empty
    <p>No aliases point to this address.</p>
@endforelse
</ul>
<h3>Remove user</h3>
@endsection

