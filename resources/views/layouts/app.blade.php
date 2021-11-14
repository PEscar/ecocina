<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- BASE Url -->
    <meta name="base-url" content="{{ url('') }}">

    <!-- Decimals -->
    <meta name="precision" content="{{ auth()->user() ? auth()->user()->entity->precision : 2 }}">

    <title>{{ config('app.name', 'Laravel') . ' - ' . ( auth()->user() ? auth()->user()->entity->name : '' ) }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ url('cooker.png') }}">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @if ( auth()->user() )
                            <li class="nav-item navbar-brand <?= Request::is('products*') ? 'active' : '' ?>"><a class="nav-link" href="{{ url('products') }}">{{ __('all.products') }}</a></li>
                            <li class="nav-item navbar-brand <?= Request::is('recipes*') ? 'active' : '' ?>"><a class="nav-link" href="{{ url('recipes') }}">{{ __('all.recipes') }}</a></li>
                            <li class="nav-item navbar-brand <?= Request::is('purchases*') ? 'active' : '' ?>"><a class="nav-link" href="{{ url('purchases') }}">{{ __('all.purchases') }}</a></li>
                            <li class="nav-item navbar-brand <?= Request::is('sales*') ? 'active' : '' ?>"><a class="nav-link" href="{{ url('sales') }}">{{ __('all.sales') }}</a></li>
                            <li class="nav-item navbar-brand <?= Request::is('expenses*') ? 'active' : '' ?>"><a class="nav-link" href="{{ url('expenses') }}">{{ __('all.expenses') }}</a></li>
                            <li class="nav-item navbar-brand <?= Request::is('productions*') ? 'active' : '' ?>"><a class="nav-link" href="{{ url('productions') }}">{{ __('all.productions') }}
                                <li class="nav-item navbar-brand <?= Request::is('regularizations*') ? 'active' : '' ?>"><a class="nav-link" href="{{ url('regularizations') }}">{{ __('all.regularizations') }}</a></li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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

            @if(session()->has('success'))
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($errors->any())
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>

                        
                    </div>
                </div>
            </div>
            @endif

            @yield('content')
        </main>

        <br><br><br><br>
            <div class="text-center text-lg-start bg-light text-muted footer">

                <!-- Copyright -->
                <div class="text-center pt-3" style="background-color: rgba(0, 0, 0, 0.05);">
                    © 2021 Copyright Pedro Scarselletta
                </div>

                <div class="text-center" style="background-color: rgba(0, 0, 0, 0.05);">
                    <a class="text-reset fw-bold" target="_blank" href="https://www.linkedin.com/in/pedro-scarselletta/"><i class="fab fa-linkedin"></i></a>
                    <a class="text-reset fw-bold" target="_blank" href="mailto:pedroscarselletta@gmail.com"><i class="fas fa-envelope"></i></a>
                    <!-- <i class="fab fa-github-square"></i> -->
                    <!-- <a class="text-reset fw-bold" href="https://wa.me/+34600739891"><i class="fab fa-whatsapp-square"></i></a> -->
                </div>
                <!-- Copyright -->

                <!-- <feedback></feedback> -->
            </div>
            <!-- Footer -->
    </div>
</body>
</html>
