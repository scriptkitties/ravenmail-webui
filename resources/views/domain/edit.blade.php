@extends('main')

@section('content')
<h2>Edit {{ $domain->name }}</h2>
<form method="post" action="{{ route('domains.update', ['name' => $domain->name]) }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <input
        type="checkbox"
        name="public"
        @if($domain->public)
            checked="checked"
        @endif
    > Public domain
    <p class="text-center">
        <button type="submit">
            <i class="fa fa-fw fa-save"></i> Save
        </button>
    </p>
</form>
@endsection

