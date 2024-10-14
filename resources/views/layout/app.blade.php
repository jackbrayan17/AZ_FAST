<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="icon" href="{{ asset('AZ_fastlogo.png') }}" type="image/png">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
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
   
    <main>
        @yield('content')
    </main>
    <footer>
        <p>&copy; {{ date('Y') }} AZ Fast.</p>
    </footer>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>    
    
</body>
</html>
