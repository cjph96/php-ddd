<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\ErrorHandler;

$env = new Dotenv();
$env->usePutenv();
$env->load(__DIR__ . '/../.env');
$env->load(__DIR__ . '/../.env.test');
ErrorHandler::register(null, false); //https://github.com/symfony/symfony/issues/53812#issuecomment-1962311843
