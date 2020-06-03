<?php

namespace App\Repository;

use App\Entity\Mariage;
use App\Repository\ExtendedRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mariage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mariage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mariage[]    findAll()
 * @method Mariage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MariageRepository extends ExtendedRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mariage::class);
    }
}
