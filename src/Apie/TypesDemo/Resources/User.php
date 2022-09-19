<?php
namespace App\Apie\TypesDemo\Resources;

use Apie\Core\Attributes\Internal;
use Apie\Core\Entities\EntityInterface;
use Apie\CountryAndPhoneNumber\BritishPhoneNumber;
use Apie\CountryAndPhoneNumber\DutchPhoneNumber;
use Apie\TextValueObjects\EncryptedPassword;
use Apie\TextValueObjects\StrongPassword;
use App\Apie\TypesDemo\Identifiers\UserIdentifier;

class User implements EntityInterface
{
    private UserIdentifier $id;
    private EncryptedPassword $encryptedPassword;

    public function __construct(StrongPassword $password, private DutchPhoneNumber|BritishPhoneNumber $phoneNumber)
    {
        $this->id = UserIdentifier::createRandom();
        $this->encryptedPassword = EncryptedPassword::fromUnencryptedPassword($password);
    }

    #[Internal()]
    public function verifyAuthentication(string $password)
    {
        return $this->encryptedPassword->verifyUnencryptedPassword($password);
    }

    public function getId(): UserIdentifier
    {
        return $this->id;
    }
}
