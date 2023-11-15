<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Domain;

use App\Shared\Kernel\Domain\Utils\UtilsReflection;
use App\Shared\Kernel\Domain\Utils\UtilsString;
use Exception;
use ReflectionException;
use Throwable;

abstract class DomainException extends Exception
{
    public final function __construct(?Throwable $previous = null)
    {
        parent::__construct($this->errorMessage(), previous: $previous);
    }

    /**
     * @throws ReflectionException
     */
    public function errorCode(): string
    {
        $class = UtilsReflection::extractClassName(static::class);
        return UtilsString::snakeCasetoCapsUnderScore($class);
    }

    public abstract function errorMessage(): string;
}
