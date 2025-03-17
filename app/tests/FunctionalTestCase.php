<?php

declare(strict_types=1);

namespace Tests\App;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\App\Helpers\HTTP\Http;
use Tests\App\Helpers\Symfony\Symfony;

abstract class FunctionalTestCase extends WebTestCase
{
    use Symfony;
    use Http;
}
