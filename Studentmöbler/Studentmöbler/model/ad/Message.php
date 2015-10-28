<?php

namespace model;

    class Message 
    {
        private $type;
        private $category;
        private $header;
        private $description;
        private $price;
        private $location;
        private $name;
        private $mail;
        private $phone;
        private $image;
        
        public function __construct()
        {
        }
        
        public function setType($text)
        {
            $this->type = $text;
        }

        public function getType()
        {
            return $this->type;
        }
        
        public function setCategory($text)
        {
            $this->category = $text;
        }
        
        public function getCategory()
        {
            return $this->category;
        }
        
        public function setHeader($text)
        {
            $this->header = $text;
        }
        
        public function getHeader()
        {
            return $this->header;
        }
        
        public function setDescription($text)
        {
            $this->description = $text;
        }
        
        public function getDescription()
        {
            return $this->description;
        }
        
        public function setPrice($text)
        {
            $this->price = $text;
        }
        
        public function getPrice()
        {
            return $this->price;
        }
        
        public function setLocation($text)
        {
            $this->location = $text;
        }
        
        public function getLocation()
        {
            return $this->location;
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
        
        public function setPhone($text)
        {
            $this->phone = $text;
        }

        public function getPhone()
        {
            return $this->phone;
        }
        
        public function setImage($text)
        {
            $this->image = $text;
        }

        public function getImage()
        {
            return $this->image;
        }
        
    }
