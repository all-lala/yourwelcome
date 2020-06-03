<?php
namespace App\Exception;

class NotNewException extends \Exception
{
    /**
     * {@inheritDoc}
     * @see \Exception::__construct()
     */
    public function __construct($message = 'This creation isn\'t new!', $code = null, $previous = null,  $errors = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

