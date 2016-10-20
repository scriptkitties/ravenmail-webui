@extends('main')

@section('content')
<h2>{{ $domain->name }}</h2>
<h3>Domain stats</h3>
<ul>
    <li>
        <i class="fa fa-fw fa-envelope"></i>
        {{ $domain->users()->count() }} email {{ str_plural('account', $domain->users()->count()) }}
    </li>
    <li>
        <i class="fa fa-fw fa-mail-forward"></i>
        {{ $domain->aliases()->count() }} email {{ str_plural('forwards', $domain->aliases()->count()) }}
    </li>
    <li>
        Domain is
        @if ($domain->public)
            <strong>public</strong>
        @else
            <strong>not</strong> public
        @endif
    </li>
</ul>
<p>
    <a href="{{ route('domains.edit', ['name' => $domain->name]) }}">
        <i class="fa fa-fw fa-pencil"></i> Edit domain
    </a>
</p>
<h3>Create new ...</h3>
<ul>
    <li>
        <a href="{{ route('users.create', ['domain' => $domain->name]) }}">
            <i class="fa fa-fw fa-envelope"></i> Account
        </a>
    </li>
    <li>
        <a href="{{ route('aliases.create', ['domain' => $domain->name]) }}">
            <i class="fa fa-fw fa-mail-forward"></i> Forward
        </a>
    </li>
</ul>
<h3>Remove domain</h3>
<div class="error">
    <form method="post" action="{{ route('domains.destroy', ['name' => $domain->name]) }}">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <p>
            Be very sure before going through with this action. It will delete
            all mailboxes and aliases attached to the domain as well. None of
            this information can be retrieved once it has been deleted. You
            have been warned.
        </p>
        <p>
            <input type="checkbox" name="confirm-destroy">
            I am sure
        </p>
        <p>
            <button>
                <i class="fa fa-fw fa-trash"></i>
                Delete this domain
            </button>
        </p>
    </form>
</div>
@endsection

