<?php


namespace App\Controller;

use App\Service\ZoneService;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ZoneController extends AbstractController
{
    /** @var ZoneService $zoneService */
    private $zoneService;

    /**
     * VehicleController constructor.
     * @param ZoneService $zoneService
     */
    public function __construct(ZoneService $zoneService){
        $this->zoneService = $zoneService;
    }

    /**
     * @Route("/createZone", name="create_zone", methods={"POST"}))
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function createZoneAction(Request $request){
        $name = $request->get('name');
        $address = $request->get('address');
        $cityId = $request->get('cityId');

        try {
            $zone = $this->zoneService->createZone($cityId, $address, $name);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        return $this->json([
            'zone' => $zone
        ],200, ['Content-Type' => 'application/json']);

    }
}