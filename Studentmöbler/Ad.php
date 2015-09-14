<?php

    class Ad 
    {
        private $id;
        private $typeId;
        private $categoryId;
        private $locationId;
        private $header;
        private $description;
        private $price;
        private $name;
        private $mail;
        private $date;
        private $imageId;
        
        public function __construct()
        {
            
        }
        
        public function setId($id)
        {
            $this->id = $id;
        }
        
        public function getid()
        {
            return $this->id;
        }
        
        public function setTypeId($typeId)
        {
            $this->typeId = $typeId;
        }
        
        public function getTypeId()
        {
            return $this->typeId();
        }
        
        public function setCategoryId($categoryId)
        {
            $this->categoryId = $categoryId;
        }
        
        public function getCategoryId()
        {
            return $this->categoryId;
        }
        
        public function setLocationId($location)
        {
            $this->location = $location;
        }
        
        public function getLocationId()
        {
            return $this->location;
        }
        
        public function setHeader($header)
        {
            $header = trim($header);
            
            if (isset($header) === true && $header === '')
            {
                throw new Exception ("En rubrik måste anges.");    
            }
            
            if (strlen($header) < 4)
            {
                throw new Exception ("För få tecken i rubrik.");
            }
            
            if (!preg_match("/[a-öA-Ö]/", $header))
            {
                throw new Exception ("En rubrik måste anges med bokstäver.");
            }
            
            if (strlen($header) > 20)
            {
                $this->header = substr($header, 0, 19);
            }
            
            else
            {
                $this->header = $header;
            }
        }
        
        public function getHeader()
        {
            return $this->header;
        }
        
        public function setDescription($description)
        {
            $description = trim($description);
            
            if (isset($description) === true && $description === '')
            {
                throw new Exception ("En beskrivning måste anges.");
            }
            
            if (strlen($description) < 4)
            {
                throw new Exception ("För få tecken i beskrivning.");
            }
            
            if (strlen($description) > 200)
            {
                $this->description = substr($description, 0, 199);
            }
            
            else
            {
                $this->description = $description;
            }
        }
        
        public function getDescription()
        {
            return $this->description;
        }
        
        public function setPrice($price)
        {
            $price = trim($price);
            
            if (isset($price) === true && $price === '')
            {
                throw new Exception ("Ett pris måste anges.");
            }
            
            if (!is_numeric($price))
            {
                throw new Exception ("Pris måste anges som heltal i siffror.");
            }
            
            if (strlen($price) > 6)
            {
                $this->price = substr($price, 0, 5);             
            }
            
            else
            {
                $this->price = $price;
            }

        }
        
        public function getPrice()
        {
            return $this->price;
        }

        public function setName($name)
        {
            $name = trim($name);
            
            if (isset($name) === true && $name === '')
            {
                throw new Exception ("Ett namn måste anges.");    
            }
            
            if (strlen($name) < 2)
            {
                throw new Exception ("För få tecken i namn.");
            }
            
            if (strlen($name) > 20)
            {
                $this->name = substr($name, 0, 19);
            }
            
            else
            {
                $this->name = $name;
            }
            
        }
        
        public function getName()
        {
            return $this->name;
        }
        
        public function setDate()
        {
            
        }
        
        public function getDate()
        {
            return $this->date;
        }
        
        public function setImageId($imageId)
        {
            $this->imageId = $imageId;
        }
        
        public function getImageId()
        {
            return $this->imageId;
        }
        
    }
