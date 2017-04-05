<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LargestPrimeFinderCommand extends Command
{
	/**
	 * @var array
	 */
	private $primeList = [];

	/**
	 * Configure the command.
	 */
	protected function configure()
	{
		$this
			->setName('app:largest-prime-finder')
			->setDescription('Largest prime finder command.')
			->setHelp('With this command you can find the largest prime number inside a given number.')
			->addArgument('number', InputArgument::REQUIRED, 'Number to find the largest prime number inside.');
	}

	/**
	 * Execute the command.
	 *
	 * @param InputInterface  $input
	 * @param OutputInterface $output
	 *
	 * @return void
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$number = $input->getArgument('number');

		$largestPrime = $this->findLargestPrime($number);

		if (null !== $largestPrime)
		{
			$output->writeln(sprintf('Largest prime inside the number %s is %s.', $number, $largestPrime));
		}
		else
		{
			$output->writeln(sprintf('There is no prime inside the number %s.', $number));
		}
	}

	/**
	 * Find the largest prime inside a given number.
	 *
	 * @param int $number
	 *
	 * @return int|null
	 */
	private function findLargestPrime($number)
	{
		$this->initPrimeList($number);

		$maxIndex = count($this->primeList) - 1;
		for ($i = $maxIndex; $i >= 0; $i--)
		{
			if (strpos((string)$number, (string)$this->primeList[$i]) !== false)
			{
				return $this->primeList[$i];
			}
		}

		return null;
	}

	/**
	 * Initialize the list of primes up to the given number.
	 *
	 * @param int $number
	 */
	private function initPrimeList($number)
	{
		for ($i = 2; $i <= $number; $i++)
		{
			if (!$this->isComposite($i))
			{
				$this->primeList[] = $i;
			}
		}
	}

	/**
	 * Determine if the given number is composite number or not.
	 * If not composite than it is prime.
	 *
	 * @param int $number
	 *
	 * @return bool
	 */
	private function isComposite($number)
	{
		$intSqrt = (int)sqrt($number);

		for ($i = 2; $i <= $intSqrt; $i++)
		{
			if ($number % $i === 0)
			{
				return true;
			}
		}

		return false;
	}
}