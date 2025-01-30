<?php

namespace App\Exception\Credit\Request;

use Symfony\Component\Asset\Exception\AssetNotFoundException;

class NotFoundException extends AssetNotFoundException
{
	public function __construct(string $message = '', array $alternatives = [], int $code = 0, ?\Throwable $previous = null)
	{
		if (empty($message))
		{
			$message = 'Request not found';
		}

		parent::__construct(
			$message, $alternatives, $code, $previous
		);
	}
}