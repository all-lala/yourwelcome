<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Service\TableService;
use Symfony\Component\Security\Core\Security;
use App\Entity\Table;

class TableCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    
    private $tableService;
    
    private $security;
    
    public function __construct(TableService $tableService, Security $security) {
        $this->tableService = $tableService;
        $this->security = $security;
    }
    
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Table::class === $resourceClass;
    }
    
    public function getCollection(string $resourceClass, string $operationName = null): Array
    {
        $mariageId = $this->security->getUser()->getMariage()->getId();
        return $this->tableService->getTables($mariageId);;
    }
}

