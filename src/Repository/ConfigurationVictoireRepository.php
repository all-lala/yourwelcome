<?php

namespace App\Repository;

use App\Entity\ConfigurationVictoire;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ExtendedRepository;

/**
 * @method ConfigurationVictoire|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConfigurationVictoire|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConfigurationVictoire[]    findAll()
 * @method ConfigurationVictoire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConfigurationVictoireRepository extends ExtendedRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConfigurationVictoire::class);
    }
}
