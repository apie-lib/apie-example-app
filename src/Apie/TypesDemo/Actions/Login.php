<?php
namespace App\Apie\TypesDemo\Actions;

use Apie\Common\ApieFacade;
use Apie\Core\BoundedContext\BoundedContextId;
use App\Apie\PetStore\Actions\User;
use App\Apie\TypesDemo\Identifiers\UserIdentifier;
use Exception;

final class Login {
    public function __construct(private readonly ApieFacade $apieFacade)
    {
    }

    public function verifyAuthentication(string $username, string $password): ?User
    {
        try {
            $user = $this->apieFacade->find(new UserIdentifier($username), new BoundedContextId('default'));
        } catch (Exception $error) {
            return null;
        }
        if ($user->verifyAuthentication($password)) {
            return $user;
        }
        return null;
    }
}
