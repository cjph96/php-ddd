<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\UI\HTTP\Controllers\HealthCheck;

use App\Shared\Kernel\Infrastructure\UI\HTTP\HttpRequest;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Optional;

final class HealthCheckRequest extends HttpRequest
{
    public function throwException(): bool
    {
        $throwException = $this->query['throwException'] ?? $this->body['throwException'] ?? false;
        return (bool) $throwException;
    }

    #[\Override]
    public static function validationConstraint(): ?Constraint
    {
        return new Collection([
            'fields' => [
                'throwException' => new Optional([
                    new Choice(['choices' => ['true', true, 'false', false]]),
                ]),
            ],
        ]);
    }
}
