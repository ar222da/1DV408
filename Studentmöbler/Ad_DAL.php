<?php

require_once ("Ad.php");

class Ad_DAL
{
    private $db;
    
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
                $ad->setName($row[1]);
                array_push($ads, $ad);
            }
            return $ads;
        }
        catch(PDOException $e)
        {
            throw new Exception ("Fel vid inläsning av annonser.");
        }
    }
    
    public function getAdsByType($typeId)
    {
        
    }
    
    public function getAdsByCategory($categoryId)
    {
        
    }
    
    public function getAdsByLocation($locationId)
    {
        
    }
    
    public function getAdsByKeywords($keywords)
    {
        
    }
    
    public function getAdById($id)
    {
        
    }
    
    public function insertAd($ad)
    {
        
    }
    
    public function updateAd($id)
    {
        
    }
    
    public function deleteAd($id)
    {
        
    }
    
}