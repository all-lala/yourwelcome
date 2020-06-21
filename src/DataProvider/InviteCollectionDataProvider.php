<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Service\InviteService;
use Symfony\Component\Security\Core\Security;
use App\Entity\Invite;

class InviteCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    
    private $inviteService;
    
    private $security;
    
    public function __construct(InviteService $inviteService, Security $security) {
        $this->inviteService = $inviteService;
        $this->security = $security;
    }
    
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Invite::class === $resourceClass;
    }
    
    public function getCollection(string $resourceClass, string $operationName = null): Array
    {
        $mariageId = $this->security->getUser()->getMariage()->getId();
        return $this->inviteService->getInvites($mariageId);;
    }
}

