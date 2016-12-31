@extends('main')

@section('content')
    <form class="pure-form pure-form-aligned" method="post" action="{{ route('aliases.store', ['domain' => $domain]) }}">
    {{ csrf_field() }}
    <fieldset>
        <div class="pure-control-group">
            <label for="local">Local part</label>
            <input id="local" name="local" type="text">
        </div>
        <div class="pure-control-group">
            <label for="destination">Destination</label>
            <input id="destination" name="destination" type="text">
        </div>
        <div class="content-center">
            <button class="pure-button" type="submit">
                <i class="fa fa-fw fa-save"></i>
                Add alias
            </button>
        </div>
    </fieldset>
</form>
@endsection

