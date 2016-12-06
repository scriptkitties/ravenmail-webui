@extends('main')

@section('content')
<h2>{{ $domain->name }}</h2>
<h3>Domain stats</h3>
<ul>
    <li>
        <a href="{{ route('users.index', ['domain' => $domain->name]) }}">
            <i class="fa fa-fw fa-envelope"></i>
            {{ $domain->users()->count() }}
            email
            {{ str_plural('account', $domain->users()->count()) }}
        </a>
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
<section>
    <a class="pure-button" href="{{ route('domains.edit', ['name' => $domain->name]) }}">
        <i class="fa fa-fw fa-pencil"></i> Edit domain
    </a>
</section>
<h3>Create new ...</h3>
<ul class="pure-menu-list">
    <li class="pure-menu-item">
        <a class="pure-menu-link" href="{{ route('users.create', ['domain' => $domain->name]) }}">
            <i class="fa fa-fw fa-envelope"></i> Account
        </a>
    </li>
    <li class="pure-menu-item">
        <a class="pure-menu-link" href="{{ route('aliases.create', ['domain' => $domain->name]) }}">
            <i class="fa fa-fw fa-mail-forward"></i> Forward
        </a>
    </li>
</ul>
<h3>Remove domain</h3>
<div class="warning">
    <form method="post" action="{{ route('domains.destroy', ['name' => $domain->name]) }}">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <p>
            Be very sure before going through with this action. It will delete
            all mailboxes and aliases attached to the domain as well. None of
            this information can be retrieved once it has been deleted. You
            have been warned.
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
                Delete this domain
            </button>
        </div>
    </form>
</div>
@endsection

