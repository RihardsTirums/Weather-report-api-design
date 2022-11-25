<?php declare(strict_types=1);

namespace App;
use App\Models\Location;
use App\Models\Weather;

class ApiClient {

    private string $apiKey;
    private const API_URL = 'https://api.openweathermap.org/';

    public function __construct(string $apiKey) {
        $this->apiKey = $apiKey;
    }

    private function getLocation(string $locationName) : Location {
        $locationRequest = file_get_contents(self::API_URL. "/geo/1.0/direct?q={$locationName}&limit=1&appid={$this->apiKey}");
        $data = json_decode($locationRequest, true);

        return new Location($locationName, $data[0]['lat'] ?? 0, $data[0]['lon'] ?? 0);
    }

    public function getWeather(string $locationName) : Weather {
        $location = $this->getLocation($locationName);
        $weatherRequest = file_get_contents(self::API_URL . "/data/2.5/weather?lat={$location->getLatitude()}&lon={$location->getLongitude()}&appid={$this->apiKey}&units=metric");
        $data = json_decode($weatherRequest, true);

        return new Weather($location->getName(), $data['main']['temp'] ?? 0, $data['main']['humidity'] ?? 0,$data['main']['feels_like'] ?? 0);
    }
}