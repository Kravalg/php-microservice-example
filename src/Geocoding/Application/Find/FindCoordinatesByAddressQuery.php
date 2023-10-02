<?php

declare(strict_types=1);

namespace App\Geocoding\Application\Find;

use App\Geocoding\Domain\ValueObject\Address;
use App\Shared\Domain\Bus\Query\Query;

readonly class FindCoordinatesByAddressQuery implements Query
{
    public function __construct(public Address $address)
    {
    }
}
