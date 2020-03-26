<?php

namespace App\Repository;

use App\Entity\CommandLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CommandLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandLine[]    findAll()
 * @method CommandLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandLine::class);
    }

    // /**
    //  * @return CommandLine[] Returns an array of CommandLine objects
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
    public function findOneBySomeField($value): ?CommandLine
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
