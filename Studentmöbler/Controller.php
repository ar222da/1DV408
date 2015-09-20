<?php

require_once "db_connection.php";
require_once "Filter.php";
require_once "Type_Service.php";
require_once "Category_Service.php";
require_once "Location_Service.php";
require_once "Ad.php";
require_once "AdCreate_View.php";
require_once "AdList_View.php";


class Controller
{
    private $db;
    private $typeService;
    private $categoryService;
    private $locationService;
    private $adCreateView;
    private $adListView;
    
    public function __construct()
    {
        $this->db = new db_connection();
        $this->typeService = new Type_Service($this->db->getDb());
        $this->categoryService = new Category_Service($this->db->getDb());
        $this->locationService = new Location_Service($this->db->getDb());
        
        $this->adCreateView = new AdCreate_View();
        //$this->adListView = new AdList_View();
        
    }
    
    public function main()
    {
        $ad = new Ad();
        $messageKeys = array('type', 'category', 'header', 'description', 'price', 'location', 'name', 'mail');
        $messages = array_fill_keys($messageKeys, '');
        $errors = false;

            try 
            {
                $ad->setHeader("!!!!!!!");
            }
            catch (HeaderException $e)
            {
                $messages[header] = $e->getMessage();
            }
            try
            {
                $ad->setName("!");
            }
            catch (NameException $e)
            {
                $messages[name] = $e->getMessage();
            }
        
        $length = count($messages);
        foreach ($messageKeys as $messageKey)
        {
            if ($messages[$messageKey] != "")
            {
                $errors = true;
                break;
            }
        }
        
        if (!$errors)
        {
            $ret .= "Allt gick helt bra!";
        }
        
        else
        {
            $types = $this->typeService->getTypes();
            $categories = $this->categoryService->getCategories();
            $locations = $this->locationService->getLocations();
    
            $ret = $this->adCreateView->createAdForm($types, $categories, $locations, $messages);
        }
        
       
        
        
           
        return $ret;
    }
}