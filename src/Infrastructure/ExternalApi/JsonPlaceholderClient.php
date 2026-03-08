<?php

declare(strict_types=1);

namespace App\Infrastructure\ExternalApi;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class JsonPlaceholderClient
{
    private const API_URL = 'https://jsonplaceholder.typicode.com/users';

    public function __construct(
        private HttpClientInterface $httpClient
    ) {
    }

    /**
     * @return array<int, array{
     *  id: int,
     *  name: string,
     *  username: string,
     *  email: string,
     *  address: array{
     *      street: string,
     *      suite: string,
     *      city: string,
     *      zipcode: string,
     *      geo: array{
     *          lat: string,
     *          lng: string
     *      }
     * },
     * phone: string,
     * website: string,
     * company: array{
     *  name: string,
     *  catchPhrase: string,
     *  bs: string
     * }
     * }>
     */
    public function fetchExternalUsers(): array
    {
        $response = $this->httpClient->request('GET', self::API_URL);

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new \RuntimeException('Unable to fetch users from external API');
        }

        return $response->toArray();
    }
}
