<?php

declare(strict_types=1);

namespace Tests\App;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\App\Helpers\Symfony\Symfony;

abstract class IntegrationTestCase extends WebTestCase
{
    use Symfony;
}
