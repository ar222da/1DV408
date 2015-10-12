<?php

require_once "db_connection.php";
require_once "Filter.php";
require_once "Type_Service.php";
require_once "Category_Service.php";
require_once "Location_Service.php";
require_once "Ad.php";
require_once "AdCreate_View.php";
require_once "AdList_View.php";


class Controller
{
    private $db;
    private $typeService;
    private $categoryService;
    private $locationService;
    private $adCreateView;
    private $adListView;
    
    private $keys = array('Type', 'Category', 'Header', 'Description', 'Price', 'Location', 'Name', 'Mail', 'Phone', 'Image1', 'Image2', 'Image3');
            
    
    public function __construct()
    {
        // Databasanslutningsobjekt
        $this->db = new db_connection();
        // Servicelagerobjekt för annonstyper
        $this->typeService = new Type_Service($this->db->getDb());
        // Servicelagerobjekt för annonskategorier
        $this->categoryService = new Category_Service($this->db->getDb());
        // Servicelagerobjekt för orter
        $this->locationService = new Location_Service($this->db->getDb());
        
        // View-objekt för ny annons. Dess array där värden från input-fälten läggs in, får nyckeluppsättningen som deklareras i nyckelarrayen       
        $this->adCreateView = new AdCreate_View($this->keys);

        
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
        
        
        
        
        
        if ($this->adCreateView->publishAdRequest())
        {
            $ad = new Ad();
            $filter = new Filter();
            $errors = false;
            $messages = array_fill_keys($this->keys, '');
            
            // Varje input-fälts värde i View förs över via filter till motsvarande egenskap för annonsobjekt där validering sker 
            foreach ($this->keys as $key)
            {
                try
                {
                    // Skickas bilder med ska dessa valideras
                    if ($key === 'Image1' || $key === 'Image2' || $key === 'Image3')
                    {
                        if ($this->adCreateView->imageUploaded())
                        {
                            $messages[$key] = "En bild har laddats upp.";
                        }
                        
                    }
                    else
                    {
                        $function = "set" . $key;
                        $ad->$function($filter->sanitizeText($this->adCreateView->getInput()[$key]));
                    }
                }
                // Upptäcks fel placeras aktuellt felmeddelande från aktuell egenskap i array av meddelanden
                catch (Exception $e)
                {
                    $errors = true;
                    $messages[$key] = $e->getMessage();
                }
            }
            
            // Annons passerade inte validering, nytt formulär med felmeddelanden presenteras
            if ($errors)
            {
                $types = $this->typeService->getTypes();
                $categories = $this->categoryService->getCategories();
                $locations = $this->locationService->getLocations();
                $ret = $this->adCreateView->createAdForm($types, $categories, $locations, $messages);
            }
            
            //Annons passerade validering
            else
            {
                foreach ($this->keys as $key)
                {
                    $ret .= $this->adCreateView->getInput()[$key];
                }
            }
        }
            
        else
        {
                $types = $this->typeService->getTypes();
                $categories = $this->categoryService->getCategories();
                $locations = $this->locationService->getLocations();
                $ret = $this->adCreateView->createAdForm($types, $categories, $locations, $messages);
            
        }
            
        
        
           
        return $ret;
    }
}