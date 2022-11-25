<?php declare(strict_types=1);

namespace App\Models;

class Weather
{

    private float $temperature;
    private string $locationName;
    private int $humidity;
    private float $temperatureFeelsLike;

    public function __construct(string $locationName, float $temperature, int $humidity, float $temperatureFeelsLike)
    {

        $this->locationName = $locationName;
        $this->temperature = $temperature;
        $this->humidity = $humidity;
        $this->temperatureFeelsLike = $temperatureFeelsLike;
    }

    public function getTemperature(): float
    {
        return $this->temperature;
    }

    public function getLocationName(): string
    {
        return $this->locationName;
    }

    public function getHumidity(): int
    {
        return $this->humidity;
    }

    public function getTemperatureFeelsLike(): float
    {
        return $this->temperatureFeelsLike;
    }
}