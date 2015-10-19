<?php

namespace model;

    class AdTemp 
    {
        private $typeId;
        private $categoryId;
        private $locationId;
        private $header;
        private $description;
        private $price;
        private $name;
        private $mail;
        private $phone;
        private $imageId;
        
        public function __construct($typeId, $categoryId, $locationId, $header, $description, $price, $name, $mail, $phone, $imageId)
        {
            $this->typeId = $typeId;
            $this->categoryId = $categoryId;
            $this->locationId = $locationId;
            $this->header = $header;
            $this->description = $description;
            $this->price = $price;
            $this->name = $name;
            $this->mail = $mail;
            $this->phone = $phone;
            $this->imageId = $imageId;
        }

        public function getType()
        {
            return $this->typeId();
        }
        
        public function getCategory()
        {
            return $this->categoryId;
        }

        public function getLocation()
        {
            return $this->location;
        }

        public function getHeader()
        {
            return $this->header;
        }
        
        public function getDescription()
        {
            return $this->description;
        }
        
        public function getPrice()
        {
            return $this->price;
        }

        public function getName()
        {
            return $this->name;
        }

        public function getMail()
        {
            return $this->mail;
        }

        public function getPhone()
        {
            return $this->phone;
        }

        public function getImage()
        {
            return $this->imageId;
        }
        
    }
