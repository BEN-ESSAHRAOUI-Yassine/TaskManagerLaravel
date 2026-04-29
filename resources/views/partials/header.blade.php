<header class="header">
    <div class="container nav-wrapper">

        {{-- LEFT --}}
        <div style="display:flex; gap:15px; align-items:center;">
            <a href="{{ route('tasks.index') }}" style="font-weight:bold;">
                Task Manager
            </a>

            @auth
                <a href="{{ route('tasks.index') }}">Dashboard</a>
            @endauth
        </div>

        {{-- RIGHT --}}
        <div style="display:flex; gap:15px; align-items:center;">

            @guest
                <a href="{{ route('login') }}" class="btn">Login</a>
                <a href="{{ route('register') }}" class="btn primary">Register</a>
            @endguest

            @auth
                <span>👋 {{ auth()->user()->name }}</span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn">Logout</button>
                </form>
            @endauth

        </div>

    </div>
</header>