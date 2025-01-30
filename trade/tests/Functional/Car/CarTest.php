<?php

namespace App\Tests\Functional\Car;

use App\Tests\Functional\DbWebTestCase;

class CarTest extends DbWebTestCase
{
	public function testGetCars()
	{
		$this->client->request('GET', '/api/v1/cars');

		$this->assertEquals(200, $this->client->getResponse()->getStatusCode());
		$this->assertJson($this->client->getResponse()->getContent());
		$content = json_decode($this->client->getResponse()->getContent(), true);
		$car = $content[0];

		$this->assertArrayHasKey('id', $car);
		$this->assertIsInt($car['id']);
		$this->assertArrayHasKey('photo', $car);
		$this->assertIsString($car['photo']);
		$this->assertArrayHasKey('price', $car);
		$this->assertIsInt($car['price']);
		$this->assertArrayHasKey('brand', $car);
		$this->assertIsArray($car['brand']);
		$this->assertArrayHasKey('id', $car['brand']);
		$this->assertIsInt($car['brand']['id']);
		$this->assertArrayHasKey('name', $car['brand']);
		$this->assertIsString($car['brand']['name']);

		$this->assertArrayNotHasKey('model', $car);
	}

	public function testGetCar()
	{
		$this->client->request('GET', '/api/v1/cars/1');

		$this->assertEquals(200, $this->client->getResponse()->getStatusCode());
		$this->assertJson($this->client->getResponse()->getContent());
		$content = json_decode($this->client->getResponse()->getContent(), true);
		$car = $content;

		$this->assertArrayHasKey('id', $car);
		$this->assertIsInt($car['id']);
		$this->assertArrayHasKey('photo', $car);
		$this->assertIsString($car['photo']);
		$this->assertArrayHasKey('price', $car);
		$this->assertIsInt($car['price']);
		$this->assertArrayHasKey('brand', $car);
		$this->assertIsArray($car['brand']);
		$this->assertArrayHasKey('id', $car['brand']);
		$this->assertIsInt($car['brand']['id']);
		$this->assertArrayHasKey('name', $car['brand']);
		$this->assertIsString($car['brand']['name']);

		$this->assertArrayHasKey('model', $car);
		$this->assertIsArray($car['model']);
		$this->assertArrayHasKey('id', $car['model']);
		$this->assertIsInt($car['model']['id']);
		$this->assertArrayHasKey('name', $car['model']);
		$this->assertIsString($car['model']['name']);
	}

	public function testEmptyCat()
	{
		$this->client->request('GET', '/api/v1/cars/1345324');

		$this->assertEquals(404, $this->client->getResponse()->getStatusCode());
	}
}