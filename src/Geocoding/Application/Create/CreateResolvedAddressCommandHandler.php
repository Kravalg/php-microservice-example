<?php

declare(strict_types=1);

namespace App\Geocoding\Application\Create;

use App\Geocoding\Domain\Repository\ResolvedAddressRepositoryInterface;
use App\Shared\Domain\Bus\Command\CommandHandler;

final class CreateResolvedAddressCommandHandler implements CommandHandler
{
    public function __construct(
        private ResolvedAddressRepositoryInterface $resolvedAddressRepository
    ) {
    }

    public function __invoke(CreateResolvedAddressCommand $command): void
    {
        $resolvedAddress = $this->resolvedAddressRepository->findByAddress($command->address);

        if (null !== $resolvedAddress) {
            return;
        }

        $this->resolvedAddressRepository->createAndSave($command->address, $command->coordinates);
    }
}
