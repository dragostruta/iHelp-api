<?php

namespace App\Service;


use App\Entity\City;
use Doctrine\ORM\EntityManagerInterface;

class CityService
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /**
     * VehicleService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    public function createCity($name){
        $city = new City();
        $city->setName($name);

        $this->entityManager->persist($city);
        $this->entityManager->flush();

        return $city;
    }
}