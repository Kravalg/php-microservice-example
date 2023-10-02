<?php

declare(strict_types=1);

namespace App\Geocoding\Application\Find;

use App\Geocoding\Domain\ValueObject\Coordinates;
use App\Shared\Domain\Bus\Query\Response;

readonly class FindCoordinatesByAddressResponse implements Response
{
    public function __construct(public ?Coordinates $coordinates = null)
    {
    }
}
