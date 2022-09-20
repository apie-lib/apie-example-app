<?php
namespace App\Apie\InMemoryDataLayer;

use Apie\ApieBundle\Wrappers\BoundedContextSelected;
use Apie\Core\BoundedContext\BoundedContextId;
use Apie\Core\Datalayers\ApieDatalayer;
use Apie\Core\Datalayers\InMemory\CountArray;
use Apie\Core\Datalayers\InMemory\GetFromArray;
use Apie\Core\Datalayers\InMemory\TakeFromArray;
use Apie\Core\Datalayers\Lists\LazyLoadedList;
use Apie\Core\Datalayers\ValueObjects\LazyLoadedListIdentifier;
use Apie\Core\Entities\EntityInterface;
use Apie\Core\Exceptions\EntityAlreadyPersisted;
use Apie\Core\Exceptions\EntityNotFoundException;
use Apie\Core\Exceptions\UnknownExistingEntityError;
use Apie\Core\Identifiers\AutoIncrementInteger;
use Apie\Core\Identifiers\IdentifierInterface;
use ReflectionClass;
use ReflectionProperty;

class InMemoryDataLayer implements ApieDatalayer
{
    public function __construct(
        private MemoryContainerInterface $memory,
        private BoundedContextSelected $boundedContextSelected
    ) {
    }

    private function getSessionKey(ReflectionClass $class): LazyLoadedListIdentifier
    {
        $boundedContext = $this->boundedContextSelected->getBoundedContextFromRequest();
        if (!$boundedContext) {
            $boundedContext = $this->boundedContextSelected->getBoundedContextFromClassName($class->name);
        }
        return LazyLoadedListIdentifier::createFrom(
            $boundedContext ? $boundedContext->getId() : new BoundedContextId('unknown'),
            $class
        );
    }

    public function all(ReflectionClass $class): LazyLoadedList
    {
        $key = $this->getSessionKey($class);
        $callable = function () use ($key) {
            return $this->memory->getAll('apie.' . $key->toNative());
        };
        return new LazyLoadedList(
            $key,
            new GetFromArray($callable),
            new TakeFromArray($callable),
            new CountArray($callable)
        );
    }

    public function find(IdentifierInterface $identifier): EntityInterface
    {
        $key = $this->getSessionKey($identifier::getReferenceFor());
        $list = $this->memory->getAll('apie.' . $key->toNative());
        $idToFind = $identifier->toNative();
        foreach ($list as $item) {
            if ($item->getId()->toNative() === $idToFind) {
                return $item;
            }
        }
        throw new EntityNotFoundException($identifier);
    }

    public function persistNew(EntityInterface $entity): EntityInterface
    {
        $id = $entity->getId();
        if ($id instanceof AutoIncrementInteger) {
            $id = $id::createRandom($this->generator);
        }
        $reflProperty = new ReflectionProperty($entity, 'id');
        $reflProperty->setAccessible(true);
        $reflProperty->setValue($entity, $id);
        $key = $this->getSessionKey($entity->getId()::getReferenceFor());
        $list = $this->memory->getAll('apie.' . $key->toNative());

        $id = $entity->getId()->toNative();        
        foreach ($list as $entityInList) {
            if ($entityInList->getId()->toNative() === $id) {
                throw new EntityAlreadyPersisted($entity);
            }
        }
        $list[] = $entity;
        $this->memory->setAll('apie.' . $key->toNative(), $list);
        return $entity;
    }

    public function persistExisting(EntityInterface $entity): EntityInterface
    {
        $key = $this->getSessionKey($entity->getId()::getReferenceFor());
        $list = $this->memory->getAll('apie.' . $key->toNative());

        $id = $entity->getId()->toNative();        
        foreach ($list as $key => $entityInList) {
            if ($entityInList->getId()->toNative() === $id) {
                $list[$key] = $entity;
                $this->memory->setAll('apie.' . $key->toNative(), $list);
                return $entity;
            }
        }
        throw new UnknownExistingEntityError($entity);
    }
}