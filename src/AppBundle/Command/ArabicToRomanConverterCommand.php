<?php

namespace AppBundle\Command;

use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ArabicToRomanConverterCommand extends Command
{
	private $conversionTable = [
		'M'  => 1000,
		'CM' => 900,
		'D'  => 500,
		'CD' => 400,
		'C'  => 100,
		'XC' => 90,
		'L'  => 50,
		'XL' => 40,
		'X'  => 10,
		'IX' => 9,
		'V'  => 5,
		'IV' => 4,
		'I'  => 1
	];

	/**
	 * Configuration of command.
	 */
	protected function configure()
	{
		$this
			->setName('app:arabic-to-roman')
			->setDescription('Arabic to roman converter.')
			->setHelp('With this command you can convert an arabic number to a roman number.')
			->addArgument('arabicNumber', InputArgument::REQUIRED, 'Arabic number to convert.');
	}

	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 *
	 * @return void
	 *
	 * @throws InvalidArgumentException
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$arabicNumber = $input->getArgument('arabicNumber');

		if (!$this->isValidArabic($arabicNumber))
		{
			throw new InvalidArgumentException(sprintf('The given arabic number "%s" cannot be converted to roman number!', $arabicNumber));
		}

		$romanNumber = '';

		do
		{
			foreach ($this->conversionTable as $roman => $arabic)
			{
				if ($arabicNumber >= $arabic)
				{
					$romanNumber  .= $roman;
					$arabicNumber -= $arabic;
					break;
				}
			}
		}
		while ($arabicNumber > 0);

		$output->writeln(sprintf('The given arabic number "%s" is egual to "%s" as a roman number.', $input->getArgument('arabicNumber'), $romanNumber));
	}

	/**
	 * @param int $arabicNumber
	 *
	 * @return bool
	 */
	private function isValidArabic($arabicNumber)
	{
		return is_numeric($arabicNumber) && $arabicNumber > 0 && $arabicNumber < 4000;
	}
} 