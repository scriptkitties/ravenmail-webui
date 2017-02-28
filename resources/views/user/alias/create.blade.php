@extends('main')

@section('content')
<h2>Create new alias</h2>
<form method="post" action="{{ route('user.alias.store', ['user' => $user->getAddress()]) }}">
    {{ csrf_field() }}
    <fieldset>
        <div>
            <label for="destination">Destination</label>
            <input id="destination" name="destination" type="text" value="{{ old('domain') }}" required>
        </div>
    </fieldset>
    <div class="content-center">
        <button class="button-primary" type="submit">
            <i class="fa fa-fw fa-save"></i>
            Add alias
        </button>
    </div>
@endsection

