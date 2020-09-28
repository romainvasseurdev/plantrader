<?php

namespace App\Repository;

use App\Entity\CategoryEchange;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CategoryEchange|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryEchange|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryEchange[]    findAll()
 * @method CategoryEchange[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryEchangeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryEchange::class);
    }

    // /**
    //  * @return CategoryEchange[] Returns an array of CategoryEchange objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategoryEchange
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
