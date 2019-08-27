<?php


namespace App\Controller;


use ApiPlatform\Core\Api\IriConverterInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends AbstractController
{
    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(){
        throw new \Exception('Should not be reached');
    }
}