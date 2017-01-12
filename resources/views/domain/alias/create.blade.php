@extends('main')

@section('content')
<form class="pure-form pure-form-stacked" method="post" action="{{ route('domain.alias.store', ['domain' => $domain]) }}">
    {{ csrf_field() }}
    <fieldset>
        <div class="pure-control-group">
            <label for="local">Local part</label>
            <input id="local" name="local" type="text" value="{{ old('local') }}" required>
        </div>
        <div class="pure-control-group">
            <label for="destination">Destination</label>
            <input id="destination" name="destination" type="text" value="{{ old('domain') }}" required>
        </div>
    </fieldset>
    <fieldset>
        <div class="pure-control-group">
            <label for="create-noreg">
                <input id="create-noreg" name="create-noreg" type="checkbox" checked>
                Create a <strong>noreg</strong> rule, prohibit user registration of the alias address
            </label>
        </div>
    </fieldset>
    <div class="content-center">
        <button class="pure-button" type="submit">
            <i class="fa fa-fw fa-save"></i>
            Add alias
        </button>
    </div>
</form>
@endsection

