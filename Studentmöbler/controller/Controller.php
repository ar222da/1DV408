<?php

namespace controller;

require_once ("model/AdCreateModel.php");
require_once ("view/AdCreateView.php");

class Controller
{
    private $adCreateModel;
    private $adCreateView;

    
    public function __construct($adCreateModel, $adCreateView)
    {
        $this->adCreateModel = $adCreateModel;
        $this->adCreateView = $adCreateView;
    }
    
    public function main()
    {
        
        
        // UR 1: Bergäran om skapande av annons
        
        // UR 2: Begäran om förhandsgranskning av nyskapad annons
        
        // UR 3: Begäran om publicering av nyskapad annons
        
        // UR 4: Begärnan om komplett lista över annonser
        
        // UR 5: Begäran om komplett lista utifrån vald kategori
        
        // UR 6: Begäran om lista utifrån sökparametrar
        
        // UR 7: Begäran om kontakt med annonsör för vald annons
        
        // UR 8: Begäran om redigering av annons
        
        // UR 9: Begäran om borttagning av annons
        
        
        $ret = $this->adCreateView->generateCreateAdForm();
            
        
        
           
        return $ret;
    }
}