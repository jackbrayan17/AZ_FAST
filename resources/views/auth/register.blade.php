<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <form id="registerForm" action="{{ route('register.post') }}" method="POST">
        @csrf
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>
    
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
    
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
    
        <label for="password_confirmation">Confirm Password:</label><br>
        <input type="password" id="password_confirmation" name="password_confirmation" required><br><br>
    
        <!-- Address Fields -->
        <label for="town">Town:</label><br>
        <input type="text" id="town" name="town" required readonly><br><br>
    
        <label for="quarter">Quarter:</label><br>
        <input type="text" id="quarter" name="quarter" required readonly><br><br>
    
        <label for="fees">Delivery Fees:</label><br>
        <input type="number" id="fees" name="fees" value="0"><br><br>
    
        <input type="hidden" id="longitude" name="longitude">
        <input type="hidden" id="latitude" name="latitude">
    
        <button type="button" onclick="getLocation()">Locate Me</button><br><br>
    
        <button type="submit">Register</button>
    </form>
    
    <script>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }
    
    function showPosition(position) {
        document.getElementById('longitude').value = position.coords.longitude;
        document.getElementById('latitude').value = position.coords.latitude;
    
        // Use Google Maps Geocoding API to get the town and quarter
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;
    
        fetch(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=YOUR_API_KEY`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'OK') {
                    const addressComponents = data.results[0].address_components;
                    let town = '';
                    let quarter = '';
    
                    addressComponents.forEach(component => {
                        if (component.types.includes('locality')) {
                            town = component.long_name;
                        }
                        if (component.types.includes('sublocality_level_1')) {
                            quarter = component.long_name;
                        }
                    });
    
                    document.getElementById('town').value = town;
                    document.getElementById('quarter').value = quarter;
    
                    alert('Location detected: ' + town + ', ' + quarter);
                } else {
                    alert('Geocode was not successful for the following reason: ' + data.status);
                }
            })
            .catch(error => {
                console.error('Error fetching the address:', error);
                alert('Failed to retrieve address information.');
            });
    }
    
    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                alert("User denied the request for Geolocation.");
                break;
            case error.POSITION_UNAVAILABLE:
                alert("Location information is unavailable.");
                break;
            case error.TIMEOUT:
                alert("The request to get user location timed out.");
                break;
            case error.UNKNOWN_ERROR:
                alert("An unknown error occurred.");
                break;
        }
    }
    </script>
    
    <a href="/login">Log In</a>
</body>
</html>
