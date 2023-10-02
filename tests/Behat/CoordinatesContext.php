<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

final class CoordinatesContext implements Context
{
    public function __construct(
        private readonly KernelInterface $kernel,
        private ?Response $response
    ) {
    }

    /**
     * @When user sends a request to :path
     */
    public function userSendsARequestTo(string $path): void
    {
        $this->response = $this->kernel->handle(Request::create(
            $path,
            'GET',
            [],
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        ));
    }

    /**
     * @Then the response should be received and valid with lat: :lat, lng: :lng
     */
    public function theResponseShouldBeReceivedAndValid(string $lat, string $lng): void
    {
        if (null === $this->response) {
            throw new \RuntimeException('No response received');
        }

        if (Response::HTTP_OK !== $this->response->getStatusCode()) {
            throw new \RuntimeException('Response status code is not 200');
        }

        $data = json_decode($this->response->getContent(), true);

        if ((float) $lat !== $data['lat']) {
            throw new \RuntimeException('Response value "lat" is not valid');
        }

        if ((float) $lng !== $data['lng']) {
            throw new \RuntimeException('Response value "lat" is not valid');
        }
    }
}
