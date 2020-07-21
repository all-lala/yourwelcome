<?php
namespace App\Security;

use App\Entity\Configuration;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use App\Entity\User;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ConfigurationVoter extends Voter
{
    const VIEW = 'VIEW';
    const EDIT = 'EDIT';
    const ADD = 'ADD';
    const REMOVE = 'REMOVE';
    
    protected function supports(string $attribute, $subject)
    {
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }
        
        if (!$subject instanceof Configuration) {
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
        
        /** @var Configuration $configuration */
        $configuration = $subject;
        
        switch ($attribute) {
            case self::VIEW:
                return $this->canView($configuration, $user);
            case self::EDIT:
                return $this->canEdit($configuration, $user);
            case self::ADD:
                return $this->canAdd($configuration, $user);
            case self::REMOVE:
                return $this->canRemove($configuration, $user);
        }
        
        throw new \LogicException('This code should not be reached!');
    }
    
    private function canView(Configuration $configuration, User $user)
    {
        if ($this->canEdit($configuration, $user)) {
            return true;
        }
    }
    
    private function canAdd(Configuration $configuration, User $user)
    {
        if ($this->canEdit($configuration, $user)) {
            return true;
        }
    }
    
    private function canRemove(Configuration $configuration, User $user)
    {
        if ($this->canEdit($configuration, $user)) {
            return true;
        }
    }
    
    private function canEdit(Configuration $configuration, User $user)
    {
        return $configuration->getMariage()->getUsers()->exists(function($key, $element) use ($user){ return $user === $element;});
    }
}

