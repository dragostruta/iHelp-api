<?php


namespace App\Service;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    /** @var UserRepository $userRepository */
    private $userRepository;

    /** @var UserPasswordEncoderInterface $encoder */
    private $encoder;

    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $encoder
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $encoder, EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return User
     * @throws \Exception
     */
    public function editUser(Request $request){
        $userId = $request->get('userId');

        /** @var User $user */
        $user = $this->userRepository->findOneBy(['id' => $userId]);
        if (!$user){
            throw new \Exception('User does not exists');
        }

        $email = $request->get('email') == $user->getEmail() ? $user->getEmail() : $request->get('email');
        $password = $this->encoder->encodePassword($user, $request->get('password')) == $user->getPassword() ? $user->getPassword() : $request->get('password');
        $firstName = $request->get('firstName') == $user->getFirstName() ? $user->getFirstName() : $request->get('firstName');
        $lastName = $request->get('lastName') == $user->getLastName() ? $user->getLastName() : $request->get('lastName');
        $phone = $request->get('phone') == $user->getPhoneNumber() ? $user->getPhoneNumber() : $request->get('phone');
        $country = $request->get('country') == $user->getCountry() ? $user->getCountry() : $request->get('country');
        $city = $request->get('city') == $user->getCity() ? $user->getCity() : $request->get('city');
        $address = $request->get('address') == $user->getAddress() ? $user->getAddress() : $request->get('address');

        $user->setEmail($email);
        $user->setPassword($password);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setPhoneNumber($phone);
        $user->setCountry($country);
        $user->setCity($city);
        $user->setAddress($address);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param $userId
     * @return User
     * @throws \Exception
     */
    public function getUserInfo($userId){
        /** @var User $user */
        $user = $this->userRepository->findOneBy(['id' => $userId]);
        if (!$user){
            throw new \Exception('User does not exists');
        }

        return $user;
    }
}