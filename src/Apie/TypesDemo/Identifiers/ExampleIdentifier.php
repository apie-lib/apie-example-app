<?php
namespace App\Apie\TypesDemo\Identifiers;

use Apie\Core\Identifiers\IdentifierInterface;
use Apie\Core\Identifiers\UuidV4;
use App\Apie\TypesDemo\Resources\Example;
use ReflectionClass;

class ExampleIdentifier extends UuidV4 implements IdentifierInterface
{
    public static function getReferenceFor(): ReflectionClass
    {
        return new ReflectionClass(Example::class);
    }
}