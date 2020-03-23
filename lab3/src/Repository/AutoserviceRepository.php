<?php

namespace App\Repository;

use App\Entity\Autoservice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Autoservice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Autoservice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Autoservice[]    findAll()
 * @method Autoservice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AutoserviceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Autoservice::class);
    }

    // /**
    //  * @return Autoservice[] Returns an array of Autoservice objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Autoservice
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
