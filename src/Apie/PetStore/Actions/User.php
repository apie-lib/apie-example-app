<?php
namespace App\Apie\PetStore\Actions;

use Apie\ApieBundle\Wrappers\BoundedContextSelected;
use Apie\Common\ApieFacade;
use Apie\Core\BoundedContext\BoundedContextId;
use Apie\Core\Context\ApieContext;
use App\Apie\PetStore\Lists\UserList;
use App\Apie\PetStore\Resources\User as ResourcesUser;

class User {
    public function __construct(private readonly ApieFacade $apieFacade, private BoundedContextSelected $selector)
    {
    }

    public function createWithArray(ResourcesUser... $users): UserList
    {
        return new UserList(
            array_map(
                function (ResourcesUser $user) {
                    return $this->apieFacade->persistNew($user, $this->selector->getBoundedContextFromRequest());
                },
                $users
            )
        );
    }
}