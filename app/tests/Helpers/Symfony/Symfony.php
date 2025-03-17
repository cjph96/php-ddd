<?php

declare(strict_types=1);

namespace Tests\App\Helpers\Symfony;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @mixin KernelTestCase
 */
trait Symfony
{
    use Container;
    use Console;
}