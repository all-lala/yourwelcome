<?php

namespace App\Repository;

use App\Entity\Theme;
use App\Repository\ExtendedRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Theme|null find($id, $lockMode = null, $lockVersion = null)
 * @method Theme|null findOneBy(array $criteria, array $orderBy = null)
 * @method Theme[]    findAll()
 * @method Theme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThemeRepository extends ExtendedRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Theme::class);
    }
}