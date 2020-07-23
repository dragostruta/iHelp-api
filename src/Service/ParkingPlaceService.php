<?php


namespace App\Service;


use App\Entity\ParkingPlace;
use App\Entity\Zone;
use App\Repository\CityRepository;
use App\Repository\ParkingPlaceRepository;
use App\Repository\ZoneRepository;
use Doctrine\ORM\EntityManagerInterface;

class ParkingPlaceService
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /** @var ZoneRepository $zoneRepository */
    private $zoneRepository;

    /** @var ParkingPlaceRepository $parkingPlaceRepository */
    private $parkingPlaceRepository;

    /** @var CityRepository $cityRepository */
    private $cityRepository;

    /**
     * VehicleService constructor.
     * @param EntityManagerInterface $entityManager
     * @param ZoneRepository $zoneRepository
     * @param ParkingPlaceRepository $parkingPlaceRepository
     * @param CityRepository $cityRepository
     */
    public function __construct(EntityManagerInterface $entityManager, ZoneRepository $zoneRepository, ParkingPlaceRepository $parkingPlaceRepository, CityRepository $cityRepository){
        $this->entityManager = $entityManager;
        $this->zoneRepository = $zoneRepository;
        $this->parkingPlaceRepository = $parkingPlaceRepository;
        $this->cityRepository = $cityRepository;
    }

    /**
     * @param $zoneId
     * @param $address
     * @param $numberParkingSpotsTotal
     * @param $numberParkingSpotsFree
     * @param $pricePerHour
     * @param $currency
     * @return ParkingPlace
     * @throws \Exception
     */
    public function createParkingPlace($zoneId, $address, $numberParkingSpotsTotal, $numberParkingSpotsFree, $pricePerHour, $currency){
        /** @var Zone $zone */
        $zone = $this->zoneRepository->findOneBy(['id' => $zoneId]);
        if (!$zone){
            throw new \Exception('Zone does not exists');
        }

        $parkingPlace = new ParkingPlace();
        $parkingPlace->setAddress($address);
        $parkingPlace->setZone($zone);
        $parkingPlace->setNumberParkingSpotsTotal($numberParkingSpotsTotal);
        $parkingPlace->setNumberParkingSpotsFree($numberParkingSpotsFree);
        $parkingPlace->setPricePerHour($pricePerHour);
        $parkingPlace->setCurrency($currency);

        $this->entityManager->persist($parkingPlace);
        $this->entityManager->flush();

        return $parkingPlace;
    }

    /**
     * @param $id
     * @return int|null
     * @throws \Exception
     */
    private function getByParkingSpots($id){
        $parkingPlace = $this->parkingPlaceRepository->findOneBy(['id' => $id]);
        if (!$parkingPlace){
            throw new \Exception('Parking place does not exists');
        }

        return $parkingPlace->getNumberParkingSpotsFree();
    }

    /**
     * @param $id
     * @return int|null
     * @throws \Exception
     */
    private function getByZone($id){
        $zone = $this->zoneRepository->findOneBy(['id' => $id]);
        if (!$zone){
            throw new \Exception('Zone does not exists');
        }

        $parkingPlaces = $this->parkingPlaceRepository->findBy(['zone' => $id]);
        if (count($parkingPlaces) === 0){
            throw new \Exception('There are no parking places in this zone');
        }
        $freeParkingSpots = 0;
        /** @var ParkingPlace $place */
        foreach ($parkingPlaces as $place){
            $freeParkingSpots += $place->getNumberParkingSpotsFree();
        }

        return $freeParkingSpots;
    }

    /**
     * @param $id
     * @return int|null
     * @throws \Exception
     */
    private function getByCity($id){
        $city = $this->cityRepository->findOneBy(['id' => $id]);
        if (!$city){
            throw new \Exception('City does not exists');
        }

        $zones = $this->zoneRepository->findBy(['city' => $city]);
        if (count($zones) === 0){
            throw new \Exception('This City does not have any zones');
        }

        $freeParkingSpots = 0;
        /** @var Zone $zone */
        foreach ($zones as $zone){
            try {
                $freeParkingSpots += $this->getByZone($zone->getId());
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        }

        return $freeParkingSpots;
    }

    /**
     * @param $by
     * @param $id
     * @return int|null
     * @throws \Exception
     */
    public function getNumberFreeParkingSpots($by, $id){
        switch ($by){
            case 'parkingSpots':
                try {
                    return $this->getByParkingSpots($id);
                } catch (\Exception $e) {
                    throw new \Exception($e->getMessage());
                }
                break;
            case 'zone':
                try {
                    return $this->getByZone($id);
                } catch (\Exception $e) {
                    throw new \Exception($e->getMessage());
                }
                break;
            case 'city':
                try {
                    return $this->getByCity($id);
                } catch (\Exception $e) {
                    throw new \Exception($e->getMessage());
                }
                break;
            default:
                throw new \Exception('Please insert a valid option');
        }
    }
}