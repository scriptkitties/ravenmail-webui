@extends('main')

@section('content')
<form method="post" action="{{ route('domain.user.store', ['domain' => $domain->name]) }}">
    {{ csrf_field() }}
    <fieldset>
    <div>
        <label for="local">Local part</label>
        <input id="local" name="local" type="text">
    </div>
    <div>
        <label>Domain part</label>
        {{ $domain->name }}
    </div>
    <div>
        <label for="password">Password</label>
        <input id="password" name="password" type="password">
    </div>
    <div>
        <label for="admin">
            Admin user
            <input id="admin" name="admin" type="checkbox">
        </label>
    </div>
    <div>
        <label for="active">
            Active
            <input id="active" name="active" type="checkbox" checked="checked">
        </label>
    </div>
    <div class="content-center">
        <button class="button-primary" type="submit">
            <i class="fa fa-fw fa-save"></i>
            Create user
        </button>
    </div>
</form>
@endsection

