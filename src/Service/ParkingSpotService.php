<?php


namespace App\Service;


use App\Entity\ParkingPlace;
use App\Entity\ParkingSpot;
use App\Entity\Vehicles;
use App\Repository\ParkingPlaceRepository;
use App\Repository\ParkingSpotRepository;
use App\Repository\VehiclesRepository;
use Doctrine\ORM\EntityManagerInterface;

class ParkingSpotService
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /** @var ParkingPlaceRepository $parkingPlaceRepository */
    private $parkingPlaceRepository;

    /** @var VehiclesRepository $vehiclesRepository */
    private $vehiclesRepository;

    /** @var ParkingSpotRepository $parkingSpotRepository */
    private $parkingSpotRepository;

    /**
     * VehicleService constructor.
     * @param EntityManagerInterface $entityManager
     * @param ParkingPlaceRepository $parkingPlaceRepository
     * @param VehiclesRepository $vehiclesRepository
     * @param ParkingSpotRepository $parkingSpotRepository
     */
    public function __construct(EntityManagerInterface $entityManager, ParkingPlaceRepository $parkingPlaceRepository, VehiclesRepository $vehiclesRepository, ParkingSpotRepository $parkingSpotRepository){
        $this->parkingPlaceRepository = $parkingPlaceRepository;
        $this->entityManager = $entityManager;
        $this->vehiclesRepository = $vehiclesRepository;
        $this->parkingSpotRepository = $parkingSpotRepository;
    }

    public function holdAParkingSpot(ParkingPlace $parkingPlace){
        $parkingPlace->setNumberParkingSpotsFree($parkingPlace->getNumberParkingSpotsFree() - 1);
        $this->entityManager->persist($parkingPlace);
        $this->entityManager->flush();
    }

    /**
     * @param $parkingPlaceId
     * @param $vehicleId
     * @param $expireAt
     * @return ParkingSpot
     * @throws \Exception
     */
    public function createParkingSpot($parkingPlaceId, $vehicleId, $expireAt){
        /** @var ParkingPlace $parkingPlace */
        $parkingPlace = $this->parkingPlaceRepository->findOneBy(['id' => $parkingPlaceId]);
        if (!$parkingPlace){
            throw new \Exception('Parking Place does not exists');
        }

        /** @var Vehicles $vehicle */
        $vehicle = $this->vehiclesRepository->findOneBy(['id' => $vehicleId]);
        if (!$vehicle){
            throw new \Exception('Vehicle does not exists');
        }
        $createdAt = new \DateTime('now');
        $createdAt->format('Y-m-d H:s');

        $expireAt = new \DateTime($expireAt);
        $expireAt->format('Y-m-d H:s');

        if ($expireAt < $createdAt){
            throw new \Exception('Expire date lower then when created');
        }

        $parkingSpot = new ParkingSpot();
        $parkingSpot->setVehicle($vehicle);
        $parkingSpot->setParkingPlace($parkingPlace);
        $parkingSpot->setCreatedAt($createdAt);
        $parkingSpot->setExpireAt($expireAt);

        $this->entityManager->persist($parkingSpot);
        $this->entityManager->flush();

        $this->holdAParkingSpot($parkingPlace);

        return $parkingSpot;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteExpiredSpots(){
        $time = new \DateTime('now');
        $time->format('Y-m-d H:s');

        try {
            $sports = $this->parkingSpotRepository->getExpiredSpots($time);
            /** @var ParkingSpot $sport */
            foreach ($sports as $sport) {
                /** @var ParkingPlace $parkingPlaceId */
                $parkingPlace = $sport->getParkingPlace();
                $parkingPlace->setNumberParkingSpotsFree($parkingPlace->getNumberParkingSpotsFree() + 1);

                $this->entityManager->persist($parkingPlace);
                $this->entityManager->remove($sport);
            }
            $this->entityManager->flush();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return true;
    }
}