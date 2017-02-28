@extends('main')

@section('content')
<form method="post" action="{{ route('domain.alias.store', ['domain' => $domain]) }}">
    {{ csrf_field() }}
    <fieldset>
        <div>
            <label for="local">Local part</label>
            <input id="local" name="local" type="text" value="{{ old('local') }}" required>
        </div>
        <div>
            <label for="destination">Destination</label>
            <input id="destination" name="destination" type="text" value="{{ old('domain') }}" required>
        </div>
    </fieldset>
    <fieldset>
        <div>
            <label for="create-noreg">
                <input id="create-noreg" name="create-noreg" type="checkbox" checked>
                Create a <strong>noreg</strong> rule, prohibit user registration of the alias address
            </label>
        </div>
    </fieldset>
    <div class="content-center">
        <button class="button-primary" type="submit">
            <i class="fa fa-fw fa-save"></i>
            Add alias
        </button>
    </div>
</form>
@endsection

