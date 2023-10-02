<?php

declare(strict_types=1);

namespace App\Geocoding\Domain\Repository;

use App\Geocoding\Domain\Aggregate\ResolvedAddress;
use App\Geocoding\Domain\ValueObject\Address;
use App\Geocoding\Domain\ValueObject\Coordinates;

/**
 * @method ResolvedAddress|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResolvedAddress|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResolvedAddress[]    findAll()
 * @method ResolvedAddress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface ResolvedAddressRepositoryInterface
{
    public function findByAddress(Address $address): ?ResolvedAddress;

    public function save(ResolvedAddress $resolvedAddress): void;

    public function createAndSave(Address $address, Coordinates $coordinates): ResolvedAddress;
}
