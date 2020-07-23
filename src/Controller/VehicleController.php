<?php


namespace App\Controller;

use App\Repository\VehiclesRepository;
use App\Service\VehicleService;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VehicleController extends AbstractController
{
    /** @var VehicleService $vehicleService */
    private $vehicleService;

    /**
     * VehicleController constructor.
     * @param VehicleService $vehicleService
     */
    public function __construct(VehicleService $vehicleService){
        $this->vehicleService = $vehicleService;
    }

    /**
     * @Route("/createVehicle", name="create_vehicle", methods={"POST"}))
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function createVehicleAction(Request $request){
        $userId = $request->get('userId');
        $licensePlate = $request->get('licensePlate');

        try {
            $vehicle = $this->vehicleService->createVehicle($userId, $licensePlate);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        return $this->json([
            'vehicle' => $vehicle
        ],200, ['Content-Type' => 'application/json']);

    }
}