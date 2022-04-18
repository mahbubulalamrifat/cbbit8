<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('common.cpbd-icon')
    <title>CPB-IT Carpool</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/carpool/user/app.css') }}">

    <!-- leaflet css  -->
    
    {{-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script> --}}

    {{-- forsearch --}}
    {{-- <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script> --}}
</head>
<body>
    <div id="app">
        <div v-if="preloader" class="loader">
            <div class="loader-icon">Loading...</div>
        </div>
        <index-component authuser="{{ Auth::user() }}" permission="{{ $roles }}"></index-component>
    </div>
    <script src="{{ asset('js/carpool/user/app.js') }}"></script>
</body>

</html>
