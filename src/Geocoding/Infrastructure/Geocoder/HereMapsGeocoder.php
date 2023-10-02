<?php

declare(strict_types=1);

namespace App\Geocoding\Infrastructure\Geocoder;

use App\Geocoding\Domain\ValueObject\Address;
use App\Geocoding\Domain\ValueObject\Coordinates;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HereMapsGeocoder implements GeocoderInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        #[Autowire('%env(HEREMAPS_GEOCODING_API_KEY)%')]
        private readonly string $apiKey,
    ) {
    }

    public function geocode(Address $address): ?Coordinates
    {
        $data = $this->findData($address);

        if (0 === count($data['items'])) {
            return null;
        }

        $firstItem = $data['items'][0];

        if ('houseNumber' !== $firstItem['resultType']) {
            return null;
        }

        $location = $firstItem['position'];

        return new Coordinates((float) $location['lat'], (float) $location['lng']);
    }

    private function findData(Address $address): array
    {
        $params = [
            'query' => [
                'qq' => $this->buildComponentsForQuery($address),
                'apiKey' => $this->apiKey,
            ],
            'timeout' => 1, // avoid network issues
        ];

        $response = $this->httpClient->request(
            'GET',
            'https://geocode.search.hereapi.com/v1/geocode',
            $params
        );

        return $response->toArray();
    }

    private function buildComponentsForQuery(Address $address): string
    {
        $components = [
            "country={$address->countryCode}",
            "city={$address->city}",
            "street={$address->street}",
            "postalCode={$address->postcode}",
        ];

        return implode(';', $components);
    }
}
