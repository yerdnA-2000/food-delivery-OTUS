<?php

namespace App\Tests\Functional\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoadUsers extends Fixture
{
    const USER_MAIN = 'main@example.test';
    const USER_MAIN_PASSWORD = 'password';

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getUsers() as $user) {
            $manager->persist($user);
        }

        $manager->flush();
    }

    /**
     * @return list<User>
     */
    private function getUsers(): array
    {
        $result = [];

        $user = new User();
        $user->setEmail(self::USER_MAIN)
            ->setPassword($this->passwordHasher->hashPassword($user, self::USER_MAIN_PASSWORD));

        $result[] = $user;

        return $result;
    }
}