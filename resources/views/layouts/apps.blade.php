<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ $title }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.7.2/css/all.css">

    <link href="{{ asset('midragon/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/prism/themes/prism-duotone-dark.css') }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter&display=swap');

    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="layout-3" style="font-family: 'Inter', sans-serif;" data-prismjs-copy-timeout="500">
    <div id="app">
        <div class="main-wrapper container">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <a href="#" class="navbar-brand sidebar-gone-hide">CRUD GENERATOR</a>
                <div class="navbar-nav">
                    <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
                </div>
                <form class="form-inline ml-auto">
                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <div class="d-sm-none d-lg-inline-block">Hi, Fahmi Ibrahim</div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-title">Logged in 5 min ago</div>
                            <a href="{{ url('profile') }}" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile
                            </a>
                            <a href="#" class="dropdown-item has-icon">
                                <i class="fas fa-bolt"></i> Activities
                            </a>
                            <a href="#" class="dropdown-item has-icon">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" class="dropdown-item has-icon" onclick="event.preventDefault();
                                this.closest('form').submit();">
                                    <i class="far fa-sign-out-alt"></i> Logout
                                </a>
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>

            <nav class="navbar navbar-secondary navbar-expand-lg">
                <div class="container">
                    <ul class="navbar-nav">
                        <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                            <a href="{{ url('/dashboard') }}" class="nav-link"><i
                                    class="fas fa-home"></i><span>Dashboard</span></a>
                        </li>
                        <li
                            class="nav-item dropdown {{ request()->is('beautifier/code') || request()->is('beautifier/html') ? 'active' : '' }}">
                            <a href="#" data-toggle="dropdown" class="nav-link has-dropdown">
                                <i class="far fa-graduation-cap"></i><span>Beautifier</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item {{ request()->is('beautifier/code') ? 'active' : '' }}">
                                    <a href="{{ url('/beautifier/code') }}" class="nav-link">Code</a>
                                </li>
                                <li class="nav-item {{ request()->is('beautifier/html') ? 'active' : '' }}">
                                    <a href="{{ url('/beautifier/html') }}" class="nav-link">HTML Beautifier</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="main-content">
                @yield('content')
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; {{ date('Y') }} <div class="bullet"></div> Create By <a
                        href="https://facebook.com/fahmiibrahimdev">Fahmi Ibrahim</a>
                </div>
                <div class="footer-right">
                    1.0
                </div>
            </footer>
        </div>
    </div>


    @livewireScripts
    <script>
        window.addEventListener("dataStore", () => {
            $("#tambahDataModal").modal("hide");
            $("#ubahDataModal").modal("hide");
        });

    </script>
    <script src="{{ asset('midragon/select2/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('midragon/js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>
    <script>
        window.onbeforeunload = function () {
            window.scrollTo(5, 75);
        };

    </script>

    <script src="{{ asset('assets/prism/prism.js') }}"></script>
    <script src="{{ asset('midragon/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    @stack('scripts')

    <script>
        document.addEventListener('livewire:load', function () {
            window.addEventListener('highlight-code', () => {
                Prism.highlightAll();
            });
        });

    </script>
</body>

</html>
