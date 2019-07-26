<?php

namespace App\Repository;

use App\Entity\Survey;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Survey|null find($id, $lockMode = null, $lockVersion = null)
 * @method Survey|null findOneBy(array $criteria, array $orderBy = null)
 * @method Survey[]    findAll()
 * @method Survey[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SurveyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Survey::class);
    }

    public function findAllForToday($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.createdAt LIKE :val')
            ->setParameter('val', $value."%")
            ->getQuery()
            ->getResult()
            ;
    }

    public function findOneForMeToday($value, $userId)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.createdAt LIKE :val')
            ->andWhere('s.user = :userid')
            ->setParameter('val', $value."%")
            ->setParameter('userid', $userId)
            ->orderBy('s.createdAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function findAllForMe($userId) {
        return $this->createQueryBuilder('s')
            ->andWhere('s.user = :userid')
            ->setParameter('userid', $userId)
            ->orderBy('s.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Survey[] Returns an array of Survey objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Survey
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
