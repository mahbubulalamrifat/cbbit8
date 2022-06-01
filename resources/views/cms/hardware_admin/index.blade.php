<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <meta http-equiv='expires' content='-1'>
    @include('common.cpbd-icon')
    <title>CPB-IT Hardware Admin</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('css/cms/admin_hardware/app.css') }}">
</head>
<body>
    <div id="app">
        <div v-if="preloader" class="loader">
            <div class="loader-icon">Loading...</div>
        </div>
        <index-component authuser="{{ Auth::user() }}" permission="{{ $roles }}" ></index-component>
    </div>
    <script src="{{ mix('js/cms/admin_hardware/app.js') }}"></script>
</body>

</html>
