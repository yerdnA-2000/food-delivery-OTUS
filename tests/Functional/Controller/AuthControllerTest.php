<?php

namespace App\Tests\Functional\Controller;

use App\Tests\Functional\DataFixtures\FixtureTrait;
use App\Tests\Functional\DataFixtures\LoadUsers;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthControllerTest extends WebTestCase
{
    use FixtureTrait;

    protected function setUp(): void
    {
        self::createClient();

        $this->loadFixtures([LoadUsers::class]);
    }

    public function testLoginSuccess(): void
    {
        $client = self::getClient();

        $client->request(
            method: 'POST',
            uri: '/api/login',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode([
                'email' => LoadUsers::USER_MAIN,
                'password' => LoadUsers::USER_MAIN_PASSWORD,
            ]),
        );

        self::assertResponseIsSuccessful();

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        self::assertArrayHasKey('token', $data);
    }

    public function testLoginFailure(): void
    {
        $client = self::getClient();

        $client->request(
            method: 'POST',
            uri: '/api/login',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode([
                'email' => 'wrong@example.com',
                'password' => 'wrongpassword',
            ]),
        );

        self::assertResponseStatusCodeSame(401);

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        self::assertArrayHasKey('message', $data);
        self::assertEquals('Invalid credentials.', $data['message']);
    }

    public function testMeActionUnauthorized(): void
    {
        $client = self::getClient();

        $client->request('GET', '/api/me');

        self::assertResponseStatusCodeSame(401);
    }

    public function testMeActionAuthorized(): void
    {
        $client = self::getClient();

        $client->request(
            method: 'POST',
            uri: '/api/login',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode([
                'email' => LoadUsers::USER_MAIN,
                'password' => LoadUsers::USER_MAIN_PASSWORD,
            ]),
        );

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);
        $token = $data['token'];

        $client->request(
            method: 'GET',
            uri: '/api/me',
            server: ['HTTP_AUTHORIZATION' => 'Bearer ' . $token],
        );

        self::assertResponseIsSuccessful();

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        self::assertArrayHasKey('email', $data);
        self::assertArrayHasKey('roles', $data);
    }
}