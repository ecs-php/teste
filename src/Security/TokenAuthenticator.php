<?php

namespace Antomarsi\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }
    public function getCredentials(Request $request)
    {
        if (!$token = $request->headers->get('Authorization')) {
            return;
        }
        $token = base64_decode(\str_replace('Basic ', '', $token));
        if (false === strpos($token, ':')) {
            return;
        }
        list($username, $secret) = explode(':', $token, 2);

        return array(
            'username' => $username,
            'secret' => $secret,
        );
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername($credentials['username']);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $encoder = $this->encoderFactory->getEncoder($user);

        return $encoder->isPasswordValid(
            $user->getPassword(),
            $credentials['secret'],
            $user->getSalt()
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = array(
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData()),
        );
        return new JsonResponse($data, 403);
    }
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = array(
            'message' => 'Authentication Required',
        );
        return new JsonResponse($data, 401);
    }
    public function supportsRememberMe()
    {
        return false;
    }
}