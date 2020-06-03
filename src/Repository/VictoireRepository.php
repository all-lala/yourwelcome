<?php

namespace App\Repository;

use App\Entity\Victoire;
use App\Repository\ExtendedRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Victoire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Victoire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Victoire[]    findAll()
 * @method Victoire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VictoireRepository extends ExtendedRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Victoire::class);
    }
}
