<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/v4-shims.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="{{ asset('AZ_fastlogo.png') }}" type="image/png">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <title>@yield('title', 'EEUEZ Market')</title>
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
    <footer class="bg-gray-800 text-white mt-10 py-6">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="text-center md:text-left">
                <h2 class="text-lg font-semibold">Informations de Contact</h2>
                <p class="mt-2">EEUEZ Market</p>
                <p class="mt-1">Email: <a href="mailto:contact@eeuezmarket.com" class="text-blue-400 hover:underline">contact@eeuezmarket.com</a></p>
                <p class="mt-1">Téléphone: <a href="tel:+237657757036" class="text-blue-400 hover:underline">+237 657 757 036</a></p>
            </div>
            <div class="mt-4 md:mt-0 text-center">
                <p class="text-sm">©2025 EEUEZ Market. Tous droits réservés.</p>
                <div class="flex justify-center mt-2 space-x-4">
                    <a href="[Lien Facebook]" class="text-blue-400 hover:text-blue-300" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="[Lien Twitter]" class="text-blue-400 hover:text-blue-300" target="_blank">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="[Lien Instagram]" class="text-blue-400 hover:text-blue-300" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="[Lien LinkedIn]" class="text-blue-400 hover:text-blue-300" target="_blank">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
    
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>    
    
    
</body>
</html>
