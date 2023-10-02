<?php

declare(strict_types=1);

namespace App\Tests\Geocoding\Infrastructure\Geocoder\Strategy;

use App\Geocoding\Domain\ValueObject\Address;
use App\Geocoding\Domain\ValueObject\Coordinates;
use App\Geocoding\Infrastructure\Geocoder\GeocoderInterface;
use App\Geocoding\Infrastructure\Geocoder\Strategy\GeocoderContext;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class GeocoderContextTest extends TestCase
{
    private $logger;

    protected function setUp(): void
    {
        $this->logger = $this->createMock(LoggerInterface::class);
    }

    public function testGeocodeReturnsCoordinates(): void
    {
        $geocoderFails = $this->createMock(GeocoderInterface::class);
        $geocoderFails->method('geocode')->willReturn(null);
        $geocoderSuccess = $this->createMock(GeocoderInterface::class);
        $geocoderSuccess->method('geocode')->willReturn(new Coordinates(50.85045, 4.34878));

        $geocoders = [$geocoderFails, $geocoderSuccess];
        $geocoderContext = new GeocoderContext($geocoders, $this->logger);

        $address = new Address('pl', 'Warsaw', 'Optykow 05', '04175');

        $this->assertInstanceOf(Coordinates::class, $geocoderContext->geocode($address));
    }

    public function testGeocodeReturnsNull(): void
    {
        $geocoderFails = $this->createMock(GeocoderInterface::class);
        $geocoderFails->method('geocode')->willReturn(null);

        $geocoders = [$geocoderFails];
        $geocoderContext = new GeocoderContext($geocoders, $this->logger);

        $address = new Address('pl', 'Warsaw', 'Optykow 05', '04175');

        $this->assertNull($geocoderContext->geocode($address));
    }
}
