<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\Symfony;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class Bundles
{
     /**
     * @return list<Bundle>
     */
    public static function getBundles(): array
    {
        return [
            new FrameworkBundle(),
        ];
    }
}
