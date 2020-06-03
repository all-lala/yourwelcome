<?php

namespace App\Service;

use App\Entity\Mariage;
use App\Repository\MariageRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;

/**
 * Description of MariageService
 *
 * @author all-lala
 */
class MariageService {
    
    private $repository;
    
    private $validator;
    
    private $s;
    
    public function __construct(SerializerInterface $serializer, MariageRepository $repository, ValidatorRestService $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->s= $serializer;
    }
    
    /**
     * Retourne un mariage
     *
     * @param int $mariageId
     * @return Mariage
     */
    public function getMariage(int $mariageId) : Mariage {
        return $this->repository->find($mariageId);
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
