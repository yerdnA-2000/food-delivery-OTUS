<?php

namespace App\Tests\Functional\DataFixtures;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\DataFixtures\Loader;

trait FixtureTrait
{
    /**
     * Загружает фикстуры перед тестами.
     *
     * @param list<string> $fixtures
     */
    protected function loadFixtures(array $fixtures): void
    {
        $entityManager = self::getContainer()->get(EntityManagerInterface::class);

        $loader = new Loader();
        foreach ($fixtures as $fixture) {
            $loader->addFixture(self::getContainer()->get($fixture));
        }

        // Очищаем базу данных и загружаем фикстуры
        $purger = new ORMPurger();
        $executor = new ORMExecutor($entityManager, $purger);
        $executor->execute($loader->getFixtures());
    }
}
