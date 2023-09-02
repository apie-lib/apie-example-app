<?php
namespace App\Apie\TypesDemo\Resources;

use Apie\CommonValueObjects\FullName;
use Apie\Core\Attributes\Context;
use Apie\Core\Entities\EntityInterface;
use App\Apie\TypesDemo\Resources\User;
use App\Apie\TypesDemo\Identifiers\OwnedByUserIdentifier;
use App\Apie\TypesDemo\Identifiers\UserIdentifier;

class OwnedByUser implements EntityInterface
{
    public function __construct(
        #[Context('authenticated')] private User $user,
        private OwnedByUserIdentifier $id,
        private FullName $name,
        private bool $owned = true
    ) {
    }

    public function setName(FullName $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): FullName
    {
        return $this->name;
    }

    public function getId(): OwnedByUserIdentifier
    {
        return $this->id;
    }

    public function getUser(): UserIdentifier
    {
        return $this->user->getId();
    }

    public function isOwned(): bool
    {
        return $this->owned;
    }

    public function setOwned(bool $owned): self
    {
        $this->owned = $owned;

        return $this;
    }
}