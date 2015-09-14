<?php

require_once ("Category_DAL.php");

class Category_Service
{
    private $db;
    private $category_DAL;

    public function __construct($db)
    {
        $this->db = $db;
        $this->category_DAL = new Category_DAL($db);
    }
    
    public function getCategories()
    {
        return $this->category_DAL->getCategories();
    }
}