<?php
namespace App\Apie\PetStore\Resources;

use Apie\CommonValueObjects\FullName;
use Apie\Core\Entities\EntityInterface;
use Apie\PetStore\Identifiers\UserIdentifier;

class User implements EntityInterface
{
    private UserIdentifier $id;

    public FullName $fullName;

    public function __construct()
    {
        $this->id = new UserIdentifier(null);
    }

    public function getId(): UserIdentifier
    {
        return $this->id;
    }
    /*"username": "string",
  "firstName": "string",
  "lastName": "string",
  "email": "string",
  "password": "string",
  "phone": "string",
  "userStatus": 0*/
}