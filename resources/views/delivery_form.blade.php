<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Livraison - AZ</title>
    <link rel="icon" href="<?php echo asset('AZ_fastlogo.png'); ?>" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/delivery_form.css') }}">
</head>
<body>
    <div class="container">
        <?php if (auth()->check()): ?>
            <!-- Header -->
            <header class="main-header">
                <div class="header-container">
                    <!-- Logo -->
                    <a href="/client/dashboard">
                        <img src="{{ asset('AZ_fastlogo.png') }}" alt="Logo" class="logo">
                    </a>

                    <!-- User Menu -->
                    <div class="wallet" onclick="location.href='{{ route('wallet.transaction.form') }}'">
                        <div class="wallet-card">
                            <a href="{{ route('wallet.transaction.form') }}" class="wallet-btn" style="text-decoration: none; font-weight: bold;">
                                <i class="fas fa-wallet"></i> <p class="wallet-amount">{{ number_format(auth()->user()->wallet->balance, 2) }} FCFA</p>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Delivery Form -->
            <div class="delivery-form">
                <h1 class="form-title">Passer une livraison</h1>

                <form action="<?php echo route('orders.store'); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="form-grid">
                        <!-- Sender Section -->
                        <div class="form-section">
                            <h2 class="section-title"><i class="fas fa-user"></i> Expéditeur</h2>

                            <div class="form-group">
                                <label>Nom complet de l'expéditeur</label>
                                <input type="text" name="sender_name" placeholder="ex: EYOUM ATOCK J-J Bryan" required>
                            </div>

                            <div class="form-group">
                                <label>Numéro de téléphone de l'expéditeur</label>
                                <input type="text" name="sender_phone" placeholder="+237" required>
                            </div>

                            <div class="form-group">
                                <label>Pays de l'expéditeur</label>
                                <select id="sender-country" name="sender_country" required>
                                    <option value="">Sélectionnez un pays</option>
                                    <?php foreach ($countries as $country): ?>
                                        <option value="<?php echo $country; ?>"><?php echo $country; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Ville de l'expéditeur</label>
                                <select id="sender-town" name="sender_town" required>
                                    <option value="">Sélectionnez une ville</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Quartier de l'expéditeur</label>
                                <select id="sender-quarter" name="sender_quarter" required>
                                    <option value="">Sélectionnez un quartier</option>
                                </select>
                                <div class="coordinates">
                                    Latitude: <span id="sender-lat">N/A</span> | 
                                    Longitude: <span id="sender-lng">N/A</span>
                                </div>
                            </div>
                        </div>

                        <!-- Receiver Section -->
                        <div class="form-section">
                            <h2 class="section-title"><i class="fas fa-user-friends"></i> Destinataire</h2>

                            <div class="form-group">
                                <label>Nom du destinataire</label>
                                <input type="text" name="receiver_name" placeholder="ex: Isaac Louis Vuiton" required>
                            </div>

                            <div class="form-group">
                                <label>Numéro de téléphone du destinataire</label>
                                <input type="text" name="receiver_phone" placeholder="+237" required>
                            </div>

                            <div class="form-group">
                                <label>Pays du destinataire</label>
                                <select id="receiver-country" name="receiver_country" required>
                                    <option value="">Sélectionnez un pays</option>
                                    <?php foreach ($countries as $country): ?>
                                        <option value="<?php echo $country; ?>"><?php echo $country; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Ville du destinataire</label>
                                <select id="receiver-town" name="receiver_town" required>
                                    <option value="">Sélectionnez une ville</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Quartier du destinataire</label>
                                <select id="receiver-quarter" name="receiver_quarter" required>
                                    <option value="">Sélectionnez un quartier</option>
                                </select>
                                <div class="coordinates">
                                    Latitude: <span id="receiver-lat">N/A</span> | 
                                    Longitude: <span id="receiver-lng">N/A</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Section -->
                    <div class="form-section">
                        <h2 class="section-title"><i class="fas fa-box"></i> Informations sur le produit</h2>
                        <div class="product-card">
                            <h3 class="product-name"><?php echo $product->name; ?></h3>
                            <p class="product-price">Prix: <?php echo $product->price; ?> FCFA</p>
                            <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                            <input type="hidden" name="product_price" value="<?php echo $product->price; ?>">
                            <input type="hidden" name="merchant_id" value="<?php echo $product->merchant_id; ?>">
                            <input type="hidden" name="category_id" value="<?php echo $product->category_id; ?>">
                        </div>
                    </div>

                    <!-- Payment Section -->
                    <div class="form-section">
                        <h2 class="section-title"><i class="fas fa-money-bill-wave"></i> Paiement</h2>

                        <div class="form-group">
                            <label>Prix total:</label>
                            <span class="total-price" id="total_price">0 FCFA</span>
                        </div>

                        <div class="form-group">
                            <label>Numéro de paiement</label>
                            <input type="text" name="payment_number" placeholder="Entrez votre numéro de paiement" required>
                        </div>

                        <div class="form-group">
                            <label>Méthode de paiement</label>
                            <div class="payment-method">
                                <input type="radio" name="payment" value="mtn" id="mtn" required>
                                <label for="mtn">MTN MOBILE MONEY</label>
                            </div>
                            <div class="payment-method">
                                <input type="radio" name="payment" value="orange" id="orange" required>
                                <label for="orange">ORANGE MONEY</label>
                            </div>
                        </div>
                    </div>
