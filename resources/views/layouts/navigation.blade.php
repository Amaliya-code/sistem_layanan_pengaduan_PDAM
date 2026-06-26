<nav class="bg-primary text-white shadow">
    <div class="container d-flex justify-content-between align-items-center py-3">

        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="fw-bold text-white text-decoration-none fs-5">
            💧 PDAM TIRTA AL-BANTANI
        </a>

        <!-- Menu -->
        <div class="d-flex align-items-center gap-3">

            @auth
                <span class="fw-semibold">
                    {{ Auth::user()->nama }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-light btn-sm">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-light btn-sm">
                    Login
                </a>
            @endauth

        </div>

    </div>
</nav>
