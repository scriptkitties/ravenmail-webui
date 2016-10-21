@extends('main')

@section('content')
<form method="post" action="{{ route('domains.store') }}">
    {{ csrf_field() }}
    <div class="container">
        <div class="grid">
            <section class="grid__col grid__col--1-of-2 content-right">
                Domain name
            </section>
            <section class="grid__col grid__col--1-of-2 content-left">
                <input type="text" name="domain">
            </section>
        </div>
    </div>
    <div class="container">
        <div class="grid">
            <section class="grid__col grid__col--1-of-2 content-right">
                Open registration
            </section>
            <section class="grid__col grid__col--1-of-2 content-left">
                <input type="checkbox" name="public">
            </section>
        </div>
    </div>
    <div class="container">
        <section class="content-center">
            <button type="submit">
                <i class="fa fa-fw fa-save"></i>
                Add domain
            </button>
        </section>
    </div>
</form>
@endsection

