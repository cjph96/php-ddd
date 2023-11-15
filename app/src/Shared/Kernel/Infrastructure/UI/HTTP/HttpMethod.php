<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\UI\HTTP;

enum HttpMethod: string
{
    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case DELETE = 'DELETE';
    case PATCH = 'PATCH';
}
