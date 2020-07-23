<?php

namespace App\Repository;

use App\Entity\LastLocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LastLocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method LastLocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method LastLocation[]    findAll()
 * @method LastLocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LastLocationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LastLocation::class);
    }

    // /**
    //  * @return LastLocation[] Returns an array of LastLocation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LastLocation
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
