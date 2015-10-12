<?php
require_once ("Exceptions.php");

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
        private $phone;
        private $date;
        private $imageId;
        
        public function __construct()
        {
        }

        public function setId($id)
        {
            $this->id = $id;
        }
        
        public function getId()
        {
            return $this->id;
        }
        
        public function setType($typeId)
        {
            $this->typeId = $typeId;
        }
        
        public function getType()
        {
            return $this->typeId();
        }
        
        public function setCategory($categoryId)
        {
            $this->categoryId = $categoryId;
        }
        
        public function getCategory()
        {
            return $this->categoryId;
        }
        
        public function setLocation($location)
        {
            $this->location = $location;
        }
        
        public function getLocation()
        {
            return $this->location;
        }
        
        public function setHeader($header)
        {
            $header = trim($header);
            
            if (isset($header) === true && $header === '')
            {
                throw new HeaderException ("En rubrik måste anges.");    
            }
            
            if (strlen($header) < 4)
            {
                throw new HeaderException ("För få tecken i rubrik.");
            }
            
            if (!preg_match("/[a-öA-Ö]/", $header))
            {
                throw new HeaderException ("En rubrik måste anges med bokstäver.");
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
                throw new DescriptionException ("En beskrivning måste anges.");
            }
            
            if (strlen($description) < 4)
            {
                throw new DescriptionException ("För få tecken i beskrivning.");
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
            $price = preg_replace("/[^0-9]/", "", $price);
            
            
            if (isset($price) === true && $price === '')
            {
                throw new PriceException ("Ett pris måste anges.");
            }
            
            if (!is_numeric($price))
            {
                throw new PriceException ("Pris måste anges som heltal i siffror.");
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
                throw new NameException ("Ett namn måste anges.");    
            }
            
            if (strlen($name) < 2)
            {
                throw new NameException ("För få tecken i namn.");
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
        
        public function setMail($mail)
        {
            if (isset($mail) === true && $mail === '')
            {
                throw new MailException ("Epost måste anges.");    
            }
            
            if (!filter_var($mail, FILTER_VALIDATE_EMAIL))
            {
                throw new MailException ("Ogiltig epost.");
            }
            
            $this->mail = $mail;
        }
        
        public function getMail()
        {
            return $this->mail;
        }
        
        public function setPhone($phone)
        {
            if (isset($phone) === true && $phone != '')
            {
                if (!preg_match('/^([-+0-9()]+)$/', $phone))
                {
                    throw new PhoneException("Ogiltig telefonnumer.");
                }
            
                $this->phone = $phone;
            }
            
        }
        
        public function getPhone()
        {
            return $this->phone;
        }
        public function setDate()
        {
            
        }
        
        public function getDate()
        {
            return $this->date;
        }
        
        public function setImage($imageId)
        {
            $this->imageId = $imageId;
        }
        
        public function getImage()
        {
            return $this->imageId;
        }
        
    }
