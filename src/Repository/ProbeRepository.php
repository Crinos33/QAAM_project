<?php

namespace App\Repository;

use App\Entity\Probe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Probe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Probe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Probe[]    findAll()
 * @method Probe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProbeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Probe::class);
    }

    // /**
    //  * @return Probe[] Returns an array of Probe objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Probe
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
