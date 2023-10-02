<?php

declare(strict_types=1);

namespace App\Geocoding\Infrastructure\Geocoder;

use App\Geocoding\Domain\ValueObject\Address;
use App\Geocoding\Domain\ValueObject\Coordinates;

interface GeocoderInterface
{
    public function geocode(Address $address): ?Coordinates;
}
