<?php


namespace App\Service;


use App\Entity\User;
use App\Entity\Vehicles;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class VehicleService
{
    /** @var UserRepository $userRepo */
    private $userRepo;

    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /**
     * VehicleService constructor.
     * @param UserRepository $userRepo
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(UserRepository $userRepo, EntityManagerInterface $entityManager){
        $this->userRepo = $userRepo;
        $this->entityManager = $entityManager;
    }

    /**
     * Creates a vehicle
     *
     * @param $userId
     * @param $licensePlate
     * @return Vehicles
     * @throws \Exception
     */
    public function createVehicle($userId, $licensePlate){
        /** @var User $user */
        $user = $this->userRepo->findOneBy(['id' => $userId]);
        if (!$user){
            throw new \Exception('User does not exists');
        }

        $vehicle = new Vehicles();
        $vehicle->setUser($user);
        $vehicle->setLicensePlate($licensePlate);

        $this->entityManager->persist($vehicle);
        $this->entityManager->flush();

        return $vehicle;
    }
}