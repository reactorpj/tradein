<?php

namespace App\Dto\Credit\Calculator;

final class GetOutput
{
	public int $programId;
	public float $interestRate;
	public int $monthlyPayment;
	public string $title;
}