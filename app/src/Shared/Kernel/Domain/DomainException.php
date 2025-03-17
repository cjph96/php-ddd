<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Domain;

use App\Shared\Kernel\Domain\Utils\Reflection;
use App\Shared\Kernel\Domain\Utils\Text;
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
        $class = Reflection::extractClassName(static::class);
        return Text::snakeCasetoCapsUnderScore($class);
    }

    public abstract function errorMessage(): string;
}
