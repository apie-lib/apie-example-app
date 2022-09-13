<?php
namespace App\Apie\PetStore\Identifiers;

use Apie\Core\Identifiers\IdentifierInterface;
use Apie\CommonValueObjects\Email;
use App\Apie\PetStore\Resources\User;
use ReflectionClass;

class UserIdentifier extends Email implements IdentifierInterface
{
    public static function getReferenceFor(): ReflectionClass
    {
        return new ReflectionClass(User::class);
    }
}