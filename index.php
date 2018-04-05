<!DOCTYPE html>
<html>
    <head>
        <link rel="manifest" href="/assets/manifest.json">

        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-title" content="placefinder">
        <link rel="apple-touch-icon" href="/assets/images/icon-152x152.png">

        <meta name="msapplication-TileImage" content="/assets/images/icon-144x144.png">
        <meta name="msapplication-TileColor" content="#2979A6">

        <meta name="theme-color" content="#2979A6">

        <title>Map</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css" integrity="sha384-v2Tw72dyUXeU3y4aM2Y0tBJQkGfplr39mxZqlTBDUZAb9BGoC40+rdFCG0m10lXk" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/fontawesome.css" integrity="sha384-q3jl8XQu1OpdLgGFvNRnPdj5VIlCvgsDQTQB6owSOHWlAurxul7f+JpUOVdAiJ5P" crossorigin="anonymous"> 
        <link rel="stylesheet" href="/assets/css/main.css">
        <link rel="stylesheet" href="/assets/css/loading.css">
    </head>
    <body>
        <div class="loading-container">
            <img src="/assets/images/icon-256x256.png" alt="logo">
            <div class="loader"></div>
        </div>

        <div class="wrapper">
            <div class="nav-wrapper">
                <div id="nav-container" class="nav-container">
                        <input id="pac-input" class="search-bar controls" type="text" placeholder="Søg..">
                    <!-- <div class="switch-map-container">
                        <button class="switch-map-map">KORT</button>
                        <button class="switch-map-satellite active">SATELLIT</button>
                    </div> -->
                    <div class="route-container">
                        <div class="route-button">
                            <i class="fas fa-map-signs"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="map-container">
                <div id="map" class="map"></div>
            </div>
        </div>
        
    <script src="/assets/js/maps.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAIXvRPJF0TRkBrTMoEMkxrCk9gy-7mYCk&libraries=places&callback=initAutocomplete"async defer></script>
    <script>
        jQuery(document).ready(function(){
            jQuery(".loading-container").remove();
        })
    </script>
    </body>
</html>