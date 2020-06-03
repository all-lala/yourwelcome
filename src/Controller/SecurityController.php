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
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use App\Exception\ValidatorException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;


class SecurityController extends AbstractFOSRestController
{
    /**
     * @View(statusCode=200)
     * @Rest\Post("/login", name="api_login")
     */
    public function api_login(): JsonResponse
    {
        $user = $this->getUser();

        return new JsonResponse([
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ]);
    }

    /**
     * @View(statusCode=200)
     * @Rest\Get("/login_check", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): JsonResponse
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return new JsonResponse(['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout()
    {
        // controller can be blank: it will never be executed!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
    
    /**
     * @View(statusCode=200, serializerEnableMaxDepthChecks=true)
     * @Rest\Post(path = "/user/{userId}", name="user_show")
     * @see \Symfony\Bundle\FrameworkBundle\Controller\AbstractController::getUser()
     */
    public function getUserRequest(SecurityService $securitySevice, $userId) {
        return $this->getUser($userId);
    }
    
    /**
     * Enregistre un nouveau couple utilisateur/mariage 
     * @View(statusCode=201, serializerEnableMaxDepthChecks=true)
     * @Rest\Post(path = "/register")
     * @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function register(SecurityService $securitySevice, JWTTokenManagerInterface $jwtManager, User $user) {
        try {
            $securitySevice->register($user);
            $token = $jwtManager->create($user);
            
            return $this->view(['token' => $token],
                Response::HTTP_CREATED,
                ['Location' => $this->generateUrl('user_show', ['userId' => $user->getId(), UrlGeneratorInterface::ABSOLUTE_URL])]);
        } catch (ValidatorException $errors) {
            return $this->view($errors->getErrors(), Response::HTTP_BAD_REQUEST);
        }
    }
}