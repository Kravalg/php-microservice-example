<?php

declare(strict_types=1);

namespace App\Geocoding\Infrastructure\Geocoder;

use App\Geocoding\Domain\ValueObject\Address;
use App\Geocoding\Domain\ValueObject\Coordinates;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoogleMapsGeocoder implements GeocoderInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        #[Autowire('%env(GOOGLE_GEOCODING_API_KEY)%')]
        private readonly string $apiKey,
    ) {
    }

    public function geocode(Address $address): ?Coordinates
    {
        $data = $this->findData($address);

        if (0 === count($data['results'])) {
            return null;
        }

        $firstResult = $data['results'][0];

        if ('ROOFTOP' !== $firstResult['geometry']['location_type']) {
            return null;
        }

        $location = $firstResult['geometry']['location'];

        return new Coordinates((float) $location['lat'], (float) $location['lng']);
    }

    private function findData(Address $address): array
    {
        $params = [
            'query' => [
                'address' => $address->street,
                'components' => $this->buildComponentsForQuery($address),
                'key' => $this->apiKey,
            ],
            'timeout' => 1, // avoid network issues
        ];

        $response = $this->httpClient->request(
            'GET',
            'https://maps.googleapis.com/maps/api/geocode/json',
            $params
        );

        return $response->toArray();
    }

    private function buildComponentsForQuery(Address $address): string
    {
        $components = [
            "country:{$address->countryCode}",
            "locality:{$address->city}",
            "postal_code:{$address->postcode}",
        ];

        return implode('|', $components);
    }
}
