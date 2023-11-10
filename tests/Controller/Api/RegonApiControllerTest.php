<?php

/*
 * This file was created by Jakub Szczerba
 * Contact: https://www.linkedin.com/in/jakub-szczerba-3492751b4/
 */

declare(strict_types=1);

namespace Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegonApiControllerTest extends WebTestCase
{
    public function testSearchWithValidAndExistingRegon(): void
    {
        $client = static::createClient();

        $data = [
            'regon' => '000331501'
        ];

        $client->request('POST', '/api/regon', [], [], [], json_encode($data));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testSearchWithNotValidRegon(): void
    {
        $client = static::createClient();

        $data = [
            'regon' => '123'
        ];

        $client->request('POST', '/api/regon', [], [], [], json_encode($data));

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testSearchWithValidAndNotExistingRegon(): void
    {
        $client = static::createClient();

        $data = [
            /* looks familiar :) */
            'regon' => '526292691 '
        ];

        $client->request('POST', '/api/regon', [], [], [], json_encode($data));

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testSearchWithEmptyData(): void
    {
        $client = static::createClient();

        $data = null;

        $client->request('POST', '/api/regon', [], [], [], json_encode($data));

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }
}