<nav class="pure-menu pure-menu-horizontal">
    <ul class="pure-menu-list">
        @if(Auth::check())
            @if(Auth::user()->admin)
                <li class="pure-menu-item"><a class="pure-menu-link" href="{{ route('domains.index') }}">domains</a></li>
            @endif
            <li class="pure-menu-item"><a class="pure-menu-link" href="{{ route('logout') }}">logout</a></li>
        @else
            <li class="pure-menu-item"><a class="pure-menu-link" href="{{ route('login') }}">login</a></li>
            <li class="pure-menu-item"><a class="pure-menu-link" href="{{ route('registration.create') }}">register</a></li>
        @endif
    </ul>
</nav>

