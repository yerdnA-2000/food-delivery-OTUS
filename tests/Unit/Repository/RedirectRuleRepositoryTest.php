<?php

namespace App\Tests\Unit\Repository;

use App\Entity\RedirectRule;
use App\Repository\RedirectRuleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RedirectRuleRepositoryTest extends TestCase
{
    private EntityManagerInterface&MockObject $em;
    private RedirectRuleRepository $repository;

    protected function setUp(): void
    {
        $this->em = self::createMock(EntityManagerInterface::class);
        $classMetadata = self::createMock(ClassMetadata::class);
        $classMetadata->name = RedirectRule::class;

        $this->repository = new RedirectRuleRepository(
            $this->em,
            $classMetadata,
        );
    }

    public function testFindByRestaurantSlug(): void
    {
        $restaurantSlug = 'test-restaurant';
        $expectedResult = [new RedirectRule(), new RedirectRule()];

        $qb = self::createMock(QueryBuilder::class);
        $query = self::createMock(Query::class);

        $this->em->expects(self::once())
            ->method('createQueryBuilder')
            ->willReturn($qb);

        $qb->expects(self::once())
            ->method('select')
            ->with('rr')
            ->willReturnSelf();
        $qb->expects(self::once())
            ->method('from')
            ->with(RedirectRule::class, 'rr', null)
            ->willReturnSelf();
        $qb->expects(self::once())
            ->method('join')
            ->with('rr.restaurant', 'r')
            ->willReturnSelf();
        $qb->expects(self::once())
            ->method('andWhere')
            ->with('r.slug = :slug')
            ->willReturnSelf();
        $qb->expects(self::once())
            ->method('setParameter')
            ->with('slug', $restaurantSlug)
            ->willReturnSelf();
        $qb->expects(self::once())
            ->method('getQuery')
            ->willReturn($query);

        $query->expects(self::once())
            ->method('getResult')
            ->willReturn($expectedResult);

        $result = $this->repository->findByRestaurantSlug($restaurantSlug);

        self::assertEquals($expectedResult, $result);
    }

    public function testFindByRestaurantSlugReturnsEmptyArrayWhenNoResults(): void
    {
        $restaurantSlug = 'non-existent-restaurant';

        $qb = self::createMock(QueryBuilder::class);

        $query = self::createMock(Query::class);

        $this->em->expects(self::once())
            ->method('createQueryBuilder')
            ->willReturn($qb);

        $qb->expects(self::once())
            ->method('select')
            ->with('rr')
            ->willReturnSelf();
        $qb->expects(self::once())
            ->method('from')
            ->with(RedirectRule::class, 'rr', null)
            ->willReturnSelf();
        $qb->expects(self::once())
            ->method('join')
            ->with('rr.restaurant', 'r')
            ->willReturnSelf();
        $qb->expects(self::once())
            ->method('andWhere')
            ->with('r.slug = :slug')
            ->willReturnSelf();
        $qb->expects(self::once())
            ->method('setParameter')
            ->with('slug', $restaurantSlug)
            ->willReturnSelf();
        $qb->expects(self::once())
            ->method('getQuery')
            ->willReturn($query);

        $query->expects(self::once())
            ->method('getResult')
            ->willReturn([]);

        $result = $this->repository->findByRestaurantSlug($restaurantSlug);

        self::assertIsArray($result);
        self::assertEmpty($result);
    }
}