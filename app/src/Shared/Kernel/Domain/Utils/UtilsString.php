<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Domain\Utils;

final class UtilsString
{
    public static function toSnakeCase(string $text): string
    {
        return ctype_lower($text) ? $text : strtolower(preg_replace('/([^A-Z\s])([A-Z])/', "$1_$2", $text));
    }

    public static function snakeCaseToCapsUnderScore(string $text): string
    {
        return strtoupper(strtolower(preg_replace(['/([a-z\s])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $text)));
    }
}
