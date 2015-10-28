<?php

namespace model;

require_once ("Type.php");

class TypeDAL
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
    
    public function getTypeById($id)
    {
        try
        {
            $statement = $this->db->prepare("SELECT * FROM Type WHERE id=? LIMIT 1");
            $statement->bindValue(1, $id);
            $statement->execute();
            $columns = $statement->fetch();
            $type = new Type();
            $type->setId($columns[0]);
            $type->setName($columns[1]);
            
            return $type;
        }
        catch(PDOException $e)
        {
            throw new Exception ("Fel vid inläsning av annons.");
        }
    }
}