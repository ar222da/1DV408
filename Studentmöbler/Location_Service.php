<?php

require_once ("Location_DAL.php");

class Location_Service
{
    private $db;
    private $location_DAL;

    public function __construct($db)
    {
        $this->db = $db;
        $this->location_DAL = new Location_DAL($db);
    }
    
    public function getLocations()
    {
        return $this->location_DAL->getLocations();
    }
}