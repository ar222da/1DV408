<?php

namespace model;

require_once ("TypeDAL.php");

class TypeService
{
    private $db;
    private $typeDAL;

    public function __construct($db)
    {
        $this->db = $db;
        $this->typeDAL = new TypeDAL($db);
    }
    
    public function getTypes()
    {
        return $this->typeDAL->getTypes();
    }
    
    public function getTypeById($id)
    {
        return $this->typeDAL->getTypeById($id);
    }
}