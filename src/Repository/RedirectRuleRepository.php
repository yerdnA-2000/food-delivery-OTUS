<?php

namespace App\Repository;

use App\Entity\RedirectRule;
use Doctrine\ORM\EntityRepository;

class RedirectRuleRepository extends EntityRepository
{
    /**
     * Находит правила редиректа для конкретного ресторана по его slug.
     *
     * @param string $restaurantSlug
     * @return RedirectRule[]
     */
    public function findByRestaurantSlug(string $restaurantSlug): array
    {
        $qb = $this->createQueryBuilder('rr')
            ->join('rr.restaurant', 'r')
            ->andWhere('r.slug = :slug')
            ->setParameter('slug', $restaurantSlug);

        return $qb->getQuery()->getResult() ?? [];
    }
}