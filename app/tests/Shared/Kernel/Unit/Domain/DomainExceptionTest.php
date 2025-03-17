<?php

declare(strict_types=1);

namespace Tests\App\Shared\Kernel\Unit\Domain;

use PHPUnit\Framework\Attributes\Test;
use Tests\App\Shared\Kernel\Unit\UnitTestCase;

final class DomainExceptionTest extends UnitTestCase
{
    #[Test]
    public function shouldReturnErrorCodeWithExpectedFormat(): void
    {
        $exception = new FooException();
        $this->assertEquals('FOO_EXCEPTION', $exception->errorCode());
        $this->assertEquals('foo message', $exception->getMessage());
    }
}
