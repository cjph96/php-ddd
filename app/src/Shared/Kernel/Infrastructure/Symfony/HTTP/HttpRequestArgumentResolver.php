<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\Symfony\HTTP;

use App\Shared\Kernel\Infrastructure\UI\HTTP\HttpMethod;
use App\Shared\Kernel\Infrastructure\UI\HTTP\HttpRequest;
use App\Shared\Kernel\Infrastructure\UI\HTTP\HttpRequestValidationException;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class HttpRequestArgumentResolver implements ValueResolverInterface
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    /**
     * @throws HttpRequestValidationException
     */
    #[\Override]
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $requestClass = $argument->getType();
        if (null === $requestClass || !is_subclass_of($requestClass, HttpRequest::class)) {
            throw new InvalidArgumentException(sprintf(
                'Expected instance of %s. %s given',
                HttpRequest::class,
                $requestClass ?? 'null',
            ));
        }

        try {
            $body = '' !== $request->getContent()
                ? json_decode($request->getContent(), true, flags: JSON_THROW_ON_ERROR)
                : null;
        } catch (\JsonException) {
            throw new InvalidArgumentException("The request body is not a valid json");
        }

        $query = $request->query->all();

        $constraint = $requestClass::validationConstraint();
        if (null !== $constraint) {
            $data = array_merge($query, $body ?? []);
            $errors = $this->validator->validate($data, $constraint);

            if (count($errors) > 0) {
                throw new HttpRequestValidationException($errors);
            }
        }

        yield new $requestClass(
            $request->headers->all(),
            $query,
            $body,
            HttpMethod::from($request->getMethod()),
        );
    }
}
