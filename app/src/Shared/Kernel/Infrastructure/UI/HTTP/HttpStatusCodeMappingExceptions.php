<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\UI\HTTP;

use InvalidArgumentException;

final class HttpStatusCodeMappingExceptions
{
    private const DEFAULT_STATUS_CODE = HttpStatusCode::INTERNAL_SERVER_ERROR;

    /**
     * @var array<string, HttpStatusCode>
     */
    public array $exceptions = [
        InvalidArgumentException::class => HttpStatusCode::BAD_REQUEST,
        HttpRequestValidationException::class => HttpStatusCode::UNPROCESSABLE_ENTITY,
    ];

    public function register(string $exceptionClass, HttpStatusCode $statusCode): void
    {
        $this->exceptions[$exceptionClass] = $statusCode;
    }

    public function statusCodeFor(string $exceptionClass): HttpStatusCode
    {
        return $this->exceptions[$exceptionClass] ?? self::DEFAULT_STATUS_CODE;
    }
}
