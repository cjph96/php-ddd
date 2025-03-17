<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\UI\HTTP;

use Exception;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class HttpRequestValidationException extends Exception
{
    public function __construct(ConstraintViolationListInterface $list)
    {
        $message = '';
        $comma = false;
        foreach ($list as $constraintViolation) {
            $message .= $comma ? ',' : '';
            $message .= str_replace(["[", "]"], "'", $constraintViolation->getPropertyPath()). ': '. (string) $constraintViolation->getMessage();
            $comma = true;
        }

        parent::__construct($message);
    }
}
