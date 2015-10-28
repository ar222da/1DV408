<?php

namespace model;

require_once ("Image.php");

class ImageDAL
{
    private $db;
    private $lastInsertId;
    
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getImageById($id)
    {
        try
        {
            $statement = $this->db->prepare("SELECT * FROM Image WHERE id=? LIMIT 1");
            $statement->bindValue(1, $id);
            $statement->execute();
            $columns = $statement->fetch();
            $image = new Image();
            $image->setId($columns[0]);
            $image->setName($columns[1]);
            $image->setExtension($columns[2]);
            return $image;
        }
        catch(PDOException $e)
        {
            throw new Exception ("Fel vid inläsning av bild.");
        }
    }

    public function insertImage($image)
    {
        try
        {
            $statement = $this->db->prepare("INSERT INTO Image(id, name, extension) VALUES(?, ?, ? )");
            $statement->bindValue(1, $image->getId());
            $statement->bindValue(2, $image->getName());
            $statement->bindValue(3, $image->getExtension());
            
            $statement->execute();
            $this->lastInsertId = $this->db->lastInsertId('id');
            return true;
        }
        catch(PDOException $e)
        {
            return false;
        }
    }
    
    public function getLastInsertId()
    {
        return $this->lastInsertId;
    }
    
    public function updateImage($image)
    {
        $id = $image->getId();
        $name = $image->getName();
        $extension = $ad->getExtension();

        try
        {
            $statement = $this->db->prepare("UPDATE Image SET name=?, extension=? WHERE id=?"); 
            $statement->execute(array($name, $extension, $id));
            return true;
        }
        catch(PDOException $e)
        {
            return false;
        }

    }
    
    
    
}