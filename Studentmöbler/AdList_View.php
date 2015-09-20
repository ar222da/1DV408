<?php

class AdList_View
{
    public function __construct()
    {
        
    }
    
    public function showLocations($locations)
    {
        $ret .= "<select>";
        foreach ($locations as $location)
        {
            $ret .= "<option value=" . $location->getId() . ">" . $location->getName() . "</option>";
        }
        $ret .= "</select>";

        return $ret;
    }
    
    public function showTypes($types)
    {
        $ret .= "<select>";
        foreach ($types as $type)
        {
            $ret .= "<option value=" . $type->getId() . ">" . $type->getName() . "</option>";
        }
        $ret .= "</select>";

        return $ret;
        
    }
    
}