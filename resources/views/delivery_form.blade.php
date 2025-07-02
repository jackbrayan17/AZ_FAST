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