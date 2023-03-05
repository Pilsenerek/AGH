<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{

    private const DOMAIN = 'https://agh.local';

    public function testAddProduct()
    {
        static::createClient()->request('POST', self::DOMAIN . '/api/product', [
            'name' => 'Test product name',
        ]);

        self::assertResponseStatusCodeSame(202);
    }

    public function testGetProduct(): void
    {
        $client = static::createClient();
        $client->request('GET', self::DOMAIN . '/api/product/1');
        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('1', $client->getResponse()->getContent());
        $this->assertStringContainsString('id', $client->getResponse()->getContent());
        $this->assertStringContainsString('name', $client->getResponse()->getContent());
    }

    public function testGetProducts(): void
    {
        $client = static::createClient();
        $client->request('GET', self::DOMAIN . '/api/product');
        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('id', $client->getResponse()->getContent());
        $this->assertStringContainsString('name', $client->getResponse()->getContent());
    }
}
