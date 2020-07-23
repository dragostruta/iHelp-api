<?php


namespace App\Controller;


use App\Service\CityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CityController extends AbstractController
{
    /** @var CityService $cityService */
    private $cityService;

    /**
     * CityController constructor.
     * @param CityService $cityService
     */
    public function __construct(CityService $cityService){
        $this->cityService = $cityService;
    }

    /**
     * @Route("/createCity", name="create_city", methods={"POST"}))
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function createCityAction(Request $request){
        $cityName = $request->get('name');

        try {
            $city = $this->cityService->createCity($cityName);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        return $this->json([
            'vehicle' => $city
        ],200, ['Content-Type' => 'application/json']);
    }
}