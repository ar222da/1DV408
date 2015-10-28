<?php

namespace model;

class Ad 
{
    private $id;
    private $type;
    private $category;
    private $location;
    private $header;
    private $description;
    private $price;
    private $name;
    private $mail;
    private $phone;
    private $date;
    private $imageId;
    private $updateDeleteString;
        
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
    
    public function setType($type)
    {
        $this->type = $type;
    }
    
    public function getType()
    {
        return $this->type;
    }
    
    public function setCategory($category)
    {
        $this->category = $category;
    }
    
    public function getCategory()
    {
        return $this->category;
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
    
    public function setDate($date)
    {
        $this->date = $date;
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
    
    public function setUpdateDeleteString($updateDeleteString)
    {
        $this->updateDeleteString = $updateDeleteString;
    }
    
    public function getUpdateDeleteString()
    {
        return $this->updateDeleteString;
    }
    
}
