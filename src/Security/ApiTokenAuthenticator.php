<?php

namespace App\Security;

use App\Repository\ApiTokenRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class ApiTokenAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var ApiTokenRepository
     */
    private $apiTokenRepository;
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(ApiTokenRepository $apiTokenRepository, EntityManagerInterface $entityManager, UserRepository $userRepository, UserPasswordEncoderInterface $encoder)
    {
        $this->apiTokenRepository = $apiTokenRepository;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->encoder = $encoder;
    }

    public function supports(Request $request)
    {
        return ($request->headers->has('Authorization') && 0 === strpos($request->headers->get('Authorization'), 'Bearer ')) ||
            'app_login' === $request->attributes->get('_route') && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        if ($request->headers->get('Authorization')) {
            $authorizationHeader = $request->headers->get('Authorization');
            return [
                'token' => substr($authorizationHeader, 7),
            ];
        } else {
            return [
                'email' => $request->request->get('email'),
                'password' => $request->request->get('password')
            ];
        }
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        if (array_key_exists('token', $credentials)) {
            $token = $this->apiTokenRepository->findOneBy([
                'token' => $credentials['token'],
            ]);

            if (!$token) {
                throw new CustomUserMessageAuthenticationException('Invalid API Token');
            }

            if ($token->isExpired()) {
                throw new CustomUserMessageAuthenticationException('Token Expired');
            }

            return $token->getUser();
        } else {
            $user = $this->userRepository->findOneBy([
                'email' => $credentials['email'],
            ]);

            if (!$user){
                throw new CustomUserMessageAuthenticationException('User not found');
            }

            if (!$this->encoder->isPasswordValid($user, $credentials['password'])){
                throw new CustomUserMessageAuthenticationException('Password is not valid');
            }

            return $user;
        }
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse([
            'message' => $exception->getMessageKey()
        ], 401);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // allow the request to continue
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        throw new \Exception('Not used: entry point from another authentification is used');
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
