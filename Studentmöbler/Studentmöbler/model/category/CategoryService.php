<?php

namespace model;

require_once ("CategoryDAL.php");

class CategoryService
{
    private $db;
    private $categoryDAL;

    public function __construct($db)
    {
        $this->db = $db;
        $this->categoryDAL = new CategoryDAL($db);
    }
    
    public function getCategories()
    {
        return $this->categoryDAL->getCategories();
    }
}