<?php

require_once 'vendor/autoload.php';

use App\ApiClient;
use Carbon\Carbon;

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
    <link rel="stylesheet" href="style.css">
    <style>
    </style>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Weather report</title>
</head>
<body>
    <a href="/?city=Riga">Riga</a> | <a href="/?city=Vilnius">Vilnius</a> | <a href="/?city=Tallinn">Tallinn</a> | <a href="/?city=Ondangwa">Ondangwa</a>|
    <a href="/?city=Volochanka">Volochanka</a>

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
