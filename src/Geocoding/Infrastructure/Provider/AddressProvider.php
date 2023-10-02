<?php

declare(strict_types=1);

namespace App\Geocoding\Infrastructure\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Geocoding\Domain\ValueObject\Address;

final class AddressProvider implements ProviderInterface
{
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return new Address(
            $uriVariables['countryCode'] ?? '',
            $uriVariables['city'] ?? '',
            $uriVariables['street'] ?? '',
            $uriVariables['postcode'] ?? '',
        );
    }
}
