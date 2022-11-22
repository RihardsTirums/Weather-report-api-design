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
    <style>

        body {
            background-image: url("weather.jpg");
            background-repeat: no-repeat;
            background-size: 100% 100%;
        }
        html {
            height: 100%;
        }
        text {
            font-weight: bold;
            font-size: 13px;
        }
        .winter {
            background-image: url("winter.jpg");
        }

        .sunny {
            background-image: url("sunny.png");
        }

        a {
            box-shadow: inset 0 0 0 0 #cc0533;
            color: #15090b;
            margin: 0 -.25rem;
            padding: 0 .25rem;
            transition: color .3s ease-in-out, box-shadow .3s ease-in-out;
            font-size: 20px;


        }
        a:hover {
            box-shadow: inset 100px 0 0 0 #a6021b;
            color: black;
        }
        #search{
            padding-top: 0.8%;
        }
        table{
            position: absolute;
            right: 0;
            top: 0;
            font-size: 30px;
            font-family: Ani, serif;

        }

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
    $currentWeather = $weather = $apiClient->getWeather($city);
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
