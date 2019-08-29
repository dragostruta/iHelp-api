<?php

namespace App\Service;

use App\Entity\ApiToken;
use App\Entity\User;
use App\Repository\UserRepository;;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class AuthService
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param $email
     * @return string|null
     * @throws \Exception
     */
    public function generateToken($email){
        /** @var User $user */
        $user = $this->userRepository->findOneBy([
            'email' => $email
        ]);

        if (!$user){
            throw new CustomUserMessageAuthenticationException('User not found');
        }

        try {
            /** @var ApiToken $token */
            $token = new ApiToken($user);

            $user->setLastLogin(new \DateTime());

            $this->entityManager->persist($token);
            $this->entityManager->flush();
        }catch (Exception $exception){
            throw new Exception($exception->getMessage());
        }

        return $token->getToken();
    }
}