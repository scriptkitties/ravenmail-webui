<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="/css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="/css/pure/base-min.css">
        <link rel="stylesheet" type="text/css" href="/css/pure/buttons-core-min.css">
        <link rel="stylesheet" type="text/css" href="/css/pure/buttons-min.css">
        <link rel="stylesheet" type="text/css" href="/css/pure/forms-min.css">
        <link rel="stylesheet" type="text/css" href="/css/pure/grids-responsive-min.css">
        <link rel="stylesheet" type="text/css" href="/css/pure/grids-units-min.css">
        <link rel="stylesheet" type="text/css" href="/css/pure/menus-core-min.css">
        <link rel="stylesheet" type="text/css" href="/css/pure/menus-horizontal-min.css">
        <link rel="stylesheet" type="text/css" href="/css/pure/menus-skin-min.css">
        <link rel="stylesheet" type="text/css" href="/css/pure/tables-min.css">
        <link rel="stylesheet" type="text/css" href="/css/main.css">
        <title>{{ config('app.name') }}</title>
    </head>
    <body>
        <header id="site-header">
            <h1>
                <a href="{{ URL::to('/') }}">Tyilmail</a>
            </h1>
            @include('nav')
        </header>
        @if($errors->count() > 0)
            <aside>
                <section class="error">
                    <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </section>
            </aside>
        @endif
        <main>
            @yield('content')
        </main>
        <footer>
            <p>
                &copy; 2016 - <a href="https://www.tyil.work">Patrick "tyil" Spek</a>
            </p>
            <p>
                Icons from the <a href="http://fontawesome.io/">Font Awesome</a> icon set, licensed under <a href="http://scripts.sil.org/OFL">SIL OFL 1.1</a>.
            </p>
        </footer>
    </body>
</html>

