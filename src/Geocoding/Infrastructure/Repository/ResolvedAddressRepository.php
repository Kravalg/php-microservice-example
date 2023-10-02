<?php

declare(strict_types=1);

namespace App\Geocoding\Infrastructure\Repository;

use App\Geocoding\Domain\Aggregate\ResolvedAddress;
use App\Geocoding\Domain\Repository\ResolvedAddressRepositoryInterface;
use App\Geocoding\Domain\ValueObject\Address;
use App\Geocoding\Domain\ValueObject\Coordinates;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ResolvedAddressRepository extends ServiceEntityRepository implements ResolvedAddressRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResolvedAddress::class);
    }

    public function findByAddress(Address $address): ?ResolvedAddress
    {
        return $this->findOneBy([
            'countryCode' => $address->countryCode,
            'city' => $address->city,
            'street' => $address->street,
            'postcode' => $address->postcode,
        ]);
    }

    public function save(ResolvedAddress $resolvedAddress): void
    {
        $this->getEntityManager()->persist($resolvedAddress);
        $this->getEntityManager()->flush($resolvedAddress);
    }

    public function createAndSave(Address $address, Coordinates $coordinates): ResolvedAddress
    {
        $resolvedAddress = ResolvedAddress::create($address, $coordinates);

        $this->save($resolvedAddress);

        return $resolvedAddress;
    }
}
