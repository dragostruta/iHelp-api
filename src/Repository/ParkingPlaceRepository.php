<?php

namespace App\Repository;

use App\Entity\ParkingPlace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ParkingPlace|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParkingPlace|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParkingPlace[]    findAll()
 * @method ParkingPlace[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParkingPlaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParkingPlace::class);
    }

    // /**
    //  * @return ParkingPlace[] Returns an array of ParkingPlace objects
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
    public function findOneBySomeField($value): ?ParkingPlace
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
