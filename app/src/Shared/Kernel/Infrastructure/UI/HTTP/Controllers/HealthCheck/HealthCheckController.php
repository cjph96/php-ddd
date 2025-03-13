<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\UI\HTTP\Controllers\HealthCheck;

use App\Shared\Kernel\Infrastructure\UI\HTTP\HttpController;
use App\Shared\Kernel\Infrastructure\UI\HTTP\HttpResponse;
use App\Shared\Kernel\Infrastructure\UI\HTTP\HttpStatusCode;
use Exception;
use InvalidArgumentException;

final class HealthCheckController extends HttpController
{
    /**
     * @throws Exception
     */
    public function __invoke(HealthCheckRequest $request): HttpResponse
    {
        if ($request->throwException()) {
            throw new Exception('Example of general Exception Handling');
        }

        return new HttpResponse('OK', HttpStatusCode::OK);
    }
}
