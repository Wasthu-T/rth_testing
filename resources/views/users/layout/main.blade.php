<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/map.css">
    <link rel="stylesheet" href="/css/dashboard.css">
    <link rel="stylesheet" href="/css/progress.css">
    <link href="/css/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/pagination.css">
    <link rel="icon" type="image/x-icon" href="/img/logo/simpel-rth-light-removebg-preview (1).png" />
  
    <title>RTH | {{ucfirst(request() -> segment(1))}}</title>
</head>

<body>
    <style>
        .nav {
            --bs-nav-link-color: white;
            --bs-nav-link-hover-color: black;
            display: block;
        }

        @media (min-width: 768px) {
            .nav {
                height: 100vh;
                position: fixed;
            }
        }
    </style>
    @include('users.partials.navbar')

    <div class="col-md-3 col-lg-2">

    </div>
    <div class="col col-md-9 col-lg-10 mt-5">

        @yield('container-user')
    </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    @yield('scripts')
</body>

</html>