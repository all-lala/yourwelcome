<?php
namespace App\Repository;

use Doctrine\ORM\Mapping\Entity;

interface ExtendedRepositoryInterface
{
    public function save(Entity$entity);
}

