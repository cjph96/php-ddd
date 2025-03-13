<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Domain\Utils;

use ReflectionClass;
use ReflectionException;

final class UtilsReflection
{
    /**
     * @param object|class-string $objectOrClass
     * @throws ReflectionException
     */
    public static function extractClassName(object|string $objectOrClass): string
    {
        $reflect = new ReflectionClass($objectOrClass);

        return $reflect->getShortName();
    }
}
