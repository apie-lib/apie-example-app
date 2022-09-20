<?php
namespace App\Apie\InMemoryDataLayer;

class FromMemory implements MemoryContainerInterface
{
    private array $mapping = [];

    public function getAll(string $key): array
    {
        return $this->mapping[$key] ?? [];
    }

    public function setAll(string $key, array $value): void
    {
        $this->mapping[$key] = $value;
    }
}