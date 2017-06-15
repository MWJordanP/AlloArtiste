<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class UserRepository
 */
class UserRepository extends EntityRepository
{
    /**
     * @param null $city
     * @param null $job
     * @param null $tag
     *
     * @return array
     */
    public function search($city = null, $job = null, $tag = null)
    {
        $qb = $this->createQueryBuilder('user');

        if (null !== $city) {
            $qb
                ->innerJoin('user.city', 'city')
                ->andWhere('city = :city')
                ->setParameter('city', $city);
        }

        if (null !== $job) {
            $qb
                ->innerJoin('user.job', 'job')
                ->andWhere('job = :job')
                ->setParameter('job', $job);
        }

        if (null !== $tag) {
            $qb
                ->innerJoin('user.tags', 'tags')
                ->andWhere('tags = :tag')
                ->setParameter('tag', $tag);
        }

        return $qb
            ->getQuery()
            ->getResult();
    }
}
