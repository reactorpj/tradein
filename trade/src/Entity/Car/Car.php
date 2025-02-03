<?php

namespace App\Entity\Car;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\Car\CarRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CarRepository::class)]
#[ORM\Table(name: 'car_car')]
#[ApiResource(
	operations: [
		new Get(
			normalizationContext: ['groups' => ['car:item:read']],
		),
		new GetCollection(
			normalizationContext: ['groups' => ['car:list:read']],
		),
	]
)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['car:item:read', 'car:list:read'])]
    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['car:item:read', 'car:list:read'])]
    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    private ?int $price = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['car:item:read', 'car:list:read'])]
    #[Assert\NotBlank]
    private ?Brand $brand = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['car:item:read'])]
    #[Assert\NotBlank]
    private ?Model $model = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $Brand): static
    {
        $this->brand = $Brand;

        return $this;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): static
    {
        $this->model = $model;

        return $this;
    }

	#[Groups(['car:item:read', 'car:list:read'])]
	#[SerializedName('photo')]
	public function getPhotoPath(): ?string
	{
		return $this->getModel()->getPhoto()->getPath();
	}
}
