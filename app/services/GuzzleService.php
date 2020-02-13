<?php declare(strict_types=1);

namespace app\services;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class GuzzleService extends AbstractService
{
    /** @var Client */
    private $client;

    public function init(): void
    {
        $this->client = new Client(['http_errors' => $this->services->config->get('guzzle.http_errors')]);
    }

    public function sendGetRequest(string $url): ?string
    {
        $response = $this->client->request('GET', $url, [
            RequestOptions::ALLOW_REDIRECTS => true,
            RequestOptions::HEADERS => [
                'User-Agent' => $this->services->config->get('guzzle.user_agent'),
            ]
        ]);

        if($response->getStatusCode() == 404) {
            return null;
        }

        $responseContents = $response->getBody()->getContents();

        return $responseContents;
    }
}