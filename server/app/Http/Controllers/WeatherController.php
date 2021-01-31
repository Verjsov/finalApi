<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function fetch(string $code)
    {
        $request = Http::withOptions([
            'curl'   => array( CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false ),
            'verify' => false
        ])->withHeaders([
            'X-API-Key' => '8fda79a7324c4ccca65fc15896'
        ])->get('https://api.checkwx.com/metar/'.$code.'/decoded');


        $data = $request->json('data')[0];
        $data = [
            'city' => $data['station']['name'],
            'temperature' => $data['temperature']['celsius'],
            'code' => $code
        ];
        return response()->json($data);
    }
}
