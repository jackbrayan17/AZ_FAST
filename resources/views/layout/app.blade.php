<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('AZ_fastlogo.png') }}" type="image/png">
    <title>@yield('title', 'EEUEZ Market')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        :root {
            --primary: #059669;
            --primary-dark: #047857;
            --secondary: #1e40af;
            --accent: #f59e0b;
            --text: #374151;
            --light: #f9fafb;
            --dark: #1f2937;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
            padding-bottom: 60px; /* Space for mobile navbar */
        }

        /* Mobile Bottom Navigation */
        .mobile-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
            z-index: 1000;
            display: none; /* Hidden by default, shown on mobile */
        }

        .mobile-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: var(--text);
            font-size: 12px;
            transition: var(--transition);
        }

        .mobile-nav-item i {
            font-size: 20px;
            margin-bottom: 4px;
        }

        .mobile-nav-item.active {
            color: var(--primary);
        }

        .mobile-nav-item:hover {
            color: var(--primary);
        }

        /* Footer */
        footer {
            background: var(--dark);
            color: white;
            padding: 30px 0;
            margin-top: 40px;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
        }

        .footer-section h3 {
            font-size: 18px;
            margin-bottom: 15px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-section h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background: var(--primary);
        }

        .footer-section p, .footer-section a {
            margin-bottom: 10px;
            display: block;
            color: #d1d5db;
            transition: var(--transition);
        }

        .footer-section a:hover {
            color: white;
            transform: translateX(5px);
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .social-links a {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .social-links a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            padding-top: 20px;
            margin-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .mobile-nav {
                display: flex;
                align-items: center;
            }

            footer {
                padding-bottom: 70px; /* Account for mobile nav */
                /* height: 100px; */
            }
        }
        .main-header {
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 15px 0;
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .header-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .logo {
        height: 80px;
        transition: var(--transition);
    }

    .logo:hover {
        transform: scale(1.05);
    }

    .user-menu {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .profile-img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--primary);
        transition: var(--transition);
    }

    .profile-img:hover {
        transform: scale(1.1);
        box-shadow: 0 0 10px rgba(5, 150, 105, 0.3);
    }

    .logout-btn {
        background: none;
        border: none;
        color: var(--text);
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .logout-btn:hover {
        color: #ef4444;
    }

    /* Wallet Card */
    .wallet{
        width: 100%;
        display: flex;
        justify-content: end;
    }
    .wallet-card {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        border-radius: 20px;
        padding: 3px;
        color: white;
        margin: 0px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
        transition: var(--transition);
    }

    .wallet-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .wallet-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
        transform: rotate(30deg);
    }

    .wallet-btn {
        background: white;
        color: var(--primary);
        border: none;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .wallet-btn:hover {
        background: rgba(255, 255, 255, 0.9);
        transform: translateY(-2px);
    }

    /* Products Grid */
    .products-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .products-title {
        font-size: 28px;
        font-weight: 700;
        margin: 30px 0 20px;
        position: relative;
        display: inline-block;
    }

    .products-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 50px;
        height: 3px;
        background: var(--primary);
    }

    .products-grid {
        display: flex;
        
        margin-bottom: 80px;
    }

    .product-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: var(--transition);
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .product-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: var(--accent);
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }

    .product-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-bottom: 1px solid #eee;
    }

    .product-details {
        padding: 15px;
    }

    .product-name {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-price {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary);
        margin: 10px 0;
    }

    .product-btn {
        width: 100%;
        padding: 10px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .product-btn:hover {
        background: var(--primary-dark);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .product-image {
            height: 150px;
        }

        .header-container {
            padding: 0 15px;
        }

        .user-menu {
            gap: 10px;
        }
    }

    @media (max-width: 480px) {
        .products-grid {
            grid-template-columns: 1fr;
        }

        .product-card {
            max-width: 100%;
        }
    }
    </style>
    @yield('styles')
</head>
<body>
    <main>
        @yield('content')
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>EEUEZ Market</h3>
                <p>La meilleure plateforme d'achat et de vente en ligne.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Liens rapides</h3>
                <a href="/">Accueil</a>
                <a href="/products">Produits</a>
                <a href="/about">À propos</a>
                <a href="/contact">Contact</a>
            </div>
            <div class="footer-section">
                <h3>Contact</h3>
                <p><i class="fas fa-envelope mr-2"></i> contact@eeuezmarket.com</p>
                <p><i class="fas fa-phone mr-2"></i> +237 657 757 036</p>
            </div>
        </div>
        <div class="copyright">
            ©2025 EEUEZ Market. Tous droits réservés.
        </div>
    </footer>

    <!-- Mobile Bottom Navigation -->
    <nav class="mobile-nav">
        <a href="/" class="mobile-nav-item">
            <i class="fas fa-home"></i>
            <span>Accueil</span>
        </a>
        <a href="/products" class="mobile-nav-item">
            <i class="fas fa-shopping-bag"></i>
            <span>Boutique</span>
        </a>
        <a href="/cart" class="mobile-nav-item">
            <i class="fas fa-shopping-cart"></i>
            <span>Panier</span>
        </a>
        
            <div class="user-menu">
                @if (auth()->check() && auth()->user()->profileImage)
    <a href="{{ route('profile.edit') }}">
        <img style="height: 40px;transition: transform 0.3s ease;border-radius:50%"  src="{{ asset('storage/' . auth()->user()->profileImage->image_path) }}" alt="Profile" class="profile-img">
    </a>
@elseif (auth()->check())
    <a href="{{ route('profile.edit') }}">
        <img style="height: 40px;transition: transform 0.3s ease;border-radius:50%" src="{{ asset('jblogo.png') }}" alt="Profile" class="profile-img">
    </a>
@endif

            </div>

        
    </nav>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    @yield('scripts')
</body>
</html>
