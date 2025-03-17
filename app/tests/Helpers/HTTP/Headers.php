<?php

declare(strict_types=1);

namespace Tests\App\Helpers\HTTP;

trait Headers
{
    private array $headers = [];

    public function seeHttpHeader(string $name, $value = null): void
    {
        $headerValue = $this->getSymfonyClient()->getResponse()->headers->get($name);

        if ($value !== null) {
            $this->assertSame($value, $headerValue);
            return;
        }

        $this->assertNotNull($headerValue);
    }

    private function getHeader(string $name): ?string
    {
        $name = $this->normalizeHeaderName($name);

        return $this->headers[$name] ?? null;
    }

    private function normalizeHeaderName(string $header): string
    {
        $header = strtoupper(str_replace('-', '_', $header));

        if (!str_starts_with($header, 'HTTP_') && $header !== 'CONTENT_TYPE') {
            $header = 'HTTP_'.$header;
        }

        return $header;
    }
}