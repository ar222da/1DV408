<?php

namespace model;

require_once ("ImageDAL.php");

class ImageService
{
    private $db;
    private $imageDAL;

    public function __construct($db)
    {
        $this->db = $db;
        $this->imageDAL = new ImageDAL($db);
    }

    public function getImageById($id)
    {
        return $this->imageDAL->getImageById($id);
    }
    
    public function insertImage($image)
    {
        return $this->imageDAL->insertImage($image);
    }
    
    public function getLastInsertId()
    {
        return $this->imageDAL->getLastInsertId();
    }
    
    public function updateImage($image)
    {
        return $this->imageDAL->updateImage($image);
    }
    
}