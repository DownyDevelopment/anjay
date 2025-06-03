<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    private $apiKey;
    private $baseUrl = 'http://api.weatherapi.com/v1';

    public function __construct()
    {
        $this->apiKey = config('services.weather.key');
    }

    public function getCurrentWeather($city = 'Bandung')
    {
        $response = Http::get("{$this->baseUrl}/current.json", [
            'key' => $this->apiKey,
            'q' => $city,
        ]);

        return $response->json();
    }
} 