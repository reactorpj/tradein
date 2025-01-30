<?php

namespace App\DataFixtures\Car;

use App\Entity\Car\Brand;
use App\Entity\Car\Model;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ModelFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
		$data = $this->getModels();

		foreach ($data as $key => $models)
		{
			$brand = $this->getReference($key, Brand::class);

			foreach ($models as $model)
			{
				$entity = new Model();

				$entity->setBrand($brand);
				$entity->setTitle($model);

				$manager->persist($entity);
				$manager->flush();

				$this->addReference("{$entity->getId()}", $entity);
			}
		}
    }

	public function getDependencies(): array
	{
		return [BrandFixtures::class];
	}

	/**
	 * @return array[]
	 */
	private function getModels(): array
	{
		return [
			'Gaz' => [
				'M-20',
			],
			'Chrysler' => [
				'Turbine Car',
			],
			'Cord' => [
				'L-29',
			],
			'Aston Martin' => [
				'DB1',
			],
			'Triumph' => [
				'Stag',
			],
			'Alfa Romeo' => [
				'Giulietta',
			],
		];
	}
}
