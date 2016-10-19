@extends('main')

@section('content')
<form method="post" action="{{ route('domains.store') }}">
    {{ csrf_field() }}
    <p class="text-center">
        <input type="text" name="domain">
    </p>
    <p class="text-center">
        <input type="checkbox" name="public">Open registration
    </p>
    <p class="text-center">
        <button type="submit">Add domain</button>
    </p>
</form>
@endsection

