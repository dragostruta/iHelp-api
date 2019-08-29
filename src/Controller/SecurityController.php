<?php


namespace App\Controller;


use ApiPlatform\Core\Api\IriConverterInterface;
use App\Service\AuthService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use TheSeer\Tokenizer\Token;

class SecurityController extends AbstractController
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
     * @Route("/login", name="app_login", methods={"POST"}))
     * @param Request $request
     * @return Response
     */
    public function login(Request $request){
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')){
             $token = $this->authService->generateToken($request->get('email'));
             return $this->json([
                 'token' => $token
             ],200,['Content-Type' => 'application/json']);
        }
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(){
        throw new \Exception('Should not be reached');
    }
}