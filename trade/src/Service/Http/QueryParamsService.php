<?php

namespace App\Service\Http;

final class QueryParamsService
{
	public function parse($uri): array
	{
		$parseResult = [];
		$urlQuery = parse_url($uri, PHP_URL_QUERY);
		parse_str(htmlspecialchars_decode($urlQuery), $parseResult);

		return $parseResult;
	}
}