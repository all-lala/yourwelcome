<?php
namespace App\Service;

use App\Repository\VictoireRepository;

class VictoireService
{
    private $repository;
    
    public function __construct(VictoireRepository $repository) {
        $this->repository = $repository;
    }
    
    /**
     * Retourne la liste des victoires
     * 
     * @return array
     */
    public function getVictoires(): Array {
        return $this->repository->findBy(['visible' => true], ['name' =>'ASC']);
    }
}

