<?php
namespace App\Apie\PetStore\Enums;

enum UserStatus: int {
    case ACTIVE = 0;
    case DISABLED = 1;
}