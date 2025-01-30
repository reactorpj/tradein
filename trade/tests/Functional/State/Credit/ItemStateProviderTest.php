<?php

namespace App\Tests\Functional\State\Credit;

use App\Tests\Functional\DbWebTestCase;

class ItemStateProviderTest extends DbWebTestCase
{
	public function testSuccessGetProgram()
	{
		$this->client->request('GET', '/api/v1/credit/calculate');

		$this->assertEquals(200, $this->client->getResponse()->getStatusCode());
		$this->assertJson($this->client->getResponse()->getContent());
	}
}
