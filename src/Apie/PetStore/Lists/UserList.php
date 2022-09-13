<?php
namespace App\Apie\PetStore\Lists;

use Apie\Core\Lists\ItemList;
use App\Apie\PetStore\Resources\User;

class UserList extends ItemList
{
    public function offsetGet(mixed $offset): User
    {
        return parent::offsetGet($offset);
    }
}