<?php

namespace model;

require_once ("Ad.php");

class AdDAL
{
    private $db;
    private $lastInsertId;
    
    public function __construct($db)
    {
        $this->db = $db;
    }
    
    public function getAds()
    {
        $ads = array();
        
        try
        {
            $statement = $this->db->prepare("SELECT * FROM Ad");
            $statement->execute();
            $result = $statement->fetchAll();
            foreach ($result as $row)
            {
                $ad = new Ad();
                $ad->setId($row[0]);
                $ad->setType($row[1]);
                $ad->setCategory($row[2]);
                $ad->setLocation($row[3]);
                $ad->setHeader($row[4]);
                $ad->setDescription($row[5]);
                $ad->setPrice($row[6]);
                $ad->setName($row[7]);
                $ad->setMail($row[8]);
                $ad->setDate($row[9]);
                array_push($ads, $ad);
            }
            return $ads;
        }
        catch(PDOException $e)
        {
            throw new Exception ("Fel vid inläsning av annonser.");
        }
    }
    
    public function getAdById($adId)
    {
        try
        {
            $statement = $this->db->prepare("SELECT * FROM Ad WHERE id=? LIMIT 1");
            $statement->bindValue(1, $adId);
            $statement->execute();
            $columns = $statement->fetch();
            $ad = new Ad();
            $ad->setId($columns[0]);
            $ad->setType($columns[1]);
            $ad->setCategory($columns[2]);
            $ad->setLocation($columns[3]);
            $ad->setHeader($columns[4]);
            $ad->setDescription($columns[5]);
            $ad->setPrice($columns[6]);
            $ad->setName($columns[7]);
            $ad->setMail($columns[8]);
            $ad->setPhone($columns[9]);
            $ad->setDate($columns[10]);
            $ad->setImage($columns[11]);
            $ad->setUpdateDeleteString($columns[12]);
            return $ad;
        }
        catch(PDOException $e)
        {
            throw new Exception ("Fel vid inläsning av annons.");
        }
    }
    
    public function getAdsByCategory($categoryId)
    {
        $ads = array();
        
        try
        {
            $statement = $this->db->prepare("SELECT * FROM Ad WHERE categoryId=?");
            $statement->bindValue(1, $categoryId);
            $statement->execute();
            $result = $statement->fetchAll();
            foreach ($result as $row)
            {
                $ad = new Ad();
                $ad->setId($row[0]);
                $ad->setType($row[1]);
                $ad->setCategory($row[2]);
                $ad->setLocation($row[3]);
                $ad->setHeader($row[4]);
                $ad->setDescription($row[5]);
                $ad->setPrice($row[6]);
                $ad->setName($row[7]);
                $ad->setMail($row[8]);
                $ad->setPhone($row[9]);
                $ad->setDate($row[10]);
                $ad->setImage($row[11]);
                $ad->setUpdateDeleteString($row[12]);
                array_push($ads, $ad);
            }
            return $ads;
        }
        catch(PDOException $e)
        {
            throw new Exception ("Fel vid inläsning av annonser.");
        }
    }
    
    
    public function insertAd($ad)
    {
        $date = date("Y-m-d H:i:s");
        try
        {
            $statement = $this->db->prepare("INSERT INTO Ad(typeId, categoryId, locationId, header, description, price, name, mail, phone, date, imageId, updateDeleteString) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?             )");
            $statement->bindValue(1, $ad->getType());
            $statement->bindValue(2, $ad->getCategory());
            $statement->bindValue(3, $ad->getLocation());
            $statement->bindValue(4, $ad->getHeader());
            $statement->bindValue(5, $ad->getDescription());
            $statement->bindValue(6, $ad->getPrice());
            $statement->bindValue(7, $ad->getName());
            $statement->bindValue(8, $ad->getMail());
            $statement->bindValue(9, $ad->getPhone());
            $statement->bindvalue(10, $date);
            $statement->bindvalue(11, $ad->getImage());
            $statement->bindvalue(12, $ad->getUpdateDeleteString());
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
    
    public function updateAd($ad)
    {
        $id = $ad->getId();
        $type = $ad->getType();
        $category = $ad->getCategory();
        $location = $ad->getLocation();
        $header = $ad->getHeader();
        $description = $ad->getDescription();
        $price = $ad->getPrice();
        $name = $ad->getName();
        $mail = $ad->getMail();
        $phone = $ad->getPhone();

        try
        {
            $statement = $this->db->prepare("UPDATE Ad SET typeId=?, categoryId=?, locationId=?, header=?, description=?, price=?, name=?, mail=?, phone=? WHERE id=?"); 
            $statement->execute(array($type, $category, $location, $header, $description, $price, $name, $mail, $phone, $id));
            return true;
        }
        catch(PDOException $e)
        {
            return false;
        }

    }
    
    public function deleteAd($adId)
    {
        try
        {
            $statement = $this->db->prepare("DELETE FROM Ad WHERE id=?"); 
            $statement->execute(array($adId));
            return true;
        }
        catch(PDOException $e)
        {
            return false;
        }
    }
    
}