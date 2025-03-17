<?php

declare(strict_types=1);

namespace Tests\App\Shared\Kernel\Unit\Infrastructure\UI\HTTP;

use App\Shared\Kernel\Domain\DomainException;
use App\Shared\Kernel\Domain\NotFoundException;
use App\Shared\Kernel\Infrastructure\UI\HTTP\HttpRequestValidationException;
use App\Shared\Kernel\Infrastructure\UI\HTTP\HttpStatusCode;
use App\Shared\Kernel\Infrastructure\UI\HTTP\HttpStatusCodeMappingExceptions;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\App\Shared\Kernel\Unit\UnitTestCase;

final class HttpStatusCodeMappingExceptionsTest extends UnitTestCase
{
    #[Test]
    #[DataProvider('exceptionClassProvider')]
    public function shouldMapExceptionsToHttpStatus(string $exceptionClass, HttpStatusCode $expected): void
    {
        $this->assertEquals($expected, new HttpStatusCodeMappingExceptions()->statusCodeFor($exceptionClass));
    }

    public static function exceptionClassProvider(): iterable
    {
        yield [InvalidArgumentException::class, HttpStatusCode::BAD_REQUEST];
        yield [HttpRequestValidationException::class, HttpStatusCode::UNPROCESSABLE_ENTITY];
        yield [NotFoundHttpException::class, HttpStatusCode::NOT_FOUND];
        yield [MethodNotAllowedHttpException::class, HttpStatusCode::METHOD_NOT_ALLOWED];

        yield [\Exception::class, HttpStatusCode::INTERNAL_SERVER_ERROR];

        yield [NotFoundException::class, HttpStatusCode::NOT_FOUND];
        yield [DomainException::class, HttpStatusCode::BAD_REQUEST];
    }
}
