<?php

declare(strict_types=1);

namespace Tests\App\Shared\Kernel\Functional\Infrastructure\UI\HTTP\Controllers\HealthCheck;

use App\Shared\Kernel\Infrastructure\UI\HTTP\HttpStatusCode;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\App\Shared\Kernel\Functional\FunctionalTestCase;

final class HealthCheckControllerTest extends FunctionalTestCase
{
    private const string PATH = '/health-check';

    #[Test]
    public function shouldReturnOk(): void
    {
        $this->sendGet(self::PATH);

        $this->seeHttpHeader('Content-Type', 'application/json');
        $this->seeResponseCodeIs(HttpStatusCode::OK);

        $this->seeJsonResponseEquals(json_encode([
            "data" => "OK"
        ]));
    }

    #[Test]
    #[DataProvider('exceptionProvider')]
    public function shouldThrowException(
        string $query,
        string $expectedJsonResponse,
        HttpStatusCode $expectedHttpStatusCode,
    ): void
    {
        $this->sendGet(self::PATH . '?' . $query);

        $this->seeHttpHeader('Content-Type', 'application/json');
        $this->seeResponseCodeIs($expectedHttpStatusCode);

        $this->seeJsonResponseEquals($expectedJsonResponse);
    }

    public static function exceptionProvider(): iterable
    {
        yield [
            'throwException=true',
            json_encode([
                "code" => "EXCEPTION",
                "message" => "Example of general Exception Handling"
            ]),
            HttpStatusCode::INTERNAL_SERVER_ERROR,
        ];

        yield [
            'throwException=12',
            json_encode([
                "code" => "HTTP_REQUEST_VALIDATION_EXCEPTION",
                "message" => "'throwException': The value you selected is not a valid choice."
            ]),
            HttpStatusCode::UNPROCESSABLE_ENTITY,
        ];
    }
}
