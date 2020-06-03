<?php

namespace App\Service;

use \App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Description of SecurityService
 *
 * @author all-lala
 */
class SecurityService
{
    private $repository;
    
    private $validator;
    
    private $passwordEncoder;
    
    public function __construct(UserRepository $repository, ValidatorRestService $validator, UserPasswordEncoderInterface $passwordEncoder) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->passwordEncoder = $passwordEncoder;
    }
    
    /**
     * Retourne un utilisateur
     *
     * @param int $userId
     * @return User
     */
    public function getUser(int $userId) : User {
        return $this->repository->find($userId);
    }
    
    /**
     * Enregistre un nouveau couple utilisateur/mariage
     * 
     * @param User $user
     * @return \App\Entity\User
     */
    public function register(User $user): \App\Entity\User {
        $this->validator->valid($user);
        $this->validator->valid($user->getMariage());
        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
        $this->repository->save($user);
        return $user;
    }
}
