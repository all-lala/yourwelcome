<?php
namespace App\Security;

use App\Entity\ConfigurationTheme;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use App\Entity\User;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ConfigurationThemeVoter extends Voter
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
        
        if (!$subject instanceof ConfigurationTheme) {
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
        
        /** @var ConfigurationTheme $configurationTheme */
        $configurationTheme = $subject;
        
        switch ($attribute) {
            case self::VIEW:
                return $this->canView($configurationTheme, $user);
            case self::EDIT:
                return $this->canEdit($configurationTheme, $user);
            case self::ADD:
                return $this->canAdd($configurationTheme, $user);
            case self::REMOVE:
                return $this->canRemove($configurationTheme, $user);
        }
        
        throw new \LogicException('This code should not be reached!');
    }
    
    private function canView(ConfigurationTheme $configurationTheme, User $user)
    {
        if ($this->canEdit($configurationTheme, $user)) {
            return true;
        }
    }
    
    private function canAdd(ConfigurationTheme $configurationTheme, User $user)
    {
        if ($this->canEdit($configurationTheme, $user)) {
            return true;
        }
    }
    
    private function canRemove(ConfigurationTheme $configurationTheme, User $user)
    {
        if ($this->canEdit($configurationTheme, $user)) {
            return true;
        }
    }
    
    private function canEdit(ConfigurationTheme $configurationTheme, User $user)
    {
        return $configurationTheme->getMariage()->getUsers()->exists(function($key, $element) use ($user){ return $user === $element;});
    }
}

