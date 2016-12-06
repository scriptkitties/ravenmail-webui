@extends('main')

@section('content')
<form class="pure-form pure-form-aligned" method="post" action="{{ route('domains.store') }}">
    {{ csrf_field() }}
    <fieldset>
        <div class="pure-control-group">
            <label for="domain">Domain name</label>
            <input id="domain" name="domain" type="text">
        </div>
        <div class="pure-control-group">
            <label class="pure-checkbox" for="public">
                <input id="public" name="public" type="checkbox">
                Open registration
            </label>
        </div>
        <div class="content-center">
            <button class="pure-button" type="submit">
                <i class="fa fa-fw fa-save"></i>
                Add domain
            </button>
        </div>
    </fieldset>
</form>
@endsection

