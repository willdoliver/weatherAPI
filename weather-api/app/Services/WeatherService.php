<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.weather_api.url');
        $this->apiKey = config('services.weather_api.key');
    }

    public function getHumidity($lat, $lon)
    {
        $response = Http::get($this->baseUrl, [
            'lat' => $lat,
            'lon' => $lon,
            'appid' => $this->apiKey,
        ]);

        if ($response->successful()) {
            return $response->json();
        } else {
            return [
                'error' => true,
                'message' => 'Falha ao consultar dados da API externa',
            ];
        }
    }
}
