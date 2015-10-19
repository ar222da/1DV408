<?php

namespace model;

class Validator
{
    public function __construct()
    {
        
    }
    
    public function validate($input, $minLength, $maxLength, $mustContainAlpha, $mustContainNumeric)
    {
        if (strlen($input) < $minLength)
        {
            
        }
        
        if (strlen($input) > $maxLength)
        {
            
        }
        
        
        
    }
}