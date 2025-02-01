<?php

namespace App\Operation\Api\Credit\Program;

use App\Dto\Credit\Calculator\SuitableProgram;
use App\Contracts\Api\Dto;
use App\Contracts\Api\Operation;
use App\Entity\Credit\Program\Program;
use App\Repository\Credit\ProgramRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final readonly class GetSuitableProgram implements Operation
{
	public function __construct(
		private ProgramRepository $programRepository
	)
	{}

	/**
	 * @param SuitableProgram $dto
	 * @return Program|null
	 */
	public function handle(Dto $dto): ?Program
	{
		$minDownPaymentPercent = (($dto->initialPayment / $dto->price) * 100);

		return $this->programRepository->findByCondition($minDownPaymentPercent, $dto->loanTerm);
	}
}