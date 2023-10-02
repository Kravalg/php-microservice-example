<?php

declare(strict_types=1);

namespace App\Tests\Geocoding\Infrastructure\Geocoder;

use App\Geocoding\Domain\ValueObject\Address;
use App\Geocoding\Domain\ValueObject\Coordinates;
use App\Geocoding\Infrastructure\Geocoder\HereMapsGeocoder;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class HereMapsGeocoderTest extends TestCase
{
    public function testGeocode(): void
    {
        $address = new Address('DE', 'Berlin', 'Test street', '12345');
        $client = $this->createMock(HttpClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);
        $response->method('toArray')->willReturn([
            'items' => [
                [
                    'resultType' => 'houseNumber',
                    'position' => [
                        'lat' => '12.123456',
                        'lng' => '13.123456',
                    ],
                ],
            ],
        ]);
        $client->method('request')->willReturn($response);

        $geocoder = new HereMapsGeocoder($client, 'test-api-key');

        $expectedCoordinates = new Coordinates(12.123456, 13.123456);

        $this->assertEquals($expectedCoordinates, $geocoder->geocode($address));
    }
}
