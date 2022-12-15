<?php
namespace App\Apie\TypesDemo\Resources;

use Apie\Core\Attributes\Context;
use Apie\Core\Entities\EntityInterface;
use App\Apie\TypesDemo\Resources\User;
use App\Apie\TypesDemo\Identifiers\OwnedByUserIdentifier;
use App\Apie\TypesDemo\Identifiers\UserIdentifier;

class OwnedByUser implements EntityInterface
{
    public function __construct(
        #[Context('authenticated')] private readonly User $user,
        private readonly OwnedByUserIdentifier $id
    ) {
    }

    public function getId(): OwnedByUserIdentifier
    {
        return $this->id;
    }

    public function getUser(): UserIdentifier
    {
        return $this->user->getId();
    }
}