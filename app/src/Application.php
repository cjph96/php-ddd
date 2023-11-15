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
        } catch (Throwable) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['Error' => 'Internal Server Error']);
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
            var_dump($t);
        }
    }
}
