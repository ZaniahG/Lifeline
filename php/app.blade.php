<!Doctype html>
<html lang="{{ str_replace(search: '_', replace: '-', subject: app()->getLocale()) }}">

<head>
    <title>@yield(section: 'page-title')</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
    <!-- Bootstrap 4 CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel='canonical' href='{{ url()->current() }}'>
    @stack('dynamic-style-sheets')
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset(path: 'css/custom.css') }}">
    @include(view: 'components.js-common-variables')
    @stack('custom-css')
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01"
            aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarTogglerDemo01">
            <a class="navbar-brand" href="#">
                <img src="{{ asset(path: 'storage/app/public/logo.png') }}" style="width: 115px" alt="">
            </a>
            <form class="form-inline main-search">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                {{-- <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button> --}}
            </form>
            <ul class="navbar-nav">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route(name: 'login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route(name: 'register') }}">Register</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href=""><i class="fa-solid fa-user"></i> Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route(name: 'logout') }}"
                            onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">Logout</a>
                    </li>
                    <form id="logout-form" action="{{ route(name: 'logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endguest
            </ul>

        </div>
    </nav>

    <div class="container mt-5">
        @yield(section: 'content')
    </div>

    <!-- Bootstrap 4 JS and dependencies -->
    <script src="https://kit.fontawesome.com/e30493ce3b.js" crossorigin="anonymous"></script>
    <script src="{{ asset(path: 'js/snackbar.js') }}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.11/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset(path: 'js/custom.js') }}"></script>
    <script src="{{ asset(path: 'js/ajax.js') }}"></script>
    @stack('custom-scripts')


    <div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="commonModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>

    @if (Session::has(key: 'success'))
        <script>
            showToast('{!! session(key: 'success') !!}');
            // show_toastr('{{ __(key: 'Success') }}', , 'success');
        </script>
        {{ Session::forget(keys: 'success') }}
    @endif
    @if (Session::has(key: 'error'))
        <script>
            showToast('{!! session(key: 'error') !!}', 'error');
        </script>
        {{ Session::forget(keys: 'error') }}
    @endif
</body>

</html>
