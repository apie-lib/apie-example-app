<?php
namespace Apie\PetStore\Identifiers;

use Apie\Core\Identifiers\AutoIncrementInteger;
use Apie\Core\Identifiers\IdentifierInterface;
use App\Apie\PetStore\Resources\User;
use ReflectionClass;

class UserIdentifier extends AutoIncrementInteger implements IdentifierInterface
{
    public static function getReferenceFor(): ReflectionClass
    {
        return new ReflectionClass(User::class);
    }
}