<?php

namespace model;

require_once ("AdDAL.php");

class AdService
{
    private $db;
    private $adDAL;

    public function __construct($db)
    {
        $this->db = $db;
        $this->adDAL = new AdDAL($db);
    }
    
    public function getAds()
    {
        return $this->adDAL->getAds();
    }
    
    public function getAdsByCategory($categoryId)
    {
        return $this->adDAL->getAdsByCategory($categoryId);
    }
    
    public function getAdById($adId)
    {
        return $this->adDAL->getAdById($adId);
    }
    
    public function insertAd($ad)
    {
        return $this->adDAL->insertAd($ad);
    }
    
    public function getLastInsertId()
    {
        return $this->adDAL->getLastInsertId();
    }
    
    public function updateAd($ad)
    {
        return $this->adDAL->updateAd($ad);
    }
    
    public function deleteAd($adId)
    {
        return $this->adDAL->deleteAd($adId);
    }
}