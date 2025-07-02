<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('AZ_fastlogo.png') }}" type="image/png">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <div class="login-card">
        <!-- Card Header -->
        <div class="card-header">
            <img src="{{ asset('AZ_fastlogo.png') }}" alt="Logo">
            <h1 class="card-title">Login</h1>
        </div>

        <!-- Login Form -->
        <form id="loginForm" method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Field -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label for="password">Mot de Passe</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            
            <!-- Hidden Fields for Geolocation -->
            <input type="hidden" name="longitude" id="longitude">
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="address_name" id="address_name">

            <!-- Submit Button -->
            <button type="submit" class="btn">Login</button>
        </form>

        <!-- Register Link -->
        <p class="register-link">
            Register as a client: <a href="{{ route('client.register.form') }}">Register</a>
        </p>
    </div>

    <!-- Geolocation Script -->
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const longitude = position.coords.longitude;
                    const latitude = position.coords.latitude;

                    // Set the hidden fields with geolocation data
                    document.getElementById('longitude').value = longitude;
                    document.getElementById('latitude').value = latitude;

                    // Get address name using reverse geocoding
                    fetch(`https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json`)
                        .then(response => response.json())
                        .then(data => {
                            const address = data.display_name || "Unknown Address";
                            document.getElementById('address_name').value = address;

                            // Submit the form with all data
                            event.target.submit();
                        })
                        .catch(error => {
                            console.error('Error fetching the address:', error);
                            alert("Could not retrieve the address. Submitting without address.");
                            event.target.submit();
                        });
                }, function(error) {
                    console.error('Error in geolocation:', error);
                    alert("Geolocation failed. Submitting without geolocation data.");
                    event.target.submit();
                });
            } else {
                alert("Geolocation is not supported by this browser.");
                event.target.submit();
            }
        });
    </script>
</body>

</html>