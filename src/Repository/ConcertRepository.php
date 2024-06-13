<?php

namespace App\Repository;

use App\Entity\Concert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Concert>
 */
class ConcertRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Concert::class);
    }

public function findByCriteria(array $criteria): array
{
    $qb = $this->createQueryBuilder('c');

    if (isset($criteria['ConcertDate'])) && $criteria['ConcertDate'] instanceof \DateTime) {
        $qb->andWhere('c.ConcertDate = :ConcertDate')
            ->setParameter('ConcertDate', $criteria['ConcertDate']);
    }

    if (isset($criteria['Stage'])) {
        $qb->andWhere('c.Stage = :Stage')
            ->setParameter('Stage', $criteria['Stage']);
    }

    if (isset($criteria['Artist.music_style'])) {
        $qb->join('c.Artist', 'a')
            ->join('a.music_style', 'm')
            ->andWhere('m.id = :music_style')
            ->setParameter('music_style', $criteria['Artist.music_style']);
    }

    $qb->orderBy('c.ConcertDate', 'ASC');

    return $qb->getQuery()->getResult();
}

    //    /**
    //     * @return Concert[] Returns an array of Concert objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Concert
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
