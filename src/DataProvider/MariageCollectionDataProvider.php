<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Mariage;
use App\Service\MariageService;
use Symfony\Component\Security\Core\Security;

class MariageCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    
    private $mariageService;
    
    private $security;
    
    public function __construct(MariageService $mariageService, Security $security) {
        $this->mariageService = $mariageService;
        $this->security = $security;
    }
    
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Mariage::class === $resourceClass;
    }
    
    public function getCollection(string $resourceClass, string $operationName = null): Array
    {
        $mariageId = $this->security->getUser()->getMariage()->getId();
        return $this->mariageService->getMariage($mariageId);
    }
}

