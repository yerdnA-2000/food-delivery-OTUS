<?php

namespace App\Tests\Unit\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testProperties(): void
    {
        $user = new User();

        self::assertNull($user->getId());
        self::assertEmpty($user->getUserIdentifier());

        self::assertNull($user->getEmail());
        $user->setEmail('test@test.test');
        self::assertSame('test@test.test', $user->getEmail());

        self::assertNull($user->getPassword());
        $user->setPassword('pass');
        self::assertSame('pass', $user->getPassword());

        self::assertSame([], $user->getRoles());
        $user->setRoles(['USER']);
        self::assertSame(['USER'], $user->getRoles());

        self::assertSame('test@test.test', $user->getUserIdentifier());
    }
}