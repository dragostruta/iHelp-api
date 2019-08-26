<?php


namespace App\Controller;


use ApiPlatform\Core\Api\IriConverterInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login", methods={"POST"})
     */
    public function login(IriConverterInterface $iriConverter)
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->json([
                'error' => 'Invalid login request: check that the Content-Type is application/json',
            ], 400);
        }

        return new Response(null, 204, [
            'Location' => $iriConverter->getIriFromItem($this->getUser()),
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(){
        throw new \Exception('Should not be reached');
    }
}