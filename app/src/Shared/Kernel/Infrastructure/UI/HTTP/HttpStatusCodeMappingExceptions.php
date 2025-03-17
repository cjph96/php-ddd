<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\UI\HTTP;

use App\Shared\Kernel\Domain\DomainException;
use App\Shared\Kernel\Domain\NotFoundException;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class HttpStatusCodeMappingExceptions
{
    private const HttpStatusCode DEFAULT_STATUS_CODE = HttpStatusCode::INTERNAL_SERVER_ERROR;

    /**
     * @var array<class-string, HttpStatusCode>
     */
    public static array $exceptions = [
        InvalidArgumentException::class => HttpStatusCode::BAD_REQUEST,
        HttpRequestValidationException::class => HttpStatusCode::UNPROCESSABLE_ENTITY,
        NotFoundHttpException::class => HttpStatusCode::NOT_FOUND,
        MethodNotAllowedHttpException::class => HttpStatusCode::METHOD_NOT_ALLOWED,
    ];

    /**
     * @param class-string $exceptionClass
     */
    public static function statusCodeFor(string $exceptionClass): HttpStatusCode
    {
        if (!is_a($exceptionClass, DomainException::class, true)) {
            return self::$exceptions[$exceptionClass] ?? self::DEFAULT_STATUS_CODE;
        }

        if (is_a($exceptionClass, NotFoundException::class, true)) {
            return HttpStatusCode::NOT_FOUND;
        }

        return HttpStatusCode::BAD_REQUEST;
    }
}
