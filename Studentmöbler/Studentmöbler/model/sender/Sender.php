<?php

namespace model;

class Sender
{
    private $name;
    private $mail;
    private $message;
    
    public function __construct()
    {
        
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setMail($mail)
    {
        $this->mail = $mail;
    }
    
    public function getMail()
    {
        return $this->mail;
    }
    
    public function setMessage($message)
    {
        $this->message = $message;
    }
    
    public function getMessage()
    {
        return $this->message;
    }
    
    
    
}