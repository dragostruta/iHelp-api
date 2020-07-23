<?php


namespace App\Service;


use App\Entity\City;
use App\Entity\Zone;
use App\Repository\CityRepository;
use Doctrine\ORM\EntityManagerInterface;

class ZoneService
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /** @var CityRepository $cityRepo */
    private $cityRepo;

    /**
     * VehicleService constructor.
     * @param EntityManagerInterface $entityManager
     * @param CityRepository $cityRepo
     */
    public function __construct(EntityManagerInterface $entityManager, CityRepository $cityRepo){
        $this->entityManager = $entityManager;
        $this->cityRepo = $cityRepo;
    }

    /**
     * @param $cityId
     * @param $address
     * @param $name
     * @return Zone
     * @throws \Exception
     */
    public function createZone($cityId, $address, $name){
        /** @var City $city */
        $city = $this->cityRepo->findOneBy(['id' => $cityId]);
        if (!$city){
            throw new \Exception('City does not exists');
        }

        $zone = new Zone();
        $zone->setName($name);
        $zone->setAddress($address);
        $zone->setCity($city);

        $this->entityManager->persist($zone);
        $this->entityManager->flush();

        return $zone;
    }
}