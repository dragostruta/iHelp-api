<?php


namespace App\Controller;


use App\Service\AuthService;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends AbstractController
{
    /**
     * @var AuthService
     */
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @Route("/register", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function register(Request $request){
        if ($this->isGranted('IS_AUTHENTICATED_ANONYMOUSLY')){

            try{
                $user = $this->authService->registerUser($request);
            } catch (Exception $exception) {
                throw new Exception($exception->getMessage());
            }

            return $this->json([
                'user' => $user
            ],200, ['Content-Type' => 'application/json']);
        }
    }
}