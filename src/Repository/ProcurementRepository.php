<?php

namespace App\Repository;

use App\Entity\Procurement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Procurement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Procurement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Procurement[]    findAll()
 * @method Procurement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProcurementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Procurement::class);
    }

    // /**
    //  * @return Procurement[] Returns an array of Procurement objects
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
    public function findOneBySomeField($value): ?Procurement
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
