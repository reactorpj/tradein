<?php

namespace App\Tests\Functional\State\Credit;

use App\Tests\Functional\DbWebTestCase;

class CreateStateProcessorTest extends DbWebTestCase
{
	public function testSuccessSave()
	{
		$this->client->jsonRequest(
			method: 'POST',
			uri: '/api/v1/request',
			parameters: [
				'carId' => 1,
				'programId' => 1,
				'initialPayment' => 20000,
				'loanTerm' => 40,
			],
			server: ['HTTP_ACCEPT' => 'application/json', 'HTTP_CONTENT-TYPE' => 'application/json'],
		);

		$this->assertEquals(201, $this->client->getResponse()->getStatusCode());

		$content = json_decode($this->client->getResponse()->getContent(), true);
		$this->assertArrayHasKey('success', $content);
		$this->assertTrue($content['success']);
	}

	public function testWithNonExistsCar()
	{
		$this->client->jsonRequest(
			method: 'POST',
			uri: '/api/v1/request',
			parameters: [
				'carId' => 234135134,
				'programId' => 1,
				'initialPayment' => 20000,
				'loanTerm' => 40,
			],
			server: ['HTTP_ACCEPT' => 'application/json', 'HTTP_CONTENT-TYPE' => 'application/json'],
		);

		$this->assertEquals(201, $this->client->getResponse()->getStatusCode());

		$content = json_decode($this->client->getResponse()->getContent(), true);
		$this->assertArrayHasKey('success', $content);
		$this->assertFalse($content['success']);
	}
}
