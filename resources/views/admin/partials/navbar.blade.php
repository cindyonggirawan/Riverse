<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
            <a href="/" class="nav-link {{ $title === 'Home' ? 'active' : '' }}">Home</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        @guest
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/login" class="nav-link {{ $title === 'Login' ? 'active' : '' }}">Login</a>
            </li>

            <li class="nav-item d-none d-sm-inline-block">
                <a href="/register" class="nav-link {{ $title === 'Register' ? 'active' : '' }}">Register</a>
            </li>
        @endguest

        @auth
            <li class="nav-item d-none d-sm-inline-block">
                <form action="/logout" method="post" class="form-horizontal">
                    @csrf
                    <button type="submit" class="btn nav-link">Logout</button>
                </form>
            </li>
        @endauth
    </ul>
</nav>
