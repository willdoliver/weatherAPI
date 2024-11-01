<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    protected $weatherService;
    function __construct() {
        $this->weatherService = new WeatherService();
    }
    public function checkHumidity(Request $request) {
        $rules = [
            'value' => 'required|numeric|between:0,100',
            'lat'   => 'required|numeric|between:-90,90',
            'lon'   => 'required|numeric|between:-180,180',
        ];

        try {
            $validatedData = $request->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return apiResponse(
                false, 
                'Invalid data',
                $e->errors(),
                400
            );
        }

        $userData = [
            'value' => $validatedData['value'],
            'latitude' => $validatedData['lat'],
            'longitude' => $validatedData['lon'],
        ];

        $weatherData = $this->weatherService->getHumidity($userData['latitude'], $userData['longitude']);

        if (isset($weatherData['error'])) {
            return apiResponse(
                false, 
                $weatherData['message'],
                $userData,
                400
            );
        }

        try {
            $message = 'Umidade aceitável';
            $humidityValue = $weatherData['main']['humidity'];
            $userData['umidadeColetada'] = $humidityValue;

            if ($humidityValue > $userData['value']) {
                $city = !empty($weatherData['name']) ? $weatherData['name'] : 'Cidade não encontrada';
                $message = "A umidade atual em {$city} é de {$humidityValue}%, que é maior que o valor informado de {$userData['value']}%.";
            }

            return apiResponse(
                true, 
                $message,
                $userData
            );

        } catch (\Exception $e) {
            return apiResponse(
                false, 
                $e->getMessage() . 'on line: ' . $e->getLine(),
                $userData,
                400
            );
        }
    }

    // TODO: implement
    public function getPressure(Request $request) {

    }
}
