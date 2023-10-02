<?php

declare(strict_types=1);

namespace App\Geocoding\Infrastructure\Geocoder\Decorator;

use App\Geocoding\Domain\Repository\ResolvedAddressRepositoryInterface;
use App\Geocoding\Domain\ValueObject\Address;
use App\Geocoding\Domain\ValueObject\Coordinates;
use App\Geocoding\Infrastructure\Geocoder\GeocoderInterface;
use Symfony\Component\DependencyInjection\Attribute\Exclude;

#[Exclude]
class CacheableGeocoder implements GeocoderInterface
{
    public function __construct(
        private readonly GeocoderInterface $geocoder,
        private readonly ResolvedAddressRepositoryInterface $resolvedAddressRepository,
    ) {
    }

    public function geocode(Address $address): ?Coordinates
    {
        $resolvedAddress = $this->resolvedAddressRepository->findByAddress($address);

        if (null !== $resolvedAddress?->getCoordinates()) {
            return $resolvedAddress->getCoordinates();
        }

        $coordinates = $this->geocoder->geocode($address);

        if (null === $coordinates) {
            return null;
        }

        if (null === $resolvedAddress) {
            $this->resolvedAddressRepository->createAndSave($address, $coordinates);
        }

        return $coordinates;
    }
}
