<?php

declare(strict_types=1);

namespace App\Geocoding\Application\Create;

use App\Geocoding\Domain\ValueObject\Address;
use App\Geocoding\Domain\ValueObject\Coordinates;
use App\Shared\Domain\Bus\Command\Command;

readonly class CreateResolvedAddressCommand implements Command
{
    public function __construct(public Address $address, public Coordinates $coordinates)
    {
    }
}
