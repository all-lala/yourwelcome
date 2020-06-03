<?php
namespace App\Repository;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class ExtendedRepository extends ServiceEntityRepository
{
    /**
     * Save data fom entity
     * {@inheritDoc}
     * @see \App\Repository\ExtendedRepositoryInterface::save()
     */
    public function save($entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);
        return $entity;
    }
    
    /**
     * Delete entity
     * {@inheritDoc}
     * @see \App\Repository\ExtendedRepositoryInterface::save()
     */
    public function remove($entity)
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush($entity);
    }
}

