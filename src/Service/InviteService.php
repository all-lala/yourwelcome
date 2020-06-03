<?php

namespace App\Service;

use App\Entity\Invite;
use App\Entity\Mariage;
use App\Repository\InviteRepository;
use App\Exception\NotNewException;
use Doctrine\ORM\EntityNotFoundException;

/**
 * Description of InviteService
 *
 * @author all-lala
 */
class InviteService {
   
    private $repository;

    private $validator;
    
    public function __construct(InviteRepository $repository, ValidatorRestService $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
    }
    
    /**
     * Retourne la liste des invites pour un mariage
     * 
     * @param int $mariageId
     * @return Invite[]
     */
    public function getInvites(int $mariageId) : Array {
        return $this->repository->findBy(['mariage' => $mariageId], ['id' => 'ASC']);
    }
    
    /**
     * Retourne un invite
     * 
     * @param int $inviteId
     * @param int $mariageId
     * @return Invite
     */
    public function getInvite(int $inviteId, int $mariageId) : Invite {
        return $this->repository->findOneBy(['id' => $inviteId, 'mariage' => $mariageId]);
    }
    
    /**
     * Ajoute une invite
     * 
     * @param Invite $newInvite
     * @param Mariage $mariage
     * @return Invite
     */
    public function addInvite(Invite $newInvite,Mariage $mariage) {
        if($newInvite->getId()){
            throw new NotNewException();
        }
        $newInvite->setMariage($mariage);
        
        $this->validator->valid($newInvite);
        
        $this->repository->save($newInvite);

        return $newInvite;
    }
    
    
    /**
     * Modifie un invite
     *
     * @param Invite $newInvite
     * @param int $mariageId
     * @return Invite
     */
    public function updateInvite(Invite $invite, int $mariageId): Invite {
        if ($invite->getId() && $invite->getMariage()->getId() === $mariageId) {
            $this->validator->valid($invite);
            
            $this->repository->save($invite);
        } else {
            throw new EntityNotFoundException();
        }
        return $invite;
    }
    
    /**
     * Supprime un invité
     * 
     * @param int $inviteId
     * @param int $mariageId
     */
    public function deleteInvite(int $inviteId, int $mariageId) {
        $invite = $this->repository->findOneBy(['id' => $inviteId, 'mariage' => $mariageId]);
        if ($invite) {
            $this->repository->remove($invite);
        } else {
            throw new EntityNotFoundException();
        }
    }
}
