<?php

declare(strict_types=1);

namespace App\Geocoding\Domain\Aggregate;

use App\Geocoding\Domain\ValueObject\Address;
use App\Geocoding\Domain\ValueObject\Coordinates;
use App\Shared\Domain\Aggregate\AggregateRoot;

class ResolvedAddress extends AggregateRoot
{
    public function __construct(
        private ?int $id = null,
        private ?string $countryCode = null,
        private ?string $city = null,
        private ?string $street = null,
        private ?string $postcode = null,
        private ?string $lat = null,
        private ?string $lng = null
    ) {
    }

    public static function create(Address $address, ?Coordinates $coordinates): self
    {
        $resolvedAddress = new self();
        $resolvedAddress
            ->setCountryCode($address->countryCode)
            ->setCity($address->city)
            ->setStreet($address->street)
            ->setPostcode($address->postcode);

        if (null !== $coordinates) {
            $resolvedAddress
                ->setLat((string) $coordinates->lat)
                ->setLng((string) $coordinates->lng);
        }

        return $resolvedAddress;
    }

    public function getId(): int
    {
        if (null === $this->id) {
            throw new \DomainException("You need save entity before accessing it's id");
        }

        return $this->id;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(string $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(?string $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?string
    {
        return $this->lng;
    }

    public function setLng(?string $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    public function getCoordinates(): ?Coordinates
    {
        if (null !== $this->getLat() && null !== $this->getLng()) {
            return new Coordinates(
                (float) $this->getLat(),
                (float) $this->getLng()
            );
        }
    }
}
