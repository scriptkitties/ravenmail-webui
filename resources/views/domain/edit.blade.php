@extends('main')

@section('content')
<h2>Edit {{ $domain->name }}</h2>
<form method="post" action="{{ route('domains.update', ['name' => $domain->name]) }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="container">
        <div class="grid">
            <section class="grid__col grid__col--1-of-2 content-right">
                Public domain
            </section>
            <section class="grid__col grid__col--1-of-2 content-left">
                <input
                    type="checkbox"
                    name="public"
                    @if($domain->public)
                        checked="checked"
                    @endif
                >
            </section>
        </div>
    </div>
    <div class="container">
        <section class="text-center">
            <button type="submit">
                <i class="fa fa-fw fa-save"></i>
                Save
            </button>
        </section>
    </div>
</form>
@endsection

