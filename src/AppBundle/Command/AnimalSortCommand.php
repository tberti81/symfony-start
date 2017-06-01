<?php

namespace AppBundle\Command;

use AppBundle\Command\Animal\Animal;
use AppBundle\Command\Animal\Bird;
use AppBundle\Command\Animal\Dog;
use AppBundle\Command\Animal\Snake;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AnimalSortCommand extends Command
{
	protected function configure()
	{
		$this
			->setName('Animal sorter')
			->setAliases(['as']);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$dogAlbert = new Dog('Albert');
		$snakeSly  = new Snake('Sly');
		$dogWilly  = new Dog('Willy');
		$birdRusty = new Bird('Rusty');
		$dogBuddy  = new Dog('Buddy');

		$animals = [
			$this->getAnimalId($dogAlbert) => $dogAlbert,
			$this->getAnimalId($snakeSly)  => $snakeSly,
			$this->getAnimalId($dogWilly)  => $dogWilly,
			$this->getAnimalId($birdRusty) => $birdRusty,
			$this->getAnimalId($dogBuddy)  => $dogBuddy,
		];
		var_dump($animals);

		foreach ($animals as $key => $animal)
		{
			/** @var Animal $animal */
			$animalsToSort[$key] = [
				'name'         => $animal->getName(),
				'numberOfLegs' => $animal->getNumberOfLegs()
			];

			$names[]        = $animal->getName();
			$numberOfLegs[] = $animal->getNumberOfLegs();
		}

		array_multisort($numberOfLegs, SORT_DESC, $names, SORT_ASC, $animalsToSort);

		/** @var Animal[] $result */
		$result = [];
		foreach ($animalsToSort as $key => $animalToSort)
		{
			$result[] = $animals[$key];
		}
		var_dump($result);
	}

	private function getAnimalId(Animal $animal)
	{
		return get_class($animal) . '_' . $animal->getNumberOfLegs() . '_' . $animal->getName();
	}
} 