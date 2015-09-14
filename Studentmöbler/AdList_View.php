<?php

class AdList_View
{
    public function __construct()
    {
        
    }
    
    public function showLocations($locations)
    {
        $ret .= "<h1>Orter</h1>";
        foreach ($locations as $location)
        {
            $ret .= $location->getId() . " " . $location->getName() . "<br>";
        }
        return $ret;
    }
}