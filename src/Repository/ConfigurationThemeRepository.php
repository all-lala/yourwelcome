<?php

namespace App\Repository;

use App\Entity\ConfigurationTheme;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ExtendedRepository;

/**
 * @method ConfigurationTheme|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConfigurationTheme|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConfigurationTheme[]    findAll()
 * @method ConfigurationTheme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConfigurationThemeRepository extends ExtendedRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConfigurationTheme::class);
    }
}
