<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Entity\User;
use App\Service\SecurityService;
use Symfony\Component\HttpFoundation\Response;
use App\Exception\ValidatorException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use PhpParser\JsonDecoder;
use Symfony\Component\Serializer\SerializerInterface;


class SecurityController extends AbstractController
{
    public function apiLogin(): JsonResponse
    {
        $user = $this->getUser();

        return new JsonResponse([
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ]);
    }
    
    public function login(AuthenticationUtils $authenticationUtils): JsonResponse
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return new JsonResponse(['last_username' => $lastUsername, 'error' => $error]);
    }
    
    public function register(Request $request, SecurityService $securitySevice, JWTTokenManagerInterface $jwtManager, SerializerInterface $serializer) {
        try {
            $newUser = $serializer->deserialize($request->getContent(), User::class, 'json' );
            $securitySevice->register($newUser);
            $token = $jwtManager->create($newUser);
            return new JsonResponse(['token' => $token], Response::HTTP_CREATED);
        } catch (ValidatorException $errors) {
            return new JsonResponse($errors->getErrors(), Response::HTTP_BAD_REQUEST);
        }
    }
}