<?php

namespace App\Repository;

use App\Entity\MotifAnnulation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MotifAnnulation|null find($id, $lockMode = null, $lockVersion = null)
 * @method MotifAnnulation|null findOneBy(array $criteria, array $orderBy = null)
 * @method MotifAnnulation[]    findAll()
 * @method MotifAnnulation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotifAnnulationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MotifAnnulation::class);
    }

    // /**
    //  * @return MotifAnnulation[] Returns an array of MotifAnnulation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MotifAnnulation
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
