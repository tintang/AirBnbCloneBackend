<?php

namespace App\Repository;

use App\Entity\RegistrationDOI;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RegistrationDOI|null find($id, $lockMode = null, $lockVersion = null)
 * @method RegistrationDOI|null findOneBy(array $criteria, array $orderBy = null)
 * @method RegistrationDOI[]    findAll()
 * @method RegistrationDOI[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegistrationDOIRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegistrationDOI::class);
    }

    // /**
    //  * @return RegistrationDOI[] Returns an array of RegistrationDOI objects
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
    public function findOneBySomeField($value): ?RegistrationDOI
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
