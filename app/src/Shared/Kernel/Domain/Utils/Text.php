<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Domain\Utils;

final class Text
{
    public static function snakeCaseToCapsUnderScore(string $text): string
    {
        return strtoupper(strtolower(preg_replace(['/([a-z\s])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $text)));
    }
}
