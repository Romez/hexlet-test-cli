<?php

namespace Php\Package\Tests;

use \PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use \Php\Package\Weather;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class WeatherTest extends TestCase
{
    private $weatherFixture;

    private $locationFixture;

    protected function setUp()
    {
        parent::setUp();

        $this->weatherFixture = file_get_contents('./tests/fixtures/weather-fixture.json');
        $this->locationFixture = file_get_contents('./tests/fixtures/location-fixture.json');
    }

    public function testGetInfoByCity()
    {
        $mock = new MockHandler([
            new Response(200, [], $this->locationFixture),
            new Response(200, [], $this->weatherFixture)
        ]);

        $handler = HandlerStack::create($mock);

        $client = new Client(['handler' => $handler]);

        $weather = new Weather($client);

        $expected = ['temperature' => 8.87];

        $this->assertEquals($expected, $weather->getInfoByCity('berlin'));
    }
}
