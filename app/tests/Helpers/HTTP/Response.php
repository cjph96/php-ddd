<?php

declare(strict_types=1);

namespace Tests\App\Helpers\HTTP;

use App\Shared\Kernel\Infrastructure\UI\HTTP\HttpStatusCode;
use PHPUnit\Framework\Assert;

trait Response
{
    public function grabResponse(): string
    {
        $response = $this->getSymfonyClient()->getResponse();

        return $response->getContent();
    }

    public function seeJsonResponseEquals(string $expected): void
    {
        Assert::assertJsonStringEqualsJsonString($expected, $this->grabResponse());
    }

    public function seeResponseCodeIs(HttpStatusCode $code, ?string $message = null): void
    {
        $responseStatusCode = $this->getSymfonyClient()->getResponse()->getStatusCode();
        $failureMessage = sprintf(
            "%sExpected HTTP Status Code: %s. Actual Status Code: %s\n\n%s",
            null !== $message ? $message.PHP_EOL : '',
            $code->value,
            $responseStatusCode,
            $this->grabResponse(),
        );
        $this->assertSame($code->value, $responseStatusCode, $failureMessage);
    }
}