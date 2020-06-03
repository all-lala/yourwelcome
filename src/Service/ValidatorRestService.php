<?php
namespace App\Service;

use Doctrine\ORM\Mapping\Entity;
use App\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorRestService
{
    private $validator;
    
    public function __construct(ValidatorInterface $validator) {
        $this->validator = $validator;
    }
    
    /**
     * Valide les données et/ou retourne une erreur
     *
     * @param $entity
     * @throws ValidatorException
     */
    public function valid($entity) {
        $errors = $this->validator->validate($entity);
        
        if ($errors->count()) {
            throw new ValidatorException('Validation Error', null, null, $errors);
        }
    }
}

