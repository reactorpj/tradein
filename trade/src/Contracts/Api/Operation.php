<?php

namespace App\Contracts\Api;

interface Operation
{
	public function handle(Dto $dto);
}