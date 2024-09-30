<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>@yield('title', 'AZ Fast')</title>
</head>
<body>
    <style>
        body{
       font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body a:any-link{
            color: #098857 ;
            text-decoration: none;
        }
    </style>
    <header>
        <nav>
            @auth
                <!-- Show this if the user is authenticated -->
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </li>
            @endauth
            @guest
                <!-- Show this if the user is not authenticated -->
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('client.register.form') }}">Register</a></li>
            @endguest
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <p>&copy; {{ date('Y') }} AZ Fast.</p>
    </footer>
</body>
</html>
