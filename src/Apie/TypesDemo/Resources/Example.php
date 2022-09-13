<?php
namespace App\Apie\TypesDemo\Resources;

use Apie\Core\Entities\EntityInterface;
use App\Apie\TypesDemo\Dtos\ExampleDto;
use App\Apie\TypesDemo\Identifiers\ExampleIdentifier;

class Example implements EntityInterface
{
    private ExampleIdentifier $id;

    public function __construct(private ExampleDto $exampleDto, ?ExampleIdentifier $id = null)
    {
        $this->id = $id ?? ExampleIdentifier::createRandom();
    }

    public function getId(): ExampleIdentifier
    {
        return $this->id;
    }

    public function getExampleDto(): ExampleDto
    {
        return $this->exampleDto;
    }
}