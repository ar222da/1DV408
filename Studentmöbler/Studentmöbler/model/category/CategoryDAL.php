<?php

namespace model;

require_once ("Category.php");

class CategoryDAL
{
    private $db;
    
    public function __construct($db)
    {
        $this->db = $db;
    }
    
    public function getCategories()
    {
        $categories = array();
        
        try
        {
            $statement = $this->db->prepare("SELECT * FROM Category");
            $statement->execute();
            $result = $statement->fetchAll();
            foreach ($result as $row)
            {
                $category = new Category();
                $category->setId($row[0]);
                $category->setName($row[1]);
                array_push($categories, $category);
            }
            return $categories;
        }
        catch(PDOException $e)
        {
            throw new Exception ("Fel vid inläsning av kategorier.");
        }
    }
}