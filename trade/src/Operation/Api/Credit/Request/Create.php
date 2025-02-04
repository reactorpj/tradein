<?php

namespace App\Operation\Api\Credit\Request;

use App\Dto\Credit\Request\PostInput;
use App\Contracts\Api\Dto;
use App\Contracts\Api\Operation;
use App\Entity\Credit\Request\Request;
use App\Exception\Credit\Request\NotFoundException;
use App\Repository\Car\CarRepository;
use App\Repository\Credit\ProgramRepository;
use App\Repository\Credit\RequestRepository;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ValidatorBuilder;

final readonly class Create implements Operation
{
	public function __construct(
		private CarRepository $carRepository,
		private ProgramRepository $programRepository,
		private RequestRepository $requestRepository,
		private ValidatorInterface $validator
	)
	{}

	/**
	 * @param PostInput $dto
	 * @return Request
	 */
	public function handle(Dto $dto): Request
	{
		$request = new Request();

		[$car, $program] = $this->getReferenceEntitiesOrFailed($dto);

		$request->setCar($car);
		$request->setProgram($program);
		$request->setLoanTerm($dto->loanTerm);
		$request->setInitialPayment($dto->initialPayment);

		$errors = $this->validator->validate($request);
		if (count($errors) > 0) {
			/** @var ConstraintViolation $firstError */
			$firstError = $errors[0];
			throw new ValidatorException($firstError->getMessage(), $firstError->getCode());
		}

		$this->requestRepository->save($request);

		return $request;
	}

	/**
	 * @param Dto|PostInput $dto
	 * @return array
	 */
	public function getReferenceEntitiesOrFailed(Dto|PostInput $dto): array
	{
		$car = $this->carRepository->find($dto->carId);
		$program = $this->programRepository->find($dto->programId);

		if ($car === null)
		{
			throw new NotFoundException('Car not found');
		}

		if ($program === null)
		{
			throw new NotFoundException('Program not found');
		}

		return array($car, $program);
	}
}