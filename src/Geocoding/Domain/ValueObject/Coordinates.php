<?php

declare(strict_types=1);

namespace App\Geocoding\Domain\ValueObject;

readonly class Coordinates
{
    public function __construct(
        public float $lat,
        public float $lng,
    ) {
    }
}
