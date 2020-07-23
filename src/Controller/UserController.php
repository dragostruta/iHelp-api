<?php


namespace App\Controller;

use Exception;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    /** @var UserService $userService */
    private $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    /**
     * @Route("/editUser", name="edit_user", methods={"POST"}))
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function editUserAction(Request $request){

        try {
            $user = $this->userService->editUser($request);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        return $this->json([
            'user' => $user
        ],200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/getUser", name="get_user", methods={"POST"}))
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function getUserInfo(Request $request){
        $userId = $request->get('userId');

        try {
            $user = $this->userService->getUserInfo($userId);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        return $this->json([
            'user' => $user
        ],200, ['Content-Type' => 'application/json']);
    }
}