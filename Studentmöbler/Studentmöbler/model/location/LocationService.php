<?php

namespace model;

require_once ("LocationDAL.php");

class LocationService
{
    private $db;
    private $locationDAL;

    public function __construct($db)
    {
        $this->db = $db;
        $this->locationDAL = new LocationDAL($db);
    }
    
    public function getLocations()
    {
        return $this->locationDAL->getLocations();
    }
    
    public function getLocationById($id)
    {
        return $this->locationDAL->getLocationById($id);
    }
}