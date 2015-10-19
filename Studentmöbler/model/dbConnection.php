<?php

namespace model;

use \PDO;

class dbConnection
{
    private $servername = "nalaka.se.mysql";
    private $username = "nalaka_se";
    private $password = "blommprinsen28";
    private $dbname = "nalaka_se";
    private $db;
    
    public function __construct()
    {
        try
        {
            $this->db = new PDO("mysql:host=$this->servername;dbname=$this->dbname;charset=utf8", $this->username, $this->password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            throw new Exception ("Fel vid uppkoppling till databas.");
        }
    }
    
    public function getDb()
    {
        return $this->db;
    }
    
    public function closeDb()
    {
        $this->db = null;
    }
    
   
}
