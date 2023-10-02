<?php

declare(strict_types=1);

namespace App\Geocoding\Domain\ValueObject;

readonly class Address
{
    public function __construct(
        public string $countryCode,
        public string $city,
        public string $street,
        public string $postcode
    ) {
    }
}
