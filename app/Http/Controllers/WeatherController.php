<?php


namespace App\Http\Controllers;


use App\Services\MetarServiceInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    private $metarService;

    public function __construct(MetarServiceInterface $metarService)
    {
        $this->metarService = $metarService;
    }

    public function fetch(string $code)
    {
        try {
            $data = $this->metarService->getWeather($code);

            $data = [
                'city' => $data['station']['name'],
                'temperature' => $data['temperature']['celsius'],
                'code' => $code
            ];
            return response()->json($data);
        } catch (\Exception $exception) {
            return response()->json(
                [
                    'error' => $exception->getMessage()
                ], Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function list()
    {
        $data = $this->metarService->all();
        return \response()->json($data);
    }
}