<style>
    :root {
            --primary: #4361ee;
            --primary-light: #4895ef;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f8961e;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --gray-light: #e9ecef;
            --green: #2ecc71;
            --blue: #3498db;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f7ff;
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header Styles */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.2);
            margin-bottom: 30px;
            color: white;
            position: relative;
            overflow: hidden;
            animation: fadeInDown 0.8s ease;
        }

        .header::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            transform: rotate(30deg);
        }

        .logo img {
            height: 40px;
            transition: transform 0.3s ease;
        }

        .logo:hover img {
            transform: scale(1.05);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .profile-pic {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .profile-pic:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .user-name {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .logout-btn {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            margin-left: 15px;
        }

        .logout-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }

        .add-profile-link {
            color: white;
            font-size: 0.8rem;
            margin-left: 5px;
            text-decoration: underline;
        }

        /* Wallet Card */
        .wallet-card {
            background: linear-gradient(135deg, var(--green) 0%, #27ae60 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 10px 20px rgba(46, 204, 113, 0.2);
            transition: all 0.3s ease;
            animation: fadeIn 0.8s ease 0.2s both;
            position: relative;
            overflow: hidden;
        }

        .wallet-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(46, 204, 113, 0.3);
        }

        .wallet-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path fill="rgba(255,255,255,0.05)" d="M0,0 L100,0 L100,100 L0,100 Z"></path></svg>');
            background-size: cover;
        }

        .wallet-amount {
            font-size: 12px;
            font-weight: 700;
            margin: 10px 0;
        }

        .wallet-btn {
            background: white;
            color: var(--green);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
            
        }

        .wallet-btn:hover {
            background: rgba(255,255,255,0.9);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* Delivery Form */
        .delivery-form {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            animation: fadeIn 0.8s ease 0.4s both;
        }

        .form-title {
            font-size: 1.8rem;
            margin-bottom: 25px;
            color: var(--dark);
            position: relative;
            padding-bottom: 10px;
        }

        .form-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--primary);
            border-radius: 3px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        @media (min-width: 768px) {
            .form-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .form-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.3rem;
            margin-bottom: 15px;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            font-size: 1.2rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }

        input, select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--gray-light);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .product-card {
            background: linear-gradient(135deg, #f5f7ff 0%, #e8ecff 100%);
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid var(--primary);
        }

        .product-name {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .product-price {
            font-weight: 700;
            color: var(--primary);
            font-size: 1.3rem;
        }

        .payment-method {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .payment-method:hover {
            background: var(--gray-light);
        }

        .payment-method input {
            width: auto;
            margin-right: 10px;
        }

        .total-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--green);
            margin: 15px 0;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
        }

        .submit-btn:active {
            transform: translateY(-1px);
        }

        .coordinates {
            font-size: 0.9rem;
            color: var(--gray);
            margin-top: 5px;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        /* Error Messages */
        .alert-danger {
            background-color: rgba(247, 37, 133, 0.1);
            color: var(--danger);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid var(--danger);
            animation: fadeIn 0.5s ease;
        }

        .alert-danger ul {
            list-style: none;
        }

        .alert-danger li {
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-danger li::before {
            content: '•';
            color: var(--danger);
            font-weight: bold;
        }

        /* Guest Message */
        .guest-message {
            text-align: center;
            padding: 40px 20px;
            animation: fadeIn 0.8s ease;
        }

        .guest-message h1 {
            font-size: 2rem;
            margin-bottom: 15px;
            color: var(--primary);
        }

        .guest-message p {
            font-size: 1.1rem;
            margin-bottom: 20px;
            color: var(--gray);
        }

        .logo {
        height: 80px;
        transition: var(--transition);
    }

    .logo:hover {
        transform: scale(1.05);
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

        @media (max-width: 768px) {

        .header-container {
            padding: 0 15px;
        }

        .user-menu {
            gap: 10px;
        }
    }

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
        padding: 0px 5px;
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
</style>
                    <button type="submit" class="submit-btn">
                        <i class="fas fa-paper-plane"></i> Passer la commande
                    </button>

                    <?php if ($errors->any()): ?>
                        <div class="alert-danger">
                            <ul>
                                <?php foreach ($errors->all() as $error): ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </form>
            </div>

        <?php else: ?>
            <!-- Guest Message -->
            <div class="guest-message">
                <h1>Bienvenue, invité!</h1>
                <p>Veuillez vous connecter pour accéder à votre tableau de bord.</p>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Animation for form sections
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('.form-section');
            sections.forEach((section, index) => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(20px)';
                section.style.transition = `all 0.5s ease ${index * 0.2}s`;
                
                setTimeout(() => {
                    section.style.opacity = '1';
                    section.style.transform = 'translateY(0)';
                }, 100);
            });
        });

        // Calculate distance between two coordinates
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Radius of the Earth in km
            const dLat = (lat2 - lat1) * (Math.PI / 180);
            const dLon = (lon2 - lon1) * (Math.PI / 180);
            const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                      Math.cos(lat1 * (Math.PI / 180)) * Math.cos(lat2 * (Math.PI / 180)) *
                      Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c; // Distance in km
        }

        // Calculate the total price based on distance and product price
        function calculateTotalPrice() {
            const productPrice = parseFloat($('input[name="product_price"]').val());
            const senderLat = parseFloat($('#sender-lat').text());
            const senderLng = parseFloat($('#sender-lng').text());
            const receiverLat = parseFloat($('#receiver-lat').text());
            const receiverLng = parseFloat($('#receiver-lng').text());

            if (!isNaN(senderLat) && !isNaN(senderLng) && !isNaN(receiverLat) && !isNaN(receiverLng)) {
                const distance = calculateDistance(senderLat, senderLng, receiverLat, receiverLng);
                const deliveryCost = Math.ceil(distance) * 450; // 450 FCFA per km
                const totalPrice = productPrice + deliveryCost;

                $('#total_price').text(totalPrice.toFixed(2) + ' FCFA');
                $('.total-price').addClass('pulse');
                setTimeout(() => $('.total-price').removeClass('pulse'), 1000);
            } else {
                $('#total_price').text('N/A');
            }
        }

        // Event listeners to calculate total price when inputs change
        $('#sender-lat, #sender-lng, #receiver-lat, #receiver-lng').on('input', calculateTotalPrice);
        $('input[name="product_price"]').on('change', calculateTotalPrice);

        // Fetch towns when a sender country is selected
        $('#sender-country').on('change', function() {
            var senderCountry = $(this).val();
            $.ajax({
                url: '/get-towns/' + senderCountry,
                type: 'GET',
                success: function(response) {
                    var senderTownSelect = $('#sender-town');
                    senderTownSelect.empty();
                    senderTownSelect.append('<option value="">Sélectionnez une ville</option>');

                    $.each(response.towns, function(index, town) {
                        senderTownSelect.append('<option value="' + town + '">' + town + '</option>');
                    });
                }
            });
        });

        // Fetch quarters when a sender town is selected
        $('#sender-town').on('change', function() {
            var senderTown = $(this).val();
            $.ajax({
                url: '/get-quarters/' + senderTown,
                type: 'GET',
                success: function(response) {
                    var senderQuarterSelect = $('#sender-quarter');
                    senderQuarterSelect.empty();
                    senderQuarterSelect.append('<option value="">Sélectionnez un quartier</option>');

                    $.each(response.quarters, function(index, quarter) {
                        senderQuarterSelect.append('<option value="' + quarter.quarter + '" data-latitude="' + quarter.latitude + '" data-longitude="' + quarter.longitude + '">' + quarter.quarter + '</option>');
                    });
                }
            });
        });

        // Update sender latitude and longitude when the sender quarter is selected
        $('#sender-quarter').on('change', function() {
            const selectedOption = $(this).find(':selected');
            const latitude = selectedOption.data('latitude');
            const longitude = selectedOption.data('longitude');

            if (latitude && longitude) {
                $('#sender-lat').text(latitude);
                $('#sender-lng').text(longitude);
                calculateTotalPrice();
            } else {
                $('#sender-lat').text('N/A');
                $('#sender-lng').text('N/A');
                $('#total_price').text('N/A');
            }
        });

        // Fetch towns when a receiver country is selected
        $('#receiver-country').on('change', function() {
            var receiverCountry = $(this).val();
            $.ajax({
                url: '/get-towns/' + receiverCountry,
                type: 'GET',
                success: function(response) {
                    var receiverTownSelect = $('#receiver-town');
                    receiverTownSelect.empty();
                    receiverTownSelect.append('<option value="">Sélectionnez une ville</option>');

                    $.each(response.towns, function(index, town) {
                        receiverTownSelect.append('<option value="' + town + '">' + town + '</option>');
                    });
                }
            });
        });

        // Fetch quarters when a receiver town is selected
        $('#receiver-town').on('change', function() {
            var receiverTown = $(this).val();
            $.ajax({
                url: '/get-quarters/' + receiverTown,
                type: 'GET',
                success: function(response) {
                    var receiverQuarterSelect = $('#receiver-quarter');
                    receiverQuarterSelect.empty().append('<option value="">Sélectionnez un quartier</option>');

                    $.each(response.quarters, function(index, quarter) {
                        receiverQuarterSelect.append('<option value="' + quarter.quarter + '" data-latitude="' + quarter.latitude + '" data-longitude="' + quarter.longitude + '">' + quarter.quarter + '</option>');
                    });
                },
                error: function() {
                    console.error('Error fetching quarters.');
                }
            });
        });

        // Update receiver latitude and longitude when the receiver quarter is selected
        $('#receiver-quarter').on('change', function() {
            const selectedOption = $(this).find(':selected');
            const latitude = selectedOption.data('latitude');
            const longitude = selectedOption.data('longitude');

            if (latitude && longitude) {
                $('#receiver-lat').text(latitude);
                $('#receiver-lng').text(longitude);
                calculateTotalPrice();
            } else {
                $('#receiver-lat').text('N/A');
                $('#receiver-lng').text('N/A');
                $('#total_price').text('N/A');
            }
        });
    </script>
</body>
</html>
