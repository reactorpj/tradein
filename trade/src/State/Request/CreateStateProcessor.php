<?php

namespace App\State\Request;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\Credit\Request\PostInput;
use App\Dto\Credit\Request\PostOutput;
use App\Exception\Credit\Request\NotFoundException;
use App\Operation\Api\Credit\Request\Create;
use Symfony\Component\Validator\Exception\ValidatorException;

final readonly class CreateStateProcessor implements ProcessorInterface
{
	public function __construct(private Create $createOperation) { }

	/**
	 * @param PostInput $data
	 * @param Operation $operation
	 * @param array $uriVariables
	 * @param array $context
	 * @return PostOutput
	 */
	public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): PostOutput
	{
		$output = new PostOutput();

		try
		{
			$request = $this->createOperation->handle($data);
		}
		catch (NotFoundException|ValidatorException)
		{
			$output->success = false;

			return $output;
		}

		$output->success = $request->getId() !== null;

		return $output;
    }
}
