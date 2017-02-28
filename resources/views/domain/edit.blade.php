@extends('main')

@section('content')
<h2>Edit {{ $domain->name }}</h2>
<form method="post" action="{{ route('domain.update', ['name' => $domain->name]) }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <fieldset>
        <div>
            <label for="public">
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
        <div>
            <button class="button-primary" type="submit">
                <i class="fa fa-fw fa-save"></i>
                Save
            </button>
        </div>
    </fieldset>
</form>
@endsection

