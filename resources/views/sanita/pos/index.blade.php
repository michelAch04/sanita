@extends('sanita.layout')

@section('content')
<div class="container my-4">
    <h2 class="display-5 text-center mb-2 mb-md-4 section-title px-1">{{ __('nav.pos_title') }}</h2>
    <div id="map" class="rounded shadow px-4"></div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>
    #map {
        width: 100%;
        /* full width */
        height: 60vh;
        /* 60% of viewport height for desktop */
        min-height: 500px;
        /* fallback for very small screens */
    }

    @media (max-width: 768px) {
        /* tablets */
        #map {
            height: 50vh;
        }
    }

    @media (max-width: 480px) {
        /* mobile */
        #map {
            height: 40vh;
        }
    }
</style>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const map = L.map('map').setView(['{{ $defaultLat }}', '{{ $defaultLng }}'], '{{ $zoom }}');

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const locations = @json($locations);

        locations.forEach(location => {
            L.marker([location.latitude, location.longitude])
                .addTo(map)
                .bindPopup(`<strong>${location.name}</strong><br>${location.address}`);
        });
    });
</script>
@endsection