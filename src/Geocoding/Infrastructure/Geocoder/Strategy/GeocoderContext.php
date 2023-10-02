<?php

declare(strict_types=1);

namespace App\Geocoding\Infrastructure\Geocoder\Strategy;

use App\Geocoding\Domain\ValueObject\Address;
use App\Geocoding\Domain\ValueObject\Coordinates;
use App\Geocoding\Infrastructure\Geocoder\GeocoderInterface;
use Psr\Log\LoggerInterface;

class GeocoderContext
{
    /**
     * @param GeocoderInterface[] $geocoders
     */
    public function __construct(
        private readonly iterable $geocoders,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function geocode(Address $address): ?Coordinates
    {
        foreach ($this->geocoders as $geocoder) {
            try {
                $coordinates = $geocoder->geocode($address);
            } catch (\Throwable $e) {
                $this->logger->error($e->getMessage());
                continue;
            }

            if (null !== $coordinates) {
                return $coordinates;
            }
        }

        return null;
    }
}
