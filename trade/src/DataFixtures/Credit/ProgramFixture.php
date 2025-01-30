<?php

namespace App\DataFixtures\Credit;

use App\Entity\Credit\Program\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProgramFixture extends Fixture
{
	private const MAX_INITIAL_PAYMENT_PERCENT = 99;
	private const MIN_INITIAL_RATE_PERCENT = 5;
	private const COUNT_PROGRAM = 5;
	private const RATE_RANGE = 20;
	private const DEFAULT_RATE = 30;
	const DEFAULT_LOAN_TERM = 360;
	private \Faker\Generator $faker;

	public function __construct()
	{
		$this->faker = \Faker\Factory::create('ru_RU');
	}

	public function load(ObjectManager $manager): void
	{
		$maxPercent = self::MAX_INITIAL_PAYMENT_PERCENT;
		$minRate = self::MIN_INITIAL_RATE_PERCENT;

		for ($i = 0; $i < self::COUNT_PROGRAM; $i++)
		{
			$program = new Program();

			$percent = $this->faker->randomFloat(nbMaxDecimals: 2, min: 5, max: $maxPercent);

			$percentForRate = self::RATE_RANGE * (1 - ($percent / $maxPercent));
			$rate = round($minRate + $percentForRate, 1);

			$program->setInterestRate($rate);
			$program->setMinDownPaymentPercent($percent);
			$program->setTitle($this->faker->words(2, true));
			$program->setLoanTerm($this->faker->numberBetween(20, 60));

			$manager->persist($program);
		}

		//default
		$program = new Program();
		$program->setTitle($this->faker->words(2, true));
		$program->setMinDownPaymentPercent(0);
		$program->setInterestRate(self::DEFAULT_RATE);
		$program->setIsDefault(true);
		$program->setLoanTerm(self::DEFAULT_LOAN_TERM);
		$manager->persist($program);

		$manager->flush();
	}
}
