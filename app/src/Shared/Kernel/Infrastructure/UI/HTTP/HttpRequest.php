<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\UI\HTTP;

use Symfony\Component\Validator\Constraint;

abstract class HttpRequest
{
    /**
     * @param array<string, string> $headers
     * @param null|array<string, string> $query
     */
    public final function __construct(
        public readonly array $headers,
        public readonly ?array $query,
        public readonly ?array $body,
        public readonly HttpMethod $method,
    ) {
    }

    abstract public static function validationConstraint(): ?Constraint;
}
