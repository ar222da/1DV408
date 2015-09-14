<?php

require_once ("Type.php");

class Type_DAL
{
    private $db;
    
    public function __construct($db)
    {
        $this->db = $db;
    }
    
    public function getTypes()
    {
        $types = array();
        
        try
        {
            $statement = $this->db->prepare("SELECT * FROM Type");
            $statement->execute();
            $result = $statement->fetchAll();
            foreach ($result as $row)
            {
                $type = new Type();
                $type->setId($row[0]);
                $type->setName($row[1]);
                array_push($types, $type);
            }
            return $types;
        }
        catch(PDOException $e)
        {
            throw new Exception ("Fel vid inläsning av kategorier.");
        }
    }
}