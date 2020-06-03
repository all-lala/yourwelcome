<?php
namespace App\Service;

use App\Repository\ThemeRepository;

class ThemeService
{
    private $repository;
    
    public function __construct(ThemeRepository $repository) {
        $this->repository = $repository;
    }
    
    /**
     * Retourne la liste des themes
     * 
     * @return array
     */
    public function getThemes(): Array {
        return $this->repository->findBy(['visible' => true], ['name' =>'ASC']);
    }
}

