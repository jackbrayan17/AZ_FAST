@extends('layout.app')

@section('content')
@if (auth()->check())
<header class="flex items-center justify-between bg-gray-100 p-4 rounded-lg shadow mb-6">
    <!-- AZ Logo on the Left -->
    <div class="flex items-center">
        <a href="/courier/dashboard"> 
            <img src="{{ asset('AZ_fastlogo.png') }}" alt="Logo" class="h-10 w-auto mr-4">
        </a>
    </div>

    <!-- User Info and Logout on the Right -->
    <div class="flex items-center ml-auto">
        @if (auth()->user()->profileImage)
            <img src="{{ asset('storage/' . auth()->user()->profileImage->image_path) }}" alt="Profile Image" class="w-10 h-10 rounded-full">
        @else
            <img src="{{ asset('jblogo.png') }}" alt="Default Profile Image" class="w-10 h-10 rounded-full">
            <a href="{{ route('profile.edit') }}" class="text-blue-500 ml-2">Add profile</a>
        @endif

        <div class="ml-2">
            <h1 class="text-3xl font-bold">{{ auth()->user()->name }}!</h1>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="ml-4">
            @csrf
            <button type="submit" class="text-red-500 hover:text-red-700">Déconnexion</button>
        </form>
    </div>
</header>
@endif

<div id="map" style="height: 500px;"></div>

{{-- <div id="courier-info" class="mt-4">
    <h2>Courier Position</h2>
    <p id="address-name">Address: N/A</p>
    <p id="coordinates">Coordinates: N/A</p>
    <p id="distance-info">Distance: N/A</p>
</div> --}}

<!-- Include Leaflet.js and its styles -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<script>
    const apiKey = '5b3ce3597851110001cf6248c656d902329a4797a48fa15e350c1834';
    let senderCoordinates = [{{ $senderLatitude }}, {{ $senderLongitude }}];
    let receiverCoordinates = [{{ $receiverLatitude }}, {{ $receiverLongitude }}];
    let courierCoordinates = [0, 0]; 
    let routeLine;
    const map = L.map('map').setView(senderCoordinates, 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    const senderMarker = L.marker(senderCoordinates).addTo(map).bindPopup('Sender');
    const receiverMarker = L.marker(receiverCoordinates).addTo(map).bindPopup('Receiver');
    const courierMarker = L.marker(courierCoordinates).addTo(map).bindPopup('Courier');

    function saveCourierLocation(latitude, longitude) {
        fetch(`/courier/location`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}', 
            },
            body: JSON.stringify({
                courier_id: {{ auth()->user()->id }},
                latitude: latitude,
                longitude: longitude,
            }),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
        })
        .catch(err => console.error('Error saving location:', err));
    }

    function getCurrentLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    courierCoordinates = [position.coords.latitude, position.coords.longitude];
                    courierMarker.setLatLng(courierCoordinates);
                    map.panTo(courierCoordinates);

                    updateCourierInfo(courierCoordinates[0], courierCoordinates[1]);
                    saveCourierLocation(courierCoordinates[0], courierCoordinates[1]); 
                },
                error => {
                    console.error('Error fetching location:', error);
                    alert('Unable to fetch courier location');
                }
            );
        } else {
            console.error('Geolocation is not supported by this browser.');
        }
    }

    function updateCourierInfo(latitude, longitude) {
        document.getElementById('coordinates').innerText = `Coordinates: ${latitude}, ${longitude}`;
        fetch(`https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('address-name').innerText = `Address: ${data.display_name || 'N/A'}`;
            })
            .catch(err => console.error('Error fetching address:', err));
    }

    function fetchRouteAndDisplayDistance(targetCoordinates, targetName) {
        if (routeLine) {
            map.removeLayer(routeLine); 
        }
        
        const courierLatLng = `${courierCoordinates[1]},${courierCoordinates[0]}`;
        const targetLatLng = `${targetCoordinates[1]},${targetCoordinates[0]}`;

        console.log(`Fetching route from ${courierLatLng} to ${targetLatLng}`);

        fetch(`https://api.openrouteservice.org/v2/directions/driving-car?api_key=${apiKey}&start=${courierLatLng}&end=${targetLatLng}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Fetch error: ${response.status} ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Route data:', data);
                if (data.routes && data.routes.length > 0) {
                    const route = data.routes[0];
                    routeLine = L.polyline(route.geometry.coordinates.map(coord => [coord[1], coord[0]]), { color: 'blue' }).addTo(map);
                    const distance = route.summary.distance / 1000; 
                    const popupContent = `${targetName}<br>Distance: ${distance.toFixed(2)} km`;
                    receiverMarker.bindPopup(popupContent).openPopup();
                } else {
                    console.error('No routes found:', data);
                }
            })
            .catch(err => console.error('Error fetching route data:', err));
    }

    senderMarker.on('click', () => fetchRouteAndDisplayDistance(senderCoordinates, 'Sender'));
    receiverMarker.on('click', () => fetchRouteAndDisplayDistance(receiverCoordinates, 'Receiver'));

    getCurrentLocation();
    setInterval(getCurrentLocation, 5000);
</script>
@endsection
