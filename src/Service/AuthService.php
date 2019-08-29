<?php

namespace App\Service;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\ApiToken;
use App\Entity\User;
use App\Repository\UserRepository;;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
    /**
     * @var ValidatorInterface
     */
    private $validation;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager, ValidatorInterface $validation, UserPasswordEncoderInterface $encoder)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->validation = $validation;
        $this->encoder = $encoder;
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

    /**
     * @param Request $request
     * @return User
     */
    public function registerUser(Request $request){
        /** @var User $user */
        $user = new User();
        $user->setEmail($request->get('email'));
        $user->setPassword($this->encoder->encodePassword($user, $request->get('password')));
        $user->setFirstName($request->get('firstName'));
        $user->setLastName($request->get('lastName'));
        $user->setAddress($request->get('address'));
        $user->setCity($request->get('city'));
        $user->setCountry($request->get('country'));
        $user->setPhoneNumber($request->get('phoneNumber'));

        $this->validation->validate($user);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}