<?php

namespace model;

require_once ("Location.php");

class LocationDAL
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
    
    public function getLocationById($id)
    {
        try
        {
            $statement = $this->db->prepare("SELECT * FROM Location WHERE id=? LIMIT 1");
            $statement->bindValue(1, $id);
            $statement->execute();
            $columns = $statement->fetch();
            $location = new Location();
            $location->setId($columns[0]);
            $location->setName($columns[1]);
            
            return $location;
        }
        catch(PDOException $e)
        {
            throw new Exception ("Fel vid inläsning av annons.");
        }
    }
}