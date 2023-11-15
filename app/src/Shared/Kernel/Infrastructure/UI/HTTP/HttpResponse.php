<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\UI\HTTP;

final class HttpResponse
{
    public function __construct(
        public readonly null|string|object|array $data,
        public readonly HttpStatusCode $statusCode,
    ){
    }
}
