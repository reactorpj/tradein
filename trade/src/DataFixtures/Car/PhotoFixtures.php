<?php

namespace App\DataFixtures\Car;

use App\Entity\Car\Model;
use App\Entity\Car\Photo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class PhotoFixtures extends Fixture implements DependentFixtureInterface
{
	private const BASE_PATH = '/assets/images/';

	public function __construct(private readonly EntityManagerInterface $em) { }

	public function load(ObjectManager $manager): void
	{
		$basePath = self::BASE_PATH;

		$models = $this->em->getRepository(Model::class)->findAll();

		/** @var Model $model */
		foreach ($models as $model)
		{
			$photo = new Photo();


			$path = "{$basePath}{$model->getBrand()->getTitle()}-{$model->getTitle()}";
			$path = str_replace(" ", '_', $path);
			$path = mb_strtolower($path);

			$photo->setPath($path);

			$model->setPhoto($photo);

			$manager->persist($photo);
			$manager->persist($model);
		}

		$manager->flush();
	}

	public function getDependencies(): array
	{
		return [ModelFixtures::class];
	}
}
