<?php

namespace App\DataFixtures\Car;

use App\Entity\Car\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends Fixture
{
	public function load(ObjectManager $manager): void
    {
		$brands = [
			'Gaz',
			'Alfa Romeo',
			'Aston Martin',
			'Triumph',
			'Cord',
			'Chrysler'
		];

		foreach ($brands as $brand) {
			$brandEntity = new Brand();
			$brandEntity->setTitle($brand);

			$manager->persist($brandEntity);
			$manager->flush();

			$this->addReference($brand, $brandEntity);
		}
    }
}
