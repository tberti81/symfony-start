<?php

namespace Tests\AppBundle\Command;

use AppBundle\Command\CatAndMouseCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class CatAndMouseCommandTest extends KernelTestCase
{
	/** @var Command */
	private $command;

	/** @var CommandTester */
	private $commandTester;

	public function setUp()
	{
		self::bootKernel();
		$application = new Application(self::$kernel);

		$application->add(new CatAndMouseCommand());

		$this->command = $application->find('app:cat-and-mouse');
		$this->commandTester = new CommandTester($this->command);

	}

	public function testExecuteReturnsBoringWithoutTwoAnimals()
	{
		$this->commandTester->execute(
			[
				'command' => $this->command->getName(),

				'map' => '5x5',
			]
		);

		$output = $this->commandTester->getDisplay();

		$outputString = '[ERROR] boring without two animals';

		$this->assertContains($outputString, $output, sprintf('Output doesn\'t contain \'%s\' string!', $outputString));
	}


	public function testExecuteReturnsEscaped()
	{
		$this->commandTester->execute(
			[
				'command' => $this->command->getName(),

				'map'   => '5x5',
				'cat'   => '1:2',
				'mouse' => '4:5',
			]
		);

		$output = $this->commandTester->getDisplay();

		$outputString = '[WARNING] Escaped!';

		$this->assertContains($outputString, $output, sprintf('Output doesn\'t contain \'%s\' string!', $outputString));
	}

	public function testExecuteReturnsCaught()
	{
		$this->commandTester->execute(
			[
				'command' => $this->command->getName(),

				'map'   => '5x5',
				'cat'   => '1:2',
				'mouse' => '3:3',
			]
		);

		$output = $this->commandTester->getDisplay();

		$outputString = '[OK] Caught!';

		$this->assertContains($outputString, $output, sprintf('Output doesn\'t contain \'%s\' string!', $outputString));
	}
}