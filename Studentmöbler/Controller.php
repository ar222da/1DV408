<?php

require_once "db_connection.php";
require_once "Filter.php";
require_once "Type_Service.php";
require_once "Category_Service.php";
require_once "Location_Service.php";
require_once "AdList_View.php";


class Controller
{
    private $db;
    private $locationService;
    private $adListView;
    
    public function __construct()
    {
        $this->db = new db_connection();
        $this->locationService = new Location_Service($this->db->getDb());
        $this->adListView = new AdList_View();
    }
    
    public function getResult()
    {
        $locations = $this->locationService->getLocations();
        $ret = $this->adListView->showLocations($locations);
        
        
        return $ret;
    }
}