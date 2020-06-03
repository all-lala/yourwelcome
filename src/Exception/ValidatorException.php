<?php
namespace App\Exception;

class ValidatorException extends \Exception
{
    
    private $errors;
    
    /**
     * {@inheritDoc}
     * @see \Exception::__construct()
     */
    public function __construct($message = null, $code = null, $previous = null,  $errors = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }
    
    public function getErrors() {
        return $this->errors;
    }
    
}

