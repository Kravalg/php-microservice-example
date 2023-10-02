<?php

declare(strict_types=1);

namespace App\Geocoding\Application\Find;

use App\Geocoding\Domain\Repository\ResolvedAddressRepositoryInterface;
use App\Shared\Domain\Bus\Query\QueryHandler;

final class FindCoordinatesByAddressQueryHandler implements QueryHandler
{
    public function __construct(
        private ResolvedAddressRepositoryInterface $resolvedAddressRepository,
    ) {
    }

    public function __invoke(FindCoordinatesByAddressQuery $query): FindCoordinatesByAddressResponse
    {
        $resolvedAddress = $this->resolvedAddressRepository->findByAddress($query->address);

        return new FindCoordinatesByAddressResponse($resolvedAddress?->getCoordinates());
    }
}
