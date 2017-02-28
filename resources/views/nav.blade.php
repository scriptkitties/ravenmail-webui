<nav>
    <ul>
        @if(Auth::check())
            <li><a href="{{ route('dashboard') }}">dashboard</a></li>
            @if(Auth::user()->admin || Auth::user()->domainModerators->count() > 0)
                <li><a href="{{ route('domain.index') }}">domains</a></li>
            @endif
            <li><a href="{{ route('logout') }}">logout</a></li>
        @else
            <li><a href="{{ route('login') }}">login</a></li>
            <li><a href="{{ route('user.create') }}">register</a></li>
        @endif
    </ul>
</nav>

