@extends('main')

@section('content')
<form method="post" action="{{ route('users.store', ['domain' => $domain->name]) }}">
    {{ csrf_field() }}
    <div class="container">
        <div class="grid">
            <section class="grid__col grid__col--1-of-2 content-right">
                <input type="text" name="local">
            </section>
            <section class="grid__col grid__col--1-of-2 content-left">
                {{ '@' . $domain->name }}
            </section>
        </div>
    </div>
    <div class="container">
        <div class="grid">
            <section class="grid__col grid__col--1-of-2 content-right">
                Password
            </section>
            <section class="grid__col grid__col--1-of-2 content-left">
                <input type="password" name="password">
            </section>
        </div>
    </div>
    <div class="container">
        <div class="grid">
            <section class="grid__col grid__col--1-of-2 content-right">
                Admin user
            </section>
            <section class="grid__col grid__col--1-of-2 content-left">
                <input type="checkbox" name="admin">
            </section>
        </div>
    </div>
    <div class="container">
        <div class="grid">
            <section class="grid__col grid__col--1-of-2 content-right">
                Active
            </section>
            <section class="grid__col grid__col--1-of-2 content-left">
                <input type="checkbox" name="active" checked="checked">
            </section>
        </div>
    </div>
    <div class="container">
        <div class="content-center">
            <button>
                <i class="fa fa-fw fa-save"></i>
                Create user
            </button>
        </div>
    </div>
</form>
@endsection

