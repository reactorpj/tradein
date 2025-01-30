<?php

namespace App\Dto\Credit\Request;

use App\Contracts\Api\Dto;

final class PostInput implements Dto
{
	public int $carId;
	public int $programId;
	public int $initialPayment;
	public int $loanTerm;
}