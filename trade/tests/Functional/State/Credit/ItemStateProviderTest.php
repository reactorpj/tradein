<?php

namespace App\Tests\Functional\State\Credit;

use App\Tests\Functional\DbWebTestCase;

class ItemStateProviderTest extends DbWebTestCase
{
	public function testSuccessGetProgram()
	{
		$this->client->request('GET', '/api/v1/credit/calculate?loanTerm=20&initialPayment=20000&price=40000');

		$this->assertEquals(200, $this->client->getResponse()->getStatusCode());
		$this->assertJson($this->client->getResponse()->getContent());

		$content = json_decode($this->client->getResponse()->getContent(), true);
		$this->assertArrayHasKey('programId', $content);
		$this->assertArrayHasKey('interestRate', $content);
		$this->assertArrayHasKey('monthlyPayment', $content);
		$this->assertArrayHasKey('title', $content);
		$this->assertIsNumeric($content['interestRate']);
		$this->assertIsNumeric($content['programId']);
		$this->assertIsNumeric($content['monthlyPayment']);
		$this->assertIsString($content['title']);
	}

	public function testWithoutLoanTerm()
	{
		$this->client->request('GET', '/api/v1/credit/calculate?initialPayment=20000&price=40000');

		$this->assertEquals(400, $this->client->getResponse()->getStatusCode());
	}
}
