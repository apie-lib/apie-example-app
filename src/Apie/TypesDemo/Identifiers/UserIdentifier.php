<?php
namespace App\Apie\TypesDemo\Identifiers;

use Apie\Core\Identifiers\IdentifierInterface;
use Apie\Core\Identifiers\UuidV4;
use App\Apie\TypesDemo\Resources\User;
use ReflectionClass;

class UserIdentifier extends UuidV4 implements IdentifierInterface
{
    /**
     * @return RefectionClass<EntityInterface>
     */
    public static function getReferenceFor(): ReflectionClass
    {
        return new ReflectionClass(User::class);
    }
}
