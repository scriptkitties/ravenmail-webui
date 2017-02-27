@extends('main')

@section('content')
<form method="post" action="{{ route('domain.store') }}">
    {{ csrf_field() }}
    <fieldset>
        <div>
            <label for="domain">Domain name</label>
            <input id="domain" name="domain" type="text">
        </div>
        <div>
            <label for="contact">Contact email address</label>
            <input id="contact" name="contact" type="text">
        </div>
        <div>
            <label for="public">
                <input id="public" name="public" type="checkbox">
                Open registration
            </label>
        </div>
        <div class="content-center">
            <button class="button-primary" type="submit">
                <i class="fa fa-fw fa-save"></i>
                Add domain
            </button>
        </div>
    </fieldset>
</form>
@endsection

