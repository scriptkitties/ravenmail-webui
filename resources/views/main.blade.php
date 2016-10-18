<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="/css/main.css">
        <link rel="stylesheet" type="text/css" href="/css/alignment.css">
        <link rel="stylesheet" type="text/css" href="/css/grid.css">
        <link rel="stylesheet" type="text/css" href="/css/font-awesome.css">
        <title>Tyilmail</title>
    </head>
    <body>
        <header id="site-header">
            <h1>
                <a href="{{ URL::to('/') }}">Tyilmail</a>
            </h1>
            <nav>
                <ul>
                    <li><a href="{{ URL::to('domains.index') }}">domains</a></li>
                    <li><a href="{{ URL::to('users.index') }}">users</a></li>
                    <li><a href="{{ URL::to('aliases.index') }}">aliases</a></li>
                </ul>
            </nav>
        </header>
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

