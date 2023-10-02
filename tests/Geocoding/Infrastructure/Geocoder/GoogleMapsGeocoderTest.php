<?php

declare(strict_types=1);

namespace App\Tests\Geocoding\Infrastructure\Geocoder;

use App\Geocoding\Domain\ValueObject\Address;
use App\Geocoding\Domain\ValueObject\Coordinates;
use App\Geocoding\Infrastructure\Geocoder\GoogleMapsGeocoder;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoogleMapsGeocoderTest extends TestCase
{
    /** @var HttpClientInterface */
    private $httpClient;

    /** @var GoogleMapsGeocoder */
    private $googleMapsGeocoder;

    public function setUp(): void
    {
        $this->httpClient = new MockHttpClient(function (): MockResponse {
            return new MockResponse(
                '{"results":[{"geometry":{"location_type": "ROOFTOP","location":{"lat": "123", "lng": "456"}}}]}'
            );
        });

        $this->googleMapsGeocoder = new GoogleMapsGeocoder($this->httpClient, 'dummy-api-key');
    }

    public function testGeocode(): void
    {
        $address = new Address('White House', 'DC', '20500', 'US');
        $coordinates = $this->googleMapsGeocoder->geocode($address);

        $this->assertInstanceOf(Coordinates::class, $coordinates);
        $this->assertEquals(123.0, $coordinates->lat);
        $this->assertEquals(456.0, $coordinates->lng);
    }
}
