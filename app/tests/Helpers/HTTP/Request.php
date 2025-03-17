<?php

declare(strict_types=1);

namespace Tests\App\Helpers\HTTP;

use JsonException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

trait Request
{
    use Headers;

    private ?KernelBrowser $symfonyClient = null;

    /**
     * @throws JsonException
     */
    public function sendPost(string $url, $params = []): void
    {
        $this->sendRequest('POST', $url, [], $this->serializeContent($params));
    }

    public function sendGet(string $url, array $params = []): void
    {
        $this->sendRequest('GET', $url, $params);
    }

    private function sendRequest(string $method, string $url, array $params = [], ?string $content = null, array $files = []): void
    {
        $this->getSymfonyClient()->request(
            $method,
            $url,
            $params,
            $files,
            content: $content,
        );
    }

    private function getSymfonyClient(): KernelBrowser
    {
        if (null === $this->symfonyClient) {
            $this->symfonyClient = $this->getContainer()->get('test.client');
        }

        return $this->symfonyClient;
    }

    /**
     * @throws JsonException
     */
    private function serializeContent(mixed $params): string|null
    {
        if (is_string($params)) {
            return $params;
        } elseif ($this->isJsonRequest()) {
            return json_encode($params, JSON_PRESERVE_ZERO_FRACTION | JSON_THROW_ON_ERROR);
        } else {
            return http_build_query($params);
        }
    }

    private function isJsonRequest(): bool
    {
        return $this->getHeader('Content-Type') === 'application/json';
    }
}