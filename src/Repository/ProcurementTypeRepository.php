<?php

namespace App\Repository;

use App\Entity\ProcurementType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProcurementType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProcurementType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProcurementType[]    findAll()
 * @method ProcurementType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProcurementTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProcurementType::class);
    }

    // /**
    //  * @return ProcurementType[] Returns an array of ProcurementType objects
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
    public function findOneBySomeField($value): ?ProcurementType
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
