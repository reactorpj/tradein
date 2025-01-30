<?php

namespace App\Dto\Credit\Calculator;

use App\Contracts\Api\Dto;

final class SuitableProgram implements Dto
{
	public int $loanTerm;
	public int $price;
	public float $initialPayment;
}