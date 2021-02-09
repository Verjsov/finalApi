<?php


namespace App\Services;


use App\Models\Station;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use RuntimeException;

class MetarService implements MetarServiceInterface
{
    public function getWeather(string $icao, int $refreshTime = self::REFRESH_TIME)
    {
        $key = "icao-$icao";
        if (!Cache::get($key)) {
            $request = Http::withOptions([
                'curl'   => array( CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false ),
                'verify' => false
            ])->withHeaders([
                'X-API-Key' => config('checkws.token')
            ])->get('https://api.checkwx.com/metar/'.$icao.'/decoded');

            if (!$request->ok()) {
                throw new RuntimeException('Server error');
            }
            $data = $request->json('data');
            if (!isset($data[0])){
                throw new RuntimeException('Arrow empty');
            }
            Cache::put($key, $data[0], $refreshTime);
            return $data[0];
        }
        return Cache::get($key);
    }

    public function all()
    {
        $stations = Station::all();
        $finaly = [];
        foreach ($stations as $station){
            try {
                $data = $this->getWeather($station->icao);
                $data['favorite'] = $station->favorite;
                $finaly[] = $data;
            }
            catch (RuntimeException $e){

            }
        }
        uasort($finaly,  function($a, $b) {
            if ($a['favorite'] == $b['favorite'])
                return 0;
            return ($a['favorite'] > $b['favorite']) ? -1 : 1;
        });
        return collect($finaly);
    }
}
