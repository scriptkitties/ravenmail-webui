@extends('main')

@section('content')
<h2>Edit {{ $domain->name }}</h2>
<form class="pure-form pure-form-aligned" method="post" action="{{ route('domain.update', ['name' => $domain->name]) }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <fieldset>
        <div class="pure-control-group">
            <label class="pure-checkbox" for="public">
                <input
                    type="checkbox"
                    name="public"
                    @if($domain->public)
                        checked="checked"
                    @endif
                >
                Public domain
            </label>
        </div>
        <div class="pure-control-group">
            <button class="pure-button" type="submit">
                <i class="fa fa-fw fa-save"></i>
                Save
            </button>
        </div>
    </fieldset>
</form>
@endsection

