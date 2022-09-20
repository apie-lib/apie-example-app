<?php
namespace App\Apie\TypesDemo\Actions;

use Apie\Common\ApieFacade;
use Apie\Core\BoundedContext\BoundedContextId;
use App\Apie\TypesDemo\Resources\User;
use App\Apie\TypesDemo\Identifiers\UserIdentifier;
use Exception;
use Psr\Log\LoggerInterface;

final class Login {
    public function __construct(private readonly ApieFacade $apieFacade, private readonly LoggerInterface $logger)
    {
    }

    public function verifyAuthentication(string $username, string $password): ?User
    {
        try {
            $user = $this->apieFacade->find(new UserIdentifier($username), new BoundedContextId('typesdemo'));
        } catch (Exception $error) {
            $this->logger->critical('Error occured when trying to login: "' . $error->getMessage() . '"');
            $this->logger->debug($error->getTraceAsString());
            return null;
        }
        //return $user;
        if ($user->verifyAuthentication($password)) {
            $this->logger->debug('Password verification was refused');
            return $user;
        }
        return null;
    }
}
