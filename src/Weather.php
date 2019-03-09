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

        ['woeid' => $woeid] = json_decode($locationResp->getBody()->getContents(), true)[0];

        $weatherResp = $this->client->request('GET', 'api/location/' . $woeid);

        ['the_temp' => $temperature] = json_decode($weatherResp->getBody()->getContents(), true)['consolidated_weather'][0];

        return compact('temperature');
    }
}
