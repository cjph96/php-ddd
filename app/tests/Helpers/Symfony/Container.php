<?php

declare(strict_types=1);

namespace Tests\App\Helpers\Symfony;

/**
 * @mixin Symfony
 */
trait Container
{
    /**
     * @template T
     * @param class-string<T>|string $serviceId
     * @return T
     */
    public function getService(string $serviceId): object
    {
        if (!$this->getContainer()->has($serviceId)) {
            $this->fail("Service $serviceId not found");
        }

        return $this->getContainer()->get($serviceId);
    }

    public function getParameter(string $name): array|string|int|float|bool|null
    {
        return $this->getContainer()->getParameter($name);
    }
}