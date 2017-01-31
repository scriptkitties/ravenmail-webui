@extends('main')

@section('content')
    <form class="pure-form pure-form-stacked" method="post" action="{{ route('domain.moderator.store', ['domain' => $domain->name]) }}">
        {{ csrf_field() }}
        <fieldset>
            <div class="pure-control-group">
                <label for="user">User</label>
                <input id="user" name="user" type="email" value="{{ old('user') }}">
            </div>
            <div class="pure-control-group">
                <label class="pure-checkbox" for="admin">
                    <input id="admin" name="admin" type="checkbox">
                    Domain admin powers
                </label>
            </div>
            <div class="content-center">
                <button class="pure-button" type="submit">
                    <i class="fa fa-fw fa-save"></i>
                    Add domain moderator
                </button>
            </div>
        </fieldset>
    </form>
@endsection

