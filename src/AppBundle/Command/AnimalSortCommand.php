<?php

namespace AppBundle\Command;

use AppBundle\Command\Animal\Animal;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use InvalidArgumentException;

/**
 * @package AppBundle\Command
 */
class AnimalSortCommand extends Command
{
	protected function configure()
	{
		$this
			->setName('Animal sorter')
			->setAliases(['as'])
			->setDescription('Sort the listed animals by leg count(desc) and name(asc).')
			->addArgument(
				'animals',
				InputArgument::IS_ARRAY | InputArgument::REQUIRED,
				'List the animals in the following way... type:name type:name type:name (separate each type and name pair with a comma):'
			)
		;
	}

	/**
	 * @param InputInterface  $input
	 * @param OutputInterface $output
	 *
	 * @return void
	 *
	 * @throws InvalidArgumentException
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		/*
		 * Get the animals as an array.
		 */

		$inputAnimals = $input->getArgument('animals');


		/*
		 * Make objects from the animals.
		 */

		/** @var Animal[] $animals */
		$animals = [];

		foreach ($inputAnimals as $inputAnimal)
		{
			list($type, $name) = explode(':', $inputAnimal);

			$animalClass = 'AppBundle\Command\Animal\\' . ucfirst($type);

			if (!class_exists($animalClass))
			{
				throw new InvalidArgumentException(sprintf('The \'%s\' animal is not implemented!', $type));
			}

			$animal = new $animalClass(ucfirst($name));

			$animals[$this->getAnimalId($animal)] = $animal;
		}

		/*
		 * Make an array to be able to multisort.
		 */

		foreach ($animals as $key => $animal)
		{
			$animalsToSort[$key] = [
				'name'         => $animal->getName(),
				'numberOfLegs' => $animal->getNumberOfLegs()
			];

			$names[]        = $animal->getName();
			$numberOfLegs[] = $animal->getNumberOfLegs();
		}

		/*
		 * Sort.
		 */

		array_multisort($numberOfLegs, SORT_DESC, $names, SORT_ASC, $animalsToSort);

		/*
		 * Output the result.
		 */

		$output->writeln('Here are the sorted animals:');

		/** @var Animal[] $result */
		$result = [];
		foreach ($animalsToSort as $key => $animalToSort)
		{
			$result[] = $animals[$key];

			$output->writeln(str_replace('AppBundle\Command\Animal\\', '', get_class($animals[$key])) . ' ' . $animals[$key]->getName());
		}
	}

	/**
	 * @param Animal $animal
	 *
	 * @return string
	 */
	private function getAnimalId(Animal $animal)
	{
		return get_class($animal) . '_' . $animal->getNumberOfLegs() . '_' . $animal->getName();
	}
} 