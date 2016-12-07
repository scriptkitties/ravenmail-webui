@extends('main')

@section('content')
<form class="pure-form pure-form-aligned" method="post" action="{{ route('users.store', ['domain' => $domain->name]) }}">
    {{ csrf_field() }}
    <fieldset>
    <div class="pure-control-group">
        <label for="local">Local part</label>
        <input id="local" name="local" type="text">
    </div>
    <div class="pure-control-group">
        <label>Domain part</label>
        {{ $domain->name }}
    </div>
    <div class="pure-control-group">
        <label for="password">Password</label>
        <input id="password" name="password" type="password">
    </div>
    <div class="pure-control-group">
        <label for="admin">
            Admin user
            <input id="admin" name="admin" type="checkbox">
        </label>
    </div>
    <div class="pure-control-group">
        <label for="active">
            Active
            <input id="active" name="active" type="checkbox" checked="checked">
        </label>
    </div>
    <div class="pure-control-group">
        <div class="content-center">
            <button class="pure-button" type="submit">
                <i class="fa fa-fw fa-save"></i>
                Create user
            </button>
        </div>
    </div>
</form>
@endsection

