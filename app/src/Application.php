<?php

declare(strict_types=1);

namespace App;

use App\Shared\Kernel\Infrastructure\Symfony\SymfonyKernel;
use Symfony\Bundle\FrameworkBundle\Console\Application as SymfonyConsole;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

final class Application
{
    public static function start(): void
    {
        try {
            $kernel = new SymfonyKernel();
            $request = Request::createFromGlobals();
            $response = $kernel->handle($request);
            $response->send();
            $kernel->terminate($request, $response);
        }catch (Throwable) {
            die();
        }
    }

    public static function CLI(): void
    {
        $kernel = new SymfonyKernel();
        $kernel->boot();
        $application = new SymfonyConsole($kernel);
        try {
            $application->run();
        } catch (Throwable $t) {
            dd($t);
        }
    }
}