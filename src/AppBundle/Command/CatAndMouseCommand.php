<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CatAndMouseCommand extends Command
{
	protected function configure()
	{
		$this
			->setName('app:cat-and-mouse')
			->setAliases(['cam'])
			->setDescription('Cat and mouse game...')
			->addArgument('map', InputArgument::REQUIRED, 'Map size. [string, format: WxH, e.g. 5x5]')
			->addArgument('cat', InputArgument::OPTIONAL, 'Cat coordinates. [string, format: X:Y, e.g. 1:2]')
			->addArgument('mouse', InputArgument::OPTIONAL, 'Mouse coordinates. [string, format: X:Y, e.g. 1:2]')
			->addArgument('catSteps', InputArgument::OPTIONAL, 'Cat step count. [int]');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$io = new SymfonyStyle($input, $output);

		$mapArg   = $input->getArgument('map');
		$catArg   = $input->getArgument('cat');
		$mouseArg = $input->getArgument('mouse');
		$catSteps = $input->getArgument('catSteps');

		if (null === $catArg || null === $mouseArg)
		{
			$io->error('boring without two animals');

			return;
		}

		list($map['w'], $map['h'])     = explode('x', $mapArg);
		list($cat['x'], $cat['y'])     = explode(':', $catArg);
		list($mouse['x'], $mouse['y']) = explode(':', $mouseArg);

		if (null === $catSteps)
		{
			$catSteps = 5;
		}

		$output->writeln(sprintf('Map: %sx%s, Cat: %s:%s, Mouse: %s:%s, Cat step count: %s', $map['w'], $map['h'], $cat['x'], $cat['y'], $mouse['x'], $mouse['y'], $catSteps));

		$output->writeln('');
		$output->writeln('Map:');

		for ($y = 1; $y <= $map['h']; $y++)
		{
			for ($x = 1; $x <= $map['w']; $x++)
			{
				if ($cat['x'] == $x && $cat['y'] == $y)
				{
					$output->write('C');
				}
				elseif ($mouse['x'] == $x && $mouse['y'] == $y)
				{
					$output->write('m');
				}
				else
				{
					$output->write('.');
				}
			}
			$output->writeln('');
		}

		$output->writeln('');

		$diffX = abs($cat['x'] - $mouse['x']);
		$diffY = abs($cat['y'] - $mouse['y']);

		if ($diffX + $diffY <= $catSteps)
		{
			$io->success('Caught!');
		}
		else
		{
			$io->warning('Escaped!');
		}
	}
}