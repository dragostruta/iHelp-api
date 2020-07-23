<?php


namespace App\Controller;


use App\Service\ParkingSpotService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ParkingSpotController extends AbstractController
{
    /** @var ParkingSpotService $parkingSpotService */
    private $parkingSpotService;

    /**
     * ParkingSpotController constructor.
     * @param ParkingSpotService $parkingSpotService
     */
    public function __construct(ParkingSpotService $parkingSpotService){
        $this->parkingSpotService = $parkingSpotService;
    }

    /**
     * @Route("/createParkingSpot", name="create_parking_spot", methods={"POST"}))
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function creatParkingSpotAction(Request $request){
        $parkingPlaceId = $request->get('parkingPlaceId');
        $vehicleId = $request->get('vehicleId');
        $expireAt = $request->get('expireAt');

        try {
            $parkingSpot = $this->parkingSpotService->createParkingSpot($parkingPlaceId, $vehicleId, $expireAt);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        return $this->json([
            'parkingSpot' => $parkingSpot
        ],200, ['Content-Type' => 'application/json']);
    }
}