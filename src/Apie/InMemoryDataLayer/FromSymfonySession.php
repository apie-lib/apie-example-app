<?php
namespace App\Apie\InMemoryDataLayer;

use Apie\Core\Datalayers\ValueObjects\LazyLoadedListIdentifier;
use Apie\Core\ValueObjects\Utils;
use Symfony\Component\HttpFoundation\RequestStack;

class FromSymfonySession implements MemoryContainerInterface
{
    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    public function getAll(string $key): array
    {
        return Utils::toArray($this->requestStack->getSession()->get($key, []));
    }

    public function setAll(string $key, array $value): void
    {
        $this->requestStack->getSession()->set($key, $value);
    }
}