<?php
namespace App\Apie\InMemoryDataLayer;

use Apie\Core\BoundedContext\BoundedContextId;
use ReflectionClass;

interface MemoryContainerInterface {
    public function getAll(string $key): array;
    public function setAll(string $key, array $value): void;
}