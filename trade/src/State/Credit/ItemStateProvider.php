<?php

namespace App\State\Credit;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Validator\Exception\ValidationException;
use App\Dto\Credit\Calculator\GetOutput;
use App\Dto\Credit\Calculator\SuitableProgram;
use App\Entity\Credit\Program\Program;
use App\Operations\Api\Credit\Program\GetSuitableProgram;
use App\Service\Http\QueryParamsService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final readonly class ItemStateProvider implements ProviderInterface
{
	public function __construct(
		private GetSuitableProgram $getSuitableProgramOperation,
		private QueryParamsService $queryParamsService,
	)
	{}

	public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
	{
		[$initialPayment, $price, $loanTerm] = $this->parseParams($context['uri']);

		$dto = $this->makeSuitableProgramDto($initialPayment, $price, $loanTerm);
		$program = $this->getSuitableProgramOperation->handle($dto);

		if ($program === null)
		{
			throw new NotFoundHttpException('Program not found');
		}

		return $this->makeOutputProgramDto($price, $initialPayment, $program, $loanTerm);
	}

	/**
	 * @param array $result
	 */
	private function validateQueryParams(array $result): void
	{
		if (
			!isset($result['loanTerm'])
			|| !is_numeric($result['loanTerm'])
			|| !isset($result['initialPayment'])
			|| !is_numeric($result['initialPayment'])
			|| !isset($result['price'])
			|| !is_numeric($result['price'])
		)
		{
			throw new ValidationException('You should pass numeric loanTerm, initialPayment and price');
		}
	}

	private function getMonthlyPayment(mixed $suitableProgram, int $loanTerm, float $paymentBody): int
	{
		$fullPayment = $paymentBody * $suitableProgram->getInterestRate();

		return (int)($fullPayment / $loanTerm);
	}

	/**
	 * @param int $price
	 * @param float $initialPayment
	 * @param Program $program
	 * @param int $loanTerm
	 * @return GetOutput
	 */
	private function makeOutputProgramDto(int $price, float $initialPayment, Program $program, int $loanTerm): GetOutput
	{
		$paymentBody = $price - $initialPayment;
		$monthlyPaymentBody = $this->getMonthlyPayment($program, $loanTerm, $paymentBody);

		$outputProgram = new GetOutput();

		$outputProgram->programId = $program->getId();
		$outputProgram->interestRate = $program->getInterestRate();
		$outputProgram->monthlyPayment = $monthlyPaymentBody;
		$outputProgram->title = $program->getTitle();

		return $outputProgram;
	}

	/**
	 * @param $uri
	 * @return array
	 */
	private function parseParams($uri): array
	{
		$parseResult = $this->queryParamsService->parse($uri);
		$this->validateQueryParams($parseResult);

		$initialPayment = (float)$parseResult['initialPayment'];
		$price = (int)$parseResult['price'];
		$loanTerm = (int)$parseResult['loanTerm'];
		return array($initialPayment, $price, $loanTerm);
	}

	/**
	 * @param mixed $initialPayment
	 * @param mixed $price
	 * @param mixed $loanTerm
	 * @return SuitableProgram
	 */
	private function makeSuitableProgramDto(float $initialPayment, int $price, int $loanTerm): SuitableProgram
	{
		$dto = new SuitableProgram();

		$dto->initialPayment = $initialPayment;
		$dto->price = $price;
		$dto->loanTerm = $loanTerm;

		return $dto;
	}
}
