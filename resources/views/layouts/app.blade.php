<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">

    <!-- Bootstrap Css -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Main Css -->
    <script src="'tailwind.config.js"></script>

    <!-- Main Css -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    <!-- Main Js File -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">

    <title>{{ config('app.name', 'Blog') }}, Multi users blog built with Laravel 8 by hbakouane</title>
</head>
<body>
    <div id="app">
        <div class="header">
            <div class="progress-container">
                <div class="progress-bar" id="myBar"></div>
            </div>
        </div>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="text-light navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Blog') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @auth()
                            <li class="nav-item">
                                <a class="text-light nav-link" href="/{{ Auth::user()->username }}">Profile</a>
                            </li>
                        @endauth
                        <li class="nav-item">
                            <a class="text-light nav-link" href="/posts/create">Create a Post</a>
                        </li>
                        @auth()
                            <li class="nav-item">
                                <a class="text-light nav-link" href="/posts/">Manage My Posts</a>
                            </li>
                        @endauth
                        <li class="nav-item">
                            <a class="text-light nav-link" href="/authors">Authors</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="d-inline-block">
                                <a href="/login">
                                    <button class="btn rounded-pill btn-sm bg-light text-dark btn-main full-width">Login</button>
                                </a>
                            </li>
                        @else
                            <li class="nav-item dropdown text-light">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/settings/{{ Auth::id() }}/edit">Settings</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        <footer class="container-fluid bg-dark footer">
            <br><br>
            <p class="text-center text-muted">
                Made with <span class="text-danger"> ♥</span> by <a href="https:/github.com/hbakouane" class="text-light">hbakouane</a> |
                <a class="text-muted" href="https:/facebook.com/cole.haytam.7"><i class="fab fa-facebook"></i></a> |
                <a class="text-muted" href="mailto:hbakouane@gmail.com">hbakouane@gmail.com</a>
            </p>
            <br>
        </footer>
    </div>

    <!-- Let's make the tooltips working -->
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <script src="{{ asset('js/main.js') }}"></script>
    <!-- Bootstrap Js -->
    <script src="{{ asset('js/app.js') }}" rel="stylesheet"></script>
    <script src="{{ asset('js/main.js') }}" rel="stylesheet"></script>
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</body>
</html>
