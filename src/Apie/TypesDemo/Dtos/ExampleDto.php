<?php
namespace App\Apie\TypesDemo\Dtos;

use Apie\Core\Dto\DtoInterface;

class ExampleDto implements DtoInterface
{
    public string $text;

    public int $number;
}