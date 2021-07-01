<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
<body class="bg-gray-100 mb-16">
    <nav class="p-6 bg-white flex justify-between">
        <ul class="flex">
            <li class="p-3">
                Home
            </li>
            <li class="p-3">
                <a href="{{ route('posts.index') }}">
                    Posts
                </a>
            </li>
        </ul>
        <ul class="flex">           
            @auth
                <li class="p-3">
                    {{ auth()->user()->name }}
                </li>
                <li class="p-3">
                    <form action="{{ route('logout') }}" method="post" class="p-3 inline">
                        @csrf
                        <button type="submit" >
                            Logout
                        </button>
                    </form>
                </li>
            @endauth
            @guest
                <li class="p-3">
                    <a href="{{ route('register.create') }}">
                        Register
                    </a>
                </li>
                <li class="p-3">
                    <a href="{{ route('login') }}">
                        Login
                    </a>
                </li>
            @endguest
        </ul>
    </nav>
    <div class="container mx-auto mt-6">
        @yield('content')
    </div>
</body>
</html>



