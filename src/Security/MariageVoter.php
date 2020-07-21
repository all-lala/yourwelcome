<?php

namespace App\Security;

use App\Entity\Mariage;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class MariageVoter extends Voter
{
    const VIEW = 'VIEW';
    const EDIT = 'EDIT';
    
    protected function supports(string $attribute, $subject)
    {
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        if (!$subject instanceof Mariage) {
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

        /** @var Mariage $mariage */
        $mariage = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($mariage, $user);
            case self::EDIT:
                return $this->canEdit($mariage, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Mariage $mariage, User $user)
    {
        if ($this->canEdit($mariage, $user)) {
            return true;
        }
    }

    private function canEdit(Mariage $mariage, User $user)
    {
        return $mariage->getUsers()->exists(function($key, $element) use ($user){ return $user === $element;});
    }
}