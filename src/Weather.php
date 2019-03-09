<?php

namespace Php\Package;

use GuzzleHttp\Client;

class Weather
{
    private $client;

    public function __construct(Client $client = null)
    {
        if (is_null($client)) {
            $client = new Client(['base_uri' => 'https://www.metaweather.com']);
        }

        $this->client = $client;
    }

    public function getInfoByCity(string $city): array
    {
        $locationResp = $this->client->request('GET', 'api/location/search', ['
            query' => ['query' => $city]
        ]);
        $locationData = json_decode($locationResp->getBody()->getContents(), true);
        ['woeid' => $woeid] = $locationData[0];

        $weatherResp = $this->client->request('GET', 'api/location/' . $woeid);
        $weatherData = json_decode($weatherResp->getBody()->getContents(), true);
        ['the_temp' => $temperature] = $weatherData['consolidated_weather'][0];

        return compact('temperature');
    }
}
