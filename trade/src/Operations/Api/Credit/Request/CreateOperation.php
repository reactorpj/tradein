<?php

namespace App\Operations\Api\Credit\Request;

use App\Dto\Credit\Request\PostInput;
use App\Contracts\Api\Dto;
use App\Contracts\Api\Operation;
use App\Entity\Car\Car;
use App\Entity\Credit\Program\Program;
use App\Entity\Credit\Request\Request;
use App\Exception\Credit\Request\NotFoundException;
use App\Repository\Credit\RequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;

final readonly class CreateOperation implements Operation
{
	private ObjectRepository $carRepo;
	private ObjectRepository $programRepo;
	/**
	 * @var RequestRepository
	 */
	private ObjectRepository $requestRepo;

	public function __construct(
		protected readonly EntityManagerInterface $manager
	)
	{
		$this->carRepo = $manager->getRepository(Car::class);
		$this->programRepo = $manager->getRepository(Program::class);
		$this->requestRepo = $manager->getRepository(Request::class);
	}

	/**
	 * @param PostInput $dto
	 * @return Request
	 */
	public function handle(Dto $dto): Request
	{
		$request = new Request();

		$car = $this->carRepo->find($dto->carId);
		$program = $this->programRepo->find($dto->programId);

		if ($car === null)
		{
			throw new NotFoundException('Car not found');
		}

		if ($program === null)
		{
			throw new NotFoundException('Program not found');
		}

		$request->setCar($car);
		$request->setProgram($program);
		$request->setLoanTerm($dto->loanTerm);
		$request->setInitialPayment($dto->initialPayment);

		$this->requestRepo->save($request);

		return $request;
	}
}