<?php

namespace App\Entity\Credit\Program;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\QueryParameter;
use App\Repository\Credit\ProgramRepository;
use App\State\Credit\ItemStateProvider;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProgramRepository::class)]
#[ORM\Table(name: 'credit_program')]
#[ApiResource(
	uriTemplate: '/credit/calculate',
	operations: [
		new Get(
			provider: ItemStateProvider::class,
		),
	],
)]
#[QueryParameter(key: 'price')]
#[QueryParameter(key: 'loanTerm')]
#[QueryParameter(key: 'initialPayment')]
class Program
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Assert\Type(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'float')]
    private ?float $minDownPaymentPercent = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'float')]
    private ?float $interestRate = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $title = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    private bool $isDefault = false;

    #[ORM\Column]
    #[Assert\NotBlank]
    private ?int $loanTerm = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getMinDownPaymentPercent(): ?float
    {
        return $this->minDownPaymentPercent;
    }

    public function setMinDownPaymentPercent(float $minDownPaymentPercent): static
    {
        $this->minDownPaymentPercent = $minDownPaymentPercent;

        return $this;
    }

    public function getInterestRate(): ?float
    {
        return $this->interestRate;
    }

    public function setInterestRate(float $interestRate): static
    {
        $this->interestRate = $interestRate;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function isDefault(): bool
    {
        return $this->isDefault;
    }

    public function setIsDefault(bool $isDefault): static
    {
        $this->isDefault = $isDefault;

        return $this;
    }

    public function getLoanTerm(): ?int
    {
        return $this->loanTerm;
    }

    public function setLoanTerm(int $loanTerm): static
    {
        $this->loanTerm = $loanTerm;

        return $this;
    }
}
