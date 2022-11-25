<?php

require_once 'vendor/autoload.php';

use App\ApiClient;
use Carbon\Carbon;

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $route) {
    $route->addRoute('GET', '/weather', '?city');
    $route->addRoute('GET', '/Riga', '?city');

});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo "Error 404 Not Found";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo "Error 405 Method Not Allowed";
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        // ... call $handler with $vars
        [$controller, $method] = $handler;
        (new $controller)->{$method}();
        break;
}


$apiKey = ''; //  <-------- ENTER YOU'RE API KEY

//$chosenLocation = readline('What city you want to check? ');

$apiClient = new ApiClient($apiKey);

//$weather = $apiClient->getWeather($chosenLocation);
//echo "Temperature in {$weather->getLocationName()} is {$weather->getTemperature()}°C (it feels like: {$weather->getTemperatureFeelsLike()}°C) / {$weather->getHumidity()}%\n";

$city = $_GET['city'] ?? 'Riga';
$currentTime = Carbon::now();
?>

<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles/style.css">
    <style>
    </style>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Weather report</title>
</head>
<body>
    <a href="/Riga">Riga</a> | <a href="/Vilnius">Vilnius</a> | <a href="/Tallinn">Tallinn</a> | <a href="/Ondangwa">Ondangwa</a>|
    <a href="/Volochanka">Volochanka</a>

    <form id="search" action="index.php" method="get">
    Search weather by city: <label>
            <input type="text" name="city">
        </label>
        <input type="submit" value="Get Weather"><br>
    <?php
    $currentWeather = $apiClient->getWeather($city);
    if (isset($currentWeather)) {

        echo PHP_EOL;

        echo "Temperature in {$currentWeather->getLocationName()} is 🌡{$currentWeather->getTemperature()}°C🌡 (it feels like: {$currentWeather->getTemperatureFeelsLike()}°C) / 💧{$currentWeather->getHumidity()}%💧 \n";

        if ($currentWeather->getTemperature() <= -1){
            echo '<body class ="winter">';

        }
        if ($currentWeather->getTemperature() >= 1) {
            echo '<body class ="sunny">';
            echo PHP_EOL;
        }
    }
    ?>
        <table>
            <tr>
                <th>
                   Current Time: <?php echo $currentTime ?>
                </th>
            </tr>
        </table>
    </form>
</body>
</html>
