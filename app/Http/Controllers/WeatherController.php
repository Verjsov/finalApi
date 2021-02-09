<?php


namespace App\Http\Controllers;



use App\Models\Station;
use App\Services\MetarServiceInterface;
use Illuminate\Http\Response;

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
            /*
            $data = [
                'city' => $data['station']['name'],
                'temperature' => $data['temperature']['celsius'],
                'code' => $code
            ];
            */
            return response()->json($data);
        } catch (\Exception $exception) {
            return response()->json(
                [
                    'error' => $exception->getMessage()
                ], Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function addFavorite (string $code)
    {
        $station = Station::where('icao',$code)->first();
        $station->favorite = !$station->favorite;
        $station->save();
        return \response()->json(['status'=>'ok'],200);
    }

    public function list()
    {
        $data = $this->metarService->all();
        return view('welcome',compact('data'));
    }
}
