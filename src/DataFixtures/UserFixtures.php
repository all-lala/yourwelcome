<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Entity\Mariage;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
        $this->passwordEncoder = $passwordEncoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $mariageRepository = $manager->getRepository(Mariage::class);
        $mariage = $mariageRepository->find(1);
        $user = new User();
        $plainPassword = "abcdefg";
        $user->setEmail('a@b.c')
            ->setPassword($this->passwordEncoder->encodePassword($user, $plainPassword))
            ->setRoles([])
            ->setMariage($mariage);
        $manager->persist($user);
        $manager->flush();
    }
}
