<?php

require_once ("Type_DAL.php");

class Type_Service
{
    private $db;
    private $type_DAL;

    public function __construct($db)
    {
        $this->db = $db;
        $this->type_DAL = new Type_DAL($db);
    }
    
    public function getTypes()
    {
        return $this->type_DAL->getTypes();
    }
}