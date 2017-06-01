<?php

namespace AppBundle\Command\Animal;

abstract class Animal
{
	protected $name;

	protected $numberOfLegs;

	public function __construct($name)
	{
		$this->name = $name;
	}

	public function getName()
	{
		return $this->name;
	}

	abstract public function getNumberOfLegs();
}