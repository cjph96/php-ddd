<?php

declare(strict_types=1);

namespace Tests\App\Shared\Kernel\Unit\Domain\Utils;

use App\Shared\Kernel\Domain\Utils\Reflection;
use PHPUnit\Framework\Attributes\Test;
use Tests\App\Shared\Kernel\Unit\Domain\Foo;
use Tests\App\Shared\Kernel\Unit\UnitTestCase;

final class ReflectionTest extends UnitTestCase
{
    #[Test]
    public function shouldExtractClassNameGivenClassString(): void
    {
        $classString = Foo::class;

        $this->assertEquals('Foo', Reflection::extractClassName($classString));
    }

    #[Test]
    public function shouldExtractClassNameGivenObject(): void
    {
        $object = new Foo();

        $this->assertEquals('Foo', Reflection::extractClassName($object));
    }
}
