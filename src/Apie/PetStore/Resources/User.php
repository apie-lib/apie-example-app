<?php
namespace App\Apie\PetStore\Resources;

use Apie\Core\Entities\EntityInterface;
use Apie\CountryAndPhoneNumber\InternationalPhoneNumber;
use Apie\TextValueObjects\FirstName;
use Apie\TextValueObjects\LastName;
use Apie\TextValueObjects\StrongPassword;
use App\Apie\PetStore\Enums\UserStatus;
use App\Apie\PetStore\Identifiers\UserIdentifier;

class User implements EntityInterface
{
    public function __construct(
        private UserIdentifier $id,
        private FirstName $firstName,
        private LastName $lastName,
        private StrongPassword $password,
        private InternationalPhoneNumber $phone,
        private UserStatus $userStatus
    ) {
    }

    public function getId(): UserIdentifier
    {
        return $this->id;
    }

    public function getEmail(): UserIdentifier
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getUserStatus(): string
    {
        return $this->userStatus;
    }
}