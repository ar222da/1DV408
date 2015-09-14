<?php

require_once ("Location.php");

class Location_DAL
{
    private $db;
    
    public function __construct($db)
    {
        $this->db = $db;
    }
    
    public function getLocations()
    {
        $locations = array();
        try
        {
            $statement = $this->db->prepare("SELECT * FROM Location");
            $statement->execute();
            $result = $statement->fetchAll();
            foreach ($result as $row)
            {
                $location = new Location();
                $location->setId($row[0]);
                $location->setName($row[1]);
                array_push($locations, $location);
            }
            return $locations;
        }
        catch(PDOException $e)
        {
            throw new Exception ("Fel vid inläsning av orter.");
        }
    }
}