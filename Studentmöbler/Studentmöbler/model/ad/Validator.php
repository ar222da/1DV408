<?php

namespace model;

class Validator
{
    private $message;
    
    
    public function __construct()
    {
        
    }
    
    public function getMessage()
    {
        return $this->message;
    }
    
    public function isValid($input, $fieldName, $required, $minLength, $alphaRequired, $onlyNumericRequired)
    {
        if ($required === true &&
            $input === '')
        {
            $this->message = $fieldName . " måste anges.";
            return false;
        }
        
        if ($input != strip_tags($input))
        {
            $this->message = $fieldName . " innehåller ogiltiga tecken.";
            return false;
        }
        
        else if ($input != stripslashes($input))
        {
            $this->message = $fieldName . " innehåller ogiltiga tecken.";
            return false;
        }
        
        else if ($input != htmlspecialchars($input))
        {
            $this->message = $fieldName . " innehåller ogiltiga tecken.";
            return false;
        }

        else if (strlen($input) < $minLength)
        {
            $this->message = $fieldName . " innehåller för få tecken. Minst " . $minLength . " tecken.";
            return false;
        }
        
        else if ($alphaRequired === true &&
            !preg_match("/[a-öA-Ö]/", $input))
        {
            $this->message = $fieldName . " måste innehålla bokstäver.";
            return false;
        }
        
        else if ($onlyNumericRequired === true &&
            !is_numeric($input))
        {
            $this->message = $fieldName . " måste anges med siffror.";
            return false;
        }
        
        else
        {
            return true;
        }
    }
    
    public function isValidMail($input)
    {
        if ($input === '')
        {
            $this->message = "Epost måste anges.";
            return false;
        }
        
        else if (!filter_var($input, FILTER_VALIDATE_EMAIL))
        {
            $this->message = "Ogiltig epost.";
            return false;
        }
        
        else
        {
            return true;
        }
    }
    
    public function isValidPhone($input)
    {
        if (!preg_match('/^([-+0-9()]+)$/', $input))
        {
            $this->message = "Ogiltig telefonnumer.";
            return false;
        }
        else
        {
            return true;
        }
    }
    
    
    
}