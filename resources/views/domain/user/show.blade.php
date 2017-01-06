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
    <a class="pure-button" href="{{ route('domain.user.edit', ['name' => $user->domain, 'address' => $user->getAddress()]) }}">
        <i class="fa fa-fw fa-pencil"></i> Edit user
    </a>
</p>

<h2>Destination for</h2>
<ul>
@forelse($user->getDestinationAliases() as $alias)
    <li>
        <a href="{{ route('domain.alias.show', ['name' => $user->domain, 'address' => $alias->getAddress()]) }}">
            {{ $alias->getAddress() }}
        </a>
    </li>
@empty
    <p>No aliases point to this address.</p>
@endforelse
</ul>

<h3>Remove user</h3>
<div class="warning">
    <form method="post" action="{{ route('domain.user.destroy', ['name' => $user->domain, 'address' => $user->getAddress()]) }}">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <p>
            Be very sure before going through with this action. It will delete
            all emails of this user as well. None of this information can be
            retrieved once it has been deleted. You have been warned.
        </p>
        <div class="pure-control-group">
            <label class=pure-checkbox" for="confirm-destroy">
                <input id="confirm-destroy" type="checkbox" name="confirm-destroy">
                I am sure
            </label>
        </div>
        <div class="pure-control-group">
            <button class="pure-button" type="submit">
                <i class="fa fa-fw fa-trash"></i>
                Delete this user
            </button>
        </div>
    </form>
</div>
@endsection

