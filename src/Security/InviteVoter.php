<?php

namespace App\Security;

use App\Entity\Invite;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use App\Entity\User;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class InviteVoter extends Voter
{
    const VIEW = 'VIEW';
    const EDIT = 'EDIT';
    const DELETE = 'DELETE';
    
    protected function supports(string $attribute, $subject)
    {
        if (!in_array($attribute, [self::VIEW, self::EDIT, self::DELETE])) {
            return false;
        }
                
        if (!$subject instanceof Invite) {
            return false;
        }
        
        return true;
    }
    
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        
        if (!$user instanceof User) {
            return false;
        }
        
        /** @var Invite $invite */
        $invite = $subject;
        
        switch ($attribute) {
            case self::VIEW:
                return $this->canView($invite, $user);
            case self::EDIT:
                return $this->canEdit($invite, $user);
            case self::DELETE:
                return $this->canDelete($invite, $user);
        }
        
        throw new \LogicException('This code should not be reached!');
    }
    
    private function canView(Invite $invite, User $user)
    {
        if ($this->canEdit($invite, $user)) {
            return true;
        }
    }
    
    private function canDelete(Invite $invite, User $user)
    {
        if ($this->canEdit($invite, $user)) {
            return true;
        }
    }
    
    private function canEdit(Invite $invite, User $user)
    {
        return $invite->getMariage()->getUsers()->exists(function($key, $element) use ($user){ return $user === $element;});
    }
}

