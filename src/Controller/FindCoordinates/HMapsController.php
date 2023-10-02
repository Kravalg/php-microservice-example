<?php

declare(strict_types=1);

namespace App\Controller\FindCoordinates;

use App\Geocoding\Domain\ValueObject\Address;
use App\Geocoding\Domain\ValueObject\Coordinates;
use App\Geocoding\Infrastructure\Geocoder\HereMapsGeocoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[AsController]
class HMapsController extends AbstractController
{
    public function __construct(
        private HereMapsGeocoder $geocoder,
    ) {
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
