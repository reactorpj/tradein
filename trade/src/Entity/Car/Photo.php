<?php

namespace App\Entity\Car;

use App\Repository\Car\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PhotoRepository::class)]
#[ORM\Table(name: 'car_photo')]
class Photo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Assert\Type('integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 255)]
    private ?string $path = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): static
    {
        $this->path = $path;

        return $this;
    }
}
