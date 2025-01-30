<?php

namespace App\DataFixtures\Car;

use App\Entity\Car\Car;
use App\Entity\Car\Model;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CarFixtures extends Fixture implements DependentFixtureInterface
{
	private \Faker\Generator $faker;

	public function __construct()
	{
		$this->faker = Factory::create();
	}

	public function load(ObjectManager $manager): void
    {
		$models = $manager->getRepository(Model::class)->findAll();

	    foreach ($models as $model)
	    {
		    $car = new Car();

			$car->setModel($model);
			$car->setBrand($model->getBrand());
			$car->setPrice($this->faker->numberBetween(20000, 40000));

			$manager->persist($car);
		    $manager->flush();
	    }

    }

	public function getDependencies(): array
	{
		return [ModelFixtures::class];
	}
}
