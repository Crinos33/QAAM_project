<?php

namespace App\Repository;

use App\Entity\OptionSurvey;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OptionSurvey|null find($id, $lockMode = null, $lockVersion = null)
 * @method OptionSurvey|null findOneBy(array $criteria, array $orderBy = null)
 * @method OptionSurvey[]    findAll()
 * @method OptionSurvey[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OptionSurveyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OptionSurvey::class);
    }

    // /**
    //  * @return OptionSurvey[] Returns an array of OptionSurvey objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OptionSurvey
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
