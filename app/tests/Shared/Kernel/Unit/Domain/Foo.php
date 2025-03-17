<?php

declare(strict_types=1);

namespace Tests\App\Shared\Kernel\Unit\Domain;

final class Foo
{
    public function __construct(
        public ?int $id = null,
    ) {
    }
}
