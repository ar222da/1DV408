<?php

namespace model;

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
        $this->header = $header;
    }
    
    public function getHeader()
    {
        return $this->header;
    }
    
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function setPrice($price)
    {
        $this->price = $price;
    }
    
    public function getPrice()
    {
        return $this->price;
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
    
    public function setPhone($phone)
    {
        $this->phone = $phone;
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
