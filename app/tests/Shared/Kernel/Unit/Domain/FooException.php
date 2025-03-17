<?php

declare(strict_types=1);

namespace Tests\App\Shared\Kernel\Unit\Domain;

use App\Shared\Kernel\Domain\DomainException;

final class FooException extends DomainException
{
    public function errorMessage(): string
    {
        return "foo message";
    }
}
