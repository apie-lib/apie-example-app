<?php
namespace App;

use Apie\Common\ApieFacade;
use Apie\Core\BoundedContext\BoundedContextHashmap;
use Apie\Core\Actions\BoundedContextEntityTuple;
use Apie\Core\Attributes\FakeCount;
use Apie\DoctrineEntityDatalayer\Exceptions\InsertConflict;
use Faker\Generator;
use LogicException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'apie:seed-entities', description: 'Seeds the Apie datalayer with faked domain objects.')]
class ApieSeedCommand extends Command
{
    public function __construct(
        private readonly BoundedContextHashmap $boundedContextHashmap,
        private readonly ApieFacade $apieFacade,
        private readonly Generator $faker,
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this->addOption('amount', 'a', InputOption::VALUE_REQUIRED, description: 'How many objects should be created', default: 100);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var BoundedContextEntityTuple $tuple */
        foreach ($this->boundedContextHashmap->getTupleIterator() as $tuple) {
            $counter = $input->getOption('amount');
            $attributes = $tuple->resourceClass->getAttributes(FakeCount::class);
            foreach ($attributes as $attribute) {
                $counter = $attribute->count;
            }
            for ($i = 0; $i < $counter; $i++) {
                $output->writeln($tuple->boundedContext->getId() . ', ' . $tuple->resourceClass->getShortName() . ', ' . $i);
                $this->attemptStorage($tuple, 50);
            }
        }
        return Command::SUCCESS;
    }

    private function attemptStorage(BoundedContextEntityTuple $tuple, int $retries): void
    {
        while ($retries > 0) {
            try {
                $fakeEntity = $this->faker->fakeClass($tuple->resourceClass->name);
                $this->apieFacade->persistNew($fakeEntity, $tuple->boundedContext);
                return;
            } catch (InsertConflict $conflict) {
                if ($retries <= 1) {
                    throw new LogicException(
                        'Trying to create a random record failed for ' . $tuple->boundedContext->getId() . ', ' . $tuple->resourceClass->getShortName(),
                        0,
                        $conflict
                    );
                }
            }
            $retries--;
        }
    }
}