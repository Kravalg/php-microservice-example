<?php

declare(strict_types=1);

namespace App\Controller\FindCoordinates;

use App\Geocoding\Domain\Repository\ResolvedAddressRepositoryInterface;
use App\Geocoding\Domain\ValueObject\Address;
use App\Geocoding\Domain\ValueObject\Coordinates;
use App\Geocoding\Infrastructure\Geocoder\Decorator\CacheableGeocoder;
use App\Geocoding\Infrastructure\Geocoder\GoogleMapsGeocoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[AsController]
class GMapsController extends AbstractController
{
    private CacheableGeocoder $geocoder;

    public function __construct(
        ResolvedAddressRepositoryInterface $resolvedAddressRepository,
        GoogleMapsGeocoder $googleMapsGeocoder,
    ) {
        $this->geocoder = new CacheableGeocoder($googleMapsGeocoder, $resolvedAddressRepository);
    }

    public function __invoke(#[MapQueryString] Address $address): ?Coordinates
    {
        $coordinates = $this->geocoder->geocode($address);

        if (null === $coordinates) {
            throw new NotFoundHttpException();
        }

        return $coordinates;
    }
}
