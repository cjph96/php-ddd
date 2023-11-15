<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\UI\HTTP;

use Exception;
use Symfony\Component\Validator\ConstraintViolationList;

final class HttpRequestValidationException extends Exception
{
    public function __construct(ConstraintViolationList $list)
    {
        $message = '';
        $comma = false;
        foreach ($list as $constraintViolation) {
            $message .= $comma ? ',' : '';
            $message .= $constraintViolation->getPropertyPath(). ': '. $constraintViolation->getMessage();
            $comma = true;
        }

        parent::__construct($message);
    }
}
