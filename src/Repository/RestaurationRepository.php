<?php

namespace App\Repository;

use App\Entity\Restauration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Restauration|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restauration|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restauration[]    findAll()
 * @method Restauration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Restauration::class);
    }

    // /**
    //  * @return Restauration[] Returns an array of Restauration objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Restauration
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
