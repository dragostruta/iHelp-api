<?php

namespace App\Controller;

use App\Service\ParkingPlaceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ParkingPlaceController extends AbstractController
{
    /** @var ParkingPlaceService $parkingPlaceService */
    private $parkingPlaceService;

    /**
     * ParkingPlaceController constructor.
     * @param ParkingPlaceService $parkingPlaceService
     */
    public function __construct(ParkingPlaceService $parkingPlaceService){
        $this->parkingPlaceService = $parkingPlaceService;
    }

    /**
     * @Route("/createParkingPlace", name="create_parking_place", methods={"POST"}))
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function createParkingPlaceAction(Request $request){
        $zoneId = $request->get('zoneId');
        $address = $request->get('address');
        $numberParkingSpotsTotal = $request->get('numberParkingSpotsTotal');
        $numberParkingSpotsFree = $request->get('numberParkingSpotsFree');
        $pricePerHour = $request->get('pricePerHour');
        $currency = $request->get('currency');

        try {
            $parkingPlace = $this->parkingPlaceService->createParkingPlace($zoneId, $address, $numberParkingSpotsTotal, $numberParkingSpotsFree, $pricePerHour, $currency);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        return $this->json([
            'parkingPlace' => $parkingPlace
        ],200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/getFreeParkingSpots", name="get_free_parking_spots", methods={"POST"}))
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function getFreeParkingSpotsActions(Request $request){
        $by = $request->get('by');
        $id = $request->get('id');

        try {
            $freeParkingSpots = $this->parkingPlaceService->getNumberFreeParkingSpots($by, $id);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        return $this->json([
            'numberFreeParkingSpots' => $freeParkingSpots
        ],200, ['Content-Type' => 'application/json']);
    }
}