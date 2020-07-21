<?php
namespace App\Security;

use App\Entity\ConfigurationVictoire;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use App\Entity\User;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ConfigurationVictoireVoter extends Voter
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
        
        if (!$subject instanceof ConfigurationVictoire) {
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
        
        /** @var ConfigurationVictoire $configurationVictoire */
        $configurationVictoire = $subject;
        
        switch ($attribute) {
            case self::VIEW:
                return $this->canView($configurationVictoire, $user);
            case self::EDIT:
                return $this->canEdit($configurationVictoire, $user);
            case self::ADD:
                return $this->canAdd($configurationVictoire, $user);
            case self::REMOVE:
                return $this->canRemove($configurationVictoire, $user);
        }
        
        throw new \LogicException('This code should not be reached!');
    }
    
    private function canView(ConfigurationVictoire $configurationVictoire, User $user)
    {
        if ($this->canEdit($configurationVictoire, $user)) {
            return true;
        }
    }
    
    private function canAdd(ConfigurationVictoire $configurationVictoire, User $user)
    {
        if ($this->canEdit($configurationVictoire, $user)) {
            return true;
        }
    }
    
    private function canRemove(ConfigurationVictoire $configurationVictoire, User $user)
    {
        if ($this->canEdit($configurationVictoire, $user)) {
            return true;
        }
    }
    
    private function canEdit(ConfigurationVictoire $configurationVictoire, User $user)
    {
        return $configurationVictoire->getMariage()->getUsers()->exists(function($key, $element) use ($user){ return $user === $element;});
    }
}

