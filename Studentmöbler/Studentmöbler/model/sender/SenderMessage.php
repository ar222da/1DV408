<?php

namespace model;

    class SenderMessage 
    {
       
        private $name;
        private $mail;
        private $message;
        
        public function __construct()
        {
        }

        public function setName($text)
        {
            $this->name = $text;
        }

        public function getName()
        {
            return $this->name;
        }
        
        public function setMail($text)
        {
            $this->mail = $text;
        }

        public function getMail()
        {
            return $this->mail;
        }
        
        public function setMessage($text)
        {
            $this->message = $text;
        }

        public function getMessage()
        {
            return $this->message;
        }
        
    }
