<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\Symfony;

use App\Shared\Kernel\Domain\DomainException;
use App\Shared\Kernel\Domain\Utils\UtilsReflection;
use App\Shared\Kernel\Domain\Utils\UtilsString;
use App\Shared\Kernel\Infrastructure\UI\HTTP\HttpResponse;
use App\Shared\Kernel\Infrastructure\UI\HTTP\HttpStatusCodeMappingExceptions;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;

/**
 * @see https://symfony.com/doc/current/reference/events
 */
final class KernelEventListener
{
    public function __construct(
        private readonly HttpStatusCodeMappingExceptions $statusCodeMappingExceptions,
        private readonly string $isDebug,
    ) {
    }

    public function onViewEvent(ViewEvent $event): void
    {
        $controllerResponse = $event->getControllerResult();
        if (!$controllerResponse instanceof HttpResponse) {
            return;
        }

        $event->setResponse(new JsonResponse(
            $controllerResponse->data,
            $controllerResponse->statusCode->value,
        ));
    }

    public function onExceptionEvent(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();
        $exceptionCode = '';
        try {
            $exceptionCode = $throwable instanceof DomainException
                ? $throwable->errorCode()
                : UtilsString::snakeCasetoCapsUnderScore(UtilsReflection::extractClassName($throwable));
        } catch (\ReflectionException) {}

        $response = [
            'code' => $exceptionCode,
            'message' => $throwable->getMessage(),
        ];

        if ($this->isDebug) {
            $response['trace'] = $throwable->getTrace();
        }

        $event->setResponse(new JsonResponse(
            $response,
            $this->statusCodeMappingExceptions->statusCodeFor($throwable::class)->value,
        ));
    }
}
