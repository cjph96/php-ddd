<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\UI\HTTP;

abstract class HttpController
{
    public final function __construct(
        private readonly HttpStatusCodeMappingExceptions $statusCodeMappingExceptions,
    ){
        foreach ($this->exceptions() as $exception => $statusCode) {
            $this->statusCodeMappingExceptions->register($exception, $statusCode);
        }
    }

    /**
     * @return array<string, HttpStatusCode>
     */
    abstract protected function exceptions(): array;
}
