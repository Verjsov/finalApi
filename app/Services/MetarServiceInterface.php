<?php


namespace App\Services;


interface MetarServiceInterface
{
    public const REFRESH_TIME = 3600;

    /**
     * Get weather from api service.
     *
     * @param string $icao
     * @param int $refreshTime
     * @return mixed
     */
    public function getWeather(string $icao, int $refreshTime = self::REFRESH_TIME);

    public function all();
}
