<?php

namespace Php\Package;

use GuzzleHttp\Client;

class Weather
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getInfoByCity(string $city): array
    {
        $locationResp = $this->client->request('GET', 'api/location/search', ['query' => ['query' => $city]]);
        $locationData = json_decode($locationResp->getBody()->getContents(), true);
        ['woeid' => $woeid] = $locationData[0];

        $weatherResp = $this->client->request('GET', 'api/location/' . $woeid);
        $weatherData = json_decode($weatherResp->getBody()->getContents(), true);
        ['the_temp' => $temperature] = $weatherData['consolidated_weather'][0];

        return compact('temperature');
    }
}
