<?php
namespace App\Security;

use App\Entity\Table;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use App\Entity\User;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TableVoter extends Voter
{
    const VIEW = 'VIEW';
    const EDIT = 'EDIT';
    const DELETE = 'DELETE';
    
    protected function supports(string $attribute, $subject)
    {
        if (!in_array($attribute, [self::VIEW, self::EDIT, self::DELETE])) {
            return false;
        }
        
        if (!$subject instanceof Table) {
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
        
        /** @var Table $table */
        $table = $subject;
        
        switch ($attribute) {
            case self::VIEW:
                return $this->canView($table, $user);
            case self::EDIT:
                return $this->canEdit($table, $user);
            case self::DELETE:
                return $this->canDelete($table, $user);
        }
        
        throw new \LogicException('This code should not be reached!');
    }
    
    private function canView(Table $table, User $user)
    {
        if ($this->canEdit($table, $user)) {
            return true;
        }
    }
    
    private function canDelete(Table $table, User $user)
    {
        if ($this->canEdit($table, $user)) {
            return true;
        }
    }
    
    private function canEdit(Table $table, User $user)
    {
        return $table->getMariage()->getUsers()->exists(function($key, $element) use ($user){ return $user === $element;});
    }
}

