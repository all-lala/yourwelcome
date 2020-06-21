<?php

namespace App\Service;

use App\Entity\Mariage;
use App\Repository\MariageRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Description of MariageService
 *
 * @author all-lala
 */
class MariageService {
    
    private $repository;
    
    private $validator;
    
    public function __construct(MariageRepository $repository, ValidatorRestService $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
    }
    
    /**
     * Retourne un mariage
     *
     * @param int $mariageId
     * @return Mariage[]
     */
    public function getMariage(int $mariageId): Array {
        return $this->repository->findBy(['id' => $mariageId]);
    }
    
    
    /**
     * Modifie un mariage
     *
     * @param Mariage $newMariage
     * @param int $mariageId
     * @return Mariage
     */
    public function updateMariage(Mariage $mariage) {
        if ($mariage->getId()) {
            $this->validator->valid($mariage);
            foreach($mariage->getConfigurations() as $configuration) {
                $configuration->setMariage($mariage);
                $this->validator->valid($configuration);
            }
            foreach($mariage->getConfigurationsTheme() as $configuration) {
                $configuration->setMariage($mariage);
                $this->validator->valid($configuration);
            }
            foreach($mariage->getConfigurationsVictoire() as $configuration) {
                $configuration->setMariage($mariage);
                $this->validator->valid($configuration);
            }
            
            $this->repository->save($mariage);
        } else {
            throw new EntityNotFoundException();
        }
        return $mariage;
    }
}
