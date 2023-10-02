<?php

declare(strict_types=1);

namespace App\Controller\FindCoordinates;

use App\Geocoding\Application\Create\CreateResolvedAddressCommand;
use App\Geocoding\Application\Find\FindCoordinatesByAddressQuery;
use App\Geocoding\Application\Find\FindCoordinatesByAddressResponse;
use App\Geocoding\Domain\ValueObject\Address;
use App\Geocoding\Domain\ValueObject\Coordinates;
use App\Geocoding\Infrastructure\Geocoder\Strategy\GeocoderContext;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Domain\Bus\Query\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[AsController]
class MainController extends AbstractController
{
    public function __construct(
        private QueryBus $queryBus,
        private CommandBus $commandBus,
        private GeocoderContext $geocoderContext,
    ) {
    }

    public function __invoke(
        #[MapQueryString] Address $address,
    ): ?Coordinates {
        /** @var FindCoordinatesByAddressResponse $response */
        $coordinates = $this->queryBus->ask(
            new FindCoordinatesByAddressQuery($address)
        )?->coordinates;

        if (null === $coordinates) {
            $coordinates = $this->geocoderContext->geocode($address);
        }

        if (null === $coordinates) {
            throw new NotFoundHttpException();
        }

        $this->commandBus->dispatch(new CreateResolvedAddressCommand($address, $coordinates));

        return $coordinates;
    }
}
