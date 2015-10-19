<?php

namespace model;

require_once("dbConnection.php");
require_once("ad/Ad.php");
require_once("ad/AdTemp.php");
require_once("ad/Message.php");
require_once("type/TypeService.php");
require_once("category/CategoryService.php");
require_once("location/LocationService.php");


class AdCreateModel
{
    private $db;
    private $typeService;
    private $categoryService;
    private $locationService;
    private $message;
    
    public function __construct()
    {
        $this->db = new dbConnection();
        $this->typeService = new TypeService($this->db->getDb());
        $this->categoryService = new CategoryService($this->db->getDb());
        $this->locationService = new LocationService($this->db->getDb());
        $this->message = new Message();
    }
    
    public function doPublish(AdTemp $adTemp)
    {
        $errorsFound = false;
        
        
        // Validering av annonstyp    
        $type = $adTemp->getType();
            if (isset($type) === true && $type === '')
            {
                $this->message->setType("Annonstyp måste anges.");
                $errorsFound = true;
            }
            
        // Validering av kategori
        $category = $adTemp->getCategory();
            if (isset($category) === true && $category === '')
            {
                $this->message->setCategory("Kategori måste anges.");
                $errorsFound = true;
            }
            
        // Validering av rubrik
        $header = trim($adTemp->getHeader());
            
            if (isset($header) === true && $header === '')
            {
                $this->message->setHeader("En rubrik måste anges.");
                $errorsFound = true;
            }
            
            else if (strlen($header) < 4)
            {
                $this->message->setHeader("För få tecken i rubrik.");
                $errorsFound = true;
            }
            
            else if (!preg_match("/[a-öA-Ö]/", $header))
            {
                $this->message->setHeader("En rubrik måste anges med bokstäver.");
                $errorsFound = true;
            }
            
            else if (strlen($header) > 20)
            {
                $header = substr($header, 0, 19);
            }
        
        // Validering av beskrivning
        $description = trim($adTemp->getDescription());

            if (isset($description) === true && $description === '')
            {
                $this->message->setDescription("En beskrivning måste anges.");
                $errorsFound = true;
            }
            
            else if (strlen($description) < 4)
            {
                $this->message->setDescription("För få tecken i beskrivning.");
                $errorsFound = true;
            }
            
            else if (strlen($description) > 200)
            {
                $description = substr($description, 0, 199);
            }
            
        // Validering av pris
        $price = $adTemp->getPrice();
        $price = trim($price);
        $price = preg_replace("/[^0-9]/", "", $price);

            if (isset($price) === true && $price === '')
            {
                $this->message->setPrice("Ett pris måste anges.");
                $errorsFound = true;
            }
            
            else if (!is_numeric($price))
            {
                $this->message->setPrice("Pris måste anges som heltal i siffror.");
                $errorsFound = true;
            }
            
            else if (strlen($price) > 6)
            {
                $price = substr($price, 0, 5);             
            }

        // Validering av ort
        $location = $adTemp->getLocation();
            if (isset($location) === true && $location === '')
            {
                $this->message->setLocation("Ort måste anges.");
                $errorsFound = true;
            }
            
        // Validering av namn
        $name = trim($adTemp->getName());
            
            if (isset($name) === true && $name === '')
            {
                $this->message->setName("Ett namn måste anges.");
                $errorsFound = true;
            }
            
            else if (strlen($name) < 2)
            {
                $this->message->setName("För få tecken i namn.");
                $errorsFound = true;
            }
            
            else if (strlen($name) > 20)
            {
                $this->name = substr($name, 0, 19);
            }
            
        // Validering av mail
        $mail = $adTemp->getMail();
        
            if (isset($mail) === true && $mail === '')
            {
                $this->message->setMail("Epost måste anges.");
                $errorsFound = true;
            }
            
            if (!filter_var($mail, FILTER_VALIDATE_EMAIL))
            {
                $this->message->setMail("Ogiltig epost.");
                $errorsFound = true;
            }
            
        // Validering av telefon
        $phone = $adTemp->getPhone();
        
            if (isset($phone) === true && $phone != '')
            {
                if (!preg_match('/^([-+0-9()]+)$/', $phone))
                {
                    $this->message->setPhone("Ogiltig telefonnumer.");
                    $errorsFound = true;
                }
            }

       if (!errorsFound)
       {
           return true;
       }
       else
       {
           return false;
       }

    }
    
    public function getMessage()
    {
        return $this->message;
    }
    
    public function getTypes()
    {
        return $this->typeService->getTypes();
    }
    
    public function getCategories()
    {
        return $this->categoryService->getCategories();
    }
    
    public function getLocations()
    {
        return $this->locationService->getLocations();
    }
    
    
}